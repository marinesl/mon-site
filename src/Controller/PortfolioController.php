<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

class PortfolioController extends AbstractController
{
    /**
     * @Route("/portfolio", name="portfolio")
     * Page Porfolio du site internet
     */
    public function index(): Response
    {
        /**
         * CONFIG
         */
            $em = $this->getDoctrine()->getManager();
        //

        /**
         * ELEMENTS
         */
        //

        /**
         * VUE
         */
            return $this->render(
                'site/portfolio.html.twig' ,
                array());
        //
    }
}