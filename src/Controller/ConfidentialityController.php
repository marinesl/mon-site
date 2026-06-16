<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ConfidentialityController extends AbstractController
{
    #[Route('/dev/confidentiality', name: 'dev_confidentiality')]
    #[Route('/readproof/confidentiality', name: 'readproof_confidentiality')]
    public function index(): Response
    {
        return $this->render(
            'site/confidentiality.html.twig' ,
            []);
    }
}