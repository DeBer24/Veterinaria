<?php
    if (!isset($_SESSION))
        session_start();
    if (!empty($_SESSION['rol']))
    {
        header('Location: principal.php');
        die();
    }
        
    
    include_once 'connection.php';
    
    if (isset($_POST['email'])){
        $query = "SELECT personal.id, roles.nombre FROM personal INNER JOIN roles ON personal.rol_id = roles.id WHERE email = '$_POST[email]' AND clave = '" . md5($_POST['password']) . "'";      
        $resultados = consultaSQL($query);
        
        if (mysqli_num_rows($resultados) != 0){
            $aux = mysqli_fetch_array($resultados);
            $_SESSION['personal_id'] = $aux[0];
            $_SESSION['rol'] = $aux[1];
            header('Location: principal.php');
            die();
        }
        
        $query = "SELECT id FROM clientes WHERE email = '$_POST[email]' AND clave = '" . md5($_POST['password']) . "'";
        $resultados = consultaSQL($query);
        $aux = mysqli_fetch_array($resultados);

        if (!empty($aux[0])){
            $_SESSION['cliente_id'] = $aux[0];
            $_SESSION['rol'] = 'cliente';
            header('Location: principal.php');
            die();
        }
    }
?>

<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Veterinaria San Antón</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
        <link rel="stylesheet" href="styles.css?v=" type="text/css">
        <link rel="icon" href="Recursos/logoVeterinaria.png">
    </head>

    <body class="bg-secondary">
        
<?php
    include_once 'menuSuperior.php';
?>

        <div class="container">
            <div class="row">

                <div class="col-12 col-lg-8 mb-3 mt-2">
                    <div id="carouselExample" class="carousel slide">
                        <div class="carousel-inner">
                            <div class="carousel-item active">
                                <img src="Recursos/Publicidad/atencion247.png" class="d-block w-100 " alt="Publicidad Veterinaria">
                            </div>
                            <div class="carousel-item active">
                                <img src="Recursos/Publicidad/publicidad2.png" class="d-block w-100" alt="Publicidad Veterinaria">
                            </div>
                        </div>
                        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExample" data-bs-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Previous</span>
                        </button>
                        <button class="carousel-control-next" type="button" data-bs-target="#carouselExample" data-bs-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Next</span>
                        </button>
                    </div>
                </div>

                <div class="col-12 col-lg-4 formulario pt-5 mb-3 mt-4">
<?php
    if (isset($_POST['email'])){
?>
                    <div class="alert alert-danger" role="alert">El usuario y/o la contraseña no son correctos</div>
<?php } ?>                
                    <h1>Iniciar Sesión</h1>
                    <form action="" method="POST">
                        <div class="ingreso"><input type="email" name="email" placeholder="Correo electrónico" required></div>
                        <div class="ingreso"><input type="password" name="password" placeholder="Contraseña" required></div>
                        <div class="reestablecer"><a href="">¿Olvidó su contraseña?</a></div>
                        <input type="submit" value="Iniciar Sesión" class="boton1">
                    </form>
                </div>
            </div>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
        <?php include_once 'footer.php';?> 
    </body>
</html>
