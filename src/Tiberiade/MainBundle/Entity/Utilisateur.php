<?php

namespace Tiberiade\MainBundle\Entity;

use Serializable;
use Symfony\Component\Security\Core\User\UserInterface;

class Utilisateur implements UserInterface, Serializable{
    
    const ADMIN = "admin";
    const UTILISATEUR = "utilisateur";
    
    static function getProfile(){
        return array(
            self::ADMIN => self::ADMIN,
            self::UTILISATEUR => self::UTILISATEUR
        );
    }

    private $id;
    private $username;
    private $password;
    private $nom;
    private $prenom;
    private $email;
    private $role;
    
    function getRole() {
        return $this->role;
    }

    function setRole($role) {
        $this->role = $role;
        return $this;
    }
    
    function getId() {
        return $this->id;
    }

    function getNom() {
        return $this->nom;
    }

    function getPrenom() {
        return $this->prenom;
    }

    function getEmail() {
        return $this->email;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setUsername($username) {
        $this->username = $username;
        return $this;
    }

    function setPassword($password) {
        $this->password = $password;
        return $this;
    }

    function setNom($nom) {
        $this->nom = $nom;
        return $this;
    }

    function setPrenom($prenom) {
        $this->prenom = $prenom;
        return $this;
    }

    function setEmail($email) {
        $this->email = $email;
        return $this;
    }

    public function eraseCredentials() {
        
    }

    public function getPassword() {
        return $this->password;
    }

    public function getRoles() {
        if($this->role == "admin"){
            return array('ROLE_ADMIN');
        }else{
            return array('ROLE_USER');
        }
    }

    public function getSalt() {
        return null;
    }

    public function getUsername() {
        return $this->username;
    }

    public function serialize() {
        return serialize(array(
            $this->id,
            $this->username,
            $this->password
            // see section on salt below
            // $this->salt,
        ));
    }

    public function unserialize($serialized) {
        list (
            $this->id,
            $this->username,
            $this->password
            // see section on salt below
            // $this->salt
            ) = unserialize($serialized);
        // TODO: Implement unserialize() method.
    }
}
