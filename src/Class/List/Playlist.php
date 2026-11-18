<?php
namespace iutnc\deefy\audio\lists;

use iutnc\deefy\audio\tracks\AudioTrack as AudioTrack;

class Playlist extends AudioList{
    public function __construct(string $titre, ?array $pistes = [])
    {
        parent::__construct($titre, $pistes);
    }

    public function addPiste(AudioTrack $piste){
        $this->pistes[] = $piste;
        $this->nbPistes++;
        $this->dureeTotale += $piste->__get("duree");
    }

    public function removePiste(AudioTrack $piste){
        $index = array_search($piste, $this->pistes);
        if ($index !== false) {
            unset($this->pistes[$index]);
            $this->pistes = array_values($this->pistes); // Re-index the array
            $this->nbPistes--;
            $this->dureeTotale -= $piste->__get("duree");
        }
    }

    public function addAudioList(array $audioList){
        foreach ($audioList as $piste) {
            $this->addPiste($piste);
        }
    }
}