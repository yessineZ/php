<?php
include '../Layout/Header.php';
include './Functions.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST["name"] ; 
    $boll = CreateCountry($name);
    if ($boll) {
        header('Location: countries.php?create=ok');

    
    } else {
    $message[] = 'Country ID not provided!';
}
}
?>

<?php include '../Layout/Footer.php'; ?>