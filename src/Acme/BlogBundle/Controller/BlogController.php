<?php

// src/Acme/BlogBundle/Controller/BlogController.php

namespace Acme\BlogBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class BlogController extends Controller
{

	public function indexAction($page)
	{
		// use the $slug variable to query the database
		$blog = '...';

		return $this->render('AcmeBlogBundle:Blog:index.html.twig', array(
			'page' => $page,
		));
	}

	public function showAction($slug)
	{
		// use the $slug variable to query the database
		$blog = '...';

		return $this->render('AcmeBlogBundle:Blog:show.html.twig', array(
			'slug' => $slug,
		));
	}

	public function redirectAction()
	{
		return $this->redirect($this->generateUrl('blog_fancy'), 301);
	}

	public function fancyAction()
	{
		return $this->render(
			'AcmeBlogBundle:Blog:fancy.html.twig', array('slug' => 1)
		);
	}

}