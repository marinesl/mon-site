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

    #[Route('/dev/portfolio', name: 'dev_portfolio')]
    public function dev(): Response
    {
        return $this->render('dev/portfolio.html.twig', [
            'projects' => $this->portfolioService->getData(),
        ]);
    }

    #[Route('/dev/portfolio/{token}', name: 'dev_portfolio_projet')]
    public function getDevProject(string $token): Response
    {
        $project = $this->portfolioService->getProject($token);

        // Check if the project exists
        if (!$project) {
            throw $this->createNotFoundException('Projet non trouvé');
        }

        return $this->render('dev/portfolio_projet.html.twig', [
            'project' => $project,
        ]);
    }
}