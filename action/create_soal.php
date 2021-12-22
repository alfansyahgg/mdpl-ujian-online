<?php 

if($_SERVER['REQUEST_METHOD'] == "POST"){

    require_once('connection.php');
    session_start();
    $idModule = $_POST['id'];
    $idUser = $_SESSION['user_id'];
    $soal = $_POST['soal'];
    $jawaban = $_POST['jawaban'];
    $opsis = $_POST['opsi'];

    $opsis = implode(',',$opsis);

    // $data = [
    //     'id' => $idModule,
    //     'user' => $idUser,
    //     'soal' => $soal,
    //     'jawaban' => $jawaban,
    //     'opsi' => $opsis
    // ];

    $qInsertSoal = " INSERT INTO tb_soal(id_module,id_user,soal,jawaban,pilihan)
        VALUES($idModule,$idUser,'$soal','$jawaban','$opsis')
     ";
    $exec = mysqli_query($conn, $qInsertSoal);

     if($exec){
         $data['success'] = true;
         $data['msg'] = "Soal Created";
     }else{
         $data['success'] = false;
         $data['msg'] = "Soal Failed";
     }

    echo json_encode($data);
    
    // echo "<pre>";print_r($opsis);
    

}else{
    die('error');
}



?>