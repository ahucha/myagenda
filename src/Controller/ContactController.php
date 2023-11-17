<?php

namespace App\Controller;

use App\Entity\Contact;
use App\Repository\ContactRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Form\ContactType;

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

    #[Route('/contact/Ajouter', name: 'formContact')]
    public function addContact(ManagerRegistry $doctrine ,Request $request)
    {
        // $this->denyAccessUnlessGranted('ROLE_USER');

        $entityManager = $doctrine->getManager();
        $contact = new Contact();
        $formContact = $this->createForm(ContactType::class, $contact);
        $formContact->handleRequest($request);

        if($formContact->isSubmitted() && $formContact->isValid())
        {
            $entityManager->persist($contact);
            $entityManager->flush();

            return $this->redirectToRoute('accueil');
        }
       return $this->render('/Form/ContactType.html.twig',[
        'formContact' => $formContact->createView()
       ]);
    }

    #[Route('/contact/modifier/{id}', name:'contactModifier')]
    public function modifContact(ManagerRegistry $doctrine, Request $request, $id)
    {
        // $this->denyAccessUnlessGranted('ROLE_USER');

        $entityManager = $doctrine->getManager();
        $contact = $doctrine->getRepository(Contact::class)->find($id);
        $formContact = $this->createForm(ContactType::class, $contact);
        
        $formContact->handleRequest($request);
        if($formContact->isSubmitted() && $formContact->isValid())
        {
            $entityManager->flush();

            // $this->addFlash('succes', "L'annonce a bien été ajoutée");

            return $this->redirectToRoute('accueil');
        }
       return $this->render('/Form/ContactType.html.twig',[
        'formContact' => $formContact->createView()
       ]);
    }
}
    