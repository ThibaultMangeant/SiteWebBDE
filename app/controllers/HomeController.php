<?php

require_once './app/core/Controller.php';
require_once './app/entities/Purchase.php';
require_once './app/repositories/Temporaire/ProduitRepository.php';
require_once './app/repositories/CategoryRepository.php';
require_once './app/trait/FormTrait.php';

class HomeController extends Controller
{
	use FormTrait;
	public function index()
	{
		$this->view('index.html.twig', []);
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

		$articles = $produitRepo->findAll();

		$this->view('boutique.html.twig', ['articles' => $articles]);
	}
}