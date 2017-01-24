<?php

namespace CoreBundle\Controller;

use CoreBundle\Entity\Animal;
use CoreBundle\Form\AnimalType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

class CoreController extends Controller
{
    public function indexAction(Request $request)
    {
        $animals = $this->getDoctrine()->getRepository('CoreBundle:Animal')->findAll();

        $secret = uniqid('', true);
        $request->getSession()->set('secret', $secret);

        return $this->render('CoreBundle:Core:index.html.twig', array('animals' => $animals, 'secret' => $secret));
    }

    public function addAction(Request $request)
    {
        $animal = new Animal();
        $form   = $this->createForm(AnimalType::class, $animal);

        if ($form->handleRequest($request)->isValid())
        {
            $manager = $this->getDoctrine()->getManager();
            $manager->persist($animal);
            $manager->flush();

            $this->addFlash('success', 'Animal correctement ajouté à votre liste !');

            return $this->redirectToRoute('core_homepage');
        }

        return $this->render('CoreBundle:Core:add.html.twig', array('form' => $form->createView()));
    }

    public function editAction(Animal $animal, Request $request)
    {
        $form = $this->createForm(AnimalType::class, $animal);

        if ($form->handleRequest($request)->isValid())
        {
            $this->getDoctrine()->getManager()->flush();
            $this->addFlash('success', 'La modification a bien été appliquée');

            return $this->redirectToRoute('core_homepage');
        }

        return $this->render('CoreBundle:Core:edit.html.twig', array('form' => $form->createView()));
    }

    public function deleteAction(Animal $animal, $csrf_token, Request $request)
    {
        $secret = $request->getSession()->get('secret');

        if ($secret === null || !$this->isCsrfTokenValid($secret, $csrf_token))
        {
            throw new AccessDeniedHttpException("Token CSRF non valide. Réessayez en utilisant la page d'accueil.");
        }

        $this->getDoctrine()->getManager()->remove($animal);
        $this->getDoctrine()->getManager()->flush();

        $this->addFlash('success', 'Animal correctement supprimé !');

        return $this->redirectToRoute('core_homepage');
    }
}
