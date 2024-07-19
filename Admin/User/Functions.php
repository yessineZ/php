<?php 
    


    function ConnectToDb() {
     try {
               $conn = new PDO("mysql:host=localhost;dbname=stageproject", "root", "");

    
         }catch(PDOException $e) {
               echo "Connection failed: " . $e->getMessage();
}
     return $conn ;
}


function GetUsers() {
    $conn = ConnectToDb();
    $sql = "SELECT * FROM users";
    $result = $conn->query($sql);
    return $result;
}

function GetUser($id) {
    $conn = ConnectToDb();
    $sql = "SELECT * FROM users WHERE id = '$id'";
    $result = $conn->query($sql);
    $result = $result->fetch(PDO::FETCH_ASSOC);
    return $result;
}

function DeleteUser($id) {
    $conn = ConnectToDb();
    $sql = "DELETE FROM users WHERE id = '$id'";
    $result = $conn->exec($sql);
    return $result;
}

function UpdateUser($id, $username, $email, $phone) {
    $conn = ConnectToDb();
    $sql = "UPDATE users SET username = '$username', email = '$email', phone = '$phone' WHERE id = '$id'";
    $result = $conn->exec($sql);
    return $result;
}

function GetAllCommandes() {
    $conn = ConnectToDb();
    $query = $conn->query('SELECT * FROM commande') ; 
    return $query->fetchAll() ; 
}

function GetUserCommandes($id) {
    $conn = ConnectToDb();
   
    $query = $conn->query("SELECT * FROM commande where user_id='$id' ") ; 

    return $query->fetchAll() ; 
}


function CreateUser($username,$password ,$email, $phone) {
    $conn = ConnectToDb();
    $sql = "INSERT INTO users ( username, password, email, phone) VALUES ('$username', '$password', '$email', '$phone')";
    $result = $conn->exec($sql);
    return $result;
}





?>