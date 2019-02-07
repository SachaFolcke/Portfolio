<?php
/**
 * Created by PhpStorm.
 * User: sachafolcke
 * Date: 05/02/19
 * Time: 21:41
 */

namespace App\Controller;


use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class PortfolioController extends AbstractController
{
    /**
     * @Route("/")
     */
    public function homepage() {

        return $this->render('index.html.twig',[]);
    }
}