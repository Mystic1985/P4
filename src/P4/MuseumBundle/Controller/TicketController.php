<?php

// src/OC/MuseumBundle/Controller/TicketController.php

namespace P4\MuseumBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class TicketController extends Controller
{
    public function indexAction()
    {
        return $this->render('P4MuseumBundle:Ticket:index.html.twig');
    }

    public function buyAction()
    {
    	return $this->render('P4MuseumBundle:Ticket:buy.html.twig');
    }

    public function priceAction()
    {
    	return $this->render('P4MuseumBundle:Ticket:price.html.twig');
    }
}