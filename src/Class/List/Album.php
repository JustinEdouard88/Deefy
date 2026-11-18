<?php
namespace iutnc\deefy\audio\lists;

require_once __DIR__ . '/AudioList.php';

class Album extends AudioList{
    protected string $artiste;
    protected int $annee;

    public function __construct(string $titre, array $pistes, string $artiste, int $annee)
    {
        parent::__construct($titre, $pistes);
        $this->artiste = $artiste;
        $this->annee = $annee;
    }

    public function setArtiste(string $artiste){
        $this->artiste = $artiste;
    }

    public function setAnnee(int $annee){
        $this->annee = $annee;
    }
}