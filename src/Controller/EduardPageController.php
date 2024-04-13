<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class EduardPageController extends AbstractController
{
    #[Route('/eduard', name: 'eduard')]
    public function index(): Response
    {
        return $this->render('eduard/eduard.html.twig', [
            'controller_name' => 'EduardPageController',
        ]);
    }
}
