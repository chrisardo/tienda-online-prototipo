<?php
class Bookrepartidor
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
            $sth = $this->objCon->prepare('SELECT * FROM logueo_repartidor
         WHERE nombre_repartidor LIKE "% ' . $word . '%" '
                . 'OR nombre_repartidor LIKE "%' . $word . '%"'
                . 'OR apellido_repartidor LIKE "%' . $word . '%"'
                . 'OR direcci_repartidor LIKE "%' . $word . '%"');
            $sth->execute();
            return $sth->fetchAll();
        } else {
            //SI HAY UNA FRASE SE UTILIZA EL ALGORTIMO DE BUSQUEDA AVANZADO DE MATCH AGAINST
            //busqueda de frases con mas de una palabra y un algoritmo especializado
            $sth = $this->objCon->prepare('SELECT *, MATCH (nombre_repartidor, apellido_repartidor, direcci_repartidor) '
                . 'AGAINST (:words) FROM books WHERE MATCH (nombre_repartidor, apellido_repartidor, direcci_repartidor) '
                . 'AGAINST (:words) ');
            $sth->execute(
                array(':words' => $word)
            );
            return $sth->fetchAll();
        }
    }
}