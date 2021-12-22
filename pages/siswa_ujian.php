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
        <div id="main-content" class="main">
            <div id="content" class="content">
            <?php 
                $qSelectModule = " select *,matpel.matpel as nama_matpel from tb_modul_soal as modul
                inner join tb_mata_pelajaran  as matpel
                on modul.matpel = matpel.id_matpel  
                where modul.id_module = $module
                ";
                $resModule = mysqli_query($conn, $qSelectModule);
                $resModule = mysqli_fetch_assoc($resModule);
            ?>
            <h1><?= $resModule['nama_module'].' - '.$resModule['nama_matpel'] ?></h1>
            <h5>Waktu : <?= $resModule['waktu'] ?> Menit</h5>
            <form class="formUjian" method="post" action="../action/submit_ujian.php" >
            <input type="hidden" name="id_module" value="<?= $module ?>">
                <?php 
                
                $qSelectSoal = "
                    select * from tb_soal where id_module = $module
                ";
                $resSoal = mysqli_query($conn, $qSelectSoal);
                ?>

                <?php 
                $no = 1;
                    while($row = mysqli_fetch_assoc($resSoal)){
                        $pilihan = explode(',',$row['pilihan']);
                ?>
                <div class="card" id="soal<?= $row['id_soal'] ?>">
                    <div class="card-header bg-primary text-white">
                        Soal <?= $no++ ?>
                    </div>
                    <div class="card-body">
                        <div class="title-soal">
                            <?= $row['soal'] ?>
                        </div>
                        <div class="opsi-soal">

                                
                                <fieldset id="soal<?= $row['id_soal'] ?>">
                                <?php foreach($pilihan as $key => $pil): ?>
                                <div class="form-check">
                                    <input class="form-check-input i-jawaban" type="radio" name="soal<?= $row['id_soal'] ?>"
                                        value="
                                        <?php                                                  
                                        switch ($key) {
                                            case 0:
                                                echo 'A';
                                                break;
                                            case 1:
                                                echo 'B';
                                                break;
                                            case 2:
                                                echo 'C';
                                                break;                                     
                                            default:
                                                echo 'D';
                                                break;
                                        }
                                        ?>
                                        ">
                                    <label class="form-check-label">
                                        <?php                                                  
                                        switch ($key) {
                                            case 0:
                                                echo 'A. ';
                                                break;
                                            case 1:
                                                echo 'B. ';
                                                break;
                                            case 2:
                                                echo 'C. ';
                                                break;                                     
                                            default:
                                                # code...
                                                break;
                                        }
                                        echo $pil;
                                        ?>
                                    </label>
                                </div>
                                <?php endforeach; ?>
                                </fieldset>
                            

                        </div>
                    </div>
                </div>
                <?php } ?>
                
                
            <div class="card">
                <div class="card-body">
                    <button type="button" class="btn btn-success btn-submit-ujian">
                        Submit Ujian
                    </button>
                </div>
            </div>

            </form>
            </div>
            <div id="sidebar" class="sidebars">
                <div class="sidebar__inner">
                    <div class="box-angka">
                        <?php 
                        $qSelectSoal = "
                            select * from tb_soal where id_module = $module
                        ";
                        $resSoal = mysqli_query($conn, $qSelectSoal);
                        $no = 1;
                        while($row = mysqli_fetch_assoc($resSoal)){
                        ?>
                        <div class="angka">
                            <a href="#soal<?= $row['id_soal'] ?>"><?= $no++ ?></a>
                        </div>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php include_once('../layout/_script.php')  ?>
    <script src="../assets/sticky-sidebar.js"></script>

    <script>
        $(document).ready(function(res){
            var sidebar = new StickySidebar('#sidebar', {
                containerSelector: '#main-content',
                innerWrapperSelector: '.sidebar__inner',
                topSpacing: 20,
                bottomSpacing: 20
            });

            $(".btn-submit-ujian").on('click', function(e){
                e.preventDefault()

                const idModule = $("input[name='id_module']").val()
                const jawaban = $(".formUjian input[type='radio'].i-jawaban:checked").map(function(){
                    return this.value.trim();
                }).get()
                // console.log(jawaban);

                let dataJawaban = {
                    idModule: idModule,
                    'jawaban[]': jawaban
                }

                $.ajax({
                    url: '../action/submit_ujian.php',
                    type: 'POST',
                    data: dataJawaban,
                    dataType: 'json',
                    success: function(res){
                        console.log(res);
                        if( res.success ){
                            window.location = '<?= $baseURL ?>'
                        }
                    }
                })

            })
            

        })
    </script>

</body>

</html>