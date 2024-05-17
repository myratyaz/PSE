<?php

namespace App\Controller;

use App\Repository\ServiceRepository;
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

    #[Route('/daema-login', name: 'daema_login')]
    public function login(): Response
    {
        return $this->render('daema/login.html.twig');
    }
    
    #[Route('/daema-home', name:'daema_home')]
    public function home(ServiceRepository $serviceRepository): Response
    {
        // Fetch all services from db
        $services = $serviceRepository->findAll();

        return $this->render('daema/home.html.twig',[
            'services' => $services,
        ]);
    }
    
    #[Route('/daema-dashboard', name: 'daema_dashboard')]
    public function dashboard(ServiceRepository $serviceRepository): Response
    {
        // Fetch all services from db
        $services = $serviceRepository->findAll();

        return $this->render('daema/dashboard.html.twig',[
            'services' => $services,
        ]);
    }
}
