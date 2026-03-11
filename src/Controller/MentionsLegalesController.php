<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

class MentionsLegalesController extends AbstractController
{
    /**
     * Page des mentions légales
     */
    #[Route('/mentions_legales', name: 'mentions_legales')]
    public function index(Request $request): Response
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
         * TRAITEMENT
         */
        //

        /**
         * VUE
         */
            return $this->render(
                'site/mentions_legales.html.twig' ,
                array());
        //
    }


    /**
     * Page des mentions légales
     */
    #[Route('/privacy-statement', name: 'privacy-statement')]
    public function privacy(Request $request): Response
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
         * TRAITEMENT
         */
        //

        /**
         * VUE
         */
            return $this->render(
                'site/privacy-statement.html.twig' ,
                array());
        //
    }
}