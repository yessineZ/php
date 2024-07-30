<?php
include '../Layout/Header.php';
include './Functions.php';

$years = getAllYears();

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
    <title>Years</title>
</head>

<body>
    <?php if (isset($_GET["delete"]) && $_GET["delete"] == "ok") { ?>
    <div class="alert alert-success" role="alert">
        <?php echo "The year has been deleted successfully"; ?>
    </div>
    <?php } elseif (isset($_GET["edit"]) && $_GET["edit"] == "ok") { ?>
    <div class="alert alert-success" role="alert">
        <?php echo "The year has been edited successfully"; ?>
    </div>
    <?php } ?>

    <div class="container">
        <div class="row pt-4 pb-2">
            <div class="col-4">
                <h2 class="text-primary text-white">Years List</h2>
            </div>
            <div class="col-6 text-end">
                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createYearModal">
                    <i class="bi bi-plus"></i> Create New Year
                </button>
            </div>
        </div>
    </div>

    <table class="table table-bordered table-striped col-8 center">
        <thead>
            <tr>
                <th class="col-4">Year</th>
                <th class="col-4">Action</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($years as $year) { ?>
            <tr>
                <td><?php echo $year["year"]; ?></td>
                <td>
                    <div class="btn-group" role="group">
                        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#editYearModal"
                            onclick="populateYearModal('<?php echo $year['id']; ?>', '<?php echo $year['year']; ?>')">Edit</button>
                        <button class="btn btn-danger mx-2"
                            onclick="confirmYearDelete('<?php echo $year['id']; ?>')">Delete</button>
                    </div>
                </td>
            </tr>
            <?php } ?>
        </tbody>
    </table>

    <!-- Edit Year Modal -->
    <div class="modal fade" id="editYearModal" tabindex="-1" aria-labelledby="editYearModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editYearModalLabel">Edit Year</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="editYearForm" method="POST" action="updateYear.php">
                        <input type="hidden" id="editYearId" name="id">
                        <div class="mb-3">
                            <label for="editYear" class="form-label">Year:</label>
                            <input type="text" class="form-control" id="editYear" name="year" required>
                        </div>
                        <button type="submit" name="edit_year" class="btn btn-primary">Save changes</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Delete Year Confirmation Modal -->
    <div class="modal fade" id="deleteYearModal" tabindex="-1" aria-labelledby="deleteYearModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteYearModalLabel">Delete Year</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to delete this year?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <a href="#" id="confirmYearDeleteBtn" class="btn btn-danger">Delete</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Create Year Modal -->
    <div class="modal fade" id="createYearModal" tabindex="-1" aria-labelledby="createYearModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="createYearModalLabel">Create New Year</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="createYear.php">
                        <div class="mb-3">
                            <label for="createYear" class="form-label">Year</label>
                            <input type="text" class="form-control" id="createYear" name="year" required>
                        </div>
                        <button type="submit" name="create_year" class="btn btn-primary">Create Year</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>
    <script>
    const populateYearModal = (id, year) => {
        document.getElementById("editYearId").value = id;
        document.getElementById("editYear").value = year;
    }

    const confirmYearDelete = (id) => {
        document.getElementById("confirmYearDeleteBtn").href = `deleteYear.php?id=${id}`;
        const deleteModal = new bootstrap.Modal(document.getElementById("deleteYearModal"));
        deleteModal.show();
    }
    </script>
</body>

</html>

<?php include '../Layout/Footer.php'; ?>