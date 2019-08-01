<?php
/**
 * Created by PhpStorm.
 * User: sachafolcke
 * Date: 05/02/19
 * Time: 21:41
 */

namespace App\Controller;


use App\Entity\General;
use App\Entity\PhotosProjet;
use App\Entity\Projet;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpKernel\Exception\ServiceUnavailableHttpException;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class PortfolioController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function homepage(EntityManagerInterface $em) {

        $info = $em->getRepository(General::class)
                ->findAll()[0];

        if($info->getIsOnline() == 0) {
            throw new ServiceUnavailableHttpException();
        }

        $projets = $em->getRepository(Projet::class)
                      ->findBy(['online' => 1]);

        $rep = $em->getRepository(PhotosProjet::class);
        $photos = [];

        foreach ($projets as $projet) {
            $id = $projet->getId();
            $photos[$id]['thumb'] = $rep->findOneBy(['idProjet' => $id, 'isThumbnail' => 1]);
            $photos[$id]['photos'] = $rep->findBy(['idProjet' => $id, 'isThumbnail' => 0]);
        }

        return $this->render('index.html.twig', [
            'projets' => $projets,
            'photos' => $photos,
            'info' => $info
        ]);
    }

}
