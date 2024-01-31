<?php
include 'config.php';

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

    // Validasi input
    if(empty($nik_pelanggan)){
        $nik_pelanggan_err = "Please enter the NIK Pelanggan.";
    }
    
    if(empty($nama)){
        $nama_err = "Please enter the name.";
    }

    if(empty($no_hp)){
        $no_hp_err = "Please enter the No. HP.";
    }

    if(empty($alamat)){
        $alamat_err = "Please enter the address.";
    }

    // Jika tidak ada error validasi, jalankan query INSERT
    if(empty($nik_pelanggan_err) && empty($nama_err) && empty($no_hp_err) && empty($alamat_err)){
        $sql = "INSERT INTO pelanggan (nik_pelanggan, nama, no_hp, alamat) VALUES ('$nik_pelanggan', '$nama', '$no_hp', '$alamat')";
        if(mysqli_query($link, $sql)){
            echo "Data berhasil ditambahkan.";
        } else{
            echo "ERROR: Tidak dapat mengeksekusi query: $sql. " . mysqli_error($link);
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Tambah Record</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <style type="text/css">
        .wrapper{
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
                        <h2>Tambah Record</h2>
                    </div>
                    <p>Silahkan isi form di bawah ini kemudian submit untuk menambahkan data pelanggan ke dalam database.</p>
                    <form action="" method="post">
                        <div class="form-group <?php echo (!empty($nik_pelanggan_err)) ? 'has-error' : ''; ?>">
                            <label>NIK Pelanggan</label>
                            <input type="text" name="nik_pelanggan" class="form-control" value="<?php echo $nik_pelanggan; ?>">
                            <span class="help-block"><?php echo $nik_pelanggan_err; ?></span>
                        </div>
                        <div class="form-group <?php echo (!empty($nama_err)) ? 'has-error' : ''; ?>">
                            <label>Nama</label>
                            <input type="text" name="nama" class="form-control" value="<?php echo $nama; ?>">
                            <span class="help-block"><?php echo $nama_err; ?></span>
                        </div>
                        <div class="form-group <?php echo (!empty($no_hp_err)) ? 'has-error' : ''; ?>">
                            <label>No. HP</label>
                            <input type="text" name="no_hp" class="form-control" value="<?php echo $no_hp; ?>">
                            <span class="help-block"><?php echo $no_hp_err; ?></span>
                        </div>
                        <div class="form-group <?php echo (!empty($alamat_err)) ? 'has-error' : ''; ?>">
                            <label>Alamat</label>
                            <input type="text" name="alamat" class="form-control" value="<?php echo $alamat; ?>">
                            <span class="help-block"><?php echo $alamat_err; ?></span>
                        </div>
                        <input type="submit" name="submit" class="btn btn-primary" value="Submit">
                        <a href="dashboard.php" class="btn btn-default">Cancel</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
