<?php

namespace App\Controller;

use App\Entity\Contact;
use App\Repository\ContactRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

class ContactController extends AbstractController
{
    #[Route('/contact/afficher/{id}', name: 'contactAfficher')]
    public function contact($id, ContactRepository $contactRepository): Response
    {
        $contact = $contactRepository->find($id);
        return $this->render('contact/index.html.twig', [ 
            'contact' => $contact   
        ]);
    }

    #[Route('/contact/supprimer/{id}', name: 'contactSupprimer')]
    public function delete(ManagerRegistry $doctrine, $id)
    {
        // $this->denyAccessUnlessGranted('ROLE_USER');

        $contact = $doctrine->getRepository(Contact::class)->find($id);
        $entityManager = $doctrine->getManager();
        $entityManager->remove($contact);
        $entityManager->flush();

        return $this->redirectToRoute('accueil');
    }
}
    