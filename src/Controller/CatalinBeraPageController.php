<?php

namespace App\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class CatalinBeraPageController extends AbstractController
{
    #[Route('../catalin-bera', name: 'catalin-bera')]
    public function index(): Response
    {
    return $this->render('catalin-bera/catalin-bera.html.twig', [
    'controller_name' => 'CatalinBeraPageController',
    ]);
    }
}