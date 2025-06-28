<?php
session_start();
if(isset($_SESSION['user_id'])) {
    header('Location: index.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    include 'system/config.php';
    $correo = $_POST['correo'] ?? '';
    $clave = $_POST['clave'] ?? '';
    $clave = hash('sha256', $clave);

    // Validar los campos
    if (empty($correo) || empty($clave)) {
        $error = "Por favor, complete todos los campos.";
    } else {

        $consulta = "SELECT id, clave FROM user WHERE email = '$correo' LIMIT 1";
        $resultado = mysqli_query($conn, $consulta);
        if ($resultado && mysqli_num_rows($resultado) > 0) {
            $usuario = mysqli_fetch_assoc($resultado);
            // Verificar la clave
            if ($usuario['clave'] === $clave) {
                $_SESSION['user_id'] = $usuario['id'];
                header('Location: index.php');
                exit();
            } else {
                $error = "Clave incorrecta.";
            }
        } else {
            $error = "Usuario no encontrado.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en" data-bs-theme="auto">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
    <meta name="generator" content="Astro v5.9.2">
    <title>Login</title>
    <script src="assets/js/color-modes.js"></script>
    <link href="assets/dist/css/bootstrap.min.css" rel="stylesheet">
    <meta name="theme-color" content="#712cf9">
    <link href="assets/css/sign-in.css" rel="stylesheet">
</head>

<body class="d-flex align-items-center py-4 bg-body-tertiary">
    <main class="form-signin w-100 m-auto">
        <form method="post" action="">
            <div class="text-center">
                <img class="mb-4" src="assets/brand/bootstrap-logo.svg" alt="" width="72" height="57">
            </div> 
            <h1 class="h3 mb-3 fw-normal">Iniciar Sesion</h1>
            <div class="form-floating">
                <input name="correo" type="email" class="form-control" id="floatingInput" placeholder="name@example.com">
                    <label for="floatingInput">Correo</label> </div>
            <div class="form-floating">
                <input name="clave" type="password" class="form-control" id="floatingPassword" placeholder="Password">
                <label for="floatingPassword">Clave</label> </div>
            <div class="my-3">
                <?php
                if (isset($error)){ 
                    echo $error;
                }
                ?>
                <button class="btn btn-primary w-100 py-2" type="submit">Ingresar</button>
            </div>
            <div class="text-center">
                <p class="mt-5 mb-3 text-body-secondary">&copy; 2025</p>
            </div>
        </form>
    </main>
    <script src="assets/dist/js/bootstrap.bundle.min.js" class="astro-vvvwv3sm"></script>
</body>

</html>