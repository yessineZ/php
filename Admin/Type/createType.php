<?php
include './Functions.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['create_type'])) {
    $name = $_POST['name'];
    $description = $_POST['description'];
    $creator = $_POST['creator'];

    if (empty($name) || empty($description) || empty($creator)) {
        $errorMessage = 'Please fill out all fields!';
    } else {
        $result = createType($name, $description, $creator);

        if ($result) {
            header('Location: types.php?create=ok');
            exit;
        } else {
            $errorMessage = 'Failed to create type.';
        }
    }
}
?>