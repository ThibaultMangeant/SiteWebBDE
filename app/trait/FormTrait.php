<?php

trait FormTrait {

    // Nettoie l'entrée utilisateur pour éviter les failles XSS
    private function sanitizeInput(string $input): string {
        return htmlspecialchars(strip_tags(trim($input)));
    }

    // Récupère un paramètre POST nettoyé
    public function getPostParam(string $key, $default = null) {
        return isset($_POST[$key]) ? $this->sanitizeInput($_POST[$key]) : $default;
    }

    // Récupère un paramètre GET nettoyé
    public function getQueryParam(string $key, $default = null) {
        return isset($_GET[$key]) ? $this->sanitizeInput($_GET[$key]) : $default;
    }

    // Récupère tous les paramètres POST nettoyés
    public function getAllPostParams(): array {
        return array_map([$this, 'sanitizeInput'], $_POST);
    }

    // Récupère tous les paramètres GET nettoyés
    public function getAllQueryParams(): array {
        return array_map([$this, 'sanitizeInput'], $_GET);
    }
}
