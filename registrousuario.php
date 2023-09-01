<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="bootstrap/css/bootstrap.css">
    <link rel="stylesheet" href="bootstrap/css/bootstrap-responsive.css">
    <link rel="stylesheet" type="text/css" href="estilos/estilos.css">
    <title>Proyecto academias</title>
</head>
<body background="images/golf.jpg" style="background-attachment: fixed">
    <center>
        <div class="tit">
            <h2 style="color: #0000FF; ">Registrarse</h2>
            <center>
                <div class="Ingreso">

                    <!-- formulario registro -->

                    <form method="POST" action="">
                        <fieldset>
                            <legend style="font-size: 18pt"><b>Registro</b></legend>
                            <div class="form-group">
                                <label style="font-size: 14pt"><b>Ingresa tu nombre</b></label>
                                <input type="text" name="realname" class="form-control" placeholder="Ingresa tu nombre" />
                            </div>
                            <div class="form-group">
                                <label style="font-size: 14pt; color: #FFFFFF;"><b>Ingresa tu email</b></label>
                                <input type="text" name="nick" class="form-control" required placeholder="Ingresa mail" />
                            </div>
                            <div class="form-group">
                                <label style="font-size: 14pt; color: #FFFFFF;"><b>Ingresa tu Password</b></label>
                                <input type="password" name="pass" class="form-control" placeholder="Ingresa contraseña" />
                            </div>
                            <div class="form-group">
                                <label style="font-size: 14pt"><b>Repite tu contraseña</b></label>
                                <input type="password" name="rpass" class="form-control" required placeholder="repite contraseña" />
                            </div>

                </div>
                <input class="btn btn-danger" type="submit" name="submit" value="Registrarse" />
                </fieldset>
                </form>
        </div>
        <?php
        if (isset($_POST['submit'])) {
            require("registro.php");
        }
        ?>
        <!--Fin formulario registro -->
        </td>
        </tr>
        </table>
        </div>
    </center>
    </div>
    </center>
</body>
</html>