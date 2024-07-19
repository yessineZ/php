<?php 
    
    function ConnectToDb() {
     try {
               $conn = new PDO("mysql:host=localhost;dbname=php_projet_class", "root", "");

    
         }catch(PDOException $e) {
               echo ("Connection failed: ".$e->getMessage());
}
     return $conn ;
}

function GetStocks() {
    $conn = ConnectToDb();
    $sql = "SELECT G.name, G.createur, S.quantite, S.date, S.id 
            FROM games G 
            JOIN stocks S ON G.id = S.produit";
    $result = $conn->query($sql);
    return $result->fetchAll(PDO::FETCH_ASSOC);
}



function UpdateStock($id,$qte) {
    $conn = ConnectToDb() ; 
  
    $query = $conn->query("UPDATE stocks SET quantite = '$qte' WHERE id= '$id' ") ;
    return $query->execute() ;
    
}








?>