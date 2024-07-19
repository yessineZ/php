<?php 
    include './connect1.php' ;


    function ConnectToDb() {
     try {
               $conn = new PDO("mysql:host=localhost;dbname=php_projet_class", "root", "");

    
         }catch(PDOException $e) {
               echo "Connection failed: " . $e->getMessage();
}
     return $conn ;
}
    

    function LoginAdmin($email) {
     
        $conn = ConnectToDb() ;

        $query = $conn->query("SELECT * FROM Admin WHERE email='$email' ") ;  
        $result = $query->fetch(PDO::FETCH_ASSOC);
        var_dump($result) ;
        return $result;



}


  function getCategories() {
     $conn = ConnectToDb() ;
     $query = $conn->query("SELECT * FROM categorie ") ;
     $result = $query->fetchAll();
     return $result ; 
  }

  function updateCategorie($id, $name, $description, $createur) {
    $conn = ConnectToDb();
    $query = $conn->prepare("UPDATE categorie SET name=:name, description=:description, createur=:createur WHERE id=:id");
    $query->bindParam(':id', $id, PDO::PARAM_INT);
    $query->bindParam(':name', $name, PDO::PARAM_STR);
    $query->bindParam(':description', $description, PDO::PARAM_STR);
    $query->bindParam(':createur', $createur, PDO::PARAM_STR);
    
    $result = $query->execute();
    
    return $result;
}


  function getCategorie($id) {
    $conn = ConnectToDb();
    
    $query = $conn->query("SELECT * FROM categorie WHERE id = '$id' ");
    

    $result = $query->fetch(PDO::FETCH_ASSOC);
    
    return $result;
}

function DeleteCategorie($id) {
    
    $conn = ConnectToDb();
    

    $query = "DELETE FROM categorie WHERE id = $id";
  
    $result = $conn->exec($query);
    
    return $result;
}


function createCategorie($name, $description, $createur) {
    $conn = ConnectToDb();
    $query = $conn->prepare("INSERT INTO categorie(name, description, createur) VALUES(:name, :description, :createur)");
    $query->bindParam(':name', $name, PDO::PARAM_STR);
    $query->bindParam(':description', $description, PDO::PARAM_STR);
    $query->bindParam(':createur', $createur, PDO::PARAM_STR);
    
    $result = $query->execute();
    
    return $result;
}




  
?>