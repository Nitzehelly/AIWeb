<?php

    class usuario{
        private $id;
        private $user;
        private $pass;
        private $nom;
        private $apat;
        private $amat;
        private $email;
        private $status;
        
        function __construct($user, $pass="",
        $id=0, $nom="",$apat="", $amat="",
        $email="",$status=0)
        {
            
            $this->id=$id;
            $this->pass=$pass;
            $this->nom=$nom;
            $this->apat=$apat;
            $this->amat=$amat;
            $this->email=$email;
            $this->status=$status;
            $this->user=$user;
        }
        
        function getNomCom(){
            return $this->nom." ". $this->apat." ".$this->amat; 
        }
    }
?>