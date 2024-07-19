<?php
// types.php
include '../Layout/Header.php';
include './Functions.php';

$types = getAllTypes();

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
    <title>Types</title>
</head>

<body>
    <?php if (isset($_GET["delete"]) && $_GET["delete"] == "ok") { ?>
    <div class="alert alert-success" role="alert">
        <?php echo "The type has been deleted successfully"; ?>
    </div>
    <?php } elseif (isset($_GET["edit"]) && $_GET["edit"] == "ok") { ?>
    <div class="alert alert-success" role="alert">
        <?php echo "The type has been edited successfully"; ?>
    </div>
    <?php } ?>

    <div class="container">
        <div class="row pt-4 pb-2">
            <div class="col-4">
                <h2 class="text-primary">
                    Type List
                </h2>
            </div>
            <div class="col-6 text-end">
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createTypeModal">
                    <i class="bi bi-plus"></i> Create New Type
                </button>
            </div>
        </div>
    </div>

    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>Type Name</th>
                <th>Description</th>
                <th>Creator</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($types as $type) { ?>
            <tr>
                <td><?php echo $type['name']; ?></td>
                <td><?php echo $type['description']; ?></td>
                <td><?php echo $type['createur']; ?></td>
                <td>
                    <div class="btn-group" role="group">
                        <button type="button" class="btn btn-primary" onclick="populateEditTypeModal(<?php echo $type['id']; ?>, '<?php echo $type['name']; ?>',
                            '<?php echo $type['description']; ?>', '<?php echo $type['createur']; ?>')">
                            Edit
                        </button>
                        <button type="button" class="btn btn-danger m-1"
                            onclick="confirmDeleteType(<?php echo $type['id']; ?>)">
                            Delete
                        </button>
                    </div>
                </td>
            </tr>
            <?php } ?>
        </tbody>
    </table>

    <!-- Create Type Modal -->
    <div class="modal fade" id="createTypeModal" tabindex="-1" aria-labelledby="createTypeModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="createTypeModalLabel">Create New Type</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="createType.php">
                        <div class="mb-3">
                            <label for="createTypeName" class="form-label">Type Name</label>
                            <input type="text" class="form-control" id="createTypeName" name="name" required>
                        </div>
                        <div class="mb-3">
                            <label for="createTypeDescription" class="form-label">Description</label>
                            <textarea class="form-control" id="createTypeDescription" name="description"
                                required></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="createTypeCreator" class="form-label">Creator</label>
                            <input type="text" class="form-control" id="createTypeCreator"
                                value="<?php echo $_SESSION['UsernameAdmin']; ?>" name="creator" readonly required>
                        </div>
                        <button type="submit" name="create_type" class="btn btn-primary">Create Type</button>
                    </form>
                </div>
            </div>
        </div>
    </div>


    <!-- Edit Type Modal -->
    <div class="modal fade" id="editTypeModal" tabindex="-1" aria-labelledby="editTypeModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editTypeModalLabel">Edit Type</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="updateType.php">
                        <input type="hidden" id="editTypeId" name="id">
                        <div class="mb-3">
                            <label for="editTypeName" class="form-label">Type Name</label>
                            <input type="text" class="form-control" id="editTypeName" name="name" required>
                        </div>
                        <div class="mb-3">
                            <label for="editTypeDescription" class="form-label">Description</label>
                            <textarea class="form-control" id="editTypeDescription" name="description"
                                required></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="editTypeCreator" class="form-label">Creator</label>
                            <input type="text" class="form-control" id="editTypeCreator" name="creator" readonly
                                required>
                        </div>
                        <button type="submit" name="edit_type" class="btn btn-primary">Save Changes</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Delete Type Modal -->
    <div class="modal fade" id="deleteTypeModal" tabindex="-1" aria-labelledby="deleteTypeModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteTypeModalLabel">Delete Type</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to delete this type?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <a href="#" id="confirmDeleteTypeBtn" class="btn btn-danger">Delete</a>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"
        integrity="sha384-AHJNPp6o+aFCW26+5j5lFfTZjrJ7k5Y5tqY+s5H8yXdzvIjO0RGN0V+anvFmKnhc" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>

    <script>
    function populateEditTypeModal(id, name, description, creator) {
        document.getElementById('editTypeId').value = id;
        document.getElementById('editTypeName').value = name;
        document.getElementById('editTypeDescription').value = description;
        document.getElementById('editTypeCreator').value = creator;

        var editTypeModal = new bootstrap.Modal(document.getElementById('editTypeModal'));
        editTypeModal.show();
    }

    function confirmDeleteType(id) {
        var deleteTypeBtn = document.getElementById('confirmDeleteTypeBtn');
        deleteTypeBtn.href = 'deleteType.php?id=' + id;

        var deleteTypeModal = new bootstrap.Modal(document.getElementById('deleteTypeModal'));
        deleteTypeModal.show();
    }
    </script>
</body>

</html>

<?php
include '../Layout/Footer.php';
?>