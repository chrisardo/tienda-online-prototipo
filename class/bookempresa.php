<?php
class Bookempresa
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
            $sth = $this->objCon->prepare('SELECT * FROM logueo_empresa
             INNER JOIN rol on logueo_empresa.codigorol = rol.codigorol 
 WHERE estado !=0 and nombreempresa LIKE "% ' . $word . '%" '
                . 'OR nombreempresa LIKE "%' . $word . '%"'
                . 'OR direccionempresa LIKE "%' . $word . '%"'
                . 'OR username_empresa LIKE "%' . $word . '%"');
            $sth->execute();
            return $sth->fetchAll();
        } else {
            //SI HAY UNA FRASE SE UTILIZA EL ALGORTIMO DE BUSQUEDA AVANZADO DE MATCH AGAINST
            //busqueda de frases con mas de una palabra y un algoritmo especializado
            $sth = $this->objCon->prepare('SELECT *, MATCH (nombreempresa, direccionempresa, username_empresa) '
                . 'AGAINST (:words) FROM books WHERE MATCH (nombreempresa, direccionempresa, username_empresa) '
                . 'AGAINST (:words) ');
            $sth->execute(
                array(':words' => $word)
            );
            return $sth->fetchAll();
        }
    }
}
