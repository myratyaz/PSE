<?php
namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class EuLaurController
{
    #[Route('/eulaur')]
    public function home(): Response
    {
        //return $this->render('eulaur/home.html.twig');
        return new Response(
            'aaaaaaaa'
        );
    }
}
