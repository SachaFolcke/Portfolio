<?php

namespace App\Controller;

use App\Entity\Projet;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
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
     * @Route("/office/projects/add", name="add_project")
     * @Security("has_role('ROLE_ADMIN')")
     */

    public function ajouterProjet() {

        return $this->render('office/projects/add.html.twig', []);

    }
}
