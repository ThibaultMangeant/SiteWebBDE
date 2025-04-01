<?php

require_once './app/core/Controller.php';
require_once './app/entities/Purchase.php';
require_once './app/repositories/ProduitRepository.php';
require_once './app/repositories/EvenementRepository.php';
require_once './app/trait/FormTrait.php';

class HomeController extends Controller
{
	use FormTrait;
	public function index()
	{
		$evenementRepo = new EvenementRepository();

		$evenements = $evenementRepo->findAll();

		$this->view('index.html.twig', ["evenements" => $evenements]);
	}

	public function purchase()
	{
		$articleRepo = new ArticleRepository();
		$article = $articleRepo->findById($this->getQueryParam('article_id'));

		$authService = new AuthService();
		$purchase = new Purchase(null,$article,$authService->getUser(),$this->getPostParam('quantity'));

		if(session_status() == PHP_SESSION_NONE)
			session_start();

		if(!isset($_SESSION['purchases']))
		{
			$_SESSION['purchases']=[];
		}

		$_SESSION['purchases'][] = serialize($purchase);

		$this->redirectTo('index.php');
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
}