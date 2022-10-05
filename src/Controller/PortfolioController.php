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
            // GET les projets
            $projets = $em->getRepository(Projet::class)->findBy(array('etat' => '1'), array('annee' => 'DESC'));

            // GET les tags
            $tags = $em->getRepository(Tag::class)->findBy(array(), array('libelle' => 'ASC'));
        //

        /**
         * VUE
         */
            return $this->render(
                'site/portfolio.html.twig' ,
                array(
                    'projets' => $projets,
                    'tags' => $tags
                ));
        //
    }


    /**
     * @Route("/portfolio/{id}", name="portfolio_projet")
     * Page d'un projet dans le portfolio
     */
    public function projet($id): Response
    {
        /**
         * CONFIG
         */
            $em = $this->getDoctrine()->getManager();
        //

        /**
         * ELEMENTS
         */
            // GET le projet
            $projet = $em->getRepository(Projet::class)->find($id);
        //

        /**
         * VUE
         */
            return $this->render(
                'site/portfolio_projet.html.twig' ,
                array(
                    'projet' => $projet,
                ));
        //
    }
}