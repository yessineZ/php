<?php
include './Functions.php';
if(isset($_GET['id'])) {
    $id = $_GET['id'];

    $result = deleteType($id);

    if ($result) {
        header('Location: types.php?delete=ok');
        exit;
    } else {
        $errorMessage = 'Failed to delete type.';
    }
}
?>