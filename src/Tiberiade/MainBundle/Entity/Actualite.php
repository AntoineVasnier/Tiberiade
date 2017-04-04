<?php

namespace Tiberiade\MainBundle\Entity;

class Actualite {
    private $id;
    private $titre;
    private $dateDebut;
    private $dateFin;
    private $file;
    private $urlImage;
    
    public function getId(){
        return $this->id;
    }
    
    public function getTitre(){
        return $this->titre;
    }
    
    public function getDateDebut(){
        return $this->dateDebut;
    }
    
    public function getDateFin(){
        return $this->dateFin;
    }
    
    public function getUrlImage(){
        return $this->urlImage;
    }
    
    public function getFile(){
        return $this->file;
    }
    
    public function setId($id){
        $this->id = $id;
    }
    
    public function setTitre($titre){
        $this->titre = $titre;
    }
    
    public function setDescription($description){
        $this->description = $description;
    }
    
    public function setResume($resume){
        $this->resume = $resume;
    }
    
    public function setDateDebut($dateDebut){
        $this->dateDebut = $dateDebut;
    }
    
    public function setDateFin($dateFin){
        $this->dateFin = $dateFin;
    }
    
    public function setUrlImage($urlImage){
        $this->urlImage = $urlImage;
    }
    
    public function setFile($file){
        $this->file = $file;
        return $this;
    }
}