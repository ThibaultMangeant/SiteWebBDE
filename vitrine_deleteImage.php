<?php
require_once './app/controllers/VitrineController.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $section = $_POST['section'] ?? null;
    $image = $_POST['image'] ?? null;

    if ($section && $image) {
        $vitrineController = new VitrineController();
        $vitrineController->deleteImage($section, $image);
        http_response_code(200); // Succès
    } else {
        http_response_code(400); // Mauvaise requête
    }
}
