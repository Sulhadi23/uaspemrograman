<?php
// Koneksi Database
include('C:\xampp\htdocs\app\koneksi.php');

// Jika tombol simpan diklik
if (isset($_POST['bsimpan'])) {
    // Pengujian Apakah data akan diedit atau disimpan baru
    if ($_GET['hal'] == "edit") {
        // Data akan di edit
        $edit = mysqli_query($conn, "UPDATE mahasiswa SET
            nim = '" . $_POST['nim'] . "',
            nama_mhs = '" . $_POST['nama'] . "',
            tanggal_lahir = '" . $_POST['tgl'] . "',
            alamat = '" . $_POST['alamat'] . "',
            jenis_kelamin = '" . $_POST['jenis'] . "'
            WHERE nim = '" . $_GET['id'] . "'
        ");
        if ($edit) {
            echo "<script>
                alert('Edit data sukses!');
                document.location='?page=mahasiswa';
            </script>";
        } else {
            echo "<script>
                alert('Edit data GAGAL!!');
                document.location='?page=mahasiswa';
            </script>";
        }
    } else {
        // Data akan disimpan Baru
        $simpan = mysqli_query($conn, "INSERT INTO mahasiswa (nim, nama_mhs, tanggal_lahir, alamat, jenis_kelamin)
            VALUES ('" . $_POST['nim'] . "', '" . $_POST['nama'] . "', '" . $_POST['tgl'] . "', '" . $_POST['alamat'] . "', '" . $_POST['jenis'] . "')
        ");
        if ($simpan) {
            echo "<script>
                alert('Simpan data sukses!');
                document.location='?page=mahasiswa';
            </script>";
        } else {
            echo "<script>
                alert('Simpan data GAGAL!!');
                document.location='?page=mahasiswa';
            </script>";
        }
    }
}

// Pengujian jika tombol Edit / Hapus di klik
if (isset($_GET['hal'])) {
    // Pengujian jika edit Data
    if ($_GET['hal'] == "edit") {
        // Tampilkan Data yang akan diedit
        $tampil = mysqli_query($conn, "SELECT * FROM mahasiswa WHERE nim = '" . $_GET['id'] . "'");
        $data = mysqli_fetch_array($tampil);
        if ($data) {
            // Jika data ditemukan, maka data ditampung ke dalam variabel
            $vnim = $data['nim'];
            $vnama = $data['nama_mhs'];
            $vtgl = $data['tanggal_lahir'];
            $valamat = $data['alamat'];
            $vjenis = $data['jenis_kelamin'];
        }
    } else if ($_GET['hal'] == "hapus") {
        // Persiapan hapus data
        $hapus = mysqli_query($conn, "DELETE FROM mahasiswa WHERE nim = '" . $_GET['id'] . "'");
        if ($hapus) {
            echo "<script>
                alert('Hapus Data Sukses!!');
                document.location='?page=mahasiswa';
            </script>";
        } else {
            echo "<script>
                alert('Hapus Data GAGAL!!');
                document.location='?page=mahasiswa';
            </script>";
        }
    }
}
?>

<!-- form mhs -->

<form action="" method="POST">
    <div class="card mt-1">
        <div class="card-header bg-primary text-white text-center">
            <h3>Input/ Edit/ Hapus Data dosen</h3>
        </div>
        <div class="card-body">
            <div class="form-group pt-3">
                <label>NIM</label>
                <input type="text" name="nim" value="<?= @$vnim ?>" class="form-control">
            </div>
            <div class="form-group pt-3">
                <label>Nama Mahasiswa</label>
                <input type="text" name="nama" value="<?= @$vnama ?>" class="form-control">
            </div>
            <div class="form-group pt-3">
                <label>Tanggal Lahir</label>
                <input type="date" name="tgl" value="<?= @$vtgl ?>" class="form-control">
            </div>
            <div class="form-group pt-3">
                <label>Alamat</label>
                <input type="text" name="alamat" value="<?= @$valamat ?>" class="form-control">
            </div>
            <div class="form-group pt-2">
                <label>Jenis Kelamin</label>
                <input type="text" name="jenis" value="<?= @$vjenis ?>" class="form-control">
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
                    <th>nim</th>
                    <th>Nama mhs</th>
                    <th>tgl</th>
                    <th>alamat</th>
                    <th>jenis kelamin</th>
                    <th>aksi</th>
                </tr>
                <?php
                $no = 1;
                $tampil = mysqli_query($conn, "SELECT * FROM mahasiswa");
                while ($data = mysqli_fetch_array($tampil)) :
                ?>
                    <tr>
                        <td><?= $no++; ?></td>
                        <td><?= $data['nim'] ?></td>
                        <td><?= $data['nama_mhs'] ?></td>
                        <td><?= $data['tanggal_lahir'] ?></td>
                        <td><?= $data['alamat'] ?></td>
                        <td><?= $data['jenis_kelamin'] ?></td>
                        <td>
                            <a href="index.php?page=mahasiswa&hal=edit&id=<?= $data['nim'] ?>" class="btn btn-warning"> Edit </a>
                            <a href="index.php?page=mahasiswa&hal=hapus&id=<?= $data['nim'] ?>" onclick="return confirm('Apakah yakin ingin menghapus data ini?')" class="btn btn-danger"> Hapus </a>

                    </tr>
                <?php endwhile; //penutup perulangan while 
                ?>
            </table>

        </div>
    </div>
</div>
<!-- end form -->