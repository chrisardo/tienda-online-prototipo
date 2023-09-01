<?php
class Bookusuario
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
            $rolcliente = sed::encryption("a1");
            //SI SOLO HAY UNA PALABRA DE BUSQUEDA SE ESTABLECE UNA INSTRUCION CON LIKE
            $sth = $this->objCon->prepare('SELECT * FROM logueo
                                INNER JOIN rol on logueo.codigorol = rol.codigorol 
                    WHERE rol !="' . $rolcliente . '" AND nombreusu LIKE "% ' . $word . '%" '
                    . 'OR idusu LIKE "%' . $word . '%"'
                    . 'OR nombreusu LIKE "%' . $word . '%"'
                    . 'OR apellidousu LIKE "%' . $word . '%"'
                    . 'OR generousu LIKE "%' . $word . '%"');
            $sth->execute();
            return $sth->fetchAll();
        } else {
            //SI HAY UNA FRASE SE UTILIZA EL ALGORTIMO DE BUSQUEDA AVANZADO DE MATCH AGAINST
            //busqueda de frases con mas de una palabra y un algoritmo especializado
            $sth = $this->objCon->prepare('SELECT *, MATCH (idusu, nombreusu, apellidousu, generousu) '
                . 'AGAINST (:words) FROM books WHERE MATCH (idusu, nombreusu, apellidousu, generousu) '
                . 'AGAINST (:words) ');
            $sth->execute(
                array(':words' => $word)
            );
            return $sth->fetchAll();
        }
    }
}
