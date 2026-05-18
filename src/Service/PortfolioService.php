<?php

namespace App\Service;

readonly class PortfolioService
{
    public function __construct(
        private string $kernelSecret
    )
    {
    }

    public function getData(): array
    {
        // Path to the JSON file
        $path = $this->kernelSecret . '/public/data/projects.json';

        // Read and decode JSON
        return json_decode(file_get_contents($path), true);
    }

    public function getProject(string $token): array
    {
        $projects = $this->getData();
        return $projects[$token] ?? [];
    }
}