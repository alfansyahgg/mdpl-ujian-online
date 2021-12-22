<?php 

if($_SERVER['REQUEST_METHOD'] == "POST"){

    require_once('connection.php');
    session_start();
    $idModule = $_POST['id'];
    $namaModule = $_POST['nama'];
    $matpel = $_POST['matpel'];
    $waktu = $_POST['waktu'];

    $data = [
        'id' => $idModule,
        'nama' => $namaModule,
        'matpel' => $matpel,
        'waktu' => $waktu
    ];

    $qInsertModule = " INSERT INTO tb_modul_soal(id_module,nama_module,matpel,waktu)
        VALUES($idModule,'$namaModule','$matpel',$waktu)
    ";
    $exec = mysqli_query($conn, $qInsertModule);

    if($exec){
        $data['success'] = true;
        $data['msg'] = "Module Created";
    }else{
        $data['success'] = false;
        $data['msg'] = "Module Failed";
    }

    print_r(json_encode($data));


}else{
    die('error');
}



?>