<?php
namespace iutnc\deefy\render;

use iutnc\deefy\audio\lists\AudioList as AudioList;
use iutnc\deefy\audio\tracks\AlbumTrack as AlbumTrack;
use iutnc\deefy\audio\tracks\PodcastTrack as PodcastTrack;
use iutnc\deefy\exception\InvalidArgumentException as InvalidArgumentException;


class AudioListRenderer implements Renderer{

    private AudioList $audioList;

    public function __construct(AudioList $audioList)
    {
        $this->audioList = $audioList;
    }

    public function render(int $selector): string
    {
        $output = "<h3>" . $this->audioList->__get("nom") . "</h3>";
        foreach ($this->audioList->__get("pistes") as $piste) {
            if ($piste instanceof AlbumTrack) {
                $renderer = new AlbumTrackRenderer($piste);
            } elseif ($piste instanceof PodcastTrack) {
                $renderer = new PodcastTrackRenderer($piste);
            }
            $output .= $renderer->render($selector) . "<br>";
        }
        $output .= "<p>Nombre de pistes : " . $this->audioList->__get("nbPistes") . "</p>";
        $output .= "<p>Durée totale : " . $this->audioList->__get("dureeTotale") . "</p>";

        return $output;
    }
}