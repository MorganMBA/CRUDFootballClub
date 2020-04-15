<?php
// src/Controller/indexController.php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
	
class indexController extends AbstractController
{
	public function home()
	{
		return  $this->render('views/index.html.twig');
	}
}