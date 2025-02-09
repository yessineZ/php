<?php 
    


    function ConnectToDb() {
     try {
               $conn = new PDO("mysql:host=localhost;dbname=stageproject", "root", "");

    
         }catch(PDOException $e) {
               echo "Connection failed: " . $e->getMessage();
}
     return $conn ;
}

function Getreferences() {
    $conn = ConnectToDb() ; 
    $query = "SELECT * from reference " ;
    $conn = $conn->query($query) ; 
    $references = $conn->fetchAll() ;
    return $references ;
     
    
}

function getYears() {
    $conn = ConnectToDb() ;
    $query = "SELECT * FROM year" ; 
    $conn = $conn->query($query) ; 
    $years = $conn->fetchAll() ;
    return $years ;
}

function getTypes() {
     $conn = ConnectToDb() ;
     $query = $conn->query("SELECT * FROM type ") ;
   
     $result = $query->fetchAll();
     return $result ; 
  }

function CreateReference($id_client1,$id_client, $description, $logo, $link, $id_type, $pays,$annee,$creator) {
    
    $conn = ConnectToDb();
    


    $query = "INSERT INTO reference (Client_id,id_client, description,logo,link,id_type,pays,annee,creator) VALUES (:id_client1,:id_client, :description, :logo, :link, :id_type, :pays,:annee, :creator)" ;
    $statement = $conn->prepare($query);
    $statement->bindParam(':id_client1', $id_client1);
    $statement->bindParam(':id_client', $id_client);
    $statement->bindParam(':description', $description);
    $statement->bindParam(':logo', $logo);
    $statement->bindParam(':link', $link);
    $statement->bindParam(':id_type', $id_type);
    $statement->bindParam(':pays', $pays);
    $statement->bindParam(':annee', $annee);
    $statement->bindParam(':creator', $creator);
    

    $result = $statement->execute();
    
   
    return $result;
}
function updateReference($id, $client_id ,$id_client, $description, $logo, $link, $id_type, $pays, $annee, $creator) {
    $conn = ConnectToDb();
    $query = "UPDATE reference SET  Client_id = :client_id ,id_client = :id_client, description = :description, logo = :logo, link = :link, id_type = :id_type, pays = :pays, annee = :annee, creator = :creator WHERE id = :id";
    $statement = $conn->prepare($query);
    $statement->bindParam(':id', $id);
    $statement->bindParam(':client_id', $client_id);
    $statement->bindParam(':id_client', $id_client);
    $statement->bindParam(':description', $description);
    $statement->bindParam(':logo', $logo);
    $statement->bindParam(':link', $link);
    $statement->bindParam(':id_type', $id_type);
    $statement->bindParam(':pays', $pays);
    $statement->bindParam(':annee', $annee);
    $statement->bindParam(':creator', $creator);
    $result = $statement->execute();
    return $result;
}



function GetReference($id) {
    $conn = ConnectToDb() ;
    $query = "SELECT * FROM reference WHERE id = :id" ; 
    $statement = $conn->prepare($query);
    $statement->bindParam(':id', $id);
    $statement->execute();
    $Reference = $statement->fetch();
    return $Reference ;
}


function getYear($id) {
    $conn = ConnectToDb() ;
    
    $query = "SELECT * FROM year WHERE id = :id" ; 
    $statement = $conn->prepare($query);
    $statement->bindParam(':id', $id);
    $statement->execute();
    $year = $statement->fetch();
    return $year ;
}
function DeleteReference($id) {
    $conn = ConnectToDb() ;
    $query = "DELETE FROM reference WHERE id = :id" ;
    $statement = $conn->prepare($query);
    $statement->bindParam(':id', $id);
    $result = $statement->execute();
    return $result;
}

function getUsers() {
    $conn = ConnectToDb() ;
    $query = "SELECT * FROM users" ;
    $conn = $conn->query($query) ;
    $users = $conn->fetchAll() ;
    return $users ;
}

function GetCountries(){
    $conn = ConnectToDb() ;
    $query = "SELECT * FROM country" ;
    $conn = $conn->query($query) ;
    $country = $conn->fetchAll() ;
    return $country ;
    
}

function getUser($id) {
    $conn = ConnectToDb() ;
    $query = "SELECT * FROM users WHERE id = '$id'" ;
    $conn = $conn->query($query) ;
    $user = $conn->fetch() ;
    return $user ;
}

function gettType($id) {
    $conn = ConnectToDb() ;
    $query = "SELECT * FROM type WHERE id = '$id'" ;
    $conn = $conn->query($query) ;
    $type = $conn->fetch() ;
    return $type ;
}

function getPays($id) {
    $conn = ConnectToDb() ;
    $query = "SELECT * FROM country WHERE id = '$id'" ;
    $conn = $conn->query($query) ;
    $pays = $conn->fetch() ;
    return $pays ;
}


function GetReferencesUser($id) {
    $conn = ConnectToDb() ;
    $query = "SELECT * FROM reference WHERE id_client = '$id'" ;
    $conn = $conn->query($query) ;
    $references = $conn->fetchAll() ;
    return $references ;
}

function GetClient() {
    $conn = ConnectToDb() ;
    $query = "SELECT * FROM client" ;
    $conn = $conn->query($query) ;
    $clients = $conn->fetchAll() ;
    return $clients ;
}

function getClient1($id) {
    $conn = ConnectToDb() ;
    $query = "SELECT * FROM client where id = '$id' " ;
    $conn = $conn->query($query) ;
    $client = $conn->fetch() ;
    return $client ;
}


  
?>