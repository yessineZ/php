<?php 
include './Layout/Header.php';
include './Functions.php' ;

if(isset($_SESSION["usernameAdmin"])) {
    header('Location: profile.php');
}

if (isset($_POST['submit'])) {

    
        
    $email = $_POST['email'];
    $password = $_POST['password'];

    
    $admin = LoginAdmin($email);
    
    
    
    if (isset($admin) && password_verify($password, $admin['password'])) {
        
            $_SESSION['EmailAdmin'] = $email;
            $_SESSION['UsernameAdmin'] = $admin['name'];
            $_SESSION['PasswordAdmin'] = $password ; 
            
    
            header('Location: profile.php');
         
        } else {
            
            echo '<div class="alert alert-danger" role="alert">
                    Invalid email or password!
                    </div>';
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
    <title>Document</title>
</head>

<body>
    <div class="row d-flex align-items-center justify-content-center">
        <div class="col-md-4 card p-3">
            <h2 class="text-center text-info">Login</h2>
            <form method="post" action="login.php">
                <div class="text-danger"></div>

                <div class="mb-1">
                    <label for="Email" class="control-label">Email</label>
                    <input id="Email" name="email" class="form-control" />
                    <span class="text-danger"></span>
                </div>

                <div class="mb-1">
                    <label for="password" class="control-label">Password</label>
                    <input id="password" name="password" class="form-control" />
                    <span class="text-danger"></span>
                </div>

                <div class="row">
                    <div class="col-4">
                        <input type="submit" name="submit" value="Login" class="btn btn-primary btn-sm float-end" />
                    </div>
                </div>
            </form>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</body>
<script>

</script>

</script>

</html>

<?php include './Layout/footer.php'; ?>

<style>
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}
</style>


<script>

</script>