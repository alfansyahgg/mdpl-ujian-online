<?php 

    require_once('./action/connection.php');
    session_start();

    if( empty($_SESSION) ){
        header("Location: ".$baseURL.'login.php');
        die('Login first!');
    }else{

        
        $role = $_SESSION['role'];
        $email = $_SESSION['email'];
        $user = $_SESSION['user_id'];

        if($role == 'siswa'){
            $qSiswa = " select * from tb_siswa  where user_id = $user";
            $resSiswa = mysqli_query($conn, $qSiswa);
            $resSiswa = mysqli_fetch_assoc($resSiswa);

            $nis = $resSiswa['nis'];

            $qGetUjian = " select id_module from tb_hasil_ujian where nis = $nis ";
            $resGetUjian = mysqli_query($conn,$qGetUjian);
            $jumlahUjian = mysqli_num_rows($resGetUjian);

            if( $jumlahUjian > 0){
                $sudahUjian = [];
                while( $dt = mysqli_fetch_assoc($resGetUjian) ){
                    // echo "<pre>";print_r($dt);exit();
                    array_push($sudahUjian, $dt['id_module']);
                }
                
                $strSudahUjian = "";
                for( $i = 0;$i<sizeof($sudahUjian);$i++ ){
                    $strSudahUjian .= "'".$sudahUjian[$i]."'";
                    $strSudahUjian .= ",";
                }
                $strSudahUjian = rtrim($strSudahUjian, ", ");
                $kondisiSudahUjian = "where modul.id_module not in (".$strSudahUjian.")";
            }else{
                $kondisiSudahUjian = '';
            }
        }
        
    }

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <?php  include('./layout/_head.php') ?>
    <link rel="stylesheet" href="./assets/style.css">
    <link rel="stylesheet" href="./assets/dashboard.css">
    <title>Dashboard</title>
</head>

<body>

    <?php include_once('./layout/_navbar.php') ?>

    <div class="content">
        <div class="sidebar bg-success">
            <ul>
                <li>
                    <a href="./"><i
                            class="fas fa-qrcode"></i>Dashboard</a>
                </li>
                <li>
                    <a
                        href="javascript:void(0)"><i
                            class="fas fa-user"></i>
                            <?=  $email ?>
                        </a>
                </li>

                <form id="logout-form" method="post" action="./action/logout.php" >
                    <input type="hidden" />
                </form>

                <li>
                    <a
                        onclick="event.preventDefault();document.getElementById('logout-form').submit() "
                        href="./action/logout.php">
                        <i class="fa fa-power-off" aria-hidden="true"></i>
                            Logout
                        </a>
                </li>
            </ul>
        </div>

        <div class="main-content">
            <?php if($role == "dosen"): ?>
            <div class="menu">
                <div class="menu-box <?=  $role == "siswa" ? 'box-ujian-siswa' : 'box-ujian' ?>">
                    <i class="fas fa-book-open fa-2x    "></i>
                    <p>
                        <?=  $role == "siswa" ? 'Ujian' : 'Buat Ujian' ?>
                    </p>
                </div>
                <div class="menu-box <?=  $role == "siswa" ? 'box-hasil-siswa' : 'box-hasil' ?>">
                    <i class="fas fa-file fa-2x    "></i>
                    <p>
                        <?=  $role == "siswa" ? 'Hasil Ujian Saya' : 'Hasil Ujian Siswa' ?>

                    </p>
                </div>
            </div>
            <?php endif; ?>


            <?php if($role == "siswa"): ?>
            <div class="jadwal">
                <h1>Jadwal</h1>
                <div class="table-responsive">
                    <table class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Mata Pelajaran</th>
                                <th>Waktu</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            $qSelectUjian = " select modul.*,matpel.matpel as nama_matpel from tb_modul_soal as modul
                            inner join tb_mata_pelajaran  as matpel
                            on modul.matpel = matpel.id_matpel
                            $kondisiSudahUjian
                            ";
                            $resUjian = mysqli_query($conn, $qSelectUjian);
                            while($row = mysqli_fetch_assoc($resUjian)){
                            ?>
                            <tr>
                                <td scope="row">1</td>
                                <td><?= $row['nama_matpel'] ?></td>
                                <td><?= $row['waktu'] ?> Menit</td>
                                <td>
                                    <a href="./pages/siswa_ujian.php?module=<?= $row['id_module'] ?>">Ikuti</a>
                                </td>
                            </tr>
                            <?php } ?>
                            <!-- <tr>
                                <td scope="row">2</td>
                                <td>Bahasa Indonesia</td>
                                <td>90 Menit</td>
                                <td>
                                    <a href="#">Ikuti</a>
                                </td>
                            </tr> -->
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="hasil">
                <h1>Hasil Ujian</h1>
                <div class="table-responsive">
                    <table class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Mata Pelajaran</th>
                                <th>Tanggal Ujian</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            $qSelectUjian = " select modul.*,hasil.tanggal_input,matpel.matpel as nama_matpel from tb_modul_soal as modul
                            inner join tb_mata_pelajaran  as matpel
                            on modul.matpel = matpel.id_matpel
                            inner join tb_hasil_ujian as hasil
                            on modul.id_module = hasil.id_module
                            ";
                            $resUjian = mysqli_query($conn, $qSelectUjian);
                            while($row = mysqli_fetch_assoc($resUjian)){
                            ?>
                            <tr>
                                <td scope="row">1</td>
                                <td><?= $row['nama_matpel'] ?></td>
                                <td><?= $row['tanggal_input'] ?></td>
                                <td>
                                    <a href="./pages/review_ujian.php?module=<?= $row['id_module'] ?>">Review</a>
                                </td>
                            </tr>
                            <?php } ?>
                            <!-- <tr>
                                <td scope="row">2</td>
                                <td>Bahasa Indonesia</td>
                                <td>90 Menit</td>
                                <td>
                                    <a href="#">Ikuti</a>
                                </td>
                            </tr> -->
                        </tbody>
                    </table>
                </div>
            </div>

            <?php endif; ?>

        </div>

    </div>







    <?php include_once('./layout/_script.php') ?>

    <script>
    $(document).ready(function() {

        $('.box-ujian-siswa').on('click', function() {
            window.location = './pages/siswa_ujian.php'
        })

        $('.box-hasil-siswa').on('click', function() {
            window.location = './pages/siswa_hasil.php'
        })

        $('.box-ujian').on('click', function() {
            window.location = './pages/dosen_soal.php'
        })

        $('.box-hasil').on('click', function() {
            window.location = './pages/dosen_hasil.php'
        })

    })
    </script>

</body>

</html>