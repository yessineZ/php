<?php
function ConnectToDb() {
     try {
               $conn = new PDO("mysql:host=localhost;dbname=stageproject", "root", "");

    
         }catch(PDOException $e) {
               echo "Connection failed: " . $e->getMessage();
}
     return $conn ;
}

function updateCountry($id,$name) {
     $conn = ConnectToDb();
     $sql = "UPDATE country SET name = '$name' WHERE id = $id";
     var_dump($sql) ; 
     $conn->exec($sql);
     return $conn ; 
}

function DeleteCountry($id) {
     $conn = ConnectToDb();
     $sql = "DELETE FROM country WHERE id = $id";
     $conn->exec($sql);
     return $conn ;
}

function CreateCountry($name) {
     $conn = ConnectToDb();
     $sql = "INSERT INTO country (name) VALUES ('$name')";
     $conn->exec($sql);
     return $conn ;
}

function GetCountry($id) {
     $conn = ConnectToDb();
     $select = $conn->query("SELECT * FROM country WHERE id=$id") ;
     return $select ;  
}

function GetAllCountries() {
    
    $conn = ConnectToDb();
    $select = $conn->query("SELECT * FROM country") ;
    return $select ;
}




?>