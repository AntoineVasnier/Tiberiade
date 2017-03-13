<?php

namespace Tiberiade\MainBundle\Entity;

class Article {
    private $id;
    private $titre;
    private $description;
    private $resume;
    private $datePublication;
    private $urlImage;
    
    public function getId(){
        return $this->id;
    }
    
    public function getTitre(){
        return $this->titre;
    }
    
    public function getDescription(){
        return $this->description;
    }
    
    public function getResume(){
        return $this->resume;
    }
    
    public function getDatePublication(){
        return $this->datePublication;
    }
    
    public function getUrlImage(){
        return $this->urlImage;
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
    
    public function setDatePublication($datePublication){
        $this->datePublication = $datePublication;
    }
    
    public function setUrlImage($urlImage){
        $this->urlImage = $urlImage;
    }

}
