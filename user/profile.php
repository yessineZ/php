<?php
    include '../Layout/Header.php' ; 
  
    if(!isset($_SESSION['username'])) {
        header('Location : login.php');
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
    <div class="all">
        <div class="pdp">
            <img src="./UsersImages/user1.png">
        </div>
        <div class="info">
            <p>Username : <?php echo $_SESSION["username"] ;?></p>
            <p>Email :<?php echo $_SESSION["email"] ;?> </p>
            <p>Password : <?php echo $_SESSION["password"] ;?></p>
            <p>Phone :<?php echo $_SESSION["userPhone"] ?> </p>
        </div>
        <a href="deconnection.php" class="btn btn-danger w-25 m-auto">Logout</a>
    </div>
</body>


<style>
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

.all {
    margin: 20px auto;
    display: flex;
    justify-content: center;
    flex-direction: column;
    width: 350px;
    background-color: blueviolet;
    border-radius: 10px;
}

.pdp {
    margin-bottom: 20px;
    width: auto;
    border: 5px;
    margin: 10px auto;

}

.pdp>img {
    width: 150px;
    height: 150px;
    border-radius: 50%;
    border: yellowgreen solid 4px;
}
</style>


</html>

<?php include '../Layout/Footer.php' ?>