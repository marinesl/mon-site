<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AppHomepageController extends AbstractController
{
    /**
     * @Route("/app/homepage", name="app_homepage")
     */
    public function index(): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');
        
        return $this->render('back/homepage.html.twig');
    }
}
