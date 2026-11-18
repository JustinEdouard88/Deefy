<?php
namespace iutnc\deefy\action;

use iutnc\deefy\audio\tracks\AlbumTrack;
use iutnc\deefy\repository\DeefyRepository;

class AddTrackAction extends Action{

    protected function executeGet(): string {

        $playlist_options = '';
        foreach(DeefyRepository::getInstance()->getAllPlaylists() as $playlist){
            $selected = (isset($_SESSION['current_playlist_id']) && $_SESSION['current_playlist_id'] == $playlist['id']) ? ' selected' : '';
            $playlist_options .= '<option value="' . $playlist['id'] . '"' . $selected . '>' . $playlist['nom'] . '</option>';
        }
        return '<form id="f1" method="post" action="?action=add_track" enctype="multipart/form-data">
                    <input name="nom" type="text" placeholder="nom de la piste" required></br>
                    <input name="audio" type="file" accept="audio/mp3, audio/mpeg" placeholder="fichier audio" required></br>
                    <input name="type" type="text" placeholder="type de la piste" required></br>
                    <input name="duree" type="number" placeholder="durée de la piste (en secondes)" required></br>
                    <select name="playlist" required>
                        <option value="">Choisir une playlist</option>'
                        . $playlist_options . '</select></br>
                    <button type="submit">Ajouter piste</button>
                </form>';
    }

    protected function executePost(): string {
        $nomPiste = filter_var($_POST['nom'], FILTER_SANITIZE_SPECIAL_CHARS);
        $audioFile = $_FILES['audio'];
        $urlPiste = 'Audio/' . uniqid('track_') . '.mp3';
        move_uploaded_file($audioFile['tmp_name'], $urlPiste);
        $typePiste = filter_var($_POST['type'], FILTER_SANITIZE_SPECIAL_CHARS);
        $dureePiste = filter_var($_POST['duree'], FILTER_SANITIZE_NUMBER_INT);
        $playlistId = (int)filter_var($_POST['playlist'], FILTER_SANITIZE_NUMBER_INT);
        DeefyRepository::getInstance()->addTrack($nomPiste, $typePiste, $dureePiste, $urlPiste, $playlistId);
        return "Piste ajoutée à la playlist";
    }
}