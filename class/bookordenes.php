<?php
class Bookordenes
{
    public $objCon;
    public function __construct()
    {
        //nos conectamos a la base de datos...
        require 'class/database.php';
        $this->objCon = new DataBase();
    }
    public function buscar($word = FALSE, $num = FALSE)
    {
        if ($num == 1) {
            $id_us = $_SESSION['idusu'];
            if ($_SESSION['rolusu'] == "a1") {
                //SI SOLO HAY UNA PALABRA DE BUSQUEDA SE ESTABLECE UNA INSTRUCION CON LIKE
                $sth = $this->objCon->prepare('SELECT * FROM ordenes
                WHERE nomproducto LIKE "% ' . $word . '%" '
                    . 'OR nomproducto LIKE "%' . $word . '%"'
                    . 'OR categ_producto LIKE "%' . $word . '%"'
                    . 'OR distrito LIKE "%' . $word . '%"'
                    . 'OR direccion_orden LIKE "%' . $word . '%" ');
            } elseif ($_SESSION['rolusu'] == "empresa") {
                //SI SOLO HAY UNA PALABRA DE BUSQUEDA SE ESTABLECE UNA INSTRUCION CON LIKE
                $sth = $this->objCon->prepare('SELECT *FROM ordenes 
                WHERE id_empresa="' . $id_us . '" AND nomproducto LIKE "% ' . $word . '%" '
                    . 'OR nomproducto LIKE "%' . $word . '%"'
                    . 'OR categ_producto LIKE "%' . $word . '%"'
                    . 'OR distrito LIKE "%' . $word . '%"'
                    . 'OR direccion_orden LIKE "%' . $word . '%"');
                //echo "Error: " . $sth . "<br>" . mysqli_error($conexion);
            } elseif ($_SESSION['rolusu'] == "user") {
                //SI SOLO HAY UNA PALABRA DE BUSQUEDA SE ESTABLECE UNA INSTRUCION CON LIKE
                $sth = $this->objCon->prepare('SELECT*FROM ordenes
                    WHERE idusu="' . $id_us . '" AND nomproducto LIKE "% ' . $word . '%" '
                    . 'OR nomproducto LIKE "%' . $word . '%"'
                    . 'OR categ_producto LIKE "%' . $word . '%"'
                    . 'OR distrito LIKE "%' . $word . '%"'
                    . 'OR direccion_orden LIKE "%' . $word . '%"');
            }

            $sth->execute();
            return $sth->fetchAll();
        } else {
            //SI HAY UNA FRASE SE UTILIZA EL ALGORTIMO DE BUSQUEDA AVANZADO DE MATCH AGAINST
            //busqueda de frases con mas de una palabra y un algoritmo especializado
            $sth = $this->objCon->prepare('SELECT *, MATCH (nomproducto, categ_producto, distrito, direccion_orden) '
                . 'AGAINST (:words) FROM books WHERE MATCH (nomproducto, categ_producto, distrito, direccion_orden) '
                . 'AGAINST (:words) ');
            $sth->execute(
                array(':words' => $word)
            );
            return $sth->fetchAll();
        }
    }
}
