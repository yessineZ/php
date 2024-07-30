<?php
include '../Layout/Header.php';
include './Functions.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST["year"] ; 
    $boll = CreateYear($name);
    if ($boll) {
        header('Location: years.php?create=ok');

    
    } else {
    $message[] = 'Country ID not provided!';
}
}
?>

<?php include '../Layout/Footer.php'; ?>