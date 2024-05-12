<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class NeaguCristianController extends AbstractController
{
    #[Route('/neagu_cristian', name: 'neagu_cristian')]
    public function index(): Response
    {
        return $this->render('neagu_cristian/neagu_cristian.html.twig', [
            'controller_name' => 'NeaguCristianController',
        ]);
    }
}
