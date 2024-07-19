<?php include '../Layout/Header.php'; 
include './Functions.php';



if(isset($_SESSION["username"])) {
    header("Location: profile.php");
    
}
if(isset($_POST["submit"])) {
    
    $addUser = AddUser($_POST) ;
    if($addUser) {
        echo '<div class="alert alert-success" role="alert">
        User added successfully!
      </div>';
    }else {
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
            <h2 class="text-center text-info">Register</h2>
            <form method="post" action="registre.php">
                <div class="text-danger"></div>
                <div class="mb-1">
                    <label for="username" class="control-label">Username</label>
                    <input id="username" name="username" class=" form-control" />
                    <span class="text-danger"></span>
                </div>
                <div class="mb-1">
                    <label for="Email" class="control-label">Email</label>
                    <input id="Email" name="email" class="form-control" />
                    <span class="text-danger"></span>
                </div>


                <div class="mb-1">
                    <label for="phone" class="password" control-label">Phone</label>
                    <input id="phone" name="phone" class="form-control" />
                    <span class="text-danger"></span>
                </div>

                <div class="mb-1">
                    <label for="password" class="control-label">Password</label>
                    <input id="password" name="password" class="form-control" />
                    <span class="text-danger"></span>
                </div>
                <div class="mb-1">
                    <label for="password" class="" control-label">Confirm Password</label>
                    <input id="password" name="" class="form-control" />
                    <span class="text-danger"></span>
                </div>



                <div class="row">

                    <div class="col-12">
                        <input id="submit" type="submit" name="submit" value="Register"
                            class="btn btn-primary btn-xl ml-auto" />
                    </div>
                </div>

            </form>

            <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        </div>
    </div>
</body>
<script>
let submitBtn = document.querySelector("#submit");
let bool = false;

submitBtn.addEventListener("click", (event) => {

    e.preventDefault();
    Swal.fire({
        title: "User",
        text: "User Added Successfully",
        icon: "success"
    }).then(() => {
        let form = document.getElementsByTagName("form")[1];
        Array.from(form.elements).forEach((element) => {
            if (element.getAttribute("id") !== "submit") {
                element.value = "";
            }
        });
    });
});
</script>

</html>

<?php include '../Layout/footer.php'; ?>