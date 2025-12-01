<?php
    require_once('../classes/usuario.class.php');
    $user1 = new usuario("Nitzhe",
    "123456"
    ,18,
    "Nitzehelly Yamilet",
    "Muñoz",
    "Suarez",
    "mnit@gmail.com",
    1);
echo $user1->getNomCom();
?>