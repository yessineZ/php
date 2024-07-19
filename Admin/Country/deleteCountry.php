<?php
include '../Layout/Header.php';
include './Functions.php';

$id = $_GET['id'];
$select = GetCountry($id) ; 
$boll = DeleteCountry($id);
    if ($boll) {
        header('Location: countries.php?delete=ok');

    
    } else {
    $message[] = 'Country ID not provided!';
    echo "3asba " ; 
}
?>


<?php include '../Layout/Footer.php'; ?>