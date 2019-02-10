<?php

namespace P4\MuseumBundle\Service;

use P4\MuseumBundle\Entity\Orders;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Translation\TranslatorInterface;

class MailService
{
	private $mailer;
	private $twig;

	public function __construct(\Swift_Mailer $mailer, \Twig_Environment $twig)
	{
		$this->mailer = $mailer;
		$this->twig = $twig;
	}

	public function sendConfirmMessage(Orders $order)
	{	
		$mail = $order->getCustomer()->getMail();
		$listtickets = $order->getTickets();
		
		$message = $this->createMessage('[Musée du Louvre]Votre commande', 'musee@louvre.com', $mail, $order, 'P4MuseumBundle:Ticket:mail.html.twig');
		$this->mailer->send($message);	
	}

	public function createMessage($subject, $from, $to, $order, $twig)
	{
		$message = (new \Swift_Message($subject));
		$message
			->setFrom($from)
			->setTo($to)
			->setBody($this->twig->render($twig, array('mail' => $order->getCustomer()->getMail(),
		                                               'orders' => $order,
		                                               'listtickets' => $order->getTickets())),
		                'text/html');
		return $message;
	}
}