<?php
include '../Layout/Header.php';
include './Functions.php';

$id = $_GET['deleteClient'];
$select = getOneClient($id) ; 
$boll = deleteClient($id) ;
    if ($boll) {
        header('Location: client.php?delete=ok');

    
    } else {
    $message[] = 'Client ID not provided!';
}
?>


<?php include '../Layout/Footer.php'; ?>