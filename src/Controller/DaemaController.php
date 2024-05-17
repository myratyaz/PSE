<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class DaemaController extends AbstractController
{
    #[Route('/daema')]
    public function index(): Response
    {
        return $this->render('daema/index.html.twig');
    }

    #[Route('/daema-login')]
    public function login(): Response
    {
        return $this->render('daema/login.html.twig');
    }
}
