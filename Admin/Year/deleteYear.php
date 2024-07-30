<?php
include '../Layout/Header.php';
include './Functions.php';

$id = $_GET['id'];
$select = GetYear($id) ; 
$boll = DeleteYear($id);
    if ($boll) {
        header('Location: years.php?delete=ok');

    
    } else {
    $message[] = 'Year ID not provided!';
     
}
?>


<?php include '../Layout/Footer.php'; ?>