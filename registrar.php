<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    define('_JEXEC', 1);
    define('JPATH_BASE', __DIR__);
    require_once JPATH_BASE . '/includes/defines.php';
    require_once JPATH_BASE . '/includes/framework.php';

    // Inicializa la aplicación de Joomla
    $app = JFactory::getApplication('site');

    // Obtén los datos del formulario
    $nombre = $_POST['nombre'];
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Crea un nuevo usuario en Joomla
    $user = JFactory::getUser();

    // Define las propiedades del nuevo usuario
    $user->set('name', $nombre);
    $user->set('username', $username);
    $user->set('email', $email);
   
    $salt = JUserHelper::genRandomPassword(32);
    $crypt = JUserHelper::getCryptedPassword($password, $salt);
    $password_hash = $crypt.':'.$salt;
    $user->set('password', $password_hash);

    //$user->set('password', $password);

    // Establece el grupo predeterminado del usuario (opcional)
    $user->set('groups', array(2));



    // Guarda el nuevo usuario en la base de datos
    $result = $user->save();

    if ($result) {
        echo "Usuario registrado exitosamente.";
    } else {
        echo "Error al registrar usuario.";
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Usuario</title>
</head>
<body>
    <h2>Registro de Usuario</h2>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <label for="nombre">Nombre:</label>
        <input type="text" id="nombre" name="nombre" required><br><br>
        <label for="username">Nombre de Usuario:</label>
        <input type="text" id="username" name="username" required><br><br>
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required><br><br>
        <label for="password">Contraseña:</label>
        <input type="password" id="password" name="password" required><br><br>
        <input type="submit" value="Registrarse">
    </form>
</body>