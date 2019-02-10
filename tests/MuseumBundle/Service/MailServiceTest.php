<?php

namespace Tests\MuseumBundle\Service;

use P4\MuseumBundle\Entity\Orders;
use P4\MuseumBundle\Entity\Ticket;
use P4\MuseumBundle\Entity\Customer;
use P4\MuseumBundle\Repository\OrdersRepository;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Templating\EngineInterface;
use PHPUnit\Framework\TestCase;
use P4\MuseumBundle\Service\MailService;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Session\Storage\MockArraySessionStorage;

class MailServiceTest extends TestCase

{
	private $mailer;
	private $twig;
	private $mailservice;

	public function setUp()
	{
		$this->mailer = $this->getMockBuilder(\Swift_Mailer::class)
	         ->disableOriginalConstructor()
	         ->setMethods(['send'])
	         ->getMock();

        $this->twig = $this->getMockBuilder(\Twig_Environment::class)
            ->disableOriginalConstructor()
            ->setMethods(['render'])
            ->getMock();
	}

	public function testTwigRenderWhenSendMail()
	{   
		$order = new Orders();
		$customer = new Customer();
		$customer->setMail('arnaud@moi.com');

		$order->setCustomer($customer);
		$order->getCustomer()->getMail();

		$ticket1 = new Ticket();
		$ticket2 = new Ticket();
		$order->addTicket($ticket1);
		$order->addTicket($ticket2);

		$this->twig->expects($this->once())
				   ->method('render')
				   ->with('P4MuseumBundle:Ticket:mail.html.twig', array('orders' => $order,
																		'mail' => $order->getCustomer()->getMail(),
																		'listtickets' => $order->getTickets()
																	));
		$this->mailer->expects($this->once())
					 ->method('send');

		$mailservice = new MailService($this->mailer, $this->twig);
		$mailservice->sendConfirmMessage($order);
	}

	public function testCreateMessage()
	{
			$order = new Orders();
			$customer = new Customer();
			$customer->setMail('arnaud@moi.com');

			$order->setCustomer($customer);
			$order->getCustomer()->getMail();

			$ticket1 = new Ticket();
			$ticket2 = new Ticket();
			$order->addTicket($ticket1);
			$order->addTicket($ticket2);

			$this->mailer->expects($this->once())
					     ->method('send');

		   $mailservice = $this->getMockBuilder(MailService::class)
            ->setConstructorArgs([$this->mailer, $this->twig])
            ->setMethods(['createMessage'])
            ->getMock();

            $mailservice->expects($this->once())
            				  ->method('createMessage')
            				  ->willReturn(new \Swift_Message('<podjfp'))
            				  ->with('[Musée du Louvre]Votre commande', 'musee@louvre.com', $order->getCustomer()->getMail(), $order, 'P4MuseumBundle:Ticket:mail.html.twig');

            $mailservice->sendConfirmMessage($order);
	}
}        