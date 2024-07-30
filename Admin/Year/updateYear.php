<?php
include './Functions.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];
    $name = $_POST['year'];

    if (empty($name)) {
        $errorMessage = 'Please fill out all fields!';
    } else {
        $result = updateYear($id, $name);

        if ($result) {
            header('Location: years.php?edit=ok');
            exit;
        } else {
            $errorMessage = 'Failed to update type.';
        }
    }
}
?>