<?php 
include '../Layout/Header.php';
include './Functions.php';

$users = GetUsers();

if(!isset($_SESSION['EmailAdmin'])) {
    header('Location: ../login.php');
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['edit_user'])) {
    $userId = $_POST['id'];
    $username = $_POST['username'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];

    // Validate inputs (you can add more validation as needed)
    if (empty($username) || empty($email) || empty($phone)) {
        $errorMessage = 'Please fill out all required fields!';
    } else {
        // Update user in database
        $result = updateUser($userId, $username, $email, $phone);

        if ($result) {
            // Redirect to users.php with success message
            header('Location: users.php?edit=ok');
            exit;
        } else {
            $errorMessage = 'Failed to update user.';
        }
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['create_user'])) {
    $username = $_POST['create_username'];
    $password = $_POST['create_password'];
    $email = $_POST['create_email'];
    $phone = $_POST['create_phone'];

    if (empty($username) || empty($password) || empty($email) || empty($phone)) {
        $message = 'Please fill out all fields!';
    } else {
        $result = CreateUser($username, $password, $email, $phone);

        if ($result) {
            header('Location: users.php?create=ok');
        } else {
            $errorMessage = 'Failed to create user.';
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
    <title>Users</title>
</head>

<body>
    <?php if(isset($_GET["delete"]) && $_GET["delete"] == "ok") { ?>
    <div class="alert alert-success" role="alert">
        <?php echo "The user has been deleted successfully"; ?>
    </div>
    <?php } elseif(isset($_GET["edit"]) && $_GET["edit"] == "ok") { ?>
    <div class="alert alert-success" role="alert">
        <?php echo "The user has been edited successfully"; ?>
    </div>
    <?php } elseif(isset($_GET["create"]) && $_GET["create"] == "ok") { ?>
    <div class="alert alert-success" role="alert">
        <?php echo "The user has been created successfully"; ?>
    </div>
    <?php } ?>

    <div class="container">
        <div class="row pt-4 pb-2">
            <div class="col-8">
                <h2 class="text-primary">Users List</h2>
            </div>
            <div class="col-4 text-end">
                <button class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#createUserModal">
                    <i class="bi bi-plus"></i> Create New User
                </button>
            </div>
        </div>
    </div>

    <div class="container">
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>Username</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($users as $user) { ?>
                <tr id="user-<?php echo $user['id']; ?>">
                    <td id="username-<?php echo $user['id']; ?>"><?php echo $user["username"]; ?></td>
                    <td id="email-<?php echo $user['id']; ?>"><?php echo $user["email"]; ?></td>
                    <td id="phone-<?php echo $user['id']; ?>"><?php echo $user["phone"]; ?></td>
                    <td>
                        <div class="btn-group" role="group">
                            <button id="edit-<?php echo $user['id']; ?>" class="btn btn-success" data-bs-toggle="modal"
                                data-bs-target="#editUserModal"
                                onclick="populateUserModal(<?php echo $user['id']; ?>)">Edit</button>
                            <button id="edit-<?php echo $user['id']; ?>" class="ml-8 btn btn-danger"
                                onclick="GoToReference(<?php echo $user['id']; ?>)">References</button>
                        </div>
                    </td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>

    <!-- Edit User Modal HTML -->
    <div class="modal fade" id="editUserModal" tabindex="-1" aria-labelledby="editUserModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editUserModalLabel">Edit User</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="editUserForm" method="POST" action="users.php">
                        <input type="hidden" id="editUserId" name="id">
                        <div class="mb-3">
                            <label for="editUsername" class="form-label">Username:</label>
                            <input type="text" class="form-control" id="editUsername" name="username" required>
                        </div>

                        <div class="mb-3">
                            <label for="editEmail" class="form-label">Email:</label>
                            <input type="email" class="form-control" id="editEmail" name="email" required>
                        </div>
                        <div class="mb-3">
                            <label for="editPhone" class="form-label">Phone:</label>
                            <input type="text" class="form-control" id="editPhone" name="phone" required>
                        </div>
                        <button type="submit" name="edit_user" class="btn btn-primary">Save changes</button>
                    </form>
                </div>
            </div>
        </div>
    </div>




    <!-- Create User Modal HTML -->
    <div class="modal fade" id="createUserModal" tabindex="-1" aria-labelledby="createUserModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="createUserModalLabel">Create New User</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="createUserForm" method="POST" action="users.php">
                        <div class="mb-3">
                            <label for="createUsername" class="form-label">Username:</label>
                            <input type="text" class="form-control" id="createUsername" name="create_username" required>
                        </div>
                        <div class="mb-3">
                            <label for="createPassword" class="form-label">Password:</label>
                            <input type="password" class="form-control" id="createPassword" name="create_password"
                                required>
                        </div>
                        <div class="mb-3">
                            <label for="createEmail" class="form-label">Email:</label>
                            <input type="email" class="form-control" id="createEmail" name="create_email" required>
                        </div>
                        <div class="mb-3">
                            <label for="createPhone" class="form-label">Phone:</label>
                            <input type="text" class="form-control" id="createPhone" name="create_phone" required>
                        </div>
                        <button type="submit" name="create_user" class="btn btn-primary">Create User</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>
    <script>
    const populateUserModal = (id) => {
        var username = document.getElementById(`username-${id}`).innerText;
        var email = document.getElementById(`email-${id}`).innerText;
        var phone = document.getElementById(`phone-${id}`).innerText;

        document.getElementById("editUserId").value = id;
        document.getElementById("editUsername").value = username;
        document.getElementById("editEmail").value = email;
        document.getElementById("editPhone").value = phone;
    }

    const confirmUserDelete = (id) => {
        const confirmUserDeleteBtn = document.getElementById("confirmUserDeleteBtn");
        confirmUserDeleteBtn.href = `deleteUser.php?id=${id}`;
        const deleteUserModal = new bootstrap.Modal(document.getElementById("deleteUserModal"));
        deleteUserModal.show();
    }

    const GoToReference = (id) => {
        window.location.href = `../References/references.php?user_id=${id}`;
    }
    </script>


    <?php include '../Layout/Footer.php'; ?>