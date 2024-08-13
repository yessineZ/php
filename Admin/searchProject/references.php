<?php 
include '../Layout/Header.php';
include './Functions.php';

if(!isset($_SESSION['EmailAdmin'])) {
    header('Location: ../login.php');
    exit;
} 

$searchTerm = '';
$currentClient = '';
$currentType = '';
$currentYear = '';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['search_term'])) {
    $searchTerm = $_POST['search_term'];
    $currentClient = $_POST['client']; 
    $currentType = $_POST['type'];
    $currentYear = $_POST['year'];

    $references = GetReferenceClient($currentClient, $searchTerm, $currentType, $currentYear);
}

$types = GetTypes();
$countries = GetCountries();
$clients = GetAllClients();
$years = getYears();

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
                        <div class="col-md-4">
                            <label for="client" class="form-label">Client:</label>
                            <select class="form-select" id="client" name="client" required>
                                <?php foreach ($clients as $client) {
                                    echo '<option value="' . $client['id'] . '">' . $client['name'] . '</option>';
                                } ?>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label for="search_term" class="form-label">Reference Name:</label>
                            <input type="text" name="search_term" class="form-control font-weight-bold"
                                placeholder="Reference Name">
                        </div>
                        <div class="col-md-2">
                            <label for="type" class="form-label">Type:</label>
                            <select class="form-select" id="type" name="type">
                                <option value="">All</option>
                                <?php foreach ($types as $type) {
                                    echo '<option value="' . $type['id'] . '">' . $type['name'] . '</option>';
                                } ?>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label for="year" class="form-label">Year:</label>
                            <select class="form-select" id="year" name="year">
                                <option value="">All</option>
                                <?php foreach ($years as $year) {
                                    echo '<option value="' . $year['id'] . '">' . $year['year'] . '</option>';
                                } ?>
                            </select>
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
            <div class="card-body overflow-auto">
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
                            <th scope="col">Actions</th>
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
                            <td><?php echo getYear($reference["annee"])['year']; ?></td>
                            <td><?php echo $reference["creator"]; ?></td>
                            <td>

                                <button class="btn btn-warning"
                                    onclick="printReferencePdf(<?php echo $reference['id']; ?>)">Print Reference as
                                    PDF</button>
                            </td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>

                <button class="btn btn-outline-primary" onclick="openPdfPreview()">Print References as PDF</button>
            </div>
        </div>
        <?php  } ?>

    </div>


    <div class="modal fade" id="pdfModal" tabindex="-1" aria-labelledby="pdfModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="pdfModalLabel">PDF Preview</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <iframe id="pdfPreview" src="" style="width: 100%; height: 500px;" frameborder="0"></iframe>
                </div>
                <div class="modal-footer">
                    <form id="pdfDownloadForm" action="generate_pdf.php" method="post">
                        <input type="hidden" name="client" value="<?php echo $currentClient; ?>">
                        <input type="hidden" name="search_term" value="<?php echo $searchTerm; ?>">
                        <input type="hidden" name="type" value="<?php echo $currentType; ?>">
                        <input type="hidden" name="year" value="<?php echo $currentYear; ?>">
                        <button type="submit" class="btn btn-primary" id="download">Download PDF</button>
                    </form>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>

    <script>
    function openPdfPreview() {
        const client = "<?php echo $currentClient; ?>";
        const searchTerm = "<?php echo $searchTerm; ?>";
        const type = "<?php echo $currentType; ?>";
        const year = "<?php echo $currentYear; ?>";
        const pdfUrl =
            `generate_pdf.php?client=${client}&search_term=${searchTerm}&type=${type}&year=${year}&preview=true`;


        const iframe = document.getElementById('pdfPreview');
        iframe.src = pdfUrl;
        const btn = document.getElementById('download');
        btn.style.display = 'block';

        const modal = new bootstrap.Modal(document.getElementById('pdfModal'));
        modal.show();
    }

    function printReferencePdf(referenceId) {
        const pdfUrl = `generate_pdf.php?reference_id=${referenceId}&preview=true`;


        const iframe = document.getElementById('pdfPreview');
        iframe.src = pdfUrl;

        const btn = document.getElementById('download');
        btn.style.display = 'none';
        const modal = new bootstrap.Modal(document.getElementById('pdfModal'));
        modal.show();
    }
    </script>

</body>

</html>

<?php 
include '../Layout/Footer.php'; 
?>