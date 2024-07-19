<?php
include '../Layout/Header.php';
include './Functions.php';

$id = $_GET['id'];
$select = GetReference($id) ; 
$boll = DeleteReference($id);
    if ($boll) {
        header('Location: references.php?delete=ok');

    
    } else {
    $message[] = 'Reference ID not provided!';
}
?>


<?php include '../Layout/Footer.php'; ?>