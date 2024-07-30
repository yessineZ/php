<?php 
include '../Layout/Header.php';
include './Functions.php';


if(!isset($_SESSION['EmailAdmin'])) {
    header('Location: ../login.php');
    exit;
} 


$searchTerm = '';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['search_term'])) {
    $searchTerm = $_POST['search_term'];
    $currentClient = $_POST['client']; 

    $references = GetReferenceClient($currentClient, $searchTerm);
}

$types = GetTypes();
$countries = GetCountries();
$clients = GetAllClients();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../static/bootstrap.min (8).css">
    <title>References</title>
</head>

<body>

    <div class="container mt-5">
        <div class="card">
            <div class="card-header bg-primary text-white">
                <h3>Search Project</h3>
            </div>
            <div class="card-body">
                <form action="references.php" method="post">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="client" class="form-label">Client:</label>
                            <select class="form-select" id="client" name="client" required>
                                <?php foreach ($clients as $client) {
                                    echo '<option value="' . $client['id'] . '">' . $client['name'] . '</option>';
                                } ?>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="search_term" class="form-label">Reference Name:</label>
                            <input type="text" name="search_term" class="form-control font-weight-bold"
                                placeholder="Reference Name">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col text-end">
                            <button class="btn btn-outline-primary" type="submit">Search</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <?php if (isset($references)) { ?>
        <div class="card mt-4">
            <div class="card-header bg-primary text-white">
                <h3>References List</h3>
            </div>
            <div class="card-body">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th scope="col">User</th>
                            <th scope="col">Client</th>
                            <th scope="col">Description</th>
                            <th scope="col">Logo</th>
                            <th scope="col">Link</th>
                            <th scope="col">Type</th>
                            <th scope="col">Pays</th>
                            <th scope="col">Year</th>
                            <th scope="col">Creator</th>
                            <th scope="col">Details</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($references as $reference) { ?>
                        <tr id="reference-<?php echo $reference['id']; ?>">
                            <td><?php echo getUser($reference["id_client"])["username"]; ?></td>
                            <td><?php echo getClient1($reference["Client_id"])["name"]; ?></td>
                            <td><?php echo $reference["description"]; ?></td>
                            <td><img src="../../images/<?php echo $reference["logo"]; ?>"
                                    style="height: 75px; width: 75px;" alt="reference Image"></td>
                            <td><?php echo $reference["link"]; ?></td>
                            <td><?php echo gettType($reference["id_type"])["name"]; ?></td>
                            <td><?php echo getPays($reference["pays"])["name"]; ?></td>
                            <td><?php echo $reference["annee"]; ?></td>
                            <td><?php echo $reference["creator"]; ?></td>
                            <td>
                                <button class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#exampleModal"
                                    onclick="populateModal(<?php echo $reference['id']; ?>)">Details</button>
                            </td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
                <form action="generate_pdf.php" method="post">
                    <input type="hidden" name="client" value="<?php echo htmlspecialchars($currentClient); ?>">
                    <input type="hidden" name="search_term" value="<?php echo htmlspecialchars($searchTerm); ?>">
                    <button class="btn btn-outline-primary" type="submit">Print References as PDF</button>
                </form>
            </div>
        </div>
        <?php  } ?>

    </div>



    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>

</body>

</html>

<?php 
include '../Layout/Footer.php'; 
?>