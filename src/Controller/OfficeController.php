<?php

namespace App\Controller;

use App\Entity\PhotosProjet;
use App\Entity\Projet;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;

class OfficeController extends AbstractController
{
    /**
     * @Route("/office", name="office")
     * @Security("has_role('ROLE_USER')")
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
     * @Security("has_role('ROLE_USER')")
     */
    public function afficherProjet($id, EntityManagerInterface $em) {

        $rep = $em->getRepository(Projet::class);
        $projet = $rep->findOneBy(['id' => $id]);

        $rep = $em->getRepository(PhotosProjet::class);
        $photos = $rep->findBy(['id_projet' => $id]);
/*
        if(!$projet) {
            throw new NotFoundHttpException("Ce projet n'existe pas !");
        }
*/
        return $this->render('office/projects/show.html.twig', [
            'projet' => $projet,
            'photos' => $photos
        ]);
    }

    /**
     * @Route("/office/projects/add", name="add_project")
     * @Security("has_role('ROLE_ADMIN')")
     */

    public function ajouterProjet(Request $request, EntityManagerInterface $em) {

        return $this->render('office/projects/add.html.twig', []);

    }

    /**
     * @Route("/office/projects/edit/{id}, name="edit_project")
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function modifierProjet(Request $request, $id, EntityManagerInterface $em) {

    }

    /**
     * @Route("/office/projects/delete/{id}, name="delete_project")
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function supprimerProjet($id, EntityManagerInterface $em) {

    }

    /**
     * @Route("/office/projects/edit/{id}/add_photo, name="add_photo")
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function ajouterPhoto(Request $request, $id, EntityManagerInterface $em) {

    }

    /**
     * @Route("/office/projects/edit/{id}, name="delete_photo")
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function supprimerPhoto($id, EntityManagerInterface $em) {

    }
}
