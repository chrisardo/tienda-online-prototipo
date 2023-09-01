<center>
    <li>
        <div class="invi border-primary " style=" border:2px solid blue; width: 50%;height: 180%;" category="iquitos">
            <?php
            if ($imagperfi) {
                ?>
                <img src="data:image/jpg;base64,<?php echo $imagperfi; ?>" style="width: 100%" alt="imagen invitado">
            <?php
            } else {
                ?>
                <img src="img/fotoperfil.png" style="width: 100%" alt="imagen invitado">
            <?php
            }
            ?>
            <p class="p"><?php echo $nom. " ".$idlog; ?></p>

        </div>
    </li>
</center>
<br>
<?php
if ($detalle_empresa) {
    ?>
    <center>
        <div style="margin-top: 0px;">
            <?php if ($_SESSION['rolusu'] == "empresa" || $_SESSION['rolusu'] == "repartidor" || $_SESSION['rolusu'] == "user") { ?>
                <div style="display: inline-block;">
                    <p><strong><?php echo $detalle_empresa; ?></strong></p>
                </div>
            <?php } ?>
        </div>
    </center>
<?php
}
?>
<center>
    <a href="verperfil.php?a=1">
        <div class="ciencia" style="width: 40%; border: 2px solid orange; float:left;">
            <div style="">
                <img src="img/perfil.png" style="width: 80px; height: 80px; margin-left: 6px; margin-top: 15px;">
                <p class="p"><strong>PERFIL</strong></p>
            </div>
        </div>
    </a>
    <a href="informacion.php?adm=1">
        <div class="ciencia" style="width: 40%; border: 2px solid orange; float:left;">
            <div style="">
                <img src="img/informa.png" style="width: 80px; height: 80px; margin-left: 6px; margin-top: 15px;">

                <p class="p"><strong>EDITAR INFORMACIÓN</strong></p>
            </div>
        </div>
    </a>
    <?php if ($_SESSION['rolusu'] == "empresa") { ?>
        <a href="admreporteventa.php">
        <?php } else { ?>
            <a href="admreserva.php">
            <?php } ?>
            <div class="ciencia" style="width: 40%; border: 2px solid orange; float:left;">
                <div style="">
                    <img src="img/ordenes.png" style="width: 80px; height: 80px; margin-left: 6px; margin-top: 15px;">
                    <p class="p"><strong>Reporte de productos vendidos</strong></p>
                </div>
            </div>
            </a>
            <?php if (@$_SESSION['rolusu'] == "empresa") { ?>
                <a href="admproductosreportados.php">
                    <div class="ciencia" style="width: 40%; border: 2px solid orange; float:left;">
                        <div style="">
                            <img src="img/reportar.png" style="width: 80px; height: 80px; margin-left: 6px; margin-top: 15px;">
                            <p class="p"><strong>Productos reportados</strong></p>
                        </div>
                    </div>
                </a>
            <?php } else if (@$_SESSION['rolusu'] == "a1") { ?>
                <a href="admclientes.php">
                    <div class="ciencia" style="width: 40%; border: 2px solid orange; float:left;">

                        <div style="">
                            <img src="img/useregis.png" style="width: 80px; height: 80px; margin-left: 6px; margin-top: 15px;">
                            <p class="p"><strong>Clientes</strong></p>
                        </div>
                    </div>
                </a>
            <?php } else { ?>
                <a href="desconectar.php">
                    <div class="ciencia" style="width: 40%; border: 2px solid orange; float:left;">

                        <div style="">
                            <img src="img/exi.png" style="width: 80px; height: 80px; margin-left: 6px; margin-top: 15px;">
                            <p class="p"><strong>Salir</strong></p>
                        </div>
                    </div>
                </a>
            <?php } ?>
</center>
<style>
    /*--Estilos responsive--*/
    @media screen and (min-width: 350px) {
        .ciencia {
            width: 100%;
            border-radius: 8px;
            border: 2px solid blue;
            margin-left: 32px;
            margin-top: 15px;
            height: 160px;
            background: blue;
        }
    }

    div .p {
        color: white;
        margin-top: 6px;
        font-size: 16px;
    }
</style>