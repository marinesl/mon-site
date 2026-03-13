<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class PortfolioController extends AbstractController
{
    #[Route('/portfolio', name: 'portfolio')]
    public function index(): Response
    {
        // TODO: faire un service
        // Path to the JSON file
        $path = $this->getParameter('kernel.project_dir') . '/public/data/projects.json';

        // Read and decode JSON
        $projects = json_decode(file_get_contents($path), true);

        return $this->render('site/portfolio.html.twig', [
            'projects' => $projects,
        ]);
    }

    #[Route('/portfolio/{token}', name: 'portfolio_projet')]
    public function getProject(string $token): Response
    {
        // Path to the JSON file
        $path = $this->getParameter('kernel.project_dir') . '/public/data/projects.json';

        // Read and decode JSON
        $projects = json_decode(file_get_contents($path), true);

        // Check if the project exists
        if (!isset($projects[$token])) {
            throw $this->createNotFoundException('Projet non trouvé');
        }

        $project = $projects[$token];

        return $this->render('site/portfolio_projet.html.twig', [
            'project' => $project,
        ]);
    }
}