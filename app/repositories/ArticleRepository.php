<?php
require_once './app/core/Repository.php';
require_once './app/entities/Article.php';

class ArticleRepository {
    private $pdo;

    public function __construct() {
        $this->pdo = Repository::getInstance()->getPDO();
    }

    public function findAll(): array {
        $stmt = $this->pdo->query('SELECT * FROM article');
        $articles = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $articles[] = $this->createArticleFromRow($row);
        }
        return $articles;
    }

    public function create(Article $article): bool {
        $stmt = $this->pdo->prepare('
        INSERT INTO article (name, price, description, stock, category_id)
        VALUES (:name, :price, :description, :stock, :category_id)
    ');

        return $stmt->execute([
            'name' => $article->getName(),
            'price' => $article->getPrice(),
            'description' => $article->getDescription(),
            'stock' => $article->getStock(),
            'category_id' => $article->getCategory()->getId()
        ]);
    }

    private function createArticleFromRow(array $row): Article
    {
        return new Article($row['id'], $row['name'], $row['price'], $row['description'], $row['stock']);
    }

    public function findById(int $id): ?Article
    {
        $stmt = $this->pdo->prepare('SELECT * FROM article WHERE id = :id');
        $stmt->execute(['id' => $id]);
        $article = $stmt->fetch(PDO::FETCH_ASSOC);
        if($article)
            return $this->createArticleFromRow($article);
        return null;
    }
}
