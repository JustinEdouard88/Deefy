<?php
namespace iutnc\deefy\audio\tracks;

use iutnc\deefy\exception\InvalidPropertyNameException as InvalidPropertyNameException;
use iutnc\deefy\exception\InvalidPropertyValueException as InvalidPropertyValueException;


class PodcastTrack extends AudioTrack{
    protected string $auteur;
    protected string $date;

    public function __construct(string $titre, string $chemin, string $auteur = "(vide)", ?string $date = "(vide)", int $duree = 0)
    {
        parent::__construct($titre, $chemin, $duree);
        $this->auteur = $auteur;
        $this->date = $date;
    }

    public function setAuteur(string $auteur){
        $this->auteur = $auteur;
    }

    public function setDate(string $date){
        $this->date = $date;
    }

}