<?php

namespace iutnc\deefy\action;

use iutnc\deefy\action\Action as Action;

class AboutAction extends Action {
    
    protected function executeGet(): string {
        return '<h1>À propos de Deefy</h1><br>
                <p>Projet de développement web fait par EDOUARD Justin S3C.</p>
                <p>Ce deefy est grandement inspiré de Cyberpunk 2077 et de son interface utilisateur.</p>
                <p>Ce projet utilise de l\'ia pour générer le css ainsi que certains éléments html comme l\'animation de l\'écran de démarrage.</p>
                <p>Le site sera surement mis à jour dans le futur pour ajouter de nouvelles fonctionnalités.</p>';
                
    }

    protected function executePost(): string {
        return $this->executeGet();
    }
}