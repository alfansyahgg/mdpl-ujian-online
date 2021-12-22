<?php 

require_once('../action/connection.php');
session_start();

if( empty($_SESSION) ){
    die('error');
}

$idModule = rand(1, 99999);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <?php include_once('../layout/_head.php')  ?>
    <link rel="stylesheet" href="../assets/dosen_soal.css">
    <title>Buat Ujian</title>

    <style>
    .navbar {
        display: flex;
    }
    </style>
</head>

<body>
    <?php include_once('../layout/_navbar.php') ?>

    <div class="container">
        <div class="card mt-3">
            <div class="card-header text-white bg-success">
                Module #<?= $idModule ?>
            </div>
            <input type="hidden" value="<?= $idModule ?>" id="id-module" class="d-none">

            </input>
            <div class="card-body">
                <form id="formModule" action="../action/create_module.php" method="post">
                    <div class="form-group">
                        <label for="">Nama Ujian</label>
                        <input type="text" name="nama" class="form-control" id="">
                    </div>
                    <div class="form-group">
                        <label for="">Mata Pelajaran</label>
                        <select name="matpel" class="form-control">

                            <?php                             
                            $qMatpel = mysqli_query($conn, " select * from tb_mata_pelajaran ");
                            while($row = mysqli_fetch_array($qMatpel)){ ?>
                            <option value="<?= $row['id_matpel'] ?>">
                                <?= $row['matpel'] ?>
                            </option>
                            <?php } ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="">Waktu Ujian</label>
                        <input type="number" name="waktu" class="form-control" id="">
                    </div>

                    <button class="btn btn-primary btn-modul">
                        <i class="fa fa-check" aria-hidden="true"></i>
                        Buat Modul
                    </button>

                </form>
            </div>
        </div>

        <div class="wrapper-soal d-none">
            <div class="card mt-3 div-soal">
                <div class="card-header header-soal text-white bg-success">
                    Soal
                </div>
                <div class="card-body">
                    <form id="formSoal" method="post">
                        <input type="hidden" value="<?= $idModule ?>" />
                        <div class="form-group soal">
                            <label class="order" for=""> Soal </label>
                            <textarea name="soal" class="form-control"></textarea>
                            <label for=""> Opsi </label>
                            <input name="opsi[]" type="text" placeholder="Opsi A" class="form-control" value="">
                            <input name="opsi[]" type="text" placeholder="Opsi B" class="form-control mt-1" value="">
                            <input name="opsi[]" type="text" placeholder="Opsi C" class="form-control mt-1" value="">
                            <label class="mt-2"> Jawaban </label>
                            <select name="jawaban" class="form-control">
                                <option value="A">Opsi A</option>
                                <option value="B">Opsi B</option>
                                <option value="C">Opsi C</option>
                            </select>
                            <!-- <div class="form-group" style="padding-bottom: 15px;"> -->

                            <!-- </div> -->
                        </div>




                    </form>
                </div>
            </div>

        </div>                        
        

        <div class="card mt-3 tombol d-none">
            <div class="card-body">
                <button type="button" class="btn btn-info btn-submit-soal">
                    Submit Soal
                </button>
                <button type="button" class="btn btn-success" id="tambahSoal">
                    Tambah Soal
                </button>
                <button class="btn btn-warning btn-submit-ujian">
                    Submit Ujian
                </button>
            </div>
        </div>

    </div>

    <?php include_once('../layout/_script.php')  ?>
    <script>
    $(document).ready(function() {

        const soalLength = $(" .soal ").length

        $(".header-soal").text("Soal " + soalLength)

        const addSoal = () => {
            let no = 1
            no++
            const formSoal = document.querySelector("#formSoal")
            const bodySoal = document.querySelector(".div-soal")

            $(".div-soal").last().after(bodySoal.outerHTML)

        }

        $("#tambahSoal").on('click', function(e) {
            e.preventDefault()
            addSoal()
            const soalLength = $(" .soal ").length
            $(".header-soal").last().text("Soal " + soalLength)
        })

        $('.btn-modul').on('click', function(e) {
            e.preventDefault()
            const idModule = $("#id-module").val()
            const namaModule = $("input[name='nama']").val()
            const matpel = $("select[name='matpel']").val()
            const waktu = $("input[name='waktu']").val()

            const dataModule = {
                id: idModule,
                nama: namaModule,
                matpel: matpel,
                waktu: waktu
            }

            $.ajax({
                url: '../action/create_module.php',
                type: 'POST',
                data: dataModule,
                dataType: 'json',
                success: function(res) {
                    console.log(res)
                    if (res.success) {
                        setTimeout(() => {                      
                            alert(res.msg)      
                            $(".wrapper-soal").removeClass('d-none')
                            $(".tombol").removeClass('d-none')
                        }, 1000);
                    }
                }
            })

        })

        $(".btn-submit-soal").on('click', function(e) {
            e.preventDefault()

            const idModule = $("#id-module").last().val()
            const soal = $("textarea[name='soal']").last().val()
            const jawaban = $("select[name='jawaban']").last().val()

            const opsi = $("input[name='opsi[]']").slice(-3).map(function() {
                return this.value;
            }).get();

            let dataSoal = {
                id: idModule,
                soal: soal,
                jawaban: jawaban,
                'opsi[]': opsi
            }

            // console.log(dataSoal);

            $.ajax({
                url: '../action/create_soal.php',
                type: 'POST',
                data: dataSoal,
                dataType: 'json',
                success: function(res) {
                    if (res.success) {
                        dataSoal = {

                        }
                        alert(res.msg)
                        // addSoal()
                    }
                }
            })
        })

        $(".btn-submit-ujian").on('click', function(){
            window.location = '<?= $baseURL ?>'
        })


    })
    </script>

</body>

</html>