<?php

namespace App\Controller;

use App\Entity\General;
use App\Entity\Introduction;
use App\Entity\PhotosProjet;
use App\Entity\ProjectState;
use App\Entity\Projet;
use App\Entity\SkillCategory;
use App\Entity\SkillRow;
use App\Entity\TimelineElement;
use App\Form\GeneralType;
use App\Form\IntroductionType;
use App\Form\PhotoUploadType;
use App\Form\ProjectStateType;
use App\Form\ProjectType;
use App\Form\SkillCategoryType;
use App\Form\SkillRowType;
use App\Form\TimelineElementType;
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
    public function index()
    {
        return $this->render('office/index.html.twig');
    }

    /**
     * @Route("/office/projects", name="index_project")
     * @Security("is_granted('ROLE_USER')")
     */
    public function indexProject(EntityManagerInterface $em)
    {
        $projects = $em->getRepository(Projet::class)
            ->findAll();

        $states = $em->getRepository(ProjectState::class)
            ->findAll();

        return $this->render('office/projects/index.html.twig', [
            'projets' => $projects,
            'states'  => $states,
        ]);
    }


    /**
     * @Route("/office/projects/show/{id}", name="show_project")
     * @Security("is_granted('ROLE_USER')")
     */
    public function afficherProjet($id, EntityManagerInterface $em) {

        $rep = $em->getRepository(Projet::class);
        $projet = $rep->findOneBy(['id' => $id]);

        if(!$projet) {
            throw new NotFoundHttpException("Ce projet n'existe pas !");
        }

        $rep = $em->getRepository(PhotosProjet::class);
        $photos = $rep->findBy(['idProjet' => $id, 'isThumbnail' => 0]);
        $thumbnail = $rep->findBy(['idProjet' => $id, 'isThumbnail' => 1]);

        return $this->render('office/projects/show.html.twig', [
            'projet'    => $projet,
            'photos'    => $photos,
            'thumbnail' => $thumbnail
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

            $projet->setOrderIndex(
                $em->getRepository(Projet::class)->getMaxOrder() + 1
            );
            $em->persist($projet);
            $em->flush();

            $this->addFlash('success', 'Projet correctement créé !');
            return $this->redirectToRoute('index_project');
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
            return $this->redirectToRoute('show_project', ['id' => $id]);
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
        $photos = $em->getRepository(PhotosProjet::class)->findBy(['idProjet' => $id]);

        if(!$projet) {
            throw new NotFoundHttpException();
        }

        $filesystem = new Filesystem();
        foreach($photos as $photo) {
            $filesystem->remove($photo->getPath());
            $em->remove($photo);
        }

        foreach(($em->getRepository(Projet::class)
               ->findAllByOrderGreaterThan($projet->getOrderIndex())) as $pro) {

            $pro->orderUp();
            $em->persist($pro);
        }

        $em->remove($projet);
        $em->flush();


        $this->addFlash('success', 'Projet correctement supprimé !');

        return $this->redirectToRoute('index_project');

    }

    /**
     * @Route("/office/projects/edit/{id}/add_photo", name="add_photo")
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function ajouterPhoto(Request $request, $id, EntityManagerInterface $em) {

        $photo = new PhotosProjet();
        $form = $this->createForm(PhotoUploadType::class);
        $hasThumbnail = (count($em->getRepository(PhotosProjet::class)
            ->findBy(['idProjet' => $id, 'isThumbnail' => 1])) == 0 ? false : true);
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
                $photo->setIsThumbnail($form->getData()['isThumbnail']);

                $em->persist($photo);
                $em->flush();

                $this->addFlash('success', 'Image ajoutée avec succès');
            } else {
                $this->addFlash('error', 'L\'image fournie n\'a pas un type valide (jpg, png ou gif)');
            }

            return $this->redirectToRoute('show_project', ['id' => $id]);

        }

        return $this->render('office/projects/add_photo.html.twig', [
            'form'         => $form->createView(),
            'id'           => $id,
            'hasThumbnail' => $hasThumbnail,
        ]);
    }

    /**
     * @Route("/office/projects/edit/{id}/delete/{id_photo}", name="delete_photo")
     * @Security("is_granted('ROLE_ADMIN')")
     */
    public function supprimerPhoto($id, $id_photo, EntityManagerInterface $em) {

        $photo = $em->getRepository(PhotosProjet::class)->findOneBy(['id' => $id_photo]);

        if(!$photo){
            throw new NotFoundHttpException;
        }

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

    /**
     * @Route("/office/states/add", name="add_state")
     * @Security("is_granted('ROLE_ADMIN')")
     */
    public function addState(Request $request, EntityManagerInterface $em) {

        $state = new ProjectState();
        $form = $this->createForm(ProjectStateType::class, $state);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $em->persist($state);
            $em->flush();

            $this->addFlash('success', 'État correctement ajouté !');
            return $this->redirectToRoute('office');
        }

        return $this->render(
            'office/states/add.html.twig', [
            'form' => $form->createView()
        ]);

    }

    /**
     * @Route("/office/states/show/{id}", name="show_state")
     * @Security("is_granted('ROLE_USER')")
     */
    public function showState($id, EntityManagerInterface $em) {

        $state = $em->getRepository(ProjectState::class)
            ->findOneBy(['id' => $id]);

        if(!$state) {
            throw new NotFoundHttpException("Cet état n'existe pas !");
        }

        return $this->render('office/states/show.html.twig', [
            'state' => $state
        ]);
    }

    /**
     * @Route("/office/states/edit/{id}", name="edit_state")
     * @Security("is_granted('ROLE_ADMIN')")
     */
    public function editState(Request $request, $id, EntityManagerInterface $em) {

        $state = $em->getRepository(ProjectState::class)
            ->find(['id' => $id]);

        if(!$state) {
            throw new NotFoundHttpException();
        }

        $form = $this->createForm(ProjectStateType::class, $state);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {

            $em->persist($state);
            $em->flush();

            $this->addFlash('success', 'État correctement modifié !');
            return $this->redirectToRoute('show_state', ['id' => $id]);
        }

        return $this->render(
            'office/states/edit.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/office/states/delete/{id}", name="delete_state")
     * @Security("is_granted('ROLE_ADMIN')")
     */
    public function deleteState($id, EntityManagerInterface $em) {

        $state = $em->getRepository(ProjectState::class)
            ->find(['id' => $id]);

        if(!$state){
            throw new NotFoundHttpException;
        }

        $em->remove($state);
        $em->flush();

        $this->addFlash('success', "État correctement supprimé !");
        return $this->redirectToRoute('office');
    }

    /**
     * @Route("/office/general", name="index_general")
     * @Security("is_granted('ROLE_USER')")
     */
    public function indexGeneral(EntityManagerInterface $em) {

        $info = $em->getRepository(General::class)
            ->findAll()[0];

        return $this->render('office/general/index.html.twig', [
            'info' => $info
        ]);
    }

    /**
     * @Route("/office/general/edit", name="edit_general")
     * @Security("is_granted('ROLE_ADMIN')")
     */
    public function editGeneral(Request $request, EntityManagerInterface $em) {

        $info = $em->getRepository(General::class)
            ->findAll()[0];

        $form = $this->createForm(GeneralType::class, $info);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {

            $em->persist($info);
            $em->flush();

            $this->addFlash('success', 'Informations correctement modifiées !');
            return $this->redirectToRoute('index_general');
        }

        return $this->render('office/general/edit.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/office/introduction", name="index_introduction")
     * @Security("is_granted('ROLE_USER')")
     */
    public function indexIntrocution(EntityManagerInterface $em) {

        $intro = $em->getRepository(Introduction::class)
            ->findAll()[0];

        return $this->render('office/introduction/index.html.twig', [
            'intro' => $intro
        ]);
    }

    /**
     * @Route("/office/introduction/edit", name="edit_introduction")
     * @Security("is_granted('ROLE_ADMIN')")
     */
    public function editIntroduction(Request $request, EntityManagerInterface $em) {

        $intro = $em->getRepository(Introduction::class)
            ->findAll()[0];

        $form = $this->createForm(IntroductionType::class, $intro);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {

            $file = $request->files->get('introduction');

            if($file['photo'] != null) {
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

                    $filesystem = new Filesystem();
                    $filesystem->remove($intro->getPhotoPath());
                    $intro->setPhotoPath('img/' . $filename);
                    $this->addFlash('success', 'Informations correctement modifiées !');

                } else {
                    $this->addFlash('error', 'L\'image fournie n\'a pas un type valide (jpg, png ou gif). 
                    Les informations ont été modifiées mais pas la photo.');
                }
            }

            $em->persist($intro);
            $em->flush();

            return $this->redirectToRoute('index_introduction');
        }

        return $this->render('office/introduction/edit.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/office/skills", name="index_skills")
     * @Security("is_granted('ROLE_USER')")
     */
    public function indexSkills(EntityManagerInterface $em) {

        $categories = $em->getRepository(SkillCategory::class)
                      ->findAll();

        return $this->render('office/skills/index.html.twig', [
            'categories' => $categories
        ]);
    }

    /**
     * @Route("/office/skills/add_category", name="add_skill_category")
     * @Security("is_granted('ROLE_ADMIN')")
     */
    public function addSkillCategory(Request $request, EntityManagerInterface $em) {

        $category = new SkillCategory();

        $form = $this->createForm(SkillCategoryType::class, $category);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {


            $file = $request->files->get('skill_category');

            if($file['icon'] != null) {
                $ext = $file['icon']->guessExtension();

                if($ext == "png" || $ext == "jpeg" || $ext == "jpg" || $ext == "gif" || $ext == "svg") {
                    $filename = $this->generateUniqueFileName() . '.' . $ext;

                    try {
                        $file['icon']->move(
                            $this->getParameter('img_directory'),
                            $filename
                        );

                    } catch (FileException $e) {

                    }

                    $category->setIconPath('img/' . $filename);
                    $this->addFlash('success', 'Catégorie correctement ajoutée !');

                } else {
                    $this->addFlash('error', 'L\'image fournie n\'a pas un type valide (jpg, png, gif ou svg). ');
                }
            }

            $category->setOrderIndex(
                $em->getRepository(SkillCategory::class)->getMaxOrder() + 1
            );
            $em->persist($category);
            $em->flush();

            return $this->redirectToRoute('index_skills');
        }

        return $this->render('office/skills/add_category.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/office/skills/edit_category/{id}", name="edit_skill_category")
     * @Security("is_granted('ROLE_ADMIN')")
     */
    public function editSkillCategory($id, Request $request, EntityManagerInterface $em) {

        $category = $em->getRepository(SkillCategory::class)
                    ->find($id);

        if(!$category){
            throw new NotFoundHttpException;
        }

        $form = $this->createForm(SkillCategoryType::class, $category);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {

            $file = $request->files->get('skill_category');

            if($file['icon'] != null) {
                $ext = $file['icon']->guessExtension();

                if($ext == "png" || $ext == "jpeg" || $ext == "jpg" || $ext == "gif" || $ext == "svg") {
                    $filename = $this->generateUniqueFileName() . '.' . $ext;

                    try {
                        $file['icon']->move(
                            $this->getParameter('img_directory'),
                            $filename
                        );

                    } catch (FileException $e) {

                    }

                    $filesystem = new Filesystem();
                    $filesystem->remove($category->getIconPath());
                    $category->setIconPath('img/' . $filename);
                    $this->addFlash('success', 'Informations correctement modifiées !');

                } else {
                    $this->addFlash('error', 'L\'image fournie n\'a pas un type valide (jpg, png, gif ou svg). 
                    Les informations ont été modifiées mais pas la photo.');
                }
            }

            $em->persist($category);
            $em->flush();

            return $this->redirectToRoute('index_skills');
        }

        return $this->render('office/skills/edit_category.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/office/skills/delete_catagory/{id}", name="delete_skill_category")
     * @Security("is_granted('ROLE_ADMIN')")
     */
    public function deleteSkillCategory($id, EntityManagerInterface $em) {

        $category = $em->getRepository(SkillCategory::class)
            ->find($id);

        if(!$category){
            throw new NotFoundHttpException;
        }

        if($category->getIconPath() != null) {
            $fs = new Filesystem();
            $fs->remove($category->getIconPath());
        }

        foreach(($em->getRepository(SkillCategory::class)
            ->findAllByOrderGreaterThan($category->getOrderIndex())) as $cat) {

            $cat->orderUp();
            $em->persist($cat);
        }

        $em->remove($category);
        $em->flush();

        $this->addFlash('success', 'Catégorie correctement supprimée !');

        return $this->redirectToRoute('index_skills');
    }

    /**
     * @Route("/office/skills/add_row", name="add_skill_row")
     * @Security("is_granted('ROLE_ADMIN')")
     */
    public function addSkillRow(Request $request, EntityManagerInterface $em) {

        $row = new SkillRow();

        $form = $this->createForm(SkillRowType::class, $row);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {

            $row->setOrderIndex(
                $em->getRepository(SkillRow::class)->getMaxOrder($row->getCategory()) + 1
            );
            $em->persist($row);
            $em->flush();

            return $this->redirectToRoute('index_skills');
        }

        return $this->render('office/skills/add_row.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/office/skills/edit_row/{id}", name="edit_skill_row")
     * @Security("is_granted('ROLE_ADMIN')")
     */
    public function editSkillRow(Request $request, $id, EntityManagerInterface $em) {

        $row = $em->getRepository(SkillRow::class)
               ->find($id);

        if(!$row){
            throw new NotFoundHttpException;
        }

        $form = $this->createForm(SkillRowType::class, $row);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {

            $em->persist($row);
            $em->flush();

            return $this->redirectToRoute('index_skills');
        }

        return $this->render('office/skills/add_row.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/office/skills/delete_row/{id}", name="delete_skill_row")
     * @Security("is_granted('ROLE_ADMIN')")
     */
    public function deleteSkillRow($id, EntityManagerInterface $em) {

        $row = $em->getRepository(SkillRow::class)
               ->find($id);

        if(!$row){
            throw new NotFoundHttpException;
        }

        foreach(($em->getRepository(SkillRow::class)
            ->findAllByOrderGreaterThan($row->getOrderIndex(), $row->getCategory())) as $r) {

            $r->orderUp();
            $em->persist($r);
        }

        $em->remove($row);
        $em->flush();

        return $this->redirectToRoute('index_skills');
    }

    /**
     * @Route("/office/timeline", name="index_timeline")
     * @Security("is_granted('ROLE_USER')")
     */
    public function indexTimeline(EntityManagerInterface $em) {

        $elements = $em->getRepository(TimelineElement::class)
                  ->findAll();

        return $this->render('office/timeline/index.html.twig', [
            'elements' => $elements
        ]);
    }

    /**
     * @Route("/office/timeline/add", name="add_timeline")
     * @Security("is_granted('ROLE_ADMIN')")
     */
    public function addTimeline(Request $request, EntityManagerInterface $em) {

        $element = new TimelineElement();

        $form = $this->createForm(TimelineElementType::class, $element);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {

            $element->setOrderIndex(
                $em->getRepository(TimelineElement::class)->getMaxOrder() + 1);
            $element->setCurrent(false);

            $em->persist($element);
            $em->flush();

            $this->addFlash('success', 'Élément correctement ajouté !');

            return $this->redirectToRoute('index_timeline');
        }

        return $this->render('office/timeline/add.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/office/timeline/edit/{id}", name="edit_timeline")
     * @Security("is_granted('ROLE_ADMIN')")
     */
    public function editTimeline($id, Request $request, EntityManagerInterface $em) {

        $element = $em->getRepository(TimelineElement::class)
                   ->find($id);

        if(!$element){
            throw new NotFoundHttpException;
        }

        $form = $this->createForm(TimelineElementType::class, $element);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {

            $element->setOrderIndex(
                $em->getRepository(TimelineElement::class)->getMaxOrder());
            $element->setCurrent(false);

            $em->persist($element);
            $em->flush();

            $this->addFlash('success', 'Élément correctement modifié !');

            return $this->redirectToRoute('index_timeline');
        }

        return $this->render('office/timeline/edit.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/office/timeline/delete/{id}", name="delete_timeline")
     * @Security("is_granted('ROLE_ADMIN')")
     */
    public function deleteTimeline($id, EntityManagerInterface $em) {

        $element = $em->getRepository(TimelineElement::class)
                   ->find($id);

        if(!$element){
            throw new NotFoundHttpException;
        }

        foreach(($em->getRepository(TimelineElement::class)
                    ->findAllByOrderGreaterThan($element->getOrderIndex())) as $e) {

            $e->orderUp();
            $em->persist($e);
        }

        $em->remove($element);
        $em->flush();
    }

    /**
     * @Route("/office/timeline/make_current/{id}", name="make_current")
     * @Security("is_granted('ROLE_ADMIN')")
     */
    public function makeCurrent($id, EntityManagerInterface $em) {

        $e = $em->getRepository(TimelineElement::class)
                ->findOneBy(['current' => true]);

        if($e) {
            $e->setCurrent(false);
            $em->persist($e);
        }

        $element = $em->getRepository(TimelineElement::class)
                      ->find($id);

        if(!$element){
            throw new NotFoundHttpException;
        }

        $element->setCurrent(true);
        $em->persist($element);
        $em->flush();

        return $this->redirectToRoute('index_timeline');

    }

    /**
     * @Route("/office/projects/order_up/{id}", name="order_project_up")
     * @Security("is_granted('ROLE_ADMIN')")
     */
    public function OrderUpProject($id, EntityManagerInterface $em) {

        $project = $em->getRepository(Projet::class)
                   ->find($id);

        if(!$project){
            throw new NotFoundHttpException;
        }

        if($project->getOrderIndex() > 1) {

            $pro = $em->getRepository(Projet::class)
                   ->findBy(['order_index' => $project->getOrderIndex() - 1])[0];

            if($pro) {

                $pro->orderDown();
                $em->persist($pro);
            }

            $project->orderUp();
            $em->persist($project);
            $em->flush();
        }

        return $this->redirectToRoute('index_project');
    }

    /**
     * @Route("/office/skills/order_category_up/{id}", name="order_skill_cat_up")
     * @Security("is_granted('ROLE_ADMIN')")
     */
    public function OrderUpSkillCategory($id, EntityManagerInterface $em) {

        $category = $em->getRepository(SkillCategory::class)
            ->find($id);

        if(!$category){
            throw new NotFoundHttpException;
        }

        if($category->getOrderIndex() > 1) {

            $cat = $em->getRepository(SkillCategory::class)
                ->findBy(['order_index' => $category->getOrderIndex() - 1])[0];

            if($cat) {

                $cat->orderDown();
                $em->persist($cat);
            }

            $category->orderUp();
            $em->persist($category);
            $em->flush();
        }

        return $this->redirectToRoute('index_skills');
    }

    /**
     * @Route("/office/skills/order_row_up/{id}", name="order_skill_row_up")
     * @Security("is_granted('ROLE_ADMIN')")
     */
    public function OrderUpRowCategory($id, EntityManagerInterface $em) {

        $row = $em->getRepository(SkillRow::class)
            ->find($id);

        if(!$row){
            throw new NotFoundHttpException;
        }

        if($row->getOrderIndex() > 1) {

            $r = $em->getRepository(SkillRow::class)
                ->findBy(['order_index' => $row->getOrderIndex() - 1,
                          'category' => $row->getCategory()])[0];

            if($r) {

                $r->orderDown();
                $em->persist($r);
            }

            $row->orderUp();
            $em->persist($row);
            $em->flush();
        }

        return $this->redirectToRoute('index_skills');
    }

    /**
     * @Route("/office/timeline/order_up/{id}", name="order_timeline_up")
     * @Security("is_granted('ROLE_ADMIN')")
     */
    public function OrderUpTimeline($id, EntityManagerInterface $em) {

        $element = $em->getRepository(TimelineElement::class)
                       ->find($id);

        if(!$element){
            throw new NotFoundHttpException;
        }

        if($element->getOrderIndex() > 1) {

            $e = $em->getRepository(TimelineElement::class)
                    ->findBy(['order_index' => $element->getOrderIndex() - 1])[0];

            if($e) {

                $e->orderDown();
                $em->persist($e);
            }

            $element->orderUp();
            $em->persist($element);
            $em->flush();
        }

        return $this->redirectToRoute('index_timeline');
    }

}
