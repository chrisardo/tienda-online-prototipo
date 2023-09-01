<?php
class Bookscateg
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
            //SI SOLO HAY UNA PALABRA DE BUSQUEDA SE ESTABLECE UNA INSTRUCION CON LIKE
            $id_us = $_SESSION['idusu'];
            if ($_SESSION['rolusu'] == "a1") {
                $sth = $this->objCon->prepare('SELECT * FROM categoria 
                WHERE nombrecateg LIKE "% ' . $word . '%" '
                    . 'OR nombrecateg LIKE "%' . $word . '%"'
                    . 'OR descripcioncateg LIKE "%' . $word . '%"');
            } elseif ($_SESSION['rolusu'] == "empresa") {
                //echo "empresa";
                $sth = $this->objCon->prepare('SELECT * FROM categoria 
                inner join logueo_empresa on categoria.id_empresa=logueo_empresa.id_empresa
                INNER JOIN rol on logueo_empresa.codigorol = rol.codigorol 
                WHERE logueo_empresa.id_empresa="' . $id_us . '" AND categoria.id_empresa="' . $id_us . '" AND nombrecateg LIKE "% ' . $word . '%" '
                    . 'OR nombrecateg LIKE "%' . $word . '%"'
                    . 'OR descripcioncateg LIKE "%' . $word . '%"');
            }
            $sth->execute();
            return $sth->fetchAll();
        } else {
            //SI HAY UNA FRASE SE UTILIZA EL ALGORTIMO DE BUSQUEDA AVANZADO DE MATCH AGAINST
            //busqueda de frases con mas de una palabra y un algoritmo especializado
            $sth = $this->objCon->prepare('SELECT *, MATCH (nombrecateg, descripcioncateg) '
                . 'AGAINST (:words) FROM books WHERE MATCH (nombrecateg, descripcioncateg) '
                . 'AGAINST (:words) ');
            $sth->execute(
                array(':words' => $word)
            );
            return $sth->fetchAll();
        }
    }
}
