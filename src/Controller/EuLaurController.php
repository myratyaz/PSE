<?php
namespace App\Controller;

use App\Repository\HobbyRepository;
use App\Repository\ServiceRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Hobby;
use Symfony\Component\HttpFoundation\Request;

class EuLaurController extends AbstractController
{
    #[Route('/eulaur', name: 'eulaur')]
    public function home(HobbyRepository $repo): Response
    {
        $data = $repo->findAll(); 
        return $this->render('eulaur/home.html.twig',["data"=>$data]);
    }

    #[Route('/eulaur/dashboard', name: 'eulaur_dashboard')]
    public function dashboard(HobbyRepository $repo, EntityManagerInterface $manager, Request $request): Response
    {
        
        $session = $request->getSession();
        $user = $session->get('loggedin_user');
        #dd($user);
        if(!$user){
            return $this->redirectToRoute('eulaur_login');
        }

        $data = $repo->findAll();
        return $this->render('eulaur/dashboard.html.twig',["data"=>$data,"user"=>$user]);
    }

    #[Route('/eulaur/login', name: 'eulaur_login')]
    public function login(Request $request): Response
    {
        $session = $request->getSession();
        $user = $session->get('loggedin_user');

        if($user){
            return $this->redirectToRoute('eulaur_dashboard');
        }

        if($request->isMethod("POST")){
            $username= $request->request->get('username');
            $password = $request->request->get('password');
            if($username == "admin" && $password == "admin"){
                $session->set("loggedin_user","admin");
                return $this->redirectToRoute('eulaur_dashboard');
            }
        }

        return $this->render('eulaur/login.html.twig');
    }

    #[Route('/eulaur/logout', name: 'eulaur_logout')]
    public function logout(Request $request): Response
    {
        $session = $request->getSession();
        $session->invalidate();
        return $this->redirectToRoute('eulaur');
    }

    #[Route('/hobby/update/{id}', name: 'hobby_update')]
    public function update(EntityManagerInterface $entityManager, int $id, Request $request): Response
    {
        $hobby = $entityManager->getRepository(Hobby::class)->find($id);
        $value = $request->request->get('title');
        if (!$hobby) {
            throw $this->createNotFoundException(
                'No hobby found for id '.$id
            );
        }

        $hobby->setTitle($value);
        $entityManager->flush();

        return $this->redirectToRoute("eulaur");
    }
}
