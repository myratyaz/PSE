<?php

namespace App\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class BacanaruSilviuPageController extends AbstractController
{
    #[Route('/bacanaru_silviu', name: 'bacanaru_silviu')]
    public function index(): Response
    {
    return $this->render('bacanaru_silviu/bacanaru_silviu.html.twig', [
    'controller_name' => 'BacanaruSilviuPageController',
    ]);
    }
}
