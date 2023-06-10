     <!-- panggil file header -->
    <link rel="icon" href="assets/img/logo-pustaka.png" type="image/x-icon">
    <?php session_start(); include "header.php"; ?>

    <?php

    if ($_SESSION['id_user'] == null) {
        echo "<script>
alert('Anda belum login, login dahulu!');
window.location.href='http://localhost/bukutamu';
</script>";
        return;
    }

    $dataUpdate = null;

    if (isset($_GET['id'])) {
        $ids =$_GET['id'];
        $dataUpdate = mysqli_fetch_array(mysqli_query(
            $koneksi,
            "SELECT * FROM ttamu where id = $ids"
        ));
    }

    // Uji Jika tambol simpan diklik
    if (isset($_POST['bsimpan'])) {
        $tgl = date('Y-m-d');

        // htmlspecialchars agar inputan lebih aman dari injection
        $nama = htmlspecialchars( $_POST['nama'], ENT_QUOTES);
        $alamat = htmlspecialchars( $_POST['alamat'], ENT_QUOTES);
        $tujuan = htmlspecialchars( $_POST['tujuan'], ENT_QUOTES);
        $nope = htmlspecialchars( $_POST['nope'], ENT_QUOTES);


        if (isset($_GET['id'])) {
            $id = $_GET['id'];
            //persiapan query simpan data
            $update = mysqli_query($koneksi, "UPDATE ttamu SET nama='$nama',alamat='$alamat',tujuan='$tujuan',nope='$nope' WHERE id=$id");

            // Uji jika simpan data sukses
            if($update){
                echo "<script>alert('Update data Sukses, Terima kasih..!');document.location='?'</script>";
            } else {
                echo "<script>alert('Update Data GAGAL!!!');document.location='?'</script>";
            }
        } else {
            //persiapan query simpan data
            $simpan = mysqli_query($koneksi, "INSERT INTO ttamu VALUES ('', '$tgl', '$nama', '$alamat', '$tujuan', '$nope')");

            // Uji jika simpan data sukses
            if($simpan){
                echo "<script>alert('Simpan data Sukses, Terima kasih..!');document.location='?'</script>";
            } else {
                echo "<script>alert('Simpan Data GAGAL!!!');document.location='?'</script>";
            }
        }
    }
    
    
    ?>


    <!-- Head -->
    <div class="head text-center">
        <img src="assets/img/logo-pustaka.png" width="100">
        <h2 class="text-white">Daftar Pengunjung <br> Pusat Perpustakaan dan Literasi Pertanian </h2>
    </div>
        <!-- end Head -->
        

        <!-- Awal Row -->
        <div class="row mt-2">
            <!-- col-md-7 -->
            <div class="col-lg-7 mb-3">
                <div class="card shadow bg-gradient-light">
                    <!-- card-body -->
                    <div class="card-body">
                            <div class="text-center">
                                <h1 class="h4 text-gray-900 mb-4">Identitas Pengunjung</h1>
                            </div>
                            <form class="user" method="POST" action="">
                                <div class="form-group">
                                    <input type="text" class="form-control form-control-user" name="nama" placeholder="Nama Pengunjung" value="<?= $dataUpdate != null ? $dataUpdate['nama'] : '' ?>" required>
                                </div>
                            <form class="user">
                                <div class="form-group">
                                    <input type="text" class="form-control form-control-user" name="alamat" placeholder="Alamat Pengunjung" value="<?= $dataUpdate != null ? $dataUpdate['alamat'] : '' ?>" required>
                                </div>
                            <form class="user">
                                <div class="form-group">
                                    <input type="text" class="form-control form-control-user" name="tujuan" placeholder="Tujuan Pengunjung" value="<?= $dataUpdate != null ? $dataUpdate['tujuan'] : '' ?>" required>
                                </div>
                            <form class="user">
                                <div class="form-group">
                                    <input type="text" class="form-control form-control-user" name="nope" placeholder="No.hp Pengunjung" value="<?= $dataUpdate != null ? $dataUpdate['nope'] : '' ?>" required>
                                </div>

                                <button type="submit" name="bsimpan" class="btn <?= $dataUpdate != null ? 'btn-warning' : 'btn-primary' ?> btn-user btn-block"><?= $dataUpdate != null ? 'Update' : 'Simpan Data' ?></button>

                                <!-- <button type="button" name="bcancel" class="btn btn-user btn-block">Cancel</button> -->

                                <a href="http://localhost/bukutamu/admin.php">Cancel</a>
                
                            </form>
                            <hr>
                            <div class="text-center">
                                <a class="small" href="#">2023 - <?=date('Y') ?> </a>
                            </div>
                        </div>
                    <!-- end card-body -->
                </div>
            </div>
            <!-- end col-md-7 -->


            <!-- col-md-5 -->
            <div class="col-lg-5 mb-3">
                <!-- card -->
                <div class="card shadow">
                    <!-- card-body -->
                    <div class="card-body">
                        <div class="text-center">
                                <h1 class="h4 text-gray-900 mb-4">Statistik Pengunjung</h1>
                        </div>
                        <?php
                        // deklarsi tanggal

                        // menampilkn tanggal sekarang
                         $tgl_sekarang = date('Y-m-d');

                        // menampilkan tgl kemarin
                         $kemarin= date('Y-m-d', strtotime('-1 day', strtotime(date('Y-m-d'))));

                        //mendapatkan 6 hari sebelum tgl skg
                        $seminggu = date('Y-m-d h:i:s', strtotime('-1 week +1 day', strtotime
                        ($tgl_sekarang)));

                        $sekarang = date('Y-m-d h:i:s');

                        // persiapan query tampilkan jumlah data pengunjung
                        
                        $tgl_sekarang = mysqli_fetch_array(mysqli_query(
                            $koneksi,
                            "SELECT count(*) FROM ttamu where tanggal like '%$tgl_sekarang%'"
                        ));

                        $kemarin = mysqli_fetch_array(mysqli_query(
                            $koneksi,
                            "SELECT count(*) FROM ttamu where tanggal like '%$kemarin%'"
                        ));

                        $seminggu = mysqli_fetch_array(mysqli_query(
                            $koneksi,
                            "SELECT count(*) FROM ttamu where tanggal BETWEEN '$seminggu' and'$sekarang'"
                        ));

                        $bulan_ini = date('m');

                        $sebulan = mysqli_fetch_array(mysqli_query(
                            $koneksi,
                            "SELECT count(*) FROM ttamu where month(tanggal) = '%$bulan_ini%'"
                        ));

                        $keseluruhan = mysqli_fetch_array(mysqli_query(
                            $koneksi,
                            "SELECT count(*) FROM ttamu" 
                        ));


                        ?>
                        <table class="table table-bordered">
                            <tr>
                                <td>Hari Ini</td>
                                <td>: <?= $tgl_sekarang[0] ?></td>
                            </tr>
                            <tr>
                                <td>Kemarin</td>
                                <td>: <?= $kemarin[0] ?></td>
                            </tr>
                            <tr>                           
                                <td>Minggu ini</td>
                                <td>: <?= $seminggu[0] ?></td>
                            </tr>
                                <td>Bulan Ini</td>
                                <td>:  <?= $sebulan[0] ?></td>
                            </tr>
                            <tr>
                                <td>Keseluruhan</td>
                                <td>:  <?= $keseluruhan[0] ?></td>
                            </tr>
                        </table>
                    </div>
                    <!-- end card-body -->
                </div>
                <!-- end cad -->
            </div>
            <!-- end col-md-5 -->


        </div>
        <!-- end row -->

        
                    <!-- DataTales Example -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Data Pengunjung Hari Ini [<?=date('d-m-Y') ?>] </h6>
                    </div>
                    <div class="card-body">
                        <a href="rekapitulasi.php" class="btn btn-success mb-3"><i class="fa fa-table">
                        </i>Rekapitulasi Pengunjung </a>
                        <a href="logout.php" class="btn btn-danger mb-3"><i class="fa fa-sign-out-alt">
                        </i>Logout</a>
                    


                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Tanggal</th>
                                            <th>Nama Pengunjung</th>
                                            <th>Alamat</th>
                                            <th>Tujuan</th>
                                            <th>No. Hp</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th>No</th>
                                            <th>Tanggal</th>
                                            <th>Nama Pengunjung</th>
                                            <th>Alamat</th>
                                            <th>Tujuan</th>
                                            <th>No. Hp</th>
                                            <th>Action</th>
                                        </tr>
                                    </tfoot>
                                    <tbody>
                                        <?php
                                            $tgl = date('Y-m-d'); //2023-05-20
                                            $tampil = mysqli_query($koneksi,"SELECT * FROM ttamu where tanggal like '%$tgl%' order by id desc");
                                            $no = 1;
                                            while($data = mysqli_fetch_array($tampil)){    
                                        ?>
                                            <tr>
                                                <td><?= $no++ ?></td>
                                                <td><?= $data['tanggal'] ?></td>
                                                <td><?= $data['nama'] ?></td>
                                                <td><?= $data['alamat'] ?></td>
                                                <td><?= $data['tujuan'] ?></td>
                                                <td><?= $data['nope'] ?></td>
                                                <td><a href='admin.php?id=<?= $data['id'] ?>'>Update</a> | <a href='delete.php?id=<?= $data['id'] ?>'>Delete</a></td>
                                            </tr>
                                        <?php } ?>  
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

    <!-- panggil file footer -->
    <?php include "header.php"; ?>                    
   