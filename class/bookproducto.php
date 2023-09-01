<?php
class Bookproducto
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
            $id_usu = @$_SESSION['idusu'];
            if (@$_SESSION['rolusu'] == "a1" || @$_SESSION['rolusu'] == "user") {
                //SI SOLO HAY UNA PALABRA DE BUSQUEDA SE ESTABLECE UNA INSTRUCION CON LIKE
                $sth = $this->objCon->prepare('SELECT * FROM productos 
                 INNER JOIN categoria on categoria.codigocate=productos.codigocate 
         WHERE nombreproducto LIKE "% ' . $word . '%" '
                    . 'OR nombreproducto LIKE "%' . $word . '%"'
                    . 'OR detalleproducto LIKE "%' . $word . '%"'
                    . 'OR nombrecateg LIKE "%' . $word . '%"');
            } elseif (@$_SESSION['rolusu'] == "empresa") {
                //SI SOLO HAY UNA PALABRA DE BUSQUEDA SE ESTABLECE UNA INSTRUCION CON LIKE
                $sth = $this->objCon->prepare('SELECT * FROM productos 
                 INNER JOIN logueo_empresa on productos.id_empresa=logueo_empresa.id_empresa
                 INNER JOIN rol on logueo_empresa.codigorol = rol.codigorol
                 INNER JOIN categoria on categoria.codigocate=productos.codigocate 
                WHERE logueo_empresa.id_empresa="' . $id_usu . '" AND productos.id_empresa="' . $id_usu . '" AND nombreproducto LIKE "% ' . $word . '%" '
                    . 'OR nombreproducto LIKE "%' . $word . '%"'
                    . 'OR detalleproducto LIKE "%' . $word . '%"'
                    . 'OR nombrecateg LIKE "%' . $word . '%"');
            } else {
                //SI SOLO HAY UNA PALABRA DE BUSQUEDA SE ESTABLECE UNA INSTRUCION CON LIKE
                $sth = $this->objCon->prepare('SELECT * FROM productos 
                inner join categoria on categoria.codigocate=productos.codigocate 
                         WHERE nombreproducto LIKE "% ' . $word . '%" '
                    . 'OR nombreproducto LIKE "%' . $word . '%"'
                    . 'OR detalleproducto LIKE "%' . $word . '%"'
                    . 'OR nombrecateg LIKE "%' . $word . '%"');
            }
            $sth->execute();
            return $sth->fetchAll();
        } else {
            //SI HAY UNA FRASE SE UTILIZA EL ALGORTIMO DE BUSQUEDA AVANZADO DE MATCH AGAINST
            //busqueda de frases con mas de una palabra y un algoritmo especializado
            $sth = $this->objCon->prepare('SELECT *, MATCH (nombreproducto, detalleproducto, nombrecateg) '
                . 'AGAINST (:words) FROM books WHERE MATCH (nombreproducto, detalleproducto, nombrecateg) '
                . 'AGAINST (:words) ');
            $sth->execute(
                array(':words' => $word)
            );
            return $sth->fetchAll();
        }
    }
}
