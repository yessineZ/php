<?php 
include '../Layout/Header.php';
include './Functions.php' ; 

$stocks = GetStocks() ;

if(!isset($_SESSION['EmailAdmin'])) {
    header('Location: login.php');
    exit;
} 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];
    $qte = $_POST['qte'] ; 
    $result = UpdateStock($id,$qte) ;

    if ($result) {
        $successMessage = 'Stock updated successfully!';
    } else {
        $errorMessage = 'Failed to update.';
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../bootstrap.min (8).css">
    <title>Stock Page</title>
</head>

<body>
    <?php if(isset($successMessage)) { ?>
    <div class="alert alert-success" role="alert">
        <?php echo $successMessage; ?>
    </div>
    <?php } ?>

    <div class="container">
        <div class="row pt-4 pb-2">
            <div class="col-4">
                <h2 class="text-primary">
                    Stock List
                </h2>
            </div>
        </div>
    </div>

    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>Stock Id</th>
                <th>Produit Name</th>
                <th>quantite</th>
                <th>createur</th>
                <th>date</th>
                <th>Actions</th>
            </tr>
        </thead>

        <tbody>
            <?php foreach($stocks as $stock) { ?>
            <tr>
                <td><?php echo $stock["id"]; ?></td>
                <td><?php echo $stock["name"]; ?></td>
                <td><?php echo $stock["quantite"]; ?></td>
                <td><?php echo $stock["createur"]; ?></td>
                <td><?php echo $stock["date"];?></td>

                <td>

                    <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                        data-bs-target="#exampleModal_<?php echo $stock['id']; ?>">
                        Edit
                    </button>
                </td>
            </tr>
            <?php } ?>
        </tbody>
    </table>


    <?php foreach($stocks as $stock) { ?>
    <div class="modal fade" id="exampleModal_<?php echo $stock['id']; ?>" tabindex="-1"
        aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Edit Stock</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">

                    <form method="POST" action="list.php">
                        <input type="hidden" name="id" value="<?php echo $stock['id']; ?>">
                        <div class="form-group">
                            <label for="qte_<?php echo $stock['id']; ?>">Quantity</label>
                            <input type="number" class="form-control" id="qte_<?php echo $stock['id']; ?>" name="qte"
                                value="<?php echo $stock['quantite']; ?>">
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Save changes</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <?php } ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>
</body>

</html>

<?php 
include '../Layout/Footer.php'; 
?>