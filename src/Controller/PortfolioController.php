<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

use App\Entity\Projet;
use App\Entity\Tag;

class PortfolioController extends AbstractController
{
    /**
     * Page Portfolio du site internet
     */
    #[Route('/portfolio', name: 'portfolio')]
    public function index(): Response
    {
        /**
         * VUE
         */
            return $this->render('site/portfolio.html.twig');
        //
    }


    /**
     * Page d'un projet dans le portfolio
     */
    #[Route('/portfolio/{token}', name: 'portfolio_projet')]
    public function projet(): Response
    {


        /**
         * VUE
         */
            return $this->render(
                'site/portfolio_projet.html.twig');
        //
    }
}