<?php
class Books{
    public $objCon;
    public function __construct() {    
        //nos conectamos a la base de datos...
        require 'class/database.php';
        $this->objCon = new DataBase();
    }
    public function buscar($word = FALSE, $num = FALSE) {
     if($num == 1){
        //SI SOLO HAY UNA PALABRA DE BUSQUEDA SE ESTABLECE UNA INSTRUCION CON LIKE
         $sth = $this->objCon->prepare('SELECT * FROM productos inner join categoria on categoria.idcategoria=productos.idcategoria 
         WHERE nombreproducto LIKE "% '.$word.'%" '
          . 'OR nombreproducto LIKE "%'.$word.'%"'
        . 'OR detalleproducto LIKE "%'.$word.'%"'

        .'OR nombrecateg LIKE "%'.$word.'%"');
         $sth->execute();
         return $sth->fetchAll();
     }  else  {
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