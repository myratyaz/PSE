<?php

namespace App\Controller;

use App\Entity\Service;
use App\Form\ServiceFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

class ServiceController extends AbstractController
{
    // #[Route('/service', name: 'app_service')]
    // public function createService(EntityManagerInterface $em): Response
    // {

    //     // service1 
    //     $service1 = new Service();
    //     $service1->setTitle('Test');
    //     $service1->setContent('Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.');
        
    //     $em->persist($service1);

    //     $em->flush();
    //     return new Response('Data saved');
    // }

    #[Route("/dashboard/add", name: "service_add")]
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

    #[Route("/dashboard/edit/{id}", name:"service_edit")]
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

    #[Route("/dashboard/delete/{id}", name: "service_delete", methods: ["POST"])]
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
