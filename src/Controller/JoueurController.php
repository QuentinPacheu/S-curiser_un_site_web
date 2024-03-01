<?php

namespace App\Controller;

use App\Entity\Joueur;
use App\Form\JoueurType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\String\Slugger\SluggerInterface;


class JoueurController extends AbstractController
{
    #[Route('/', name: 'app_joueur')]
    public function index(EntityManagerInterface $em, Request $r, SluggerInterface $slugger): Response
    {
        $joueur = new Joueur();
        $form = $this->createForm(JoueurType::class, $joueur);
        $form->handleRequest($r);

        if($form->isSubmitted() && $form->isValid()){
            $slug = $slugger->slug($joueur->getName() . '-' . uniqid());
            $joueur->setSlug($slug);

            $em->persist($joueur);
            $em->flush();
        }

        $joueur = $em->getRepository(Joueur::class)->findAll();

        return $this->render('joueur/index.html.twig', [
            'joueurs' => $joueur,
            'form' => $form->createView()
        ]);
    }

    #[Route('/delete/{slug}', name: 'app_joueur_delete')]
    public function delete(EntityManagerInterface $em, Joueur $joueur): Response
    {

        $em->remove($joueur);
        $em->flush();

        return $this->redirectToRoute('app_joueur');
    }

    #[Route('/edit/{slug}', name: 'app_joueur_edit')]
    public function edit(Request $request, EntityManagerInterface $em, Joueur $joueur): Response
    {
        $form = $this->createForm(JoueurType::class, $joueur);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->flush();

            return $this->redirectToRoute('app_joueur', ['slug' => $joueur->getSlug()]);
        }

        return $this->render('joueur/edit.html.twig', [
            'joueur' => $joueur,
            'form' => $form->createView()
        ]);
    }

    #[Route('/show/{slug}', name: 'app_joueur_show')]
    public function show(Joueur $joueur): Response
    {
        return $this->render('joueur/show.html.twig', [
            'joueur' => $joueur,
        ]);
    }

}