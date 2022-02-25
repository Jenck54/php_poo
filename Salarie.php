<?php

class Salarie extends Personne{
    private $salaire;

    public function __construct($nom, $prenom, $salaire) {
        parent::__construct($nom, $prenom);
        $this->salaire = $salaire;
    }

    public function info() {
        echo "salaire : " . $this->salaire . 
        ", prenom : " . $this->prenom;
    }

    /**
     * Get the value of salaire
     */ 
    public function getSalaire()
    {
        return $this->salaire;
    }

    /**
     * Set the value of salaire
     *
     * @return  self
     */ 
    public function setSalaire($salaire)
    {
        $this->salaire = $salaire;

        return $this;
    }
}
?>