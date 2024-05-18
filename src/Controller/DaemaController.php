<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\ServiceRepository;
use App\Form\RegistrationFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

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

    #[Route('/register', name: 'app_register')]
    public function register(Request $request, UserPasswordHasherInterface $userPasswordHasher, EntityManagerInterface $em): Response
    {
        $user = new User();
        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // encode the plain password
            $user->setPassword(
                    $userPasswordHasher->hashPassword(
                    $user,
                    $form->get('plainPassword')->getData()
                )
            );

            $em->persist($user);
            $em->flush();

            // do anything else you need here, like send an email

            return $this->redirectToRoute('daema_dashboard');
        }

        return $this->render('daema/register.html.twig', [
            'registrationForm' => $form,
        ]);
    }
}
