<?php
include './Functions.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['edit_type'])) {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $description = $_POST['description'];
    $creator = $_POST['creator'];

    if (empty($name) || empty($description) || empty($creator)) {
        $errorMessage = 'Please fill out all fields!';
    } else {
        $result = updateType($id, $name, $description, $creator);

        if ($result) {
            header('Location: types.php?edit=ok');
            exit;
        } else {
            $errorMessage = 'Failed to update type.';
        }
    }
}
?>