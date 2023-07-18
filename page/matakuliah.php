<?php
// Koneksi Database
include('C:\xampp\htdocs\app\koneksi.php');

// Jika tombol simpan diklik
if (isset($_POST['bsimpan'])) {
    // Pengujian Apakah data akan diedit atau disimpan baru
    if ($_GET['hal'] == "edit") {
        // Data akan di edit
        $edit = mysqli_query($conn, "UPDATE matakuliah SET
            kode_matakuliah = '$_POST[kode]',
            nama_matakuliah = '$_POST[nama]',
            sks = '$_POST[sks]'
            WHERE kode_matakuliah = '$_GET[id]'
        ");
        if ($edit) {
            echo "<script>
                alert('Edit data sukses!');
                document.location='?page=matakuliah';
            </script>";
        } else {
            echo "<script>
                alert('Edit data GAGAL!!');
                document.location='?page=matakuliah';
            </script>";
        }
    } else {
        // Data akan disimpan Baru
        $simpan = mysqli_query($conn, "INSERT INTO matakuliah (kode_matakuliah,nama_matakuliah, sks)
            VALUES ('$_POST[kode]', '$_POST[nama]', '$_POST[sks]')
        ");
        if ($simpan) {
            echo "<script>
                alert('Simpan data sukses!');
                document.location='?page=matakuliah';
            </script>";
        } else {
            echo "<script>
                alert('Simpan data GAGAL!!');
                document.location='?page=matakuliah';
            </script>";
        }
    }
}

// Pengujian jika tombol Edit / Hapus di klik
if (isset($_GET['hal'])) {
    // Pengujian jika edit Data
    if ($_GET['hal'] == "edit") {
        // Tampilkan Data yang akan diedit
        $tampil = mysqli_query($conn, "SELECT * FROM matakuliah WHERE kode_matakuliah = '$_GET[id]'");
        $data = mysqli_fetch_array($tampil);
        if ($data) {
            // Jika data ditemukan, maka data ditampung ke dalam variabel
            $vkode = $data['kode_matakuliah'];
            $vnama = $data['nama_matakuliah'];
            $vsks = $data['sks'];
        }
    } else if ($_GET['hal'] == "hapus") {
        // Persiapan hapus data
        $hapus = mysqli_query($conn, "DELETE FROM matakuliah WHERE kode_matakuliah = '$_GET[id]'");
        if ($hapus) {
            echo "<script>
                alert('Hapus Data Sukses!!');
                document.location='?page=matakuliah';
            </script>";
        } else {
            echo "<script>
                alert('Hapus Data GAGAL!!');
                document.location='?page=matakuliah';
            </script>";
        }
    }
}
?>

<!-- form matakuliah -->
<form action="" method="POST">
    <div class="card mt-1">
        <div class="card-header bg-primary text-white text-center">
            <h3>Input/ Edit/ Hapus Data dosen</h3>
        </div>
        <div class="card-body">
            <div class="form-group pt-3">
                <label>kode matakuliah</label>
                <input type="text" name="kode" value="<?= @$vkode ?>" class="form-control">
            </div>
            <div class="form-group pt-2">
                <label>Nama matakuliah</label>
                <input type="text" name="nama" value="<?= @$vnama ?>" class="form-control">
            </div>
            <div class="form-group pt-2">
                <label>sks</label>
                <input type="text" name="sks" value="<?= @$vsks ?>" class="form-control">
            </div>
            <div class="pt-3">
                <button type="submit" class="btn btn-success " name="bsimpan">Simpan</button>
                <button type="reset" class="btn btn-danger" name="breset">Kosongkan</button>
            </div>
        </div>
    </div>
</form>

<div class="card">
    <div class="card-body pt-3">
        <div class="col-md-15 p-1 pt-2 text-center">
            <h3>DAFTAR dosen</h3>
            <hr>
            <table class="table table-bordered table-striped text-center">
                <tr>
                    <th>No.</th>
                    <th>kode matakuliah</th>
                    <th>nama matakuliah</th>
                    <th>sks</th>
                    <th>aksi</th>
                </tr>
                <?php
                $no = 1;
                $tampil = mysqli_query($conn, "SELECT * FROM matakuliah");
                while ($data = mysqli_fetch_array($tampil)) :
                ?>
                    <tr>
                        <td><?= $no++; ?></td>
                        <td><?= $data['kode_matakuliah'] ?></td>
                        <td><?= $data['nama_matakuliah'] ?></td>
                        <td><?= $data['sks'] ?></td>
                        <td>
                        <a href="index.php?page=matakuliah&hal=edit&id=<?= $data['kode_matakuliah'] ?>" class="btn btn-warning"> Edit </a>

                        <a href="index.php?page=matakuliah&hal=hapus&id=<?= $data['kode_matakuliah'] ?>" onclick="return confirm('Apakah yakin ingin menghapus data ini?')" class="btn btn-danger"> Hapus </a>

                    </tr>
                <?php endwhile; //penutup perulangan while 
                ?>
            </table>

        </div>
    </div>
</div>
<!-- end form -->