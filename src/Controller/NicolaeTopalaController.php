<?php
namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\NicolaeTopalaFavoriteThingsRepository;
use App\Entity\NicolaeTopalaFavoriteThings;

class NicolaeTopalaController extends AbstractController
{
    private EntityManagerInterface $entityManager;
    private NicolaeTopalaFavoriteThingsRepository $favoriteThingRepository;

    public function __construct(
        EntityManagerInterface $entityManager, 
        NicolaeTopalaFavoriteThingsRepository $favoriteThingRepository)
    {
        $this->entityManager = $entityManager;
        $this->favoriteThingRepository = $favoriteThingRepository;
    }

    #[Route('/nicolae_topala_login', name: 'nicolae_topala_login', methods: ['POST'])]
    public function login(Request $request, SessionInterface $session): Response
    {
        $username = $request->request->get('username');
        $password = $request->request->get('password');

        if ($username === 'admin' && $password === 'password123') {
            $session->set('isLogged', true);
            return $this->redirectToRoute('nicolae_topala');
        } else {
            return $this->redirectToRoute('nicolae_topala', ['error' => 'Invalid credentials']);
        }
    }

    #[Route('/nicolae_topala', name: 'nicolae_topala')]
    public function index(SessionInterface $session, Request $request): Response
    {
        $this->checkAndSeedData();
        $favoriteThings = $this->favoriteThingRepository->findAll();
        $error = $request->query->get('error');

        return $this->render('nicolae_topala/index.html.twig', [
            'favoriteThings' => $favoriteThings,
            'isLogged' => $session->get('isLogged'),
            'error' => $error
        ]);
    }

    #[Route('/nicolae_topala_add_favorite_thing', name: 'nicolae_topala_add_favorite_thing', methods: ['POST'])]
    public function addFavoriteThing(Request $request, SessionInterface $session): Response
    {
        if (!$session->get('isLogged')) {
            return $this->redirectToRoute('nicolae_topala');
        }

        $name = $request->request->get('name');
        if (!empty($name)) {
            $this->addNewFavoriteThingData($name);
            $this->entityManager->flush();
        }

        return $this->redirectToRoute('nicolae_topala');
    }
    
    private function checkAndSeedData(): void
    {
        if ($this->favoriteThingRepository->count([]) === 0) {
            $things = ['Cats', 'Video Games', 'The payday', 'Increases'];
            foreach ($things as $thing) {
                $this->addNewFavoriteThingData($thing);
            }
            $this->entityManager->flush();
        }
    }

    private function addNewFavoriteThingData(string $name): void
    {
        $favoriteThing = new NicolaeTopalaFavoriteThings();
        $favoriteThing->setName($name);
        $this->entityManager->persist($favoriteThing);
    }
}
