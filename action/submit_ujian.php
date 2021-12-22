<?php 

if($_SERVER['REQUEST_METHOD'] == "POST"){

    require_once('connection.php');
    session_start();
    date_default_timezone_set("Asia/Jakarta");
    $module = $_POST['idModule'];
    $user = $_SESSION['user_id'];
    $jawabans = $_POST['jawaban'];

    $qSiswa = " select * from tb_siswa  where user_id = $user";
    $resSiswa = mysqli_query($conn, $qSiswa);
    $resSiswa = mysqli_fetch_assoc($resSiswa);

    $nis = $resSiswa['nis'];
    $tanggal = date("Y-m-d", time());

    $qModule = " select * from tb_modul_soal as module inner join tb_soal as soal
                on module.id_module = soal.id_module
                where module.id_module = $module
    ";

    $resModule = mysqli_query($conn, $qModule);
    $jmlSoal = mysqli_num_rows($resModule);

    $correctAnswer = [];
    while( $dt = mysqli_fetch_assoc($resModule) ){
        array_push($correctAnswer, $dt['jawaban']);
    }

    $nilai = 0;
    $benar = 0;
    for ($i=0; $i < sizeof($correctAnswer); $i++) { 
        if( $jawabans[$i] == $correctAnswer[$i] ){
            $benar++;
        }
    }

    $nilai = ( $benar / $jmlSoal ) * 100;

    $svJawabans = implode(',',$jawabans);

    $qInsertHasilUjian = "
        insert into tb_hasil_ujian(id_module,nis,nilai,jawaban,tanggal_input)
        values($module, $nis, $nilai,'$svJawabans', '$tanggal')
    ";

    $execInsert = mysqli_query($conn, $qInsertHasilUjian);

    if($execInsert){
        $data['success'] = true;
        $data['msg'] = "Hasil Inserted";
    }else{
        $data['success'] = false;
        $data['msg'] = mysqli_error($conn);
    }

    // echo "<pre>";
    // print_r($tanggal);
    // print_r(sizeof($jawabans));
    print_r(json_encode($data));
    // exit();

}else{
    die('Error');
}

?>