<?php

namespace App\Controller;

use App\Service\MailerService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

use App\Form\ContactType;

class HomepageController extends AbstractController
{
    public function __construct(
        private readonly MailerService $mailerService
    ) {
    }

    #[Route('/', name: 'homepage', methods: ['GET', 'POST'])]
    public function index(Request $request): Response
    {
        $form = $this->createForm(ContactType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $this->mailerService->sendMailContact($form->getData());
                $this->addFlash('success', 'Votre demande de contact a été envoyée !');
            } catch (\Throwable $e) {
                $this->addFlash('fail', 'Un problème est survenu, recommencez votre demande.' . $e);
            }

            return $this->redirect($this->generateUrl('homepage') . '#contact');
        }

        return $this->render('site/homepage.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}