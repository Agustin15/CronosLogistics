<?php

session_id("sessionAdmin");
session_start();

if (empty($_SESSION['id'])) {

?>
    <?php

    header('Location:../../../controllers/login.html');
    ?>
<?php
}

require('../controllers/claseDatosUsuario.php');
$claseDatosUsuario = new datosUsuario();

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <link rel="shortcut icon" href="img/LogoQuickCarry.png" type="image/x-icon">
    <title>Borrar Chofer QuickCarry</title>
</head>

<body>

    <header>

        <a href="index.php">
            <img class="userImg" src="img/atras.png" width="30px">
        </a>
        <h1>Usuarios Choferes</h1>
        <div onclick="mostrarMenu()" class="miPefil">
            <img class="userImg" src="img/miPerfil.png" width="30px">

        </div>
    </header>

    <div class=".active" onmouseleave="ocultarMenu()" id="menuPerfilBorrarChofer">

        <img src="img/miPerfil.png" width="60px">
        <h4><?php echo $_SESSION['usuario'] ?></h4>
        <a href="../../../views/editarPerfilUsuarioAdmin.php"><button>Editar perfil</button></a>
        <br>
        <br>
        <hr>

        <div class="cerrarSesionBorrarChofer">
            <img src="img/apagado.png" width="18px">
            <a href="../../controllers/cerrarSesion.php">Cerrar Sesion</a>
        </div>

    </div>

    <?php

    if ($_GET['id']) {

        $id = $_GET['id'];


        $conexion =  new mysqli('localhost','root','','php');  
        
        $sentencia = "select * from chofercamion where id='$id'";

        $registro = $conexion->query($sentencia);

    ?>
        <div class="msjEliminar">
            <img src="img/eliminar.png" width="30px">
            <br><br>

            <?php
            if ($reg = mysqli_fetch_array($registro)) {

                $sentencia = $claseDatosUsuario->eliminarUsuario($id);

            ?>
                <a class="msj">Registro de <?php echo $reg['nombre'] ?> eliminado</a>

            <?php
            } else {

            ?>

                <a class="msj">Datos no encontrados</a>

            <?php
            }

            ?>
            <br><br>
            <button onclick="volver()" class="volverError">Volver</button>
        </div>
    <?php
        $conexion->close();
    } else {

    ?>
        <div class="msjEliminar">
            <br>
            <img class="iconoMsj" src="img/advertencia.png" width="40px"><br><br>
            <a class="msj">Datos no encontrados</a><br><br>
            <button onclick="volver()" class="volverError">Volver</button>
        </div>
    <?php
    }
    ?>




    <script>
        function volver() {

            location.href = "index.php";

        }


        var menuPerfil = document.getElementById('menuPerfilBorrarChofer');


        var v = 1;

        function mostrarMenu() {


            menuPerfil.style.visibility = 'visible';
            menuPerfil.classList.add('active');


        }


        function ocultarMenu() {


            menuPerfil.style.visibility = 'hidden';
            menuPerfil.classList.remove('active');

        }
    </script>
</body>

</html>