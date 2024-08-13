<?php 
include '../Layout/Header.php';
include './Functions.php';

// Redirect to profile if the user is already logged in
if(isset($_SESSION["username"])) {
    header('Location: profile.php');
    exit();
}

// Handle login form submission
if (isset($_POST['submit'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $result = Login($email);

    if ($result) {
        if ($result['role'] == 'admin' && password_verify($password, $result['data']['password'])) {
            $_SESSION['EmailAdmin'] = $email;
            $_SESSION['UsernameAdmin'] = $result['data']['name'];
            $_SESSION['PasswordAdmin'] = $password;
            header("Location: http://" . $_SERVER['HTTP_HOST'] . "/projetStage/Admin/profile.php");
            exit();
        } elseif ($result['role'] == 'client' && password_verify($password, $result['data']['password'])) {
            $_SESSION['email'] = $email;
            $_SESSION['username'] = $result['data']['username'];
            $_SESSION['userPhone'] = $result['data']['phone'];
            $_SESSION['password'] = $password;
            $_SESSION['id'] = $result['data']['id'];
            header('Location: profile.php');
            exit();
        } else {
            echo '<div class="alert alert-danger" role="alert">Invalid password or email!</div>';
        }
    } else {
        echo '<div class="alert alert-danger" role="alert">Invalid email or password!</div>';
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../static/bootstrap.min (8).css">
    <title>GESTION DE REFERENCES</title>
</head>

<body>
    <div class="row d-flex align-items-center justify-content-center">
        <div class="col-md-4 card p-3">
            <h2 class="text-center text-info">Login</h2>
            <form method="post" action="login.php">
                <div class="mb-1">
                    <label for="Email" class="control-label">Email</label>
                    <input id="Email" name="email" type="email" class="form-control" required />
                </div>

                <div class="mb-1">
                    <label for="password" class="control-label">Password</label>
                    <input id="password" name="password" type="password" class="form-control" required />
                </div>

                <div class="row">
                    <div class="col-4">
                        <input type="submit" name="submit" value="Login" class="btn btn-primary btn-xl float-end" />
                    </div>
                </div>
            </form>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</body>

</html>

<?php include '../Layout/footer.php'; ?>

<style>
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}
</style>