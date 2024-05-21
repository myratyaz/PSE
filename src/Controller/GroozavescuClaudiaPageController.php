<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class GrozavescuClaudiaController extends AbstractController
{
    #[Route('/grozavescu_claudia', name: 'grozavescu_claudia')]
    public function index(): Response
    {
        return $this->render('grozavescu_claudia/grozavescu_claudia.html.twig', [
            'controller_name' => 'GrozavescuClaudiaController',
        ]);
    }
}
