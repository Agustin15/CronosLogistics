<?php

session_id("sessionCrecom");
session_start();

if (empty($_SESSION['id'])) {

?>
    <?php

    header('Location:../controllers/login.html');
    ?>
<?php
}
require("../controllers/claseEditarPerfil.php");
$claseEditarPerfil = new editarPerfil();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="img/LogoQuickCarry.png" type="image/x-icon">
    <link rel="stylesheet" href="style.css">
    <title>Editar Perfil</title>
</head>

<body>
    <header>



        <a href="index.php">
            <img src="img/atras.png" width="30px">
        </a>
        <h1>Editar Perfil</h1>

        <div onclick="mostrarMenu()" class="miPefil">
            <img class="userImg" src="img/miPerfil.png" width="30px">

        </div>
    </header>
    <br>





    <br>

    <div class="containerDatosPerfil">

        <br>
        <div id="avisoDatosExistentes">

            <div class="containerInfo">
                <img src="img/exclamacion.png" width="17px">
                <a>Error</a>
            </div>
            <h2 id="msjAviso"></h2>

        </div>

        <form id="formEditarPerfil" method="POST">

            <div class="tituloEditar">
                <h1>Datos del Perfil</h1>
            </div>


            <div class="containerInputsEditar">


                <br>
                <label class="lblUsuario">Usuario</label>
                <br>
                <input class="inputUsuarioEditar" name="usuario" id="inputUsuario" type="text" value="<?php echo $_SESSION['usuario'] ?>">


                <div class="inputIzqEditar">
                    <label class="lblNombreEditar">Nombre</label>
                    <br>

                    <input type="text" name="nombre" value="<?php echo $_SESSION['nombre'] ?>">

                    <br><br>
                    <label class="lblCorreoEditar">Correo</label>
                    <br>

                    <input type="email" name="correo" value="<?php echo $_SESSION['correo'] ?>">
                    <br><br>


                </div>


                <div class="inputDerEditar">

                    <label class="lblApellidoEditar">Apellido</label>
                    <br>

                    <input type="text" name="apellido" value="<?php echo $_SESSION['apellido'] ?>">

                    <br><br>

                    <label class="lblCI">C.I</label>
                    <br>

                    <input type="text" name="cedula" maxlength="8" value="<?php echo $_SESSION['cedula'] ?>">
                </div>
            </div>
            <br><br>

            <label class="lblNumFuncio">N° Funcionario</label>
            <br>

            <input class="inputFuncio" type="number" name="numFuncio" min="1" value="<?php echo $_SESSION['numFuncio'] ?>">

            <input class="guardarCambios" id="guardarCambios" type="submit" value="Guardar cambios">

        </form>

        <div class="containerUsuario">

            <img src="img/miPerfil.png">
            <br>
        
            <a>Puesto:<br>Funcionario Crecom</a>
        </div>
    </div>

</body>

<?php

?>
<script>



</script>

<?php
if ($_SERVER['REQUEST_METHOD'] == "POST") {

    $nombre = $_POST['nombre'];
    $apellido = $_POST['apellido'];
    $correo = $_POST['correo'];
    $usuario = $_POST['usuario'];
    $numFuncio = $_POST['numFuncio'];
    $cedula = $_POST['cedula'];


    $repetidoUsuarioCrecom = $claseEditarPerfil->comprobarUsuarioActualizado($usuario, $_SESSION['id']);
    $repetidoUsuarioFuncioQuick = $claseEditarPerfil->UsuarioRepetidoFuncioQuick($usuario);
    $repetidoClienteEnCrecom = $claseEditarPerfil->comprobarUsuarioRepetidoClienteCrecom($usuario);
    $repetidoUsuarioChofer = $claseEditarPerfil->usuarioRepetidoChofer($usuario);
    $repetidoUsuarioAdmin = $claseEditarPerfil->usuarioRepetidoAdmin($usuario);

    $repetidoCorreoCrecom = $claseEditarPerfil->comprobarCorreoActualizado($correo, $_SESSION['id']);
    $repetidoCorreoFuncioQuick = $claseEditarPerfil->comprobarCorreoRepetidoFuncioQuick($correo);
    $repetidoCorreoChofer = $claseEditarPerfil->comprobarCorreoRepetidoChofer($correo);
    $repetidoCorreoEnClienteCrecom = $claseEditarPerfil->comprobarCorreoRepetidoClienteCrecom($correo);
    $repetidoCorreoAdmin = $claseEditarPerfil->comprobarCorreoRepetidoAdmin($correo);


    $repetidoCedulaCrecom = $claseEditarPerfil->comprobarCedulaActualizado($cedula, $_SESSION['id']);
    $repetidoCedulaFuncioQuick = $claseEditarPerfil->comprobarCedulaRepetidoFuncioQuick($cedula);
    $repetidoCedulaChofer = $claseEditarPerfil->comprobarCedulaRepetidoChofer($cedula);



    $repetidoNumFuncio = $claseEditarPerfil->comprobarNumFuncioActualizado($numFuncio, $_SESSION['id']);

    if ($repetidoNumFuncio == true) {


?>
        <script>
            document.getElementById("avisoDatosExistentes").style.visibility = "visible";
            document.getElementById("msjAviso").innerHTML = 'N° Funcionario ya en uso';
        </script>
        <?php
    } else {

        if (
            $repetidoCorreoAdmin > 0 || $repetidoCorreoCrecom == true
            || $repetidoCorreoChofer > 0 || $repetidoCorreoFuncioQuick > 0
            || $repetidoCorreoEnClienteCrecom > 0
        ) {


        ?>
            <script>
                document.getElementById("avisoDatosExistentes").style.visibility = "visible";
                document.getElementById("msjAviso").innerHTML = 'Correo ya en uso';
            </script>
            <?php
        } else {


            if ($repetidoCedulaChofer > 0 || $repetidoCedulaCrecom == true || $repetidoCedulaFuncioQuick > 0) {


            ?>
                <script>
                    document.getElementById("avisoDatosExistentes").style.visibility = "visible";
                    document.getElementById("msjAviso").innerHTML = 'Cedula ya en uso';
                </script>
                <?php
            } else {


                if (
                    $repetidoUsuarioCrecom == true  || $repetidoUsuarioAdmin > 0
                    || $repetidoUsuarioChofer > 0 || $repetidoUsuarioFuncioQuick > 0
                    ||  $repetidoClienteEnCrecom > 0
                ) {


                ?>
                    <script>
                        document.getElementById("avisoDatosExistentes").style.visibility = "visible";
                        document.getElementById("msjAviso").innerHTML = 'Usuario ya en uso';
                    </script>
                <?php
                } else {

                    $sentencia = $claseEditarPerfil->modificarUsuario(
                        $nombre,
                        $apellido,
                        $usuario,
                        $numFuncio,
                        $cedula,
                        $correo,
                        $_SESSION['id']
                    );
                    $_SESSION['nombre'] = $nombre;
                    $_SESSION['apellido'] = $apellido;
                    $_SESSION['usuario'] = $usuario;
                    $_SESSION['correo'] = $correo;
                    $_SESSION['numFuncio'] = $numFuncio;
                    $_SESSION['cedula'] = $cedula;

                ?>

                    <script>
                        location.href = "editarPerfilUsuario.php";
                    </script>

<?php
                }
            }
        }
    }
}
?>


<script>


    function cerrarAviso() {

        document.getElementById('perfilDatosGuardados').classList.remove("active");

    }
</script>

</html>