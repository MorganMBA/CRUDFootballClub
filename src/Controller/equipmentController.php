<?php
// src/Controller/equipmentController.php

namespace App\Controller;

use App\Entity\Equipement;
use App\Form\EquipmentsType;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class equipmentController extends AbstractController
{
	/**
	*@Route("/equipements/creer")
	*/
	public function CreateAll(): Response
	{
        $entityManager = $this->getDoctrine()->getManager();

		// equipements chasuble
		$chasuble = new Equipement();
        $chasuble->setDescription('chasuble');
        $chasuble->setPrice(15);
        $chasuble->setBrand('Puma');
		$chasuble->setQuantity(10);

		// equipements ballon
		$ballon = new Equipement();
        $ballon->setDescription('ballon');
        $ballon->setPrice(30);
        $ballon->setBrand('Puma');
		$ballon->setQuantity(10);

		// equipements plot
		$plot = new Equipement();
        $plot->setDescription('plot');
        $plot->setPrice(10);
        $plot->setBrand('Puma');
		$plot->setQuantity(10);

		// equipements barre
		$barre = new Equipement();
        $barre->setDescription('barre');
        $barre->setPrice(20);
        $barre->setBrand('Puma');
		$barre->setQuantity(10);

		// equipements mini-plot
		$miniPlot = new Equipement();
        $miniPlot->setDescription('mini-plot');
        $miniPlot->setPrice(15);
        $miniPlot->setBrand('Puma');
		$miniPlot->setQuantity(10);

		// equipements maillot
		$maillot = new Equipement();
        $maillot->setDescription('maillot');
        $maillot->setPrice(80);
        $maillot->setBrand('Puma');
		$maillot->setQuantity(10);

		// equipements short
		$short = new Equipement();
        $short->setDescription('short');
        $short->setPrice(40);
        $short->setBrand('Puma');
		$short->setQuantity(10);

		// equipements sifflet
		$sifflet = new Equipement();
        $sifflet->setDescription('sifflet');
        $sifflet->setPrice(10);
        $sifflet->setBrand('Puma');
		$sifflet->setQuantity(10);

        // tell Doctrine you want to (eventually) save the Product (no queries yet)
        $entityManager->persist($chasuble);
		$entityManager->persist($ballon);
		$entityManager->persist($plot);
		$entityManager->persist($barre);
		$entityManager->persist($miniPlot);
		$entityManager->persist($maillot);
		$entityManager->persist($short);
		$entityManager->persist($sifflet);
        // actually executes the queries (i.e. the INSERT query)
        $entityManager->flush();
		$allEquipments = array($chasuble->getDescription(), $ballon->getDescription(), $plot->getDescription(), $barre->getDescription(), 
						$miniPlot->getDescription(), $maillot->getDescription(), $short->getDescription(), $sifflet->getDescription()
		);
		return new Response('Saved new equipements with id <br>'.var_dump($allEquipments));
	}

	/**
	*@Route("/equipements", name="show_equipments")
	*/
	public function ShowAll(): Response
	{
		$repository  = $this->getDoctrine()->getRepository(Equipement::class);

		// look for *all* Task objects
		$equipments = $repository ->findAll();
		if(empty($equipments))
		{
			$message = 'not equipements saved';
			return  $this->render('views/equipments.html.twig',[
				'message' => $message,
			]);
		}
		else
		{
			//returns all tasks
			return  $this->render('views/equipments.html.twig',[
				'equipements' => $equipments,
			]);
		}
	}

	/**
	*@Route("/equipement/new", name="add_equipment")
	*@Route("/equipement/{id}/edit", name="equipment_edit")
	*/
	public function form(Equipement $equipment = null, Request $request)
	{
		if(!$equipment)
		{
			$equipment = new Equipement();
		}
			
		$form = $this->createForm(EquipmentsType::class, $equipment);

		$form->handleRequest($request);
		$entityManager = $this->getDoctrine()->getManager();

		if($form->isSubmitted() && $form->isValid())
		{
			$entityManager->persist($equipment);
			$entityManager->flush();

			return $this->redirectToRoute('show_equipments');
		}
	
		return $this->render('views/FormNewEquip.html.twig', array(
			'form' => $form->createView(),
		));
	}

	/**
	*@Route("/equipement/{id}", name="show_id")
	*/
	public function showId($id)
	{	
		$equipment = $this->getDoctrine()
			->getRepository(Equipement::class)
			->find($id);

		if (!$equipment) {
			throw $this->createNotFoundException(
				'No equipment found for id '.$id
			);
		}
		return  $this->render('views/equipmentId.html.twig',[
			'brand' => $equipment->getBrand(),
			'price' => $equipment->getPrice(),
			'description' => $equipment->getDescription(),
			'quantite' => $equipment->getQuantity(),
		]);
	}

	/**
	*@Route("/equipement/{id}/delete", name="delete_id")
	*/
	public function deleteId($id)
	{	
		$entityManager = $this->getDoctrine()->getManager();
		$Equipment = $entityManager->getRepository(Equipement::class)->find($id);

		if (!$Equipment) {
			throw $this->createNotFoundException(
				'No equipment found for id '.$id
			);
		}

		$entityManager->remove($Equipment);
		$entityManager->flush();

		return $this->redirectToRoute('show_equipments');
	}
}