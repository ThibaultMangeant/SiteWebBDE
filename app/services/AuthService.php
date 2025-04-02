<?php
require_once './app/trait/AuthTrait.php';
require_once './app/entities/Utilisateur.php';

class AuthService {

    use AuthTrait;

    public function getUtilisateur():?Utilisateur
    {
        if(session_status() == PHP_SESSION_NONE)
            session_start();
        return unserialize($_SESSION['utilisateur']);
    }

    public function setUtilisateur(Utilisateur $utilisateur): void
    {
        if(session_status() == PHP_SESSION_NONE)
            session_start();
		if ($utilisateur != null)
		{
        	$_SESSION['utilisateur'] = serialize($utilisateur);
		}
    }

    public function logout(): void
    {
        session_destroy();
    }

    public function isLoggedIn(): bool {
        if(session_status() == PHP_SESSION_NONE)
            session_start();
        return isset($_SESSION['utilisateur']);
    }

	public function isAdmin(): bool {
		if(session_status() == PHP_SESSION_NONE)
			session_start();
		return isset($_SESSION['utilisateur']) && $this->getUtilisateur()->getRole()->getNomRole() === 'admin';
	}
}
