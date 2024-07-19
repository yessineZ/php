<?php 
    

    function ConnectToDb() {
     try {
               $conn = new PDO("mysql:host=localhost;dbname=stageproject", "root", "");

    
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


  function getAlltypes() {
     $conn = ConnectToDb() ;
     $query = $conn->query("SELECT * FROM type ") ;
     $result = $query->fetchAll();
     return $result ; 
  }

  function updateType($id, $name, $description, $createur) {
    $conn = ConnectToDb();
    
    // Prepare and execute the SQL query using prepared statements to prevent SQL injection
    $query = $conn->prepare("UPDATE type SET name=:name, description=:description, createur=:createur WHERE id=:id");
    $query->bindParam(':id', $id, PDO::PARAM_INT);
    $query->bindParam(':name', $name, PDO::PARAM_STR);
    $query->bindParam(':description', $description, PDO::PARAM_STR);
    $query->bindParam(':createur', $createur, PDO::PARAM_STR);
    
    $result = $query->execute();
    
    return $result;
}


  function getOnetype($id) {
    $conn = ConnectToDb();
    
    $query = $conn->query("SELECT * FROM type WHERE id = '$id' ");
    

    $result = $query->fetch(PDO::FETCH_ASSOC);
    return  $result;
}

function Deletetype($id) {
    $conn = ConnectToDb();
    

    $query = "DELETE FROM type WHERE id = $id";
  
    $result = $conn->exec($query);
    
    return $result;
}


function createType($name, $description, $createur) {
    $conn = ConnectToDb();
    
    $query = $conn->prepare("INSERT INTO type(name, description, createur) VALUES(:name, :description, :createur)");
    $query->bindParam(':name', $name, PDO::PARAM_STR);
    $query->bindParam(':description', $description, PDO::PARAM_STR);
    $query->bindParam(':createur', $createur, PDO::PARAM_STR);
    
    $result = $query->execute();
    
    return $result;
}




  
?>