<?php
class Purchase
{

    public function __construct(private ?int $id, private Article $article, private ?User $user, private int $quantity)
    {
        $this->date = new \DateTime();
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getArticle(): Article
    {
        return $this->article;
    }

    public function getUser(): User
    {
        return $this->user;
    }

    public function getQuantity(): int
    {
        return $this->quantity;
    }

    public function getDate(): \DateTime
    {
        return $this->date;
    }
}
?>
