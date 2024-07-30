<?php
function ConnectToDb() {
    try {
        $conn = new PDO("mysql:host=localhost;dbname=stageproject", "root", "");
    } catch(PDOException $e) {
        echo "Connection failed: " . $e->getMessage();
    }
    return $conn;
}



function updateYear($id, $year) {
    $conn = ConnectToDb();
    $sql = "UPDATE year SET year = '$year' WHERE id = $id";
    $conn->exec($sql);
    return $conn;
}

function deleteYear($id) {
    $conn = ConnectToDb();
    $sql = "DELETE FROM year WHERE id = $id";
    $conn->exec($sql);
    return $conn;
}

function createYear($year) {
    $conn = ConnectToDb();
    $sql = "INSERT INTO year (year) VALUES ('$year')";
    $conn->exec($sql);
    return $conn;
}

function getYear($id) {
    $conn = ConnectToDb();
    $select = $conn->query("SELECT * FROM year WHERE id = $id");
    return $select;
}

function getAllYears() {
    $conn = ConnectToDb();
    $select = $conn->query("SELECT * FROM year");
    return $select;
}
?>