<?php

namespace P4\MuseumBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('P4MuseumBundle:Default:index.html.twig');
    }
}
