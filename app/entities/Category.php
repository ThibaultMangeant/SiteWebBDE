<?php
class Category {

    public function __construct(private int $id, private string $name, private array $articles = []) 
    {}

    public function getId(): int {
        return $this->id;
    }

    public function getName(): string {
        return $this->name;
    }

    public function getArticles(): array {
        return $this->articles;
    }

    public function setName(string $name): void {
        $this->name = $name;
    }

    public function addArticle(Article $article): void {
        $this->articles[] = $article;
    }
}
?>
