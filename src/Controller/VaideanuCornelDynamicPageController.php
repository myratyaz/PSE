<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\VaideanuCornelPages;

class VaideanuCornelDynamicPageController extends AbstractController
{
    #[Route('/vaideanu-cornel/dynamic-page', name: 'app_vaideanu_cornel_dynamic_page')]
    public function index(EntityManagerInterface $entityManager, ): Response
    {

        // display the page
        $page = $entityManager->getRepository(VaideanuCornelPages::class)->findOneBy(['slug' => 'cornel']);

        return $this->render('vaideanu_cornel_dynamic_page/index.html.twig', [
            'controller_name' => 'VaideanuCornelDynamicPageController',
            'page' => $page,
        ]);
    }

    #[Route('/vaideanu-cornel/dynamic-page/login', name: 'app_vaideanu_cornel_dynamic_page_login')]
    public function login(EntityManagerInterface $entityManager, Request $request): Response
    {

        // check if the user is logged in
        $username = "cornel";
        $password = md5('password');

        $session = $request->getSession();
        $user = $session->get('loggedin_user');

        if($user){
            return $this->redirectToRoute('app_vaideanu_cornel_dynamic_page_edit');
        }

        // verificam daca primim datele
        if ($request->isMethod('post')) {

            $user = $request->get('user');
            $pass = $request->get('password');

            if($username == $user && md5($pass) == $password) {

                // save user to session
                $session->set('loggedin_user', 'cornel');

                return $this->redirectToRoute('app_vaideanu_cornel_dynamic_page_edit');    
            }

            $this->addFlash(
                'error',
                'Invalid credentials'
            );

            return $this->redirectToRoute('app_vaideanu_cornel_dynamic_page_login');

        }

        return $this->render('vaideanu_cornel_dynamic_page/login.html.twig', [
            'controller_name' => 'VaideanuCornelDynamicPageController',
        ]);
    }


    #[Route('/vaideanu-cornel/dynamic-page/edit', name: 'app_vaideanu_cornel_dynamic_page_edit')]
    public function edit(EntityManagerInterface $entityManager, 
            ValidatorInterface $validator, Request $request): Response
    {

        $session = $request->getSession();
        $user = $session->get('loggedin_user');

        if(!$user){
            return $this->redirectToRoute('app_vaideanu_cornel_dynamic_page_login');
        }

        $page = $entityManager->getRepository(VaideanuCornelPages::class)->findOneBy(['slug' => 'cornel']);

        if(!$page) {
            $page = new VaideanuCornelPages();
        }

        // verificam daca primim datele
        if ($request->isMethod('post')) {

            $title = $request->get('title');
            $description = $request->get('description');

            $file = $request->files->get('image');
            $filename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
            $filename = $filename .".". $file->guessExtension();

            $file->move($this->getParameter('kernel.project_dir') . "/assets/images/", $filename);

            $page->setTitle($title);
            $page->setSlug('cornel');
            $page->setPhoto($filename);
            $page->setDescription($description);

            $errors = $validator->validate($page);
            if (count($errors) > 0) {
                return new Response((string) $errors, 400);
            }

            $entityManager->persist($page);
            $entityManager->flush();

            return $this->redirectToRoute('app_vaideanu_cornel_dynamic_page_edit');

        }


        return $this->render('vaideanu_cornel_dynamic_page/edit.html.twig', [
            'controller_name' => 'VaideanuCornelDynamicPageController',
            'page' => $page,
        ]);
    }


}
