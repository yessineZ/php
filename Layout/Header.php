<?php
    include 'connect1.php' ;      
               

?>

<?php
      session_start();
      $query = $conn->query("SELECT * from reference");
       $select = $query->fetchAll() ; 
      

?>
<nav class="navbar navbar-expand-lg bg-primary" data-bs-theme="dark">
    <div class="container-fluid">
        <a class="navbar-brand" href="index.php">MTD</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarColor01"
            aria-controls="navbarColor01" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarColor01">
            <ul class="navbar-nav me-auto ">
                <?php if(isset($_SESSION['username'])) { ?>
                <a class="nav-link active ml-2" href="index.php">references
                    <span class="visually-hidden">(current)</span>
                </a>
                <?PHP } ?>
                <?php if(!isset($_SESSION["username"])) { ?>
                <a class=" ml-2 nav-link active" href="registre.php">Registre
                    <span class="visually-hidden">(current)</span>
                </a>
                <a class="ml-2 nav-link active" href="login.php">Login
                    <span class="visually-hidden">(current)</span>
                </a>
                <?php } else {?>
                <a class="ml-2 nav-link active" href="profile.php">Profile
                    <span class="visually-hidden">(current)</span>
                </a>

                <?php } ?>



            </ul>
            <form action="index.php" method="post" class="">
                <div class="div flex  align-center justify-center">
                    <input class="form-control me-sm-2" type="search" placeholder="Search" name="search">
                    <button class="btn btn-secondary text-center" type="submit">Search</button>
                </div>

            </form>
        </div>
    </div>
</nav>

<style>
* {
    padding: 0px;
    margin: 0px;
    box-sizing: border-box;
    overflow: hidden;
}

.div {
    display: flex;
    align-items: center;
    justify-content: center;
}
</style>