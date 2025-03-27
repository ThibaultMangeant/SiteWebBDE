<?php
require_once './app/core/Repository.php';
require_once './app/entities/Category.php';

class CategoryRepository {
    private $pdo;

    public function __construct() {
        $this->pdo = Repository::getInstance()->getPDO();
    }

    public function findByArticle(Article $article): Category {
        $stmt = $this->pdo->prepare('SELECT c.* FROM category c join article a on a.category_id = c.id WHERE a.id = :id');
        $stmt->execute(['id' => $article->getId()]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $this->createCategoryFromRow($row);
    }

    public function findAll(): array {
        $stmt = $this->pdo->query('SELECT * FROM category');
        $categories = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $categories[] = $this->createCategoryFromRow($row);
        }
        return $categories;
    }

    private function createCategoryFromRow(array $row): Category
    {
        return new Category(
            (int) $row['id'],
            $row['name']
        );
    }
}
