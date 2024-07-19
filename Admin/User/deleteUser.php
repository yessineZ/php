<?php
include '../Layout/Header.php';
include './Functions.php';
if(!isset($_SESSION['EmailAdmin'])) {
    header('Location: login.php');
    exit;
} 
$id = $_GET['id'];
$select = GetUser($id);

if (isset($_POST['delete'])) {
    $boll = DeleteUser($id);
    if ($boll) {
        header('Location: users.php?delete=ok');

    
    }
} else {
    $message[] = 'Category ID not provided!';
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../static/bootstrap.min (8).css">
</head>

<body>
    <? foreach($message as $mess) {
        echo $mess ; 
    } ?>
    <div class="card-body p-4">
        <form method="post" class="row" enctype="multipart/form-data">
            <div class="row">
                <div class="col-10">
                    <div class="border p-3">

                        <div class="form-floating py-2 col-12">
                            <input class="form-control border-0 shadow" value="<?php echo $select["username"]; ?>"
                                readonly />
                            <label class="ms-2">UserName</label>

                            <div class=" form-floating py-2 col-12">
                                <input value="<?php echo $select["email"]; ?>" class="form-control border-0 shadow"
                                    readonly />
                                <label class="ms-2">Email</label>
                            </div>




                            <div class="row pt-2">
                                <div class="col-6 col-md-3">
                                    <button type="submit" name="delete"
                                        class="btn btn-primary form-control">Delete</button>
                                </div>
                                <div class="col-6 col-md-3">
                                    <a href="games.php" class="btn btn-outline-primary border  form-control">
                                        Back to List
                                    </a>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</body>

</html>

<?php include '../Layout/Footer.php'; ?>