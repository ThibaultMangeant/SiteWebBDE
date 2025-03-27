<?php

require_once './app/services/AuthService.php';
require_once './app/repositories/ArticleRepository.php';
require_once './app/repositories/CategoryRepository.php';
require_once './app/core/Controller.php';
require_once './app/trait/FormTrait.php';

class ArticleController extends Controller{

    use FormTrait;

    public function index() {
        $this->checkAuth();

        $articleRepo = new ArticleRepository();
        $categoryRepo = new CategoryRepository();

        $articles = $articleRepo->findAll();

        foreach ($articles as $article) {
            $category = $categoryRepo->findByArticle($article);
            $article->setCategory($category);
        }

        $this->view('/article/index.html.twig',  ['articles' => $articles]);
    }

    public function create() {
        $this->checkAuth();
        $repository = new CategoryRepository();
        $categories =  $repository->findAll();

        $data = $this->getAllPostParams();
        $errors = [];

        if (!empty($data)) {
            try {

                $errors = [];

                // Validation des données
                if (empty($data['category_id'])) {
                    $errors[] = 'La catégorie est requise.';
                }
                if (empty($data['name'])) {
                    $errors[] = 'Le nom est requis.';
                }
                if (empty($data['price']) || $data['price'] <= 0) {
                    $errors[] = 'Le prix doit être supérieur à 0.';
                }
                if (empty($data['stock']) || $data['stock'] < 0) {
                    $errors[] = 'Le stock ne peut pas être négatif.';
                }

                if (!empty($errors)) {
                    throw new Exception(implode(', ', $errors));
                }

                $article = new Article(
                    null,
                    $data['name'],
                    (float)$data['price'],
                    $data['description'] ?? '',
                    (int)$data['stock']
                );

                $article->setCategory(new Category((int)$data['category_id'], ''));

                $repository = new ArticleRepository();
                if (!$repository->create($article)) {
                    throw new Exception('Erreur lors de la création de l\'article.');
                }

                $this->redirectTo('articles.php');
            } catch (Exception $e) {
                $errors = explode(', ', $e->getMessage());
            }
        }

        $this->view('/article/form', [
            'categories' => $categories,
            'data' => $data,
            'errors' => $errors
        ]);
    }

    private function checkAuth() {
        $auth = new AuthService();
        if (!$auth->isLoggedIn()) {
            $this->redirectTo('login.php');
        }
    }

    public function update()
    {
        $this->checkAuth();

        $id = $this->getQueryParam('id');

        if ($id === null) {
            throw new Exception('Article ID is required.');
        }
        $repository = new ArticleRepository();
        $categoryRepo = new CategoryRepository();
        $article = $repository->findById($id);

        $category = $categoryRepo->findByArticle($article);
        $article->setCategory($category);

        if ($article === null) {
            throw new Exception('Article not found');
        }

        $data = array_merge([
            'name'=>$article->getName(),
            'stock'=>$article->getStock(),
            'price'=>$article->getPrice(),
            'description'=>$article->getDescription(),
            'category_id'=>$article->getCategory()->getId()
        ],$this->getAllPostParams()); //Get submitted data

        $categories =  $categoryRepo->findAll();

        $errors = [];

        if (!empty($this->getAllPostParams())) {
            try {

                $errors = [];

                // Validation des données
                if (empty($data['category_id'])) {
                    $errors[] = 'La catégorie est requise.';
                }
                if (empty($data['name'])) {
                    $errors[] = 'Le nom est requis.';
                }
                if (empty($data['price']) || $data['price'] <= 0) {
                    $errors[] = 'Le prix doit être supérieur à 0.';
                }
                if (empty($data['stock']) || $data['stock'] < 0) {
                    $errors[] = 'Le stock ne peut pas être négatif.';
                }

                if (!empty($errors)) {
                    throw new Exception(implode(', ', $errors));
                }

                $article = new Article(
                    null,
                    $data['name'],
                    (float)$data['price'],
                    $data['description'] ?? '',
                    (int)$data['stock']
                );

                $article->setCategory(new Category((int)$data['category_id'], ''));

                $repository = new ArticleRepository();
                if (!$repository->create($article)) {
                    throw new Exception('Erreur lors de la création de l\'article.');
                }

                $this->redirectTo('articles.php');
            } catch (Exception $e) {
                $errors = explode(', ', $e->getMessage());
            }
        }

        $this->view('/article/form.html.twig', [
            'categories' => $categories,
            'data' => $data,
            'errors' => $errors
        ]);
    }


}
