<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Psr\Log\LoggerInterface;

class DefaultController extends AbstractController
{

    #[Route('/about', name: 'about')]
    public function about(LoggerInterface $logger): Response
    {
        $logger->info("get about info");
        return $this->render('default/about.html.twig', [
            'name' => "sdsds",
        ]);
    }

    #[Route('/hello/{name}', name: 'index')]
    public function index(string $name, LoggerInterface $logger): Response
    {
        $logger->info("Saying hello to $name!");
        return $this->render('default/index.html.twig', [
            'name' => $name,
        ]);
    }

    #[Route('/simplicity', methods: ['GET'])]
    public function simple(LoggerInterface $logger): Response
    {
        $logger->info("Saying 'Simple! Easy! Great!'");
        return new Response('Simple! Easy! Great!');
    }

    #[Route('/api/hello/{name}', methods: ['GET'])]
    public function apiHello(string $name, LoggerInterface $logger): JsonResponse
    {
        $logger->info("Saying hello as json to $name!");
        return $this->json([
            'name' => $name,
            'symfony' => 'rocks',
        ]);
    }
}