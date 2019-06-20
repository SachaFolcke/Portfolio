<?php
/**
 * Created by PhpStorm.
 * User: sachafolcke
 * Date: 05/02/19
 * Time: 21:41
 */

namespace App\Controller;


use App\Entity\PhotosProjet;
use App\Entity\Projet;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class PortfolioController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function homepage(EntityManagerInterface $em) {

        $rep = $em->getRepository(Projet::class);
        $projets = $rep->findAll();

        $rep = $em->getRepository(PhotosProjet::class);
        $photos = [];

        foreach ($projets as $projet) {
            $photos[$projet->getId()] = $rep->findBy(['id_projet' => $projet->getId()]);
        }

        return $this->render('index.html.twig', [
            'projets' => $projets,
            'photos' => $photos
        ]);
    }

}