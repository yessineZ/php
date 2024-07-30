<?php
include '../Layout/Header.php';
include './Functions.php';

$countries = getAllCountries();

if (!isset($_SESSION['EmailAdmin'])) {
    header('Location: login.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../static/bootstrap.min (8).css">
    <title>Countries</title>
</head>

<body>
    <?php if (isset($_GET["delete"]) && $_GET["delete"] == "ok") { ?>
    <div class="alert alert-success" role="alert">
        <?php echo "The country has been deleted successfully"; ?>
    </div>
    <?php } elseif (isset($_GET["edit"]) && $_GET["edit"] == "ok") { ?>
    <div class="alert alert-success" role="alert">
        <?php echo "The country has been edited successfully"; ?>
    </div>
    <?php } ?>

    <div class="container">
        <div class="row pt-4 pb-2">
            <div class="col-4">
                <h2 class="text-primary text-white">Countries List</h2>
            </div>
            <div class="col-6 text-end">
                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createCountryModal">
                    <i class="bi bi-plus"></i> Create New Country
                </button>
            </div>
        </div>
    </div>

    <table class="table table-bordered table-striped col-4">
        <thead>
            <tr>
                <th>Country Name</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($countries as $country) { ?>
            <tr>
                <td><?php echo $country["name"]; ?></td>
                <td>
                    <div class="btn-group" role="group">
                        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#editCountryModal"
                            onclick="populateCountryModal('<?php echo $country['id']; ?>', '<?php echo $country['name']; ?>')">Edit</button>
                        <button class="btn btn-danger mx-2"
                            onclick="confirmCountryDelete('<?php echo $country['id']; ?>')">Delete</button>
                    </div>
                </td>
            </tr>
            <?php } ?>
        </tbody>
    </table>

    <!-- Edit Country Modal -->
    <div class="modal fade" id="editCountryModal" tabindex="-1" aria-labelledby="editCountryModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editCountryModalLabel">Edit Country</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="editCountryForm" method="POST" action="updateCountry.php">
                        <input type="hidden" id="editCountryId" name="id">
                        <div class="mb-3">
                            <label for="editCountryName" class="form-label">Country Name:</label>
                            <input type="text" class="form-control" id="editCountryName" name="name" required>
                        </div>
                        <button type="submit" name="edit_country" class="btn btn-primary">Save changes</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Delete Country Confirmation Modal -->
    <div class="modal fade" id="deleteCountryModal" tabindex="-1" aria-labelledby="deleteCountryModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteCountryModalLabel">Delete Country</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to delete this country?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <a href="#" id="confirmCountryDeleteBtn" class="btn btn-danger">Delete</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Create Country Modal -->
    <div class="modal fade" id="createCountryModal" tabindex="-1" aria-labelledby="createCountryModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="createCountryModalLabel">Create New Country</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="createCountry.php">
                        <div class="mb-3">
                            <label for="createCountryName" class="form-label">Country Name</label>
                            <input type="text" class="form-control" id="createCountryName" name="name" required>
                        </div>
                        <button type="submit" name="create_country" class="btn btn-primary">Create Country</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>
    <script>
    const populateCountryModal = (id, name) => {
        document.getElementById("editCountryId").value = id;
        document.getElementById("editCountryName").value = name;
    }

    const confirmCountryDelete = (id) => {
        document.getElementById("confirmCountryDeleteBtn").href = `deleteCountry.php?id=${id}`;
        const deleteModal = new bootstrap.Modal(document.getElementById("deleteCountryModal"));
        deleteModal.show();

    }
    </script>
</body>

</html>

<?php include '../Layout/Footer.php'; ?>