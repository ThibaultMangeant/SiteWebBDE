<?php
require_once './app/controllers/EvenementController.php';

// Fais la liste des évènements pour l'admin
(new EvenementController())->index();