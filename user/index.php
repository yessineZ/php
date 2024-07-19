<?php include '../Layout/Header.php'; 
    include './Functions.php';
    if(isset($_SESSION['username'])) {
            if($_POST) {
        $games = search($_POST["search"]) ; 
     }else {
        $id = $_SESSION['id'] ; 
        $references = getAllReferences($id) ;
    }    
    }else {
        header('Location : login.php');
    }
    
     
    

?>
<style>
img {
    width: 200px;
    height: 200px;
    border-radius: 50%;
    border: 1px solid black;
    margin: 10px;
    padding: 10px;
    box-shadow: 1px 1px 10px black;

}

* {
    box-sizing: border-box;
    margin: 0;
    padding: 0;


}
</style>


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
    <div class="row col-12 m-5 ml-5">
        <?php foreach ($references as $reference) { ?>
        <div class="col-3">
            <div class="card" style="width: 18rem;">
                <img style="width : 200px ; height :200px ;" src="./ProductImages/<?php echo $game["image"]  ?>"
                    class="card-img-top" alt="...">
                <div class="card-body">
                    <h5 class="card-title"><?php echo $reference["id_user"] ?></h5>
                    <p class="card-text"><?php echo $reference["description"]?></p>
                    <a href="game.php?id=<?php echo $reference['id']; ?>" class="btn btn-primary">Details</a>
                </div>
            </div>
        </div>

        <?php }?>







        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
            integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous">
        </script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"
            integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous">
        </script>

        <script>
        span = document.getElementsByClassName("year")[0];
        span.innerHTML = new Date().getFullYear();
        console.log(span);
        </script>



</body>

</body>

</html>


</html>

<?php include '../Layout/footer.php'; ?>