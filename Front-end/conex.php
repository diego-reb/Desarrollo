<?php
$servername = "localhost";  // Dirección del servidor de la base de datos
$username = "root";         // Nombre de usuario de la base de datos
$password = "";             // Contraseña de la base de datos
$dbname = "login";          // Nombre de la base de datos

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar la conexión
if ($conn->connect_error) {
    die("La conexión falló: " . $conn->connect_error);
} else {
    // echo "Conexión exitosa"; // Para producción, evita mostrar esta información
}

$usuario = $_POST['username'];
$password = $_POST['password'];  // Nombre de variable diferente para evitar confusión

// // Consulta SQL para obtener el hash de la contraseña
$sql = "SELECT * FROM usuarios_prueba WHERE usuario = '$usuario' AND contraseña = '$password'";
$stmt = $conn->prepare($sql);

// // Ejecutar la consulta
$result = $conn->query($sql);
// // Verificar si se encuentra el usuario
 if ($result->num_rows > 0) {
    // El dato existe
    header("location:home.html");
    //echo "El valor existe en la base de datos.";
    } 
    else {
    // El dato no existe
    echo "El valor no existe en la base de datos.";
    }
// Cerrar la conexión
$stmt->close();
$conn->close();
?>