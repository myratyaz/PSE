<?php
namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class EuLaurController extends AbstractController
{
    #[Route('/eulaur', name: 'eulaur')]
    public function home(): Response
    {
        return $this->render('eulaur/home.html.twig');
    }
}
