<?php

namespace Tests\MuseumBundle\Validator;

use Doctrine\ORM\EntityManager;
use P4\MuseumBundle\Entity\Orders;
use P4\MuseumBundle\Repository\OrdersRepository;
use P4\MuseumBundle\Service\StripeService;
use P4\MuseumBundle\Service\MailService;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\HttpFoundation\Session\Storage\MockArraySessionStorage;
use Symfony\Component\Routing\Router;
use Symfony\Component\Translation\Translator;

class StripeServiceTest extends TestCase
{

    private $session;
    private $router;
    private $translator;
    private $request;
    private $mailservice;
    private $twig;
    private $em;
    private $service;
    private $secretKey;

    /**
     *
     */
    protected function setUp()
    {
        $this->session = $this->getMockBuilder(Session::class)
            ->disableOriginalConstructor()
            ->setMethods(['get'])
            ->getMock();
        ;

        $this->session->method('get')->will($this->returnCallback(function($param) {
            if ($param === 'mail') {
                return 'test@local.dev';
            }
            if ($param === 'totalprice') {
                return 100;
            }

            return $param;
        }));


        $this->router = $this->getMockBuilder(Router::class)
            ->disableOriginalConstructor()
            ->setMethods(['generate'])
            ->getMock();

        $this->router->method('generate')->willReturn("http://local.dev");

        $this->request = $this->getMockBuilder(Request::class)
            ->disableOriginalConstructor()
            ->setMethods(['get'])
            ->getMock();

        $this->request->method('get')->will($this->returnCallback(function($param) {
            return $param;
        }));

        $this->mailservice = $this->getMockBuilder(MailService::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->twig = $this->getMockBuilder(\Twig_Environment::class)
            ->disableOriginalConstructor()
            ->getMock();

        $repository = $this->getMockBuilder(OrdersRepository::class)
            ->disableOriginalConstructor()
            ->setMethods(['find'])
            ->getMock();

        $order = new Orders();
        $order->setPaymentstatus('status_1');

        $repository->method('find')->willReturn($order);

        $this->em = $this->getMockBuilder(EntityManager::class)
            ->disableOriginalConstructor()
            ->setMethods(['getRepository'])
            ->getMock();

        $this->em->method('getRepository')->will($this->returnCallback(function($param) use ($repository) {
            return $repository;
        }));

        $this->translator = $this->getMockBuilder(Translator::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->service = $this->getMockBuilder(StripeService::class)
            ->setConstructorArgs([$this->session, $this->router, $this->request, $this->twig, $this->em, $this->translator, $this->secretKey, $this->mailservice])
            ->setMethods(['setStripeApiKey', 'createStripeCharge'])
            ->getMock();

        $this->service->expects($this->once())
            ->method('setStripeApiKey')
        ;
    }

    /**
    * Test de paiement valide.
    */
    public function testCheckoutOk()
    {

        $this->service->expects($this->once())
            ->method('createStripeCharge')
            ->with(10000, 'stripeToken', 'test@local.dev');

        $this->service->checkoutOrders();
    }

}