<?php 
include '../Layout/Header.php';
include './Functions.php';
if(isset($_GET['user_id'])) {
    $user_id = $_GET['user_id'];
    $references = GetReferencesUser($user_id);
    
}else {
    $references = Getreferences();
}
$types = GetTypes();
$users = getUsers();
$countries = GetCountries();

if(!isset($_SESSION['EmailAdmin'])) {
    header('Location: ../login.php');
    exit;
} 

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['create_reference'])) {
    $name = $_POST['create_name'];
    $description = $_POST['create_description'];
    $link = $_POST['create_link'];
    $type = $_POST['create_type'];
    $pays = $_POST['create_pays'];
    $annee = $_POST['create_annee'];
    $createur = $_POST['create_createur'];

    // Image upload logic
    $image = uploadImage('create_image');

    if (empty($name) || empty($description) || empty($link) || empty($createur) || empty($annee) || empty($type) || empty($pays) || $image === false) {
        $errorMessage = 'Please fill out all fields and upload a valid image!';
    } else {
        $result = createReference($name, $description, $image, $link, $type, $pays, $annee, $createur);

        if ($result) {
            header('Location: references.php?create=ok');
        } else {
            $errorMessage = 'Failed to create reference.';
        }
    }
}

// Function to handle image upload
function uploadImage($inputName) {
    $targetDir = "../../images/";
    $targetFile = basename($_FILES[$inputName]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

    // Check if image file is a actual image or fake image
    $check = getimagesize($_FILES[$inputName]["tmp_name"]);
    if ($check === false) {
        return false;
    }

    // Check file size (500KB)
    if ($_FILES[$inputName]["size"] > 500000) {
        return false;
    }

    // Allow certain file formats
    if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
        && $imageFileType != "gif") {
        return false;
    }

    // if everything is ok, try to upload file
    if (move_uploaded_file($_FILES[$inputName]["tmp_name"],"../../images/" . $targetFile)) {
        return $targetFile;
    } else {
        return false;
    }
}



if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update'])) {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $description = $_POST['description'];
    $link = $_POST['link'];
    $type = $_POST['type'];
    $pays = $_POST['modalPays'];
    $annee = $_POST['annee'];
    $createur = $_POST['createur'];

    // Image upload logic for update
    $image = $_POST['image']; // Existing image path

    if ($_FILES['image']['name']) {
        $newImage = uploadImage('image');
        if ($newImage !== false) {
            // Delete old image if needed
            if ($image) {
                unlink($image); // Delete old image file
            }
            $image = $newImage; // Update image path
        }
    }

    if (empty($name) || empty($description) || empty($link) || empty($createur) || empty($annee) || empty($type) || empty($pays)) {
        $errorMessage = 'Please fill out all fields!';
    } else {
        $result = updateReference($id, $name, $description, $image, $link, $type, $pays, $annee, $createur);

        if ($result) {
            header('Location: references.php?update=ok');
            exit;
        } else {
            $errorMessage = 'Failed to update reference.';
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
    <title>References</title>
</head>

<body>
    <?php if(isset($_GET["delete"]) && $_GET["delete"] == "ok") { ?>
    <div class="alert alert-success" role="alert">
        <?php echo "The reference has been deleted successfully"; ?>
    </div>
    <?php } elseif(isset($_GET["edit"]) && $_GET["edit"] == "ok") { ?>
    <div class="alert alert-success" role="alert">
        <?php echo "The reference has been edited successfully"; ?>
    </div>
    <?php } elseif(isset($_GET["update"]) && $_GET["update"] == "ok") { ?>
    <div class="alert alert-success" role="alert">
        <?php echo "The reference has been edited successfully"; ?>
    </div>
    <?php } elseif(isset($_GET["create"]) && $_GET["create"] == "ok") { ?>
    <div class="alert alert-success" role="alert">
        <?php echo "The reference has been created successfully"; ?>
    </div>
    <?php } ?>

    <div class="container">
        <div class="row pt-4 pb-2">
            <div class="col-8">
                <h2 class="text-primary">References List</h2>
            </div>
            <div class="col-4 text-end">
                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createReferenceModal">
                    <i class="bi bi-search"></i> Create New Reference
                </button>
            </div>
        </div>
    </div>

    <div class="container">
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th scope="col">clientId</th>
                    <th scope="col">Description</th>
                    <th scope="col">logo</th>
                    <th scope="col">Link</th>
                    <th scope="col">id_type</th>
                    <th scope="col">Pays</th>
                    <th scope="col">year</th>
                    <th scope="col">creater</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($references as $reference) { ?>
                <tr id="reference-<?php echo $reference['id']; ?>">
                    <td class="yoo" id="client-<?php echo $reference['id']; ?>">
                        <?php $client = getClient($reference["id_client"]);
                        echo $client["username"]; ?>
                    </td>
                    <td id="description-<?php echo $reference['id']; ?>"><?php echo $reference["description"]; ?></td>
                    <td><img id="img-<?php echo $reference['id']; ?>"
                            src="<?php  echo "../../images/" . $reference["logo"]; ?>"
                            style="height: 75px; width: 75px;" alt="reference Image"></td>
                    <td id="link-<?php echo $reference['id']; ?>"><?php echo $reference["link"]; ?></td>
                    <td id="type-<?php echo $reference['id']; ?>">
                        <?php $type = gettType($reference["id_type"]);
                        echo $type["name"]; ?>
                    </td>
                    <td id="pays-<?php echo $reference['id']; ?>">
                        <?php $pays = getPays($reference["pays"]);
                        echo $pays["name"]; ?>
                    </td>
                    <td id="annee-<?php echo $reference['id']; ?>"><?php echo $reference["annee"]; ?></td>
                    <td id="creator-<?php echo $reference['id']; ?>"><?php echo $reference["creator"]; ?></td>
                    <td>
                        <div class="btn-group" role="group">
                            <button id="edit-<?php echo $reference['id']; ?>" class="btn btn-primary"
                                data-bs-toggle="modal" data-bs-target="#exampleModal"
                                onclick="populateModal(<?php echo $reference['id']; ?>)">Edit</button>
                            <button class="btn btn-danger mx-2"
                                onclick="confirmDelete(<?php echo $reference['id']; ?>)">
                                <i class="fa-thin fa-trash"></i> Delete
                            </button>
                        </div>
                    </td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>

    <!-- Edit Modal HTML -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="updateReferenceModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="updateReferenceModalLabel">Update Reference</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="updateReferenceForm" method="POST" action="references.php" enctype="multipart/form-data">
                        <input type="hidden" id="referenceId" name="id">
                        <div class="mb-3">
                            <label for="modalClient" class="form-label">User </label>
                            <select class="form-select" id="modalClient" name="name" required>
                                <?php foreach ($users as $user) {
                                    echo '<option value="' . $user['id'] . '">' . $user['username'] . '</option>';
                                } ?>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="modalDescription" class="form-label">Description:</label>
                            <input type="text" class="form-control" id="modalDescription" name="description" required>
                        </div>
                        <div class="mb-3">
                            <label for="modalLink" class="form-label">Link</label>
                            <input type="text" class="form-control" id="modalLink" name="link" required>
                        </div>
                        <div class="mb-3">
                            <label for="modalImage" class="form-label">Image URL:</label>
                            <input type="file" class="form-control" id="modalImage" name="image">
                        </div>
                        <div class="mb-3">
                            <label for="modalCreator" class="form-label">Creator:</label>
                            <input type="text" class="form-control" id="modalCreator" name="createur" readonly>
                        </div>
                        <div class="mb-3">
                            <label for="modalYear" class="form-label">Year:</label>
                            <input type="text" class="form-control" id="modalYear" name="annee">
                        </div>
                        <div class="mb-3">
                            <label for="modalType" class="form-label">Type</label>
                            <select class="form-select" id="modalType" name="type" required>
                                <?php foreach ($types as $type) {
                                    echo '<option value="' . $type['id'] . '">' . $type['name'] . '</option>';
                                } ?>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="modalPays" class="form-label">Pays</label>
                            <select class="form-select" id="modalPays" name="modalPays" required>
                                <?php foreach ($countries as $country) {
                                    echo '<option value="' . $country['id'] . '">' . $country['name'] . '</option>';
                                } ?>
                            </select>
                        </div>
                        <button type="submit" name="update" class="btn btn-primary">Save changes</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Delete Confirmation Modal HTML -->
    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteReferenceModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteReferenceModalLabel">Delete Reference</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to delete this reference?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <a href="#" id="confirmDeleteBtn" class="btn btn-danger">Delete</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Create Reference Modal HTML -->
    <div class="modal fade" id="createReferenceModal" tabindex="-1" aria-labelledby="createReferenceModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="createReferenceModalLabel">Create New Reference</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="createReferenceForm" method="POST" action="references.php" enctype="multipart/form-data">
                        <div class="mb-3">
                            <label for="createClient" class="form-label">User:</label>
                            <select class="form-select" id="createClient" name="create_name" required>
                                <?php foreach ($users as $user) {
                                    echo '<option value="' . $user['id'] . '">' . $user['username'] . '</option>';
                                } ?>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="createDescription" class="form-label">Description:</label>
                            <input type="text" class="form-control" id="createDescription" name="create_description"
                                required>
                        </div>
                        <div class="mb-3">
                            <label for="createLink" class="form-label">Link:</label>
                            <input type="text" class="form-control" id="createLink" name="create_link" required>
                        </div>
                        <div class="mb-3">
                            <label for="createImage" class="form-label">Image URL:</label>
                            <input type="file" class="form-control" id="createImage" name="create_image" required>
                        </div>
                        <div class="mb-3">
                            <label for="createYear" class="form-label">Year:</label>
                            <input type="text" class="form-control" id="createYear" name="create_annee" required>
                        </div>
                        <div class="mb-3">
                            <label for="createType" class="form-label">Type:</label>
                            <select class="form-select" id="createType" name="create_type" required>
                                <?php foreach ($types as $type) {
                                    echo '<option value="' . $type['id'] . '">' . $type['name'] . '</option>';
                                } ?>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="createPays" class="form-label">Pays:</label>
                            <select class="form-select" id="createPays" name="create_pays" required>
                                <?php foreach ($countries as $country) {
                                    echo '<option value="' . $country['id'] . '">' . $country['name'] . '</option>';
                                } ?>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="createCreator" class="form-label">Creator:</label>
                            <input type="text" class="form-control" id="createCreator" value=<?php echo $_SESSION["UsernameAdmin"] 
                                ?> name="create_createur" required readonly>
                        </div>
                        <button type="submit" name="create_reference" class="btn btn-primary">Create Reference</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>
    <script>
    const populateModal = (id) => {
        var client = document.getElementById(`client-${id}`).innerText;
        var description = document.getElementById(`description-${id}`).innerText;
        var logo = document.getElementById(`img-${id}`).src.split('/').pop();
        var link = document.getElementById(`link-${id}`).innerText;
        var type = document.getElementById(`type-${id}`).innerText;
        var pays = document.getElementById(`pays-${id}`).innerText;
        var annee = document.getElementById(`annee-${id}`).innerText;
        var creator = document.getElementById(`creator-${id}`).innerText;

        document.getElementById("referenceId").value = parseInt(id);
        document.getElementById("modalClient").value = parseInt(client);
        document.getElementById("modalDescription").value = description;
        document.getElementById("modalLink").value = link;
        document.getElementById("modalYear").value = annee;
        document.getElementById("modalCreator").value = creator;

        const userOptions = document.getElementById("modalClient").options;
        for (let i = 0; i < userOptions.length; i++) {
            if (userOptions[i].text.trim() === client) {
                userOptions[i].selected = true;
                break;
            }
        }

        const typeOptions = document.getElementById("modalType").options;
        for (let i = 0; i < typeOptions.length; i++) {
            if (typeOptions[i].text.trim() === type) {
                typeOptions[i].selected = true;
                break;
            }
        }

        const countryOptions = document.getElementById("modalPays").options;
        for (let i = 0; i < countryOptions.length; i++) {
            if (countryOptions[i].text.trim() === pays) {
                countryOptions[i].selected = true;
                break;
            }
        }
    }

    const confirmDelete = (id) => {
        const confirmDeleteBtn = document.getElementById("confirmDeleteBtn");
        confirmDeleteBtn.href = `deletereference.php?id=${id}`;
        const deleteModal = new bootstrap.Modal(document.getElementById("deleteModal"));
        deleteModal.show();
    }
    </script>
</body>

</html>

<?php 
include '../Layout/Footer.php'; 
?>