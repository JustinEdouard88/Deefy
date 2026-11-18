<?php
namespace iutnc\deefy\action;

use iutnc\deefy\audio\lists\Playlist;
use iutnc\deefy\repository\DeefyRepository;


class AddPlaylistAction extends Action{

    protected function executeGet(): string {
        return '<form id="f1" method="post" action="?action=add_playlist">
                    <input name="nom" type="text" placeholder="nom de la playlist" required></br>
                    <button type="submit">Créer playlist</button>
                </form>';
    }

    protected function executePost(): string {
        $repo = DeefyRepository::getInstance();
        $nomPlaylist = filter_var($_POST['nom'], FILTER_SANITIZE_SPECIAL_CHARS);
        $_SESSION['current_playlist_id'] = $repo->addPlaylist($nomPlaylist);
        return "Playlist " . $nomPlaylist . " créée";
    }
}