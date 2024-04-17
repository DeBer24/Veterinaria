<?php
    if(!isset($_SESSION))
        session_start();
?>

<link rel="stylesheet" href="styles/stylesMenuSuperior.css" type="text/css">

<nav class="navbar sticky-top navbar-expand-lg navbar-light bg-light">
    <div class="container-fluid">
        <a class="navbar-brand" href="index.php">
            <img src="recursos/logoVeterinaria.png" id="logoVeterinaria" class="d-inline-block align-top" alt="Logo veterinaria. Click para ir al inicio">
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarScroll" aria-controls="navbarScroll" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        
        <div class="collapse navbar-collapse" id="navbarScroll">
            <div class="d-flex flex-wrap">
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item active ps-2 me-3 seccionesNavegacion">
                        <a class="nav-link text-black"  href="nuestraEmpresa.php"><img class="logo" src="recursos/logoNuestraEmpresa.png" alt="Nuestra Empresa">NUESTRA EMPRESA</a>
                    </li>
                    <li class="nav-item active ps-2 me-3 seccionesNavegacion" >         
                        <a class="nav-link text-black"  href="nuestrosServicios.php"><img class="logo" src="recursos/logoServicios.png" alt="Servicios">SERVICIOS</a>
                    </li>
                    <li class="nav-item active ps-2 me-3 seccionesNavegacion">
                        <a class="nav-link text-black"   href="nuestraUbicacion.php"><img class="logo" src="recursos/logoUbicacion.png" alt="Ubicacion">UBICACIÓN</a>
                    </li>
                </ul>
            </div>
        </div>

        <?php if (isset($_SESSION['rol'])){?>
            <div class="justify-content-end mx-5">
                <form style="display: inline" action="snippets/cerrarSesion.php" method="POST">
                    <button id="btn-cerrarSesion">Salir</button>
                </form>
            </div>
        <?php } ?>

    </div>
</nav>