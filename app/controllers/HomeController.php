<?php

require_once './app/core/Controller.php';
require_once './app/repositories/ProduitRepository.php';
require_once './app/repositories/EvenementRepository.php';
require_once './app/repositories/ActualiteRepository.php';
require_once './app/services/AuthService.php';
require_once './app/trait/FormTrait.php';

class HomeController extends Controller
{
	use FormTrait;

	private $isAdmin;

	public function __construct()
	{
		$service = new AuthService();
		$this->isAdmin = $service->isAdmin();
	}

	public function index()
	{
		$evenementRepo = new EvenementRepository();

		$evenements = $evenementRepo->findAll();

		$actualiteRepo = new ActualiteRepository();

		$actualites = $actualiteRepo->findAll();

		$this->view('index.html.twig', ["evenements" => $evenements, "actualites" => $actualites,"isAdmin" => $this->isAdmin]);
	}

	public function vitrine()
	{
		$this->view('vitrine.html.twig',  ["isAdmin" => $this->isAdmin]);
	}

	public function boutique()
	{
		$produitRepo = new ProduitRepository();

		$produits = $produitRepo->findAll();

		$this->view('boutique.html.twig', ['produits' => $produits, "isAdmin" => $this->isAdmin]);
	}

	public function evenement()
	{
		$evenementRepo = new EvenementRepository();

		$evenements = $evenementRepo->findAll();

		$this->view('evenement.html.twig', ['evenements' => $evenements, "isAdmin" => $this->isAdmin]);
	}

	public function contact()
	{
		$this->view('contact.html.twig', []);
	}
}