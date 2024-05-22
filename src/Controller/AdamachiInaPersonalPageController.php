<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class AdamachiInaPersonalPageController extends AbstractController
{
    #[Route('/adamachi_ina', name: 'adamachi_ina_personal_page')]
    public function index(): Response
    {
        return $this->render('adamachi_ina_personal_page/adamachi_ina.html.twig', [
            'controller_name' => 'AdamachiInaPersonalPageController',
        ]);
    }
}
