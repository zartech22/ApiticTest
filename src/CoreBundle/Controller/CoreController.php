<?php

namespace CoreBundle\Controller;

use CoreBundle\Entity\Animal;
use CoreBundle\Form\AnimalType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class CoreController extends Controller
{
    public function indexAction()
    {
        $animals = $this->getDoctrine()->getRepository('CoreBundle:Animal')->findAll();

        return $this->render('CoreBundle:Core:index.html.twig', array('animals' => $animals));
    }

    public function addAction(Request $request)
    {
        $animal = new Animal();
        $form = $this->createForm(AnimalType::class, $animal);

        if($form->handleRequest($request)->isValid())
        {
            $manager = $this->getDoctrine()->getManager();
            $manager->persist($animal);
            $manager->flush();

            return $this->redirectToRoute('core_homepage');
        }

        return $this->render('CoreBundle:Core:add.html.twig', array('form' => $form->createView()));
    }

    public function editAction(Animal $animal, Request $request)
    {
        $form = $this->createForm(AnimalType::class, $animal);

        if($form->handleRequest($request)->isValid())
        {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('core_homepage');
        }

        return $this->render('CoreBundle:Core:edit.html.twig', array('form' => $form->createView()));
    }

    public function deleteAction(Animal $animal)
    {
        $this->getDoctrine()->getManager()->remove($animal);
        $this->getDoctrine()->getManager()->flush();

        $this->addFlash('success', 'Animal correctement supprimé !');

        return $this->redirectToRoute('core_homepage');
    }
}
