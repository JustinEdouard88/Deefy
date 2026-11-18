<?php

class AutoLoader{
    private string $prefixe;
    private string $chemin;

    public function __construct(string $prefixe, string $chemin)
    {
        $this->prefixe = $prefixe;
        $this->chemin = $chemin;
    }

    public function loadClass(string $class){
        $class = str_replace($this->prefixe, "", $class);
        require_once $this->chemin . $class . ".php";
    }

    public function register(){
        spl_autoload_register([$this, 'loadClass']);
    }
}