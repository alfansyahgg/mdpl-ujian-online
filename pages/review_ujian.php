<?php 

require_once('../action/connection.php');
session_start();

if( empty($_SESSION) ){
    die('error');
}

$module = $_GET['module'];

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
        <div class="main-content">

            <?php 
            
            $qSelectModule = "select modul.*,hasil.nilai,hasil.tanggal_input,matpel.matpel as nama_matpel from tb_modul_soal as modul
            inner join tb_mata_pelajaran  as matpel
            on modul.matpel = matpel.id_matpel
            inner join tb_hasil_ujian as hasil
            on modul.id_module = hasil.id_module";

            $resModule = mysqli_query($conn, $qSelectModule);
            $resModule = mysqli_fetch_assoc($resModule);
            
            ?>
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <?= $resModule['nama_module'].' - '.$resModule['nama_matpel'] ?>
                </div>
                <div class="card-body">
                    Nilai : <?= round($resModule['nilai']) ?> <br>
                    Tanggal Ujian : <?= $resModule['tanggal_input'] ?>
                </div>
            </div>

            <div class="table-responsive mt-5">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>No Soal</th>
                            <th>Soal</th>
                            <th>Jawaban</th>
                            <th>Jawaban Anda</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 

                        $qSelectHasil = "
                            select * from tb_hasil_ujian where id_module = $module
                        ";

                        $resHasilUjian = mysqli_query($conn,$qSelectHasil);
                        $resHasilUjian = mysqli_fetch_assoc($resHasilUjian);
                        $jawabanHasil = explode(',',$resHasilUjian['jawaban']);

                        $qSelectSoal = "
                            select * from tb_soal where id_module = $module
                        ";
                        $resSoal = mysqli_query($conn, $qSelectSoal);
                        ?>

                        <?php 
                        $no = 1;
                        $content = [];
                            while($row = mysqli_fetch_assoc($resSoal)){
                                $content[] = $row;
                            }
                            foreach ($content as $key => $item) {
                                $item['jawaban_anda'] = $jawabanHasil[$key];
                            
                        ?>
                        <tr>
                            <td><?= $no++ ?></td>
                            <td>
                                <?= $item['soal'] ?>
                            </td>
                            <td>
                                <?= $item['jawaban'] ?>
                            </td>
                            <td>
                                <?= $item['jawaban_anda'] ?>
                            </td>
                        </tr>
                        <?php // foreach(){?>
                        <?php  } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</body>