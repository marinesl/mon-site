<?php

namespace App\Controller;

use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Annotation\Route;

use App\Form\ContactType;

class HomepageController extends AbstractController
{
    /**
     * Page d'accueil du site internet
     * @throws Exception|TransportExceptionInterface
     */
    #[Route('/', name: 'homepage')]
    public function index(
        Request $request,
        MailerInterface $mailer
    ): Response
    {
        /**
         * ELEMENTS
         */
            // GET Form
            $form = $this->createForm(ContactType::class);
        //

        /**
         * TRAITEMENT
         */
            $form->handleRequest($request);
            if ($request->isMethod('POST')) {
        
                if ($form->isSubmitted() && $form->isValid()) {
                    $contact = $form->getData();


                    /***** ENVOI DU MAIL *****/

                    try {

                        $email = (new Email())
                            ->from($this->getParameter('MAILER_EMAIL_FROM'))
                            ->to($this->getParameter('MAILER_EMAIL_TO'))
                            ->subject('Site - Demande de contact')
                            ->text('<p>Bonjour,</p><p>Vous avez une nouvelle demande de contact :</p>'.
                                '<ul>'.
                                '<li>Nom : '.$contact->getPrenom().' '.$contact->getNom().'</li>'.
                                '<li>Téléphone : '.$contact->getTelephone().'</li>'.
                                '<li>E-mail : '.$contact->getEmail().'</li>'.
                                '<li>Message : '.$contact->getMessage().'</li>'.
                                '</ul>'.
                                '<p>Bonne réception</p>');

                        $mailer->send($email);

                        $this->addFlash('success', 'Votre demande de contact a été envoyée !');
                    } catch (FileException $e) {
                        $this->addFlash('fail', 'Un problème est survenu, recommencez votre demande.');
                    }

                    return $this->redirect($this->generateUrl('homepage').'#contact');
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