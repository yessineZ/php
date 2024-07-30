<?php 
include '../Layout/Header.php';
include './Functions.php';

$clients = getAllClients(); // Fetch clients
if(!isset($_SESSION['EmailAdmin'])) {
    header('Location: ../login.php');
    exit;
} 

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['create_client'])) {
    $name = $_POST['create_name'];
    $email = $_POST['create_email'];
    $password = $_POST['create_password'];

    if (empty($name) || empty($email) || empty($password)) {
        $errorMessage = 'Please fill out all fields!';
    } else {
        $result = createClient($name, $email, $password);

        if ($result) {
            header('Location: client.php?create=ok');
        } else {
            $errorMessage = 'Failed to create client.';
        }
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update'])) {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = !empty($_POST['password']) ? $_POST['password'] : null;

    if (empty($name) || empty($email)) {
        $errorMessage = 'Please fill out all fields!';
    } else {
        $result = updateClient($id, $name, $email, $password);

        if ($result) {
            header('Location: client.php?update=ok');
            exit;
        } else {
            $errorMessage = 'Failed to update client.';
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../static/bootstrap.min (8).css">
    <title>Clients</title>
</head>

<body>
    <?php if(isset($_GET["delete"]) && $_GET["delete"] == "ok") { ?>
    <div class="alert alert-success" role="alert">
        <?php echo "The client has been deleted successfully"; ?>
    </div>
    <?php } elseif(isset($_GET["edit"]) && $_GET["edit"] == "ok") { ?>
    <div class="alert alert-success" role="alert">
        <?php echo "The client has been edited successfully"; ?>
    </div>
    <?php } elseif(isset($_GET["update"]) && $_GET["update"] == "ok") { ?>
    <div class="alert alert-success" role="alert">
        <?php echo "The client has been edited successfully"; ?>
    </div>
    <?php } elseif(isset($_GET["create"]) && $_GET["create"] == "ok") { ?>
    <div class="alert alert-success" role="alert">
        <?php echo "The client has been created successfully"; ?>
    </div>
    <?php } ?>

    <div class="container">
        <div class="row pt-4 pb-2">
            <div class="col-8">
                <h2 class="text-primary">Clients List</h2>
            </div>
            <div class="col-4 text-end">
                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createClientModal">
                    <i class="bi bi-search"></i> Create New Client
                </button>
            </div>
        </div>
    </div>

    <div class="container">
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Name</th>
                    <th scope="col">Email</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($clients as $client) { ?>
                <tr id="client-<?php echo $client['id']; ?>">
                    <td><?php echo $client['id']; ?></td>
                    <td id="name-<?php echo $client['id']; ?>"><?php echo $client['name']; ?></td>
                    <td id="email-<?php echo $client['id']; ?>"><?php echo $client['email']; ?></td>
                    <td>
                        <div class="btn-group" role="group">
                            <button id="edit-<?php echo $client['id']; ?>" class="btn btn-primary"
                                data-bs-toggle="modal" data-bs-target="#editClientModal"
                                onclick="populateClientModal(<?php echo $client['id']; ?>)">Edit</button>
                            <button class="btn btn-danger mx-2" onclick="confirmDelete(<?php echo $client['id']; ?>)">
                                <i class="fa-thin fa-trash"></i> Delete
                            </button>
                        </div>
                    </td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>

    <!-- Edit Client Modal HTML -->
    <div class="modal fade" id="editClientModal" tabindex="-1" aria-labelledby="editClientModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editClientModalLabel">Update Client</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="updateClientForm" method="POST" action="client.php">
                        <input type="hidden" id="clientId" name="id">
                        <div class="mb-3">
                            <label for="modalName" class="form-label">Name:</label>
                            <input type="text" class="form-control" id="modalName" name="name" required>
                        </div>
                        <div class="mb-3">
                            <label for="modalEmail" class="form-label">Email:</label>
                            <input type="email" class="form-control" id="modalEmail" name="email" required>
                        </div>
                        <div class="mb-3">
                            <label for="modalPassword" class="form-label">Password (leave blank to keep
                                unchanged):</label>
                            <input type="password" class="form-control" id="modalPassword" name="password">
                        </div>
                        <button type="submit" name="update" class="btn btn-primary">Save changes</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Create Client Modal HTML -->
    <div class="modal fade" id="createClientModal" tabindex="-1" aria-labelledby="createClientModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="createClientModalLabel">Create New Client</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="createClientForm" method="POST" action="client.php">
                        <input type="hidden" name="create_client" value="1">
                        <div class="mb-3">
                            <label for="create_name" class="form-label">Name:</label>
                            <input type="text" class="form-control" id="create_name" name="create_name" required>
                        </div>
                        <div class="mb-3">
                            <label for="create_email" class="form-label">Email:</label>
                            <input type="email" class="form-control" id="create_email" name="create_email" required>
                        </div>
                        <div class="mb-3">
                            <label for="create_password" class="form-label">Password:</label>
                            <input type="password" class="form-control" id="create_password" name="create_password"
                                required>
                        </div>
                        <button type="submit" class="btn btn-primary">Create Client</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Delete Confirmation Modal HTML -->
    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteModalLabel">Confirm Deletion</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Are you sure you want to delete this client?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <a href="#" class="btn btn-danger" id="confirmDeleteBtn">Delete</a>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>

    <script>
    function confirmDelete(clientId) {
        var deleteUrl = "deleteClient.php?deleteClient=" + clientId;
        document.getElementById('confirmDeleteBtn').setAttribute('href', deleteUrl);
        var deleteModal = new bootstrap.Modal(document.getElementById('deleteModal'));
        deleteModal.show();
    }

    function populateClientModal(clientId) {
        var name = document.getElementById("name-" + clientId).innerHTML;
        var email = document.getElementById("email-" + clientId).innerHTML;
        document.getElementById("modalName").value = name;
        document.getElementById("modalEmail").value = email;
        document.getElementById("clientId").value = clientId;
    }
    </script>
</body>

</html>