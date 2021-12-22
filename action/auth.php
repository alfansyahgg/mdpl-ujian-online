<?php 

if( $_SERVER['REQUEST_METHOD'] == "POST" ){
    
    require_once('connection.php');
    session_start();

    $email      = $_POST['email'];
    $password   = $_POST['password'];

    $qLogin     = " select * from users where email = '$email' ";
    $qExec      = mysqli_query( $conn, $qLogin ) or die( mysqli_error($conn) );

    $qData      = mysqli_fetch_assoc( $qExec );

    if( isset($qData) ){

        $md5Password = md5($password);

        if( $qData['password'] == $md5Password ){
            $_SESSION['user_id'] = $qData['user_id'];
            $_SESSION['email']  = $qData['email'];
            $_SESSION['role']   = $qData['role'];

            $response = [
                'success' => true,
                'msg' => 'Login Sukses'
            ];

        }else{

            $response = [
                'success' => false,
                'msg' => 'Wrong Password!'
            ];
            
        }

    }else{
        
        $response = [
            'success' => false,
            'msg' => 'Email not found'
        ];

    }

    // echo "<pre>";var_dump($qData);exit();
    


}else{

    $response = [
        'success' => false,
        'msg' => 'Only POST is Allowed',
    ];

}

echo json_encode($response);







?>