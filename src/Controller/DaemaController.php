<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Service;
use App\Form\ServiceFormType;
use App\Repository\ServiceRepository;
use App\Form\RegistrationFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class DaemaController extends AbstractController
{
    #[Route('/daema')]
    public function index(): Response
    {
        return $this->render('daema/index.html.twig');
    }
    
    #[Route('/daema/home', name:'daema_home')]
    public function home(ServiceRepository $serviceRepository): Response
    {
        // Fetch all services from db
        $services = $serviceRepository->findAll();

        return $this->render('daema/home.html.twig',[
            'services' => $services,
        ]);
    }
    
    #[Route('/daema/dashboard', name: 'daema_dashboard')]
    public function dashboard(ServiceRepository $serviceRepository): Response
    {
        // Fetch all services from db
        $services = $serviceRepository->findAll();

        return $this->render('daema/dashboard.html.twig',[
            'services' => $services,
        ]);
    }

    // #[Route('/daema/login', name: 'daema_login')]
    // public function login(): Response
    // {
    //     return $this->render('daema/login.html.twig');
    // }

    #[Route('daema/register', name: 'daema_register')]
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

    #[Route(path: '/daema/login', name: 'daema_login')]
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();

        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('daema/login.html.twig', [
            'last_username' => $lastUsername,
            'error' => $error,
        ]);
    }

    #[Route(path: '/daema/logout', name: 'daema_logout')]
    public function logout(): void
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }

    #[Route("daema/dashboard/add", name: "daema_service_add")]
    public function add(Request $request, EntityManagerInterface $em): Response
    {
        $service = new Service();
        $form = $this->createForm(ServiceFormType::class, $service);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($service);
            $em->flush();

            $this->addFlash('success', 'Service added successfully.');

            return $this->redirectToRoute('daema_dashboard');
        }

        return $this->render('daema/add.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route("daema/dashboard/edit/{id}", name:"daema_service_edit")]
    public function edit(Request $request, Service $service, EntityManagerInterface $em): Response
    {
        $form = $this->createForm(ServiceFormType::class, $service);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em->flush();

            $this->addFlash('success', 'Service updated successfully.');

            return $this->redirectToRoute('daema_dashboard');
        }

        return $this->render('daema/edit.html.twig', [
            'form' => $form->createView(),
            'service' => $service,
        ]);
    }

    #[Route("/dashboard/delete/{id}", name: "daema_service_delete", methods: ["POST"])]
    public function delete(Request $request, int $id, EntityManagerInterface $em): Response
    {
        $service = $em->getRepository(Service::class)->find($id);

        if ($service) {
            if ($this->isCsrfTokenValid('delete'.$service->getId(), $request->request->get('_token'))) {
                $em->remove($service);
                $em->flush();
                $this->addFlash('success', 'Service deleted successfully.');
            } else {
                $this->addFlash('error', 'Invalid CSRF token.');
            }
        } else {
            $this->addFlash('error', 'Service not found.');
        }

        return $this->redirectToRoute('daema_dashboard');
    }
}
