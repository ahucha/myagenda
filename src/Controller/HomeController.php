<?php

namespace App\Controller;

use App\Repository\ContactRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'accueil')]
    public function index(ContactRepository $contactRepository)
    {
        $liste_contact = $contactRepository->findAll();
        return $this->render('home/index.html.twig', [
            'contact' => $liste_contact
        ]);
    }
    
}
