<?php
namespace iutnc\deefy\audio\tracks;

use iutnc\deefy\exception\InvalidPropertyNameException as InvalidPropertyNameException;
use iutnc\deefy\exception\InvalidPropertyValueException as InvalidPropertyValueException;

class AudioTrack{
    private string $titre;
    private string $genre;
    private int $duree = 0;
    private string $nomFichier;

    public function __construct(string $titre, string $chemin, int $duree = 0)
    {
        $this->titre = $titre;
        $this->nomFichier = $chemin;
        $this->setDuree($duree);
    }

    public function __toString()
    {
        return json_encode(get_object_vars($this));
    }

    public function __get($name)
    {
        if (!property_exists($this, $name)) {
            throw new InvalidPropertyNameException("La propriété '$name' n'existe pas.");
        }

        return $this->$name;
    }

    public function setGenre(string $genre){
        $this->genre = $genre;
    }

    public function setDuree(int $duree){
        if ($duree < 0) {
            throw new InvalidPropertyValueException("La durée ne peut pas être négative.");
        }

        $this->duree = $duree;
    }

}