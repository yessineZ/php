<?php 
function ConnectToDb() {
    try {
        $conn = new PDO("mysql:host=localhost;dbname=stageproject", "root", "");
    } catch(PDOException $e) {
        echo "Connection failed: " . $e->getMessage();
    }
    return $conn;
}

function LoginAdmin($email) {
    $conn = ConnectToDb();
    $query = $conn->query("SELECT * FROM Admin WHERE email='$email'");
    $result = $query->fetch(PDO::FETCH_ASSOC);
    var_dump($result);
    return $result;
}

function getAllClients() {
    $conn = ConnectToDb();
    $query = $conn->query("SELECT * FROM client");
    $result = $query->fetchAll();
    return $result;
}

function updateClient($id, $name, $email, $password = null) {
    $conn = ConnectToDb();

    $queryStr = "UPDATE client SET name=:name, email=:email";
    if ($password) {
        $queryStr .= ", password=:password";
    }
    $queryStr .= " WHERE id=:id";

    $query = $conn->prepare($queryStr);
    $query->bindParam(':id', $id, PDO::PARAM_INT);
    $query->bindParam(':name', $name, PDO::PARAM_STR);
    $query->bindParam(':email', $email, PDO::PARAM_STR);
    if ($password) {
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
        $query->bindParam(':password', $hashedPassword, PDO::PARAM_STR);
    }

    $result = $query->execute();
    return $result;
}

function getOneClient($id) {
    $conn = ConnectToDb();
    $query = $conn->query("SELECT * FROM client WHERE id='$id'");
    $result = $query->fetch(PDO::FETCH_ASSOC);
    return $result;
}

function deleteClient($id) {
    $conn = ConnectToDb();
    $query = "DELETE FROM client WHERE id=$id";
    $result = $conn->exec($query);
    return $result;
}

function createClient($name, $email, $password) {
    $conn = ConnectToDb();
    $query = $conn->prepare("INSERT INTO client (name, email, password) VALUES (:name, :email, :password)");
    $query->bindParam(':name', $name, PDO::PARAM_STR);
    $query->bindParam(':email', $email, PDO::PARAM_STR);
    $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
    $query->bindParam(':password', $hashedPassword, PDO::PARAM_STR);

    $result = $query->execute();
    return $result;
}
?>