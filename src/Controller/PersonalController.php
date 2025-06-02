<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PersonalController extends AbstractController
{
    #[Route('/myrat', name: 'app_personal')]
    public function index(): Response
    {
        return $this->render('personal/index.html.twig', [
            'controller_name' => 'PersonalController',
        ]);
    }
} 