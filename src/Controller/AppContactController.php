<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

use App\Entity\Contact;

class AppContactController extends AbstractController
{
    /**
     * @Route("/app/contact", name="app_contact")
     * Page de la liste de demandes de contact
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
            // GET les contacts
            $contacts = $em->getRepository(Contact::class)->findAll();
        //

        /**
         * VUE
         */
            return $this->render(
                'back/contact.html.twig' ,
                array(
                    'contacts' => $contacts
                ));
        //
    }
}