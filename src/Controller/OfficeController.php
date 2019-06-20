<?php

namespace App\Controller;

use App\Entity\PhotosProjet;
use App\Entity\Projet;
use App\Form\PhotoUploadType;
use App\Form\ProjectType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;

class OfficeController extends AbstractController
{
    /**
     * @Route("/office", name="office")
     * @Security("is_granted('ROLE_USER')")
     */
    public function index(EntityManagerInterface $em)
    {
        $rep = $em->getRepository(Projet::class);
        $projets = $rep->findAll();

        return $this->render('office/index.html.twig', [
            'projets' => $projets
        ]);
    }


    /**
     * @Route("/office/projects/show/{id}", name="show_project")
     * @Security("is_granted('ROLE_USER')")
     */
    public function afficherProjet($id, EntityManagerInterface $em) {

        $rep = $em->getRepository(Projet::class);
        $projet = $rep->findOneBy(['id' => $id]);

        $rep = $em->getRepository(PhotosProjet::class);
        $photos = $rep->findBy(['id_projet' => $id]);

        if(!$projet) {
            throw new NotFoundHttpException("Ce projet n'existe pas !");
        }

        return $this->render('office/projects/show.html.twig', [
            'projet' => $projet,
            'photos' => $photos
        ]);
    }

    /**
     * @Route("/office/projects/add", name="add_project")
     * @Security("is_granted('ROLE_ADMIN')")
     */

    public function ajouterProjet(Request $request, EntityManagerInterface $em) {

        $projet = new Projet();
        $form = $this->createForm(ProjectType::class, $projet);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($projet);
            $entityManager->flush();

            $this->addFlash('success', 'Projet correctement créé !');
            return $this->redirectToRoute('office');
        }

        return $this->render(
            'office/projects/add.html.twig', [
                'form' => $form->createView()
            ]);

    }

    /**
     * @Route("/office/projects/edit/{id}", name="edit_project")
     * @Security("is_granted('ROLE_ADMIN')")
    */
    public function modifierProjet(Request $request, $id, EntityManagerInterface $em) {

        $projet = $em->getRepository(Projet::class)->findOneBy(['id' => $id]);

        if(!$projet) {
            throw new NotFoundHttpException();
        }

        $form = $this->createForm(ProjectType::class, $projet);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($projet);
            $entityManager->flush();

            $this->addFlash('success', 'Projet correctement modifié !');
            return $this->redirectToRoute('office');
        }

        return $this->render(
            'office/projects/edit.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/office/projects/delete/{id}", name="delete_project")
     * @Security("is_granted('ROLE_ADMIN')")
    */
    public function supprimerProjet($id, EntityManagerInterface $em) {

        $projet = $em->getRepository(Projet::class)->findOneBy(['id' => $id]);
        $photos = $em->getRepository(PhotosProjet::class)->findBy(['id_projet' => $id]);

        if(!$projet) {
            throw new NotFoundHttpException();
        }

        $filesystem = new Filesystem();
        foreach($photos as $photo) {
            $filesystem->remove($photo->getPath());
        }

        $em->remove($projet);
        $em->flush();


        $this->addFlash('success', 'Projet correctement supprimé !');

        return $this->redirectToRoute('office');

    }

    /**
     * @Route("/office/projects/edit/{id}/add_photo", name="add_photo")
     * @Security("has_role('ROLE_ADMIN')")
    */
    public function ajouterPhoto(Request $request, $id, EntityManagerInterface $em) {

        $photo = new PhotosProjet();
        $form = $this->createForm(PhotoUploadType::class);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {

            $file = $request->files->get('photo_upload');
            $ext = $file['photo']->guessExtension();

            if($ext == "png" || $ext == "jpeg" || $ext == "jpg" || $ext == "gif") {
                $filename = $this->generateUniqueFileName() . '.' . $ext;

                try {
                    $file['photo']->move(
                        $this->getParameter('img_directory'),
                        $filename
                    );

                } catch (FileException $e) {

                }

                $photo->setIdProjet($id);
                $photo->setPath('img/' . $filename);
                $em->persist($photo);
                $em->flush();

                $this->addFlash('success', 'Image ajoutée avec succès');
            } else {
                $this->addFlash('error', 'L\'image fournie n\'a pas un type valide (jpg, png ou gif)');
            }
            return $this->redirectToRoute('show_project', ['id' => $id]);

        }

        return $this->render('office/projects/add_photo.html.twig', [
            'form' => $form->createView(),
            'id' => $id
        ]);
    }

    /**
     * @Route("/office/projects/edit/{id}/delete/{id_photo}", name="delete_photo")
     * @Security("is_granted('ROLE_ADMIN')")
     */
    public function supprimerPhoto($id, $id_photo, EntityManagerInterface $em) {

        $photo = $em->getRepository(PhotosProjet::class)->findOneBy(['id' => $id_photo]);

        $path = $photo->getPath();
        $filesystem = new Filesystem();
        $filesystem->remove($path);

        $em->remove($photo);
        $em->flush();

        return $this->redirectToRoute('show_project', ['id' => $id]);
    }

    /**
     * @return string
     */
    private function generateUniqueFileName()
    {
        // md5() reduces the similarity of the file names generated by
        // uniqid(), which is based on timestamps
        return md5(uniqid());
    }
}
