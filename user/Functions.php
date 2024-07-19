<?php


function ConnectToDb() {
     try {
               $conn = new PDO("mysql:host=localhost;dbname=stageproject", "root", "");

    
         }catch(PDOException $e) {
               echo "Connection failed: " . $e->getMessage();
}
     return $conn ;
}
function getAllReferences($id) {

     
     
     $conn = ConnectToDb() ;
     

     $query = "SELECT * FROM reference where id_client = $id";
        $statement = $conn->query($query);
        $references = $statement->fetchAll();
        return $references ; 

     
}

function search($name) {
     $conn = ConnectToDb() ;  
     $query = $conn->query("SELECT * FROM reference where name like '%$name%' ") ; 
     $references = $query->fetchAll();
     return $references;

     
}

function getGame($id) {
    $conn = ConnectToDb() ;  
    $select = $conn->query("SELECT * FROM reference WHERE id=$id") ;
    return $select ; 

}

function Adduser($users) {
     
     $conn = ConnectToDb() ;
     
     $name = $users["username"]  ; 
     $password = $users["password"] ;
     $passwordHashed = password_hash($password,true) ;
       
     $email = $users["email"] ;
     $phone = $users["phone"] ;
     $query = $conn->query("INSERT INTO users (username,password,email,phone) VALUES ('$name','$passwordHashed','$email','$phone')") ;
     
     $query1 = "select * from users WHERE username = '$name' "  ;
     if($query1) {
          return false ; 
     } 
     if(isset($query)) {
          return true ;
     }
     else {
          return false ;
     }



}


function Login($email) {
     $conn = ConnectToDb() ;
     $query = $conn->query("SELECT * FROM users WHERE email='$email' ") ;  
      
     
     $result = $query->fetch();
     
     return $result;

     
}

function getusers($usersname, $password) {
     $conn = ConnectToDb() ;
     $query = $conn->query("SELECT * FROM users WHERE usersname='$usersname' AND password='$password'   ") ; 
     return $query->fetch() ; 
}

function AddCommand($id_users,$id_game) {
     $conn = ConnectToDb() ; 
     $query = $conn->query("insert into commande (users_id,produit_id) values('$id_users','$id_game') ") ;
     if(isset($query)) {
          header('Location: commandeusers.php?create=true') ; 
     }    
     
}


function GetCommandes($id_users) {
     $conn = ConnectToDb() ;
     $query = $conn->query("select * from commande where users_id='$id_users'") ; 
     return $query->fetchAll() ;
}

function getreferencesByCategory($category) {
    $conn = ConnectToDb();

    $query = $conn->prepare("SELECT * FROM references WHERE categorie = :category");

    $query->bindParam(':category', $category);

    $query->execute();

    $references = $query->fetchAll();
    

   
    return $references;
}




?>