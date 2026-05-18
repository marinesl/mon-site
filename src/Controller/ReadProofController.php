<?php

namespace App\Controller;

use App\Form\ContactType;
use App\Service\MailerService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

class ReadProofController extends AbstractController
{
    public function __construct(
        private readonly MailerService $mailerService
    ) {
    }

    #[Route('/readproof', name: 'readproof', methods: ['GET', 'POST'])]
    public function index(Request $request): Response
    {
        return $this->render('readproof/homepage.html.twig');
    }
}