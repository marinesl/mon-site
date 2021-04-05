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
use App\Form\ContactType;

class HomepageController extends AbstractController
{
    /**
     * @Route("/", name="homepage")
     * Page d'accueil du site internet
     */
    // public function index(Request $request, \Swift_Mailer $mailer): Response
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
            // GET Form
            $form = $this->createForm(ContactType::class, new Contact);
        //

        /**
         * TRAITEMENT
         */
            $form->handleRequest($request);
            if ($request->isMethod('POST')) {
        
                if ($form->isSubmitted() && $form->isValid()) {
                    $contact = $form->getData();
                    $contact->setDate(new \DateTime(date('Y-m-d H:i:s')));
                    $em->persist($contact);
                    $em->flush();


                    /***** ENVOI DU MAIL *****/

                        // On initialise le transport
                        $transport = new \Swift_SmtpTransport( $this->getParameter('MAILER_SMTP'), $this->getParameter('MAILER_PORT'), $this->getParameter('MAILER_ENCRYPTION') );
                        $transport->setUsername( $this->getParameter('MAILER_EMAIL') )->setPassword( $this->getParameter('MAILER_PASSWORD') );

                        // On initialise le mailer
                        $mailer = new \Swift_Mailer( $transport );

                        // On initialise le message
                        $message = new \Swift_Message();

                        // On crée le mail
                        $message->setSubject( 'Site - Demande de contact' )
                                ->setFrom( $this->getParameter('MAILER_EMAIL') )
                                ->setTo( $this->getParameter('MAILER_EMAIL_DEST') )
                                ->setBody( '<p>Bonjour,</p><p>Vous avez une nouvelle demande de contact :</p>'.
                                            '<ul>'.
                                            '<li>Nom : '.$contact->getPrenom().' '.$contact->getNom().'</li>'.
                                            '<li>Téléphone : '.$contact->getTelephone().'</li>'.
                                            '<li>E-mail : '.$contact->getEmail().'</li>'.
                                            '<li>Message : '.$contact->getMessage().'</li>'.
                                            '</ul>'.
                                            '<p>Bonne réception</p>' )
                                ->setContentType( "text/html" );

                        // On envoie le mail
                        if ($mailer->send( $message ))
                            $this->addFlash('success', 'Votre demande de contact a été envoyée !');
                        else
                            $this->addFlash('fail', 'Un problème est survenu, recommencez votre demande.');

                        return $this->redirect($this->generateUrl('homepage').'#contact');

                    //
                }
            }
        //

        /**
         * VUE
         */
            return $this->render(
                'site/homepage.html.twig' ,
                array(
                    'form' => $form->createView()
                ));
        //
    }
}