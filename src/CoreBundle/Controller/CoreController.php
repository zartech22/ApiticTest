<?php

namespace CoreBundle\Controller;

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

    }

    public function editAction($id, Request $request)
    {

    }

    public function deleteAction($id)
    {

    }
}
