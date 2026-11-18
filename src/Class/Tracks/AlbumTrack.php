<?php
namespace iutnc\deefy\audio\tracks;

use iutnc\deefy\audio\tracks\AudioTrack as AudioTrack;

class AlbumTrack extends AudioTrack{
    protected string $artiste;
    protected int $annee;
    protected string $album;
    protected int $numPiste;

    public function __construct(string $titre, string $chemin, string $album, int $num, int $duree = 0)
    {
        parent::__construct($titre, $chemin, $duree);
        $this->album = $album;
        $this->numPiste = $num;
    }

    public function setArtiste(string $artiste){
        $this->artiste = $artiste;
    }

    public function setAnnee(int $annee){
        $this->annee = $annee;
    }
}