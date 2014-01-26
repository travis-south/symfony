<?php

// src/Acme/HelloBundle/Controller/HelloController.php

namespace Acme\HelloBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class HelloController extends Controller
{

	public function indexAction()
	{
		return $this->render(
			'AcmeHelloBundle:Hello:index.html.twig', array('name' => 'test')
		);
	}

	public function redirectAction()
	{
		return $this->redirect($this->generateUrl('fancy'), 301);
	}

	public function fancyAction()
	{
		return $this->render(
			'AcmeHelloBundle:Hello:index.html.twig', array('name' => 'redirect')
		);
	}

}