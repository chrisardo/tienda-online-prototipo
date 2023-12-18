<div style="width: 96%; margin-left: 28px; border:2px solid blue;">
    <div style="width: 100%; border:2px solid blue; background: greenyellow;">
        <center>
            <img src="img/favorito.png" style="width: 30px; height: 30px; margin-left: 6px; margin-top: -0px;">
            <h1 style="display: inline-block; font-size: 18px; color:blue;">Comentarios</h1>
        </center>
    </div>
    <div style="width: 99%; margin-left: 10px;">
        <ul id="comments">
            <?php
            $queryc = "SELECT * FROM comentarios WHERE reply = 0 and idproducto='$idproducto' ORDER BY id_comentario DESC LIMIT 5";
            $sqlcomentarios = mysqli_query($conexion, $queryc);
            $canti_comentario = mysqli_num_rows($sqlcomentarios);
            $comentarios = mysqli_fetch_all($sqlcomentarios, MYSQLI_ASSOC);
            foreach ($comentarios as $rowco) {
                $idcom_use = $rowco['idusu'];
                $queryu = "SELECT * FROM logueo WHERE logueo.idusu = '$idcom_use'";
                $sqlusuario = mysqli_query($conexion, $queryu);
                $usuarios = mysqli_fetch_all($sqlusuario, MYSQLI_ASSOC);
                foreach ($usuarios as $u) {
                    $imp = base64_encode($u['imagperfil']);
                    $nomusu = sed::decryption($u['nombreusu']);
                }
            ?>
            <li class="cmmnt">
                <div style="width: 95%; margin-left: 10px; background: blue; height: 2px; margin-top: 0px;"></div>

                <div style="display: inline-block; ">
                    <?php if (@$imp) { ?>
                    <img src="data:image/jpg;base64,<?php echo base64_encode($users['imagperfil']); ?>"
                        style="width: 50px; height: 66px; <?php if (@$_SESSION['idusu'] == $idcom_use) { ?>margin-top: -50px; <?php } else { ?><?php } ?>">
                    <?php } else { ?>
                    <img src="img/fotoperfil.png"
                        style="width: 50px; height: 57px; border: 2px solid green;  <?php if (@$_SESSION['idusu'] == $idcom_use) { ?>margin-top: -50px; <?php } else { ?><?php } ?>">
                    <?php } ?>
                </div>
                <div style="display: inline-block;">
                    <div style="display: inline-block;">
                        <p style="color:blue; font-size: 14px;">
                            <strong><?php echo $nomusu . " " . sed::decryption($u['apellidousu']) . " "; ?></strong>
                        </p>
                    </div>
                    <div style="display: inline-block;">
                        <p style="font-size: 14px;"><strong><?php echo  $rowco["fecha"]; ?></strong></p>
                    </div>
                    <p style="color:orange; font-size: 14px; margin-top:-16px;">
                        <strong><?php echo sed::decryption($rowco["comentario"]);
                                    ?>
                        </strong>
                    </p>
                    <div style="margin-top:-12px;">
                        <?php if (@$_SESSION['rolusu'] == "empresa") { ?>
                        <a href="vercomentario.php?idproducto=<?php echo $id; ?>&user=<?php echo  $nomusu; ?>&comentario=<?php echo $rowco['id_comentario']; ?>"
                            style="">
                            Responder
                        </a>
                        <?php } ?>
                        <?php if (@$_SESSION['idusu'] == $idcom_use) { ?>
                        <a href="?idproducto=<?php echo $id; ?>&id_comentar=<?php echo $rowco['id_comentario']; ?>"
                            style="">
                            Eliminar
                        </a>
                        <?php } ?>
                    </div>
                </div>
                <?php
                    $contar = mysqli_num_rows(mysqli_query($conexion, "SELECT * FROM comentarios WHERE reply = '" . $rowco['id_comentario'] . "' and idproducto='$idproducto'"));
                    if ($contar != '0') {
                        $reply = mysqli_query($conexion, "SELECT * FROM comentarios WHERE reply = '" . $rowco['id_comentario'] . "'  and idproducto='$idproducto' ORDER BY id_comentario DESC LIMIT 1");
                        while ($rep = mysqli_fetch_array($reply)) {
                            $usuario2 = mysqli_query($conexion, "SELECT * FROM logueo WHERE idusu = '" . $rep['idusu'] . "'");
                            $user2 = mysqli_fetch_array($usuario2);
                            $sqlempresa2 = mysqli_query($conexion, "SELECT * FROM logueo_empresa WHERE id_empresa = '" . $rep['id_empresa'] . "'");
                            $empresa2 = mysqli_fetch_array($sqlempresa2);
                    ?>
                <ul class="replies">
                    <li class="cmmnt">
                        <div style="margin-left:42px;" class="replies">
                            <div style="width: 95%; margin-left: 12px; background: blue; height: 2px; margin-top: 4px;">
                            </div>
                            <div style="display: inline-block; ">
                                <?php if (base64_encode(@$user2['imagperfil'])) { ?>
                                <img src="data:image/jpg;base64,<?php echo base64_encode(@$user2['imagperfil']); ?>"
                                    style="width: 50px; height: 66px; <?php if (@$_SESSION['idusu'] == $idcom_use) { ?>margin-top: -50px; <?php } else { ?><?php } ?>">
                                <?php }
                                            if (base64_encode(@$empresa2['imagempresa'])) { ?>
                                <img src="data:image/jpg;base64,<?php echo base64_encode(@$empresa2['imagempresa']); ?>"
                                    style="width: 50px; height: 66px; <?php if (@$_SESSION['idusu'] == $idcom_use) { ?>margin-top: -50px; <?php } else { ?><?php } ?>">
                                <?php } else { ?>
                                <img src="img/fotoperfil.png"
                                    style="width: 50px; height: 56px; border: 2px solid green; <?php if (@$_SESSION['idusu'] == $idcom_use) { ?>margin-top: -50px; <?php } else { ?><?php } ?>">
                                <?php } ?>
                            </div>
                            <div style="display: inline-block;">
                                <div style="display: inline-block;">
                                    <p style="color:blue; font-size: 14px;">
                                        <strong>
                                            <?php
                                                        if (!empty(sed::decryption(@$user2["nombreusu"])) && !empty(sed::decryption(@$user2['apellidousu']))) {
                                                            echo sed::decryption($user2["nombreusu"]) . " " . sed::decryption($user2['apellidousu']) . " ";
                                                        } else if (!empty(sed::decryption($empresa2["nombreempresa"]))) {
                                                            echo sed::decryption($empresa2["nombreempresa"]);
                                                        }
                                                        ?>
                                        </strong>
                                    </p>
                                </div>
                                <div style="display: inline-block;">
                                    <p style="font-size: 14px;"><strong><?php echo  $rep["fecha"]; ?></strong></p>
                                </div>
                                <p style="color:orange; font-size: 14px; margin-top:-16px;">
                                    <strong><?php echo sed::decryption($rep["comentario"]);
                                                        ?>
                                    </strong>
                                </p>
                                <div style="margin-top:-12px;">
                                    <?php if (@$_SESSION['idusu']) { ?>
                                    <?php if (@$_SESSION['idusu'] == $idcom_use) { ?>
                                    <a href="vercomentario.php?idproducto=<?php echo $id; ?>&user=<?php if (!empty(sed::decryption(@$user2["nombreusu"]))) {
                                                                                                                            echo sed::decryption($user2["nombreusu"]);
                                                                                                                        } else if (!empty(sed::decryption(@$empresa2["nombreempresa"]))) {
                                                                                                                            echo sed::decryption(@$empresa2["nombreempresa"]);
                                                                                                                        } ?>&comentario=<?php echo $rowco['id_comentario']; ?>"
                                        style="">
                                        Responder
                                    </a>
                                    <?php } ?>
                                    <?php if (@$_SESSION['rolusu'] == "empresa" && $rep['idusu']) { ?>
                                    <a href="vercomentario.php?idproducto=<?php echo $id; ?>&user=<?php echo  sed::decryption(@$user2["nombreusu"]); ?>&comentario=<?php echo $rowco['id_comentario']; ?>"
                                        style="">
                                        Responder
                                    </a>
                                    <?php } ?>
                                    <?php if (@$_SESSION['idusu'] == $rep['idusu']) { ?>
                                    <a href="vercomentario.php?idproducto=<?php echo $id; ?>&id_comenta=<?php echo $rep['id_comentario']; ?>"
                                        style="">
                                        Eliminar
                                    </a>
                                    <?php } elseif (@$_SESSION['idusu'] == $rep['id_empresa']) { ?>
                                    <a href="vercomentario.php?idproducto=<?php echo $id; ?>&id_comenta=<?php echo $rep['id_comentario']; ?>"
                                        style="">
                                        Eliminar
                                    </a>
                                    <?php } ?>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                    </li>
                </ul>
                <?php } ?>
                <?php  } ?>
                <?php } ?>
            </li>
        </ul>
    </div>
    <?php if ($canti_comentario >= 2) { ?>
    <div style="width: 100%; border:2px solid blue; background: greenyellow;">
        <center>
            <a href="vercomentario.php?idproducto=<?php echo $id; ?>" style="">
                <h1 style="display: inline-block; font-size: 18px; color:blue;">Ver todos los comentarios</h1>
            </a>
        </center>
    </div>
    <?php } ?>
</div>
<?php
if (@$id_comentar) {
    extract($_GET);
    $eliminarcomen = mysqli_query($mysqli, "DELETE FROM comentarios WHERE id_comentario='$id_comentar'");
    if ($eliminarcomen) {
        echo "<script>location.href='?idproducto=$id'</script>";
    }
}
if (@$id_comenta) {
    extract($_GET);
    $eliminarcomen = mysqli_query($mysqli, "DELETE FROM comentarios WHERE id_comentario='$id_comenta'");
    if ($eliminarcomen) {
        echo "<script>location.href='?idproducto=$id'</script>";
    }
}
?>
<br>
<style>
/* h1 {
        font-family: Tahoma, Geneva, sans-serif;
        font-size: 2.85em;
        line-height: 1.6em;
        font-weight: normal;
        color: #756f8b;
        text-shadow: 0px 1px 1px #fff;
        margin-bottom: 21px;
    }
  #comments .cmmnt,
    ul .cmmnt,
    ul ul .cmmnt {
        display: block;
        position: relative;
        padding-left: 65px;
        border-top: 1px solid #ddd;
    }
    p {
        font-family: Arial, Geneva, Verdana, sans-serif;
        font-size: 1.3em;
        line-height: 1.42em;
        margin-bottom: 12px;
        font-weight: normal;
        color: #656565;
    }

    a {
        color: #069;
        text-decoration: none;
    }

    a:hover {
        text-decoration: underline;
    }

    /* page layout structure */
/*#L {
        display: block;
        width: 700px;
        margin: 0 auto;
        padding-top: 35px;
    }

    #container {
        display: block;
        width: 100%;
        background: #fff;
        padding: 14px 20px;
        -webkit-border-radius: 4px;
        -moz-border-radius: 4px;
        border-radius: 4px;
        -webkit-box-shadow: 1px 1px 1px rgba(0, 0, 0, 0.3);
        -moz-box-shadow: 1px 1px 1px rgba(0, 0, 0, 0.3);
        box-shadow: 1px 1px 1px rgba(0, 0, 0, 0.3);
    }


    /* comments area */
/*#comments {
        display: block;
    }

    #comments .cmmnt,
    ul .cmmnt,
    ul ul .cmmnt {
        display: block;
        position: relative;
        padding-left: 65px;
        border-top: 1px solid #ddd;
    }

    #comments .cmmnt .avatar {
        position: absolute;
        top: 8px;
        left: 0;
    }

    #comments .cmmnt .avatar img {
        -webkit-border-radius: 3px;
        -moz-border-radius: 3px;
        border-radius: 3px;
        -webkit-box-shadow: 1px 1px 2px rgba(0, 0, 0, 0.44);
        -moz-box-shadow: 1px 1px 2px rgba(0, 0, 0, 0.44);
        box-shadow: 1px 1px 2px rgba(0, 0, 0, 0.44);
        -webkit-transition: all 0.4s linear;
        -moz-transition: all 0.4s linear;
        -ms-transition: all 0.4s linear;
        -o-transition: all 0.4s linear;
        transition: all 0.4s linear;
    }

    #comments .cmmnt .avatar a:hover img {
        opacity: 0.77;
    }

    #comments .cmmnt .cmmnt-content {
        padding: 0px 3px;
        padding-bottom: 12px;
        padding-top: 8px;
    }

    #comments .cmmnt .cmmnt-content header {
        font-size: 1.3em;
        display: block;
        margin-bottom: 8px;
    }

    #comments .cmmnt .cmmnt-content header .pubdate {
        color: #777;
    }

    #comments .cmmnt .cmmnt-content header .userlink {
        font-weight: bold;
    }

    #comments .cmmnt .replies {
        margin-bottom: 7px;
    }
    */
</style>