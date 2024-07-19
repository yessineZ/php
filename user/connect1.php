<?php 

    try {
        $conn = new PDO("mysql:host=localhost;dbname=stageproject", "root", "");


        }catch(PDOException $e) {
        echo "Connection failed: " . $e->getMessage();
}


?>