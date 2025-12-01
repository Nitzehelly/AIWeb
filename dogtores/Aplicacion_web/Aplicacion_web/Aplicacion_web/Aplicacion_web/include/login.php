<?php
    session_start();
    include "db.php";
    
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $usuario = $_POST["usuario"];
        $contrasena = $_POST["contrasena"];
        $stmt = $conn->prepare("SELECT id, contrasena FROM usuarios WHERE usuario = ?");
        $stmt->bind_param("s", $usuario);
        $stmt->execute();
        $stmt->store_result();
        
        if ($stmt->num_rows > 0) {
            $stmt->bind_result($id, $hash);
            $stmt->fetch();
            
            if ($hash !== null && password_verify($contrasena, $hash)) {
                $_SESSION["usuario_id"] = $id;
                $_SESSION["usuario"] = $usuario;
                header("Location: ../IndexVeterinaria.html"); 
                exit();
            
            } else {
                echo "Contraseña incorrecta";
            }
        
        } else {
            echo "Usuario no encontrado";
        }
        
        $stmt->close();
        $conn->close();
    }
?>