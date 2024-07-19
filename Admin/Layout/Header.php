<?php

            

?>

<?php
      session_start();
 
      

?>
<nav class="navbar navbar-expand-lg bg-primary" data-bs-theme="dark">
    <div class="container-fluid">
        <a class="navbar-brand" class="text-danger"
            href="http://localhost/projetStage/Admin/References/references.php">MTD</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarColor01"
            aria-controls="navbarColor01" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarColor01">
            <ul class="navbar-nav me-auto">
                <li class="nav-item">
                    <?php if(isset($_SESSION["UsernameAdmin"])) { ?>

                <li class="nav-item">
                    <a class="nav-link active"
                        href="<?php $_SERVER["HTTP_HOST"] ?>/projetStage/Admin/Type/types.php">Types
                        <span class="visually-hidden">(current)</span>
                    </a>

                </li>
                <?php }?>


                <?php if(isset($_SESSION["UsernameAdmin"])) { ?>
                <li class="nav-item">
                    <a class="nav-link active"
                        href="<?php $_SERVER["HTTP_HOST"] ?>/projetStage/Admin/References/references.php">References
                        <span class="visually-hidden">(current)</span>
                    </a>

                </li>
                <?php }?>

                <?php        if(isset($_SESSION["UsernameAdmin"])) { ?>


                <li class="nav-item">
                    <a class="nav-link active"
                        href="<?php $_SERVER["HTTP_HOST"] ?>/projetStage/Admin/User/users.php">Users
                        <span class="visually-hidden">(current)</span>
                    </a>

                </li>
                <?php } ?>


                <?php if(isset($_SESSION["UsernameAdmin"])) { ?>
                <li class="nav-item">
                    <a class="nav-link active m-auto"
                        href="<?php $_SERVER["HTTP_HOST"] ?>/projetStage/Admin/Country/countries.php">Country
                        <span class="visually-hidden">(current)</span>
                    </a>

                </li>
                <?php }?>



                <?php if(!isset($_SESSION["EmailAdmin"])) { ?>

                <a class=" nav-link active" href="<?php $_SERVER["HTTP_HOST"] ?>/projetStage/Admin/login.php">Login
                    <span class="visually-hidden">(current)</span>
                </a>
                <?php } else {?>
                <a class="nav-link active" href="<?php $_SERVER["HTTP_HOST"] ?>/projetStage/Admin/profile.php">Profile
                    <span class="visually-hidden">(current)</span>
                </a>
                <?php } ?>



            </ul>
            <form action="index.php" method="post" class="div">
                <input class="form-control me-sm-2" type="search" placeholder="Search" name="search">
                <button class="btn btn-secondary my-2 my-sm-0" type="submit">Search</button>
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
</style>