<?php 

require_once('../action/connection.php');
session_start();

if( empty($_SESSION) ){
    die('error');
}

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <?php include_once('../layout/_head.php')  ?>
    <link rel="stylesheet" href="../assets/siswa_ujian.css">
    <title>Ujian</title>
    

</head>

<body>
    <?php include_once('../layout/_navbar.php') ?>

    <div class="container">
        <div class="m-content">
            <h1>
                Hasil Ujian Siswa
            </h1>

            <div class="table-responsive">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nomor Induk Siswa</th>
                            <th>Nama</th>
                            <th>Module</th>
                            <th>Matpel</th>
                            <th>Tanggal Input</th>
                            <th>Nilai</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        
                        $qSelectHasilSiswa = " select siswa.nis,siswa.nama,modul.nama_module,matpel.matpel,hasil.tanggal_input,hasil.nilai 
                        from tb_hasil_ujian as hasil
                                                    inner join tb_modul_soal as modul
                                                    on hasil.id_module = modul.id_module
                                                    inner join tb_siswa as siswa
                                                    on hasil.nis = siswa.nis
                                                    inner join tb_mata_pelajaran as matpel
                                                    on modul.matpel = matpel.id_matpel                        
                        ";

                        $resHasilSiswa = mysqli_query($conn, $qSelectHasilSiswa);
                        ?>

                        <?php 
                            $no = 1;
                            while($row = mysqli_fetch_assoc($resHasilSiswa)){
                        ?>
                        <tr>
                            <td><?= $no++ ?></td>
                            <td><?= $row['nis'] ?></td>
                            <td><?= $row['nama'] ?></td>
                            <td><?= $row['nama_module'] ?></td>
                            <td><?= $row['matpel'] ?></td>
                            <td><?= $row['tanggal_input'] ?></td>
                            <td><?= round($row['nilai'],2) ?></td>
                            <td>
                                <button class="btn btn-primary">
                                    Action
                                </button>
                            </td>
                        </tr>

                        <?php } ?>
                    </tbody>
                </table>
            </div>

        </div>
    </div>

</body>