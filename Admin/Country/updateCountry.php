<?php
include './Functions.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];
    $name = $_POST['name'];

    if (empty($name)) {
        $errorMessage = 'Please fill out all fields!';
    } else {
        $result = updateCountry($id, $name);

        if ($result) {
            header('Location: countries.php?edit=ok');
            exit;
        } else {
            $errorMessage = 'Failed to update type.';
        }
    }
}
?>