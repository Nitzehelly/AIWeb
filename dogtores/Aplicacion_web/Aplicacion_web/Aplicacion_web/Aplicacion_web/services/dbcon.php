<?php
    require_once("config/db.php");
    function conectar(){
        try{
            $dbc=new PDO(
            'mysql:host='.DBHOST.
            ';port='.DBPORT.
            ';dbname='.DBNAME,
            DBUSER,
            DBPASS,
            array(PDO::ATTR_PERSISTENT => false)
            );
        echo"<script>console.log('conexion establecida');</script>";
            return $dbc;
    }
    catch(PDOException $e){
        echo"ocurrio un error de conexion, consulte la consola para saber mas.";

        echo"<script>console.log(\"". $e->getMessage()."\");</script>";
        return null;
    }
}
?>