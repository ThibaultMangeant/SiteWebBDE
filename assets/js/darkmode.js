document.addEventListener('DOMContentLoaded', function() {
    // Récupérer les éléments nécessaires
    const darkModeToggle = document.getElementById('darkModeToggle');
    const loginHeaderLogo = document.getElementById('loginHeaderLogo'); // Logo de connexion dans le header
    
    // Vérifier si un thème est déjà enregistré
    const currentTheme = localStorage.getItem('theme');
    if (currentTheme) {
        document.documentElement.setAttribute('data-theme', currentTheme);
        updateDarkModeIcon(currentTheme === 'dark');
        updateLoginHeaderLogo(currentTheme === 'dark');
    }

    // Ajouter l'événement de clic
    darkModeToggle.addEventListener('click', function() {
        let theme = document.documentElement.getAttribute('data-theme');
        if (theme === 'dark') {
            document.documentElement.setAttribute('data-theme', 'light');
            localStorage.setItem('theme', 'light');
            updateDarkModeIcon(false);
            updateLoginHeaderLogo(false);
        } else {
            document.documentElement.setAttribute('data-theme', 'dark');
            localStorage.setItem('theme', 'dark');
            updateDarkModeIcon(true);
            updateLoginHeaderLogo(true);
        }
    });

    function updateDarkModeIcon(isDark) {
        const darkModeIcon = document.getElementById('darkModeIcon');
        if (isDark) {
            darkModeIcon.src = 'assets/images/light-mode.webp';
            darkModeIcon.alt = 'Mode clair';
        } else {
            darkModeIcon.src = 'assets/images/dark-mode.webp';
            darkModeIcon.alt = 'Mode sombre';
        }
    }

    function updateLoginHeaderLogo(isDark) {
        if (loginHeaderLogo) {
            if (isDark) {
                loginHeaderLogo.src = 'assets/images/login-dark-mode.webp';
                loginHeaderLogo.alt = 'Connexion au compte (Mode Sombre)';
            } else {
                loginHeaderLogo.src = 'assets/images/login-light-mode.webp';
                loginHeaderLogo.alt = 'Connexion au compte (Mode Clair)';
            }
        }
    }
});