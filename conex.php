<?php

session_start(); // Start the session

// Conexión a la base de datos
$host = 'localhost';  // Host de la base de datos
$dbname = 'login';  // Nombre de la base de datos
$username = 'root';  // Nombre de usuario de MySQL
$password = '';  // Contraseña de MySQL

try {
    // Crear una instancia de PDO
    $cnx = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $cnx->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("No se pudo conectar a la base de datos:" . $e->getMessage());
}

// Comprobar si se han enviado los datos del formulario
if (isset($_POST['login']) && isset($_POST['password'])) {
    // Obtener la entrada del usuario desde el formulario
    $username_usr = $_POST['login'];
    $password_usr = $_POST['password'];

    // Preparar la consulta SQL para obtener los datos del usuario
    $query = "SELECT * FROM usuarios_prueba WHERE usuario = :username_usr LIMIT 1";

    $stmt = $cnx->prepare($query);
    $stmt->bindParam(':username_usr', $username_usr, PDO::PARAM_STR);
    $stmt->execute();

    // Compruebe si existe un usuario con ese nombre de 
    if ($stmt->rowCount() > 0) {
        // Fetch user data
        $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

        // Verificar la contraseña
        if (password_verify($password_usr, $usuario['contraseña'])) {
            // Iniciar la sesión y almacenar los datos del usuario
            $_SESSION['usuario'] = $usuario['usuario']; // Guardar el nombre de usuario en la sesión
            
            // Redirigir a una página de bienvenida
            header("Location: home.php");
            exit();
        } else {
            echo "Contraseña incorrecta";
        }
    } else {
        echo "Usuario no encontrado";
    }
} else {
    echo "Por favor, ingresa un nombre de usuario y contraseña.";
}
?>
