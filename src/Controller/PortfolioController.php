<?php

namespace App\Controller;

use App\Service\PortfolioService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class PortfolioController extends AbstractController
{

    public function __construct(private readonly PortfolioService $portfolioService)
    {
    }

    #[Route('/portfolio', name: 'portfolio')]
    public function index(): Response
    {
        return $this->render('site/portfolio.html.twig', [
            'projects' => $this->portfolioService->getData(),
        ]);
    }

    #[Route('/portfolio/{token}', name: 'portfolio_projet')]
    public function getProject(string $token): Response
    {
        $project = $this->portfolioService->getProject($token);

        // Check if the project exists
        if (!isset($project)) {
            throw $this->createNotFoundException('Projet non trouvé');
        }

        return $this->render('site/portfolio_projet.html.twig', [
            'project' => $project,
        ]);
    }
}