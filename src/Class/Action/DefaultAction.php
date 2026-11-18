<?php

namespace iutnc\deefy\action;

class DefaultAction extends Action{

    protected function executeGet(): string {
        return "<p>C0nn3xi0n ét4bli3 sur D33Fy. Rés34u pir4t3 non-enregistré. Coupez les flux des mégacorps et laissez tourner la vraie musique. Sponsorisé par Johnny Silverhand et les rebelles de Samurai. __</p>";
    }

    protected function executePost(): string {
        return $this->executeGet();
    }
}