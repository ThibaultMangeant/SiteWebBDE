<?php

require_once './app/core/Controller.php';
require_once './app/repositories/ProduitRepository.php';
require_once './app/repositories/EvenementRepository.php';
require_once './app/repositories/ActualiteRepository.php';
require_once './app/trait/FormTrait.php';

class HomeController extends Controller
{
	use FormTrait;
	public function index()
	{
		$evenementRepo = new EvenementRepository();

		$evenements = $evenementRepo->findAll();

		$actualiteRepo = new ActualiteRepository();

		$actualites = $actualiteRepo->findAll();

		$this->view('index.html.twig', ["evenements" => $evenements, "actualites" => $actualites]);
	}

	public function vitrine()
	{
		$this->view('vitrine.html.twig',  []);
	}

	public function boutique()
	{
		$produitRepo = new ProduitRepository();

		$produits = $produitRepo->findAll();

		$this->view('boutique.html.twig', ['produits' => $produits]);
	}

	public function evenement()
	{
		$evenementRepo = new EvenementRepository();

		$evenements = $evenementRepo->findAll();

		$this->view('evenement.html.twig', ['evenements' => $evenements]);
	}

	public function contact()
	{
		$this->view('contact.html.twig', []);
	}

	public function actualiteModif()
	{
		$this->view('actualite_modif.html.twig', []);
	}
}