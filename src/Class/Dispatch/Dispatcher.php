<?php

namespace iutnc\deefy\dispatch;

use iutnc\deefy\action\AddPlaylistAction as AddPlaylistAction;
use iutnc\deefy\action\AddTrackAction as AddTrackAction;
use iutnc\deefy\action\DisplayPlaylistAction as DisplayPlaylistAction;
use iutnc\deefy\action\DefaultAction as DefaultAction;
use iutnc\deefy\action\AboutAction as AboutAction;

class Dispatcher{

    private String $action;

    public function __construct(){
        $this->action = $_GET['action'] ?? 'default';
    }

    private function renderPage(string $html): void {

        $bootHtml = '';
        if (!isset($_SESSION['demarrage'])) {
            $_SESSION['demarrage'] = true;
            $bootHtml = '
            <div id="boot-screen">
                <div class="boot-text">INITIALIZING DEEFY_OS v4.02</div>
                <div class="boot-sub">LOADING NEURAL AUDIO DRIVERS<span id="p1">.</span><span id="p2" style="opacity:0;">.</span><span id="p3" style="opacity:0;">.</span> <span id="boot-ok" style="opacity: 0;">OK</span></div>
            </div>';
        }

        echo <<<HTML
        <!DOCTYPE html>
        <html lang="fr">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Deefy</title>
            <link rel="stylesheet" href="css/style.css?v=2">
            <link rel="icon" type="image/png" href="logo.png?v=2"/>
        </head>
        <body>
            {$bootHtml}
            <div class="cp-layout">
                <header class="cp-header-box">
                    <h1><a href="index.php" style="color: inherit; text-decoration: none;">Deefy</a></h1>
                </header>
                <aside class="cp-sidebar-box">
                    <nav class="cp-nav">
                        <ul>
                            <li><a href="index.php?action=add_playlist">Ajouter une playlist</a></li>
                            <li><a href="index.php?action=add_track">Ajouter une piste</a></li>
                            <li><a href="index.php?action=display_playlist">Afficher la playlist</a></li>
                            <li><a href="index.php?action=about">À propos</a></li>
                        </ul>
                    </nav>
                </aside>
                <main class="cp-main-box">
                    {$html}
                </main>
            </div>
        </body>

        <script>
            window.addEventListener('DOMContentLoaded', () => {
                const p1 = document.getElementById('p1');
                const p2 = document.getElementById('p2');
                const p3 = document.getElementById('p3');
                const okElement = document.getElementById('boot-ok');
                const bootScreen = document.getElementById('boot-screen');

                if (bootScreen) {
                    // Étape 1 : Afficher le 1er point après 400ms
                    setTimeout(() => { if(p1) p1.style.opacity = '1'; }, 400);

                    // Étape 2 : Afficher le 2e point après 800ms
                    setTimeout(() => { if(p2) p2.style.opacity = '1'; }, 800);

                    // Étape 3 : Afficher le 3e point ET le "OK" en même temps après 1200ms
                    setTimeout(() => { 
                        if(p3) p3.style.opacity = '1'; 
                        if(okElement) okElement.style.opacity = '1'; 
                    }, 1200);

                    // Étape 4 : Disparition de l'écran de boot un court instant après l'apparition du OK (ex: à 1600ms)
                    setTimeout(() => {
                        bootScreen.style.opacity = '0';
                        setTimeout(() => bootScreen.style.display = 'none', 500);
                    }, 1600);
                }
            });
        </script>
        </html>
        HTML;
    }

    public function run(): void {
        switch ($this->action) {
            case 'add_playlist':
                $action = new AddPlaylistAction();
                break;
            case 'add_track':
                $action = new AddTrackAction();
                break;
            case 'display_playlist':
                $action = new DisplayPlaylistAction();
                break;
            case 'about':
                $action = new AboutAction();
                break;
            default:
                $action = new DefaultAction();
        }
        $html = $action->execute();
        $this->renderPage($html);
    }
}