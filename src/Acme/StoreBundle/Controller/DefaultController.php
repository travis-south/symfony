<?php

namespace Acme\StoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Acme\StoreBundle\Entity\Product;
use Acme\StoreBundle\Entity\Category;
use Symfony\Component\HttpFoundation\Response;

class DefaultController extends Controller
{

	public function indexAction($name)
	{
		return $this->render('AcmeStoreBundle:Default:index.html.twig', array('name' => $name));
	}

	public function createAction()
	{
		$product	 = new Product();
		//$product->setName('A Foo Bar ' . rand(1, 100));
		$product->setPrice('19.99');
		$product->setDescription('Lorem ipsum dolor ' . rand(1, 100));
		$validator	 = $this->get('validator');
		$errors		 = $validator->validate($product);

		if (count($errors) > 0)
		{
			/**
			 * Uses a __toString method on the $errors variable which is a
			 * ConstraintViolationList object. This gives us a nice string
			 * for debugging
			 */

			return $this->render('AcmeStoreBundle:Default:validate.html.twig', array(
				'errors' => $errors,
			));
		}

		$em = $this->getDoctrine()->getManager();
		$em->persist($product);
		$em->flush();

		return new Response('Created product id ' . $product->getId());
	}

	public function showAction($id)
	{
		$product = $this->getDoctrine()
		  ->getRepository('AcmeStoreBundle:Product')
		  ->find($id);

		$category = $product->getCategory();
		if (!$product)
		{
			throw $this->createNotFoundException(
			  'No product found for id ' . $id
			);
		}

		return $this->render('AcmeStoreBundle:Default:index.html.twig', array('name'		 => $product->getName(), 'category'	 => $category->getName()));
	}

	public function showProductPriceAction($price)
	{
		$repository = $this->getDoctrine()
		  ->getRepository('AcmeStoreBundle:Product');

		$query = $repository->createQueryBuilder('p')
		  ->where('p.price > :price')
		  ->setParameter('price', $price)
		  ->orderBy('p.price', 'ASC')
		  ->getQuery();

		$products = $query->getResult();
		echo '<pre>';
		print_r($products);
		echo '</pre>';
		//die();
		if (!$products)
		{
			throw $this->createNotFoundException(
			  'No product found for price > ' . $price
			);
		}
		else
		{
			return $this->render('AcmeStoreBundle:Default:index.html.twig', array('name' => $products[0]->getName()));
		}
	}

	public function useRepoAction()
	{
		$em			 = $this->getDoctrine()->getManager();
		$products	 = $em->getRepository('AcmeStoreBundle:Product')
		  ->findAllOrderedByName();
		if (!$products)
		{
			throw $this->createNotFoundException(
			  'No product found for price > ' . $price
			);
		}
		else
		{
			return $this->render('AcmeStoreBundle:Default:index.html.twig', array(
				'name'		 => $products[0]->getName(),
				'category'	 => $products[0]->getCategory()->getName(),
				)
			);
		}
	}

	public function createProductAction()
	{
		$category = new Category();
		$category->setName('Main Products ' . rand(1, 100));

		$product = new Product();
		$product->setName('Foo ' . rand(101, 200));
		$product->setPrice(19.99);
		$product->setDescription('Foo desc');
		// relate this product to the category
		$product->setCategory($category);

		$em = $this->getDoctrine()->getManager();
		$em->persist($category);
		$em->persist($product);
		$em->flush();

		return new Response(
		  'Created product id: ' . $product->getId() . ' and category id: ' . $category->getId()
		);
	}

}
