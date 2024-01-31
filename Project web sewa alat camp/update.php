<?php
// Include config file
require_once "config.php";

// Define variables and initialize with empty values
$nik_pelanggan = $nama = $no_hp = $alamat = "";
$nik_pelanggan_err = $nama_err = $no_hp_err = $alamat_err = "";

// Memeriksa apakah form telah disubmit
if(isset($_POST['submit'])){
    // Mendapatkan data dari form
    $nik_pelanggan = $_POST['nik_pelanggan'];
    $nama = $_POST['nama'];
    $no_hp = $_POST['no_hp'];
    $alamat = $_POST['alamat'];

    // Menjalankan query UPDATE
    $sql = "UPDATE pelanggan SET nama=?, alamat=?, no_hp=? WHERE nik_pelanggan=?";

    if ($stmt = mysqli_prepare($link, $sql)) {
        // Bind variables to the prepared statement as parameters
        mysqli_stmt_bind_param($stmt, "sssi", $param_nama, $param_alamat, $param_no_hp, $param_nik_pelanggan);

        // Set parameters
        $param_nama = $nama;
        $param_alamat = $alamat;
        $param_no_hp = $no_hp;
        $param_nik_pelanggan = $nik_pelanggan;

        // Attempt to execute the prepared statement
        if (mysqli_stmt_execute($stmt)) {
            // Records updated successfully. Redirect to the landing page
            header("location: dashboard.php");
            exit();
        } else {
            echo "Something went wrong. Please try again later.";
        }
    }

    // Close statement
    mysqli_stmt_close($stmt);

    // Close connection
    mysqli_close($link);
} else {
    // Check the existence of the id parameter before processing further
    if (isset($_GET["id"]) && !empty(trim($_GET["id"]))) {
        // Get the URL parameter
        $id = trim($_GET["id"]);

        // Prepare a select statement
        $sql = "SELECT * FROM pelanggan WHERE nik_pelanggan = ?";
        if ($stmt = mysqli_prepare($link, $sql)) {
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "i", $param_id);

            // Set parameters
            $param_id = $id;

            // Attempt to execute the prepared statement
            if (mysqli_stmt_execute($stmt)) {
                $result = mysqli_stmt_get_result($stmt);

                if (mysqli_num_rows($result) == 1) {
                    /* Fetch the result row as an associative array.
                    Since the result set contains only one row, we don't need to use a while loop */
                    $row = mysqli_fetch_array($result, MYSQLI_ASSOC);

                    // Retrieve individual field values
                    $nama = $row["nama"];
                    $alamat = $row["alamat"];
                    $no_hp = $row["no_hp"];
                } else {
                    // The URL doesn't contain a valid id. Redirect to the error page
                    header("location: error.php");
                    exit();
                }

            } else {
                echo "Oops! Something went wrong. Please try again later.";
            }
        }

        // Close statement
        mysqli_stmt_close($stmt);

        // Close connection
        mysqli_close($link);
    } else {
        // The URL doesn't contain an id parameter. Redirect to the error page
        header("location: error.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Update Record</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <style type="text/css">
        .wrapper {
            width: 500px;
            margin: 0 auto;
        }
    </style>
</head>

<body>
    <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="page-header">
                        <h2>Update Record</h2>
                    </div>
                    <p>Please edit the input values and submit to update the record.</p>
                    <form action="<?php echo htmlspecialchars(basename($_SERVER['REQUEST_URI'])); ?>" method="post">
                        <div class="form-group <?php echo (!empty($nama_err)) ? 'has-error' : ''; ?>">
                            <label>Nama</label>
                            <input type="text" name="nama" class="form-control" value="<?php echo $nama; ?>">
                            <span class="help-block"><?php echo $nama_err; ?></span>
                        </div>
                        <div class="form-group <?php echo (!empty($alamat_err)) ? 'has-error' : ''; ?>">
                            <label>Alamat</label>
                            <textarea name="alamat" class="form-control"><?php echo $alamat; ?></textarea>
                            <span class="help-block"><?php echo $alamat_err; ?></span>
                        </div>
                        <div class="form-group <?php echo (!empty($no_hp_err)) ? 'has-error' : ''; ?>">
                            <label>No. HP</label>
                            <input type="text" name="no_hp" class="form-control" value="<?php echo $no_hp; ?>">
                            <span class="help-block"><?php echo $no_hp_err; ?></span>
                        </div>
                        <input type="hidden" name="nik_pelanggan" value="<?php echo $_GET['id']; ?>" />
                        <input type="submit" class="btn btn-primary" name="submit" value="Submit">
                        <a href="dashboard.php" class="btn btn-default">Cancel</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
