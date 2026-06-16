<?php

namespace App\Controller;

use App\Form\ContactType;
use App\Service\MailerService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

class ResumeController extends AbstractController
{
    public function __construct(
        private readonly MailerService $mailerService
    ) {
    }

    #[Route('/dev', name: 'dev', methods: ['GET', 'POST'])]
    public function dev(Request $request): Response
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

            return $this->redirect($this->generateUrl('dev') . '#contact');
        }

        return $this->render('dev/resume.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/readproof', name: 'readproof', methods: ['GET', 'POST'])]
    public function readproof(Request $request): Response
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

            return $this->redirect($this->generateUrl('readproof') . '#contact');
        }

        return $this->render('readproof/resume.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}