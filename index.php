<?php
    if (!isset($_SESSION))
        session_start();
    
    if (!empty($_SESSION['rol']))
    {
        if($_SESSION['rol'] == 'cliente'){
            header('Location: consultaAtenciones.php');
            die();
        }else{
        header('Location: abmcAtenciones.php');
        die();
        }
    }
        
    
    include_once 'consultasdb/connection.php';
    
    if (isset($_POST['email']) && isset($_POST['password'])){
        $query = "SELECT personal.id, roles.nombre, roles.id, personal.nombre, personal.apellido FROM personal INNER JOIN roles ON personal.rol_id = roles.id WHERE email = '$_POST[email]' AND clave = '" . md5($_POST['password']) . "'";      
        $resultados = consultaSQL($query);
        
        if (mysqli_num_rows($resultados) != 0){
            $aux = mysqli_fetch_array($resultados);
            $_SESSION['personal_id'] = $aux[0];
            $_SESSION['rol'] = $aux[1];
            $_SESSION['rol_id'] = $aux[2];
            $_SESSION['nombre'] = $aux[3];
            $_SESSION['apellido'] = $aux[4];
            header('Location: abmcAtenciones.php');
            die();
        }
        
        $query = "SELECT id, nombre, apellido FROM clientes WHERE email = '$_POST[email]' AND clave = '" . md5($_POST['password']) . "'";
        $resultados = consultaSQL($query);
        $aux = mysqli_fetch_array($resultados);

        if (!empty($aux[0])){
            $_SESSION['cliente_id'] = $aux[0];
            $_SESSION['rol'] = 'cliente';
            $_SESSION['nombre'] = $aux[1];
            $_SESSION['apellido'] = $aux[2];
            header('Location: consultaAtenciones.php');
            die();
        }
    }

    include_once('snippets/cabeceraHtml.php');
    mostrarCabecera("<link rel='stylesheet' href='styles/stylesIndex.css' type='text/css'>");
?>

    <body>
        <?php include_once 'snippets/menuSuperior.php' ?>

        <div class="container">
            <div class="row">
            <?php
                $files = glob('recursos/publicidad/*.{jpg,png}', GLOB_BRACE);
                if (count($files) > 0){
                    $bandera = true;
            ?>

                <div class="col-12 col-lg-7 mb-4 mt-4">
                    <div id="carouselExampleAutoplaying" class="carousel slide" data-bs-ride="carousel">
                        <div class="carousel-inner">

                            <?php foreach ($files as $file){
                                echo "<div class='carousel-item" . ($bandera ? " active" : "") . "'>";
                                    echo "<img src=" . $rutaInicio . $file . " class='d-block w-100' alt='Publicidad Veterinaria'>";
                                echo "</div>";
                                $bandera = false;
                            } ?>
                            
                        </div>
                        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleAutoplaying" data-bs-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Anterior</span>
                        </button>
                        <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleAutoplaying" data-bs-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Siguiente</span>
                        </button>
                    </div>

                </div>
                <?php } ?>
                <div class="col-lg-1 d-none d-md-block"></div>
                <div class="col-12 col-lg-4 bg-light rounded-5 pt-4 mb-5 mt-5 flex-wrap border border-warning border-4 ">
<?php
    if (isset($_POST['email'])){
?>
                    <div class="alert alert-danger pt-2" role="alert">El usuario y/o la contraseña no son correctos
                    <button type="button" class="btn-close ms-4" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
<?php } ?>                
                    <form action="#" method="POST">
                        <h1 class="text-secondary border-bottom border-warning border-5">Iniciar Sesión</h1>
                        <div class="form-floating mb-3">
                            <input name="email" type="email" class="form-control ingreso" id="floatingInput" placeholder="Correo Electronico" required>
                            <label for="floatingInput">Correo electrónico</label>
                        </div>
                        <div class="form-floating">
                            <input name="password" type="password" class="form-control ingreso" id="floatingPassword" placeholder="Password" required>
                            <label for="floatingPassword">Contraseña</label>
                        </div>

                        <p><a href="#modalRecuperarClave" data-bs-toggle="modal" class="text-black link-offset-2 mb-2 link-underline-opacity-100-hover reestablecer">
                            ¿Olvidó su contraseña?
                        </a></p>
                        
                        <div class="d-grid gap-2 col-6 mx-auto">
                            <button class="btn btn-warning mb-4 mt-2" type="submit">Iniciar Sesión</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        
        
        <div class="modal fade" id="modalRecuperarClave" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="labelModal" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="labelModal">Recuperar mi clave</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <form action="snippets/enviarMail.php" method="POST">
                        <div class="modal-body">
                            <input type="hidden" name="operacion" value="recuperarClave">
                            <div class="form-group">
                                <label for="email" class="form-label">Su correo electrónico</label>
                                <input type="email" id="email" name="correo" class="form-control" required>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                            <button type="submit" class="btn btn-warning">Continuar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

        <?php 
        include_once 'snippets/footer.php';
        include_once 'snippets/mostrarAlerta.php'
        ?>
    </body>
</html>
