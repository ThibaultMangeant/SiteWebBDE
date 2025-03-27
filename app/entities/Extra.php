<?php
class Extra {

    // Propriétés
    

    // Constructeur
    public function __construct(private int $id,
    private string $name) {
    }

    // Getters
    public function getId(): int {
        return $this->id;
    }

    public function getName(): string {
        return $this->name;
    }

    // Setters
    public function setId(int $id): void {
        $this->id = $id;
    }

    public function setName(string $name): void {
        $this->name = $name;
    }
}
?>
