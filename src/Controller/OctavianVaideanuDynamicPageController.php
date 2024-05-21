<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\OctavianVaideanuPages;

class OctavianVaideanuDynamicPageController extends AbstractController
{
    #[Route('/octavian/dynamic-page', name: 'app_octavian_vaideanu_dynamic_page')]
    public function index(EntityManagerInterface $entityManager, ): Response
    {

        // display the page
        $page = $entityManager->getRepository(OctavianVaideanuPages::class)->findOneBy(['linkSlug' => 'octavian']);

        return $this->render('octavian/index.html.twig', [
            'controller_name' => 'OctavianVaideanuDynamicPageController',
            'page' => $page,
        ]);
    }

    #[Route('/octavian/dynamic-page/login', name: 'app_octavian_vaideanu_dynamic_page_login')]
    public function login(EntityManagerInterface $entityManager, Request $request): Response
    {

        // check if the user is logged in
        $username = "octavian_vaideanu";
        $password = md5('password');

        $session = $request->getSession();
        $user = $session->get('loggedin_user');

        if($user){
            return $this->redirectToRoute('app_octavian_vaideanu_dynamic_page_edit');
        }

        if ($request->isMethod('post')) {

            $user = $request->get('user');
            $pass = $request->get('password');

            if($username == $user && md5($pass) == $password) {

                // save user to session
                $session->set('loggedin_user', 'octavian_vaideanu');

                return $this->redirectToRoute('app_octavian_vaideanu_dynamic_page_edit');    
            }

            $this->addFlash(
                'error',
                'Invalid credentials'
            );

            return $this->redirectToRoute('app_octavian_vaideanu_dynamic_page_login');

        }

        return $this->render('octavian/login.html.twig', [
            'controller_name' => 'OctavianVaideanuDynamicPageController',
        ]);
    }


    #[Route('/octavian/dynamic-page/edit', name: 'app_octavian_vaideanu_dynamic_page_edit')]
    public function edit(EntityManagerInterface $entityManager, 
            ValidatorInterface $validator, Request $request): Response
    {

        $session = $request->getSession();
        $user = $session->get('loggedin_user');

        if(!$user){
            return $this->redirectToRoute('app_octavian_vaideanu_dynamic_page_login');
        }

        $page = $entityManager->getRepository(OctavianVaideanuPages::class)->findOneBy(['linkSlug' => 'octavian']);

        if(!$page) {
            $page = new OctavianVaideanuPages();
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
            $page->setLinkSlug('octavian');
            $page->setPhoto($filename);
            $page->setDescription($description);

            $errors = $validator->validate($page);
            if (count($errors) > 0) {
                return new Response((string) $errors, 400);
            }

            $entityManager->persist($page);
            $entityManager->flush();

            return $this->redirectToRoute('app_octavian_vaideanu_dynamic_page_edit');

        }


        return $this->render('octavian/edit.html.twig', [
            'controller_name' => 'OctavianVaideanuDynamicPageController',
            'page' => $page,
        ]);
    }


}
