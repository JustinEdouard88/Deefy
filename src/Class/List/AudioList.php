<?php
namespace iutnc\deefy\audio\lists;

use iutnc\deefy\exception\InvalidPropertyNameException as InvalidPropertyNameException;

class AudioList{
    protected string $nom;
    protected int $nbPistes;
    protected int $dureeTotale;
    protected array $pistes;

    public function __construct(string $nom, ?array $pistes = []){
        $this->nom = $nom;
        $this->pistes = $pistes;
        $this->nbPistes = count($pistes);
        $totalDuree = 0;
        foreach ($this->pistes as $piste) {
            $totalDuree += $piste->__get("duree");
        }
        $this->dureeTotale = $totalDuree;
    }

    public function __get($name)
    {
        if (!property_exists($this, $name)) {
            throw new InvalidPropertyNameException("La propriété '$name' n'existe pas.");
        }

        return $this->$name;
    }
}