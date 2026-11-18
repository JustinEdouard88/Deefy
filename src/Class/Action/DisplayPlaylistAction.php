<?php
namespace iutnc\deefy\action;


use iutnc\deefy\render\AudioListRenderer as AudioListRenderer;
use iutnc\deefy\render\Renderer as Renderer;
use iutnc\deefy\repository\DeefyRepository as DeefyRepository;
use iutnc\deefy\audio\lists\Playlist as Playlist;
use iutnc\deefy\audio\tracks\AlbumTrack as AlbumTrack;


class DisplayPlaylistAction extends Action{

    protected function executeGet(): string {
        $html = "";
        $repo = DeefyRepository::getInstance();
        
        if(!isset($_GET['id'])){
            foreach($repo->getAllPlaylists() as $p){
                $html .= "<h3><a href='?action=display_playlist&id=" . $p['id'] . "'>" . $p['nom'] . "</a></h3>";
            }
        }
        else{
            $html .= "<a href='?action=display_playlist'>Retour aux playlists</a><br><br>";
            $id = (int)filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);
            $_SESSION['current_playlist_id'] = $id;
            $playlistData = $repo->getPlaylistById($id);
            $playlist = new Playlist($playlistData[0]['nom']);
            $track_ids = $repo->getTracksByPlaylistId($id);
            foreach($track_ids as $track){
                $track = new AlbumTrack($track['titre'], $track['filename'], $track['genre'], 0, $track['duree']);
                $playlist->addPiste($track);
            }
            
            $renderPlaylist = new AudioListRenderer($playlist);
            $html .= $renderPlaylist->render(Renderer::LONG);
            $html .= "<br><a href='?action=add_track'>Ajouter une piste</a>";
        } 
        return $html;
    }

    protected function executePost(): string {
        return $this->executeGet();
    }
}