<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Koneksi Database
include('C:\xampp\htdocs\app\koneksi.php');


// Jika tombol simpan atau update diklik
if (isset($_POST['bsimpan'])) {
    // Pengujian Apakah data akan diedit atau disimpan baru
    if ($_GET['hal'] == "edit") {
        // Data akan di edit
        $edit = mysqli_query($conn, "UPDATE perkuliahan SET
            nim = '$_POST[nim]',
            kode_matakuliah = '$_POST[kode]',
            nidn = '$_POST[nidn]',
            nilai = '$_POST[nilai]'
            WHERE nim = '$_GET[id]'
        ");
        if ($edit) {
            echo "<script>
                alert('Edit data sukses!');
                document.location='?page=perkuliahan';
                </script>";
        } else {
            echo "<script>
                alert('Edit data GAGAL!!');
                document.location='?page=perkuliahan';
            </script>";
        }
    } else {
        // Data akan disimpan Baru
        $simpan = mysqli_query($conn, "INSERT INTO perkuliahan (nim, kode_matakuliah, nidn, nilai)
            VALUES ('" . $_POST['nim'] . "', '" . $_POST['kode'] . "', '" . $_POST['nidn'] . "', '" . $_POST['nilai'] . "')
        ");
        if ($simpan) {
            echo "<script>
                alert('Simpan data sukses!');
                document.location='?page=perkuliahan';
            </script>";
        } else {
            echo "<script>
                alert('Simpan data GAGAL!!');
                document.location='?page=perkuliahan';
            </script>";
        }
    }
}


// Pengujian jika tombol Edit / Hapus di klik
if (isset($_GET['hal']) && $_GET['hal'] == "edit" && isset($_GET['id'])) {
    $tampil = mysqli_query($conn, "SELECT * FROM perkuliahan WHERE nim = '" . $_GET['id'] . "'");
    $data = mysqli_fetch_array($tampil);
    if ($data) {
        // Jika data ditemukan, maka data ditampung ke dalam variabel
        $vid = $data['nim'];
        $vnim = $data['nim'];
        $vkode = $data['kode_matakuliah'];
        $vnidn = $data['nidn'];
        $vnilai = $data['nilai'];
    }


} else if (isset($_GET['hal']) && $_GET['hal'] == "hapus") {
    // Persiapan hapus data
    $hapus = mysqli_query($conn, "DELETE FROM perkuliahan WHERE nim = '" . $_GET['id'] . "'");
    if ($hapus) {
        echo "<script>
                alert('Hapus Data Sukses!!');
                document.location='?page=perkuliahan';
            </script>";
    } else {
        echo "<script>
                alert('Hapus Data GAGAL!!');
                document.location='?page=perkuliahan';
            </script>";
    }
}
?>

<!-- form -->
<form action="" method="POST">
    <div class="card mt-1">
        <div class="card-header bg-primary text-white text-center">
            <h3>Input/ Edit/ Hapus Data nilai mhs</h3>
        </div>
        <div class="card-body">
            
            <input type="hidden" name="id" value="<?= $vid ?>">
            <div class="form-group pt-3">
                <label for="nim">-- Pilih NIM Mahasiswa --</label>
                <select name="nim" class="form-control" id="nim">
                    <option value=""><?= @$vnim ?></option>
                    <?php
                    $tampil = mysqli_query($conn, "SELECT * FROM mahasiswa");
                    while ($data = mysqli_fetch_assoc($tampil)) {
                        $selected = ($data['nim'] == $vnim) ? 'selected' : '';
                        echo '<option value="' . $data['nim'] . '"  ' . $selected . '>' . $data['nim'] . '</option>';
                    }
                    ?>
                </select>
            </div>
            <div class="form-group pt-3">
                <label for="kode">-- Pilih kode Mahasiswa --</label>
                <select name="kode" class="form-control" id="kode">
                    <option value=""><?= @$vkode ?></option>
                    <?php
                    $tampil = mysqli_query($conn, "SELECT * FROM matakuliah ");
                    while ($data = mysqli_fetch_assoc($tampil)) {
                        echo '<option value="' . $data['kode_matakuliah'] . '">' . $data['kode_matakuliah'] . '</option>';
                    }
                    ?>
                </select>
            </div>
            <div class="form-group pt-3">
                <label for="nidn">-- Pilih NIDN --</label>
                <select name="nidn" class="form-control" id="nidn">
                    <option value=""><?= @$vnidn ?></option>
                    <?php
                    $tampil = mysqli_query($conn, "SELECT * FROM dosen");
                    while ($data = mysqli_fetch_assoc($tampil)) {
                        echo '<option value="' . $data['nidn'] . '">' . $data['nidn'] . '</option>';
                    }
                    ?>
                </select>
            </div>
            <div class="form-group pt-3">
                <label for="floatingSelect">-- Pilih Grade Nilai --</label>
                <div class="form-floating mb-3">
                    <select class="form-select" id="floatingSelect" aria-label="Floating label select example" name="nilai">
                        <option selected value="<?= @$vnilai ?>"><?= @$vnilai ?></option>
                        <option>A</option>
                        <option>B</option>
                        <option>C</option>
                    </select>

                </div>
            </div>
            <div class="pt-3">
                <button type="submit" class="btn btn-success" name="bsimpan">Simpan</button>
                <button type="reset" class="btn btn-danger" name="breset">Kosongkan</button>
            </div>
        </div>
    </div>
</form>
<!-- end form -->

<div class="card">
    <div class="card-body pt-3">
        <div class="col-md-15 p-1 pt-2 text-center">
            <h3>Daftar haha</h3>
            <hr>
            <table class="table table-bordered table-striped text-center">
                <tr>
                    <th>No.</th>
                    <th>nim</th>
                    <th>kode matakuliah</th>
                    <th>nidn</th>
                    <th>nilai</th>
                    <th>aksi</th>
                </tr>
                <?php
                $no = 1;
                $tampil = mysqli_query($conn, "SELECT * FROM perkuliahan");
                while ($data = mysqli_fetch_array($tampil)) :
                ?>
                    <tr>
                        <td><?= $no++; ?></td>
                        <td><?= $data['nim'] ?></td>
                        <td><?= $data['kode_matakuliah'] ?></td>
                        <td><?= $data['nidn'] ?></td>
                        <td><?= $data['nilai'] ?></td>
                        <td>
                        <a href="index.php?page=perkuliahan&hal=edit&id=<?= $data['nim'] ?>" class="btn btn-warning"> Edit </a>


                            <a href="index.php?page=perkuliahan&hal=hapus&id=<?= $data['nim'] ?>" onclick="return confirm('Apakah yakin ingin menghapus data ini?')" class="btn btn-danger"> Hapus </a>
                    </tr>
                <?php endwhile; //penutup perulangan while 
                ?>
            </table>

        </div>
    </div>
</div>
<!-- end perkuliahan -->