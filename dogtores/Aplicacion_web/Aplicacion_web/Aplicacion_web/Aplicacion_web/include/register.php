<?php
    session_start();
    include "db.php";
    
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $usuario = $_POST["usuario"];
        $correo = $_POST["correo"];
        $contrasena = password_hash($_POST["contrasena"], PASSWORD_DEFAULT);

        $stmt = $conn->prepare("INSERT INTO usuarios (usuario, correo, contrasena) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $usuario, $correo, $contrasena);
        
        if ($stmt->execute()) {
            $_SESSION["usuario_id"] = $stmt->insert_id;
            $_SESSION["usuario"] = $usuario;
            header("Location: ../IndexVeterinaria.html");
            exit();
        } else {
            echo "Error al registrar: " . $stmt->error;
        }
        
        $stmt->close();
        $conn->close();
    }
?>