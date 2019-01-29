<?php

namespace P4\MuseumBundle\Service;

use P4\MuseumBundle\Entity\Orders;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Templating\EngineInterface;

class MailService
{
	private $mailer;
	private $twig;

	public function __construct(\Swift_Mailer $mailer, \Twig_Environment $twig)
	{
		$this->mailer = $mailer;
		$this->twig = $twig;
	}


	public function sendMessage(Orders $order)
	{	
		$message = (new \Swift_Message('Votre commande'));
		$mail = $order->getCustomer()->getMail();
		$listtickets = $order->getTickets();

		$message
			->setFrom('musee@louvre.com')
			->setTo($mail)
			->setBody($this->twig->render('P4MuseumBundle:Ticket:mail.html.twig', array('mail' => $mail,
		                                                                                'orders' => $order,
		                                                                            	'listtickets' => $listtickets)),
		                'text/html');
		$this->mailer->send($message);
	}
}