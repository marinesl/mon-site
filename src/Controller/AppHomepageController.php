<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use App\Entity\Contact;
use App\Entity\Projet;

class AppHomepageController extends AbstractController
{
    /**
     * @Route("/app/homepage", name="app_homepage")
     */
    public function index(): Response
    {
        /**
         * CONFIG
         */
            $this->denyAccessUnlessGranted('ROLE_ADMIN');

            $em = $this->getDoctrine()->getManager();
        //

        /**
         * ELEMENTS
         */
            // GET le nombre de contacts
            $contacts = count( $em->getRepository(Contact::class)->findAll() );

            // GET le nombre de projets en ligne
            $projets_etat_1 = count( $em->getRepository(Projet::class)->findBy( array('etat' => 1) ) );

            // GET le nombre de projets hors ligne
            $projets_etat_0 = count( $em->getRepository(Projet::class)->findBy( array('etat' => 0) ) );
        //


        /**
         * VUE
         */
            return $this->render(
                'back/homepage.html.twig' ,
                array(
                    'contacts' => $contacts ,
                    'projets_etat_1' => $projets_etat_1 ,
                    'projets_etat_0' => $projets_etat_0
                ));
        //
    }
}

