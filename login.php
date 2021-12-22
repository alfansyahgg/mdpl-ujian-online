<?php

require_once('./action/connection.php');
session_start();
// print_r($_SESSION);exit();

if(!empty($_SESSION)){
    header("Location: ".$baseURL);
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <?php  include('./layout/_head.php') ?>
    <link rel="stylesheet" href="./assets/login.css">
    <link rel="stylesheet" href="./assets/style.css">  
    <title> Login </title>
</head>

<body>

    <div class="wrapper">
        <div class="box">
            <h1 class="text-center"> Ujian Online </h1>

            <form class="login mt-3 px-3 h-100" method="post" action="./action/auth.php">
                <div class="alert alert-danger alert-error d-none" role="alert">
                    
                </div>
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text">
                            Email &nbsp; &nbsp; &nbsp;
                        </span>
                    </div>
                    <input name="email" type="text" class="form-control">
                </div>

                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text">
                            Password
                        </span>
                    </div>
                    <input name="password" type="password" class="form-control">
                </div>

                <div class="form-group">
                    <button type="submit" class="btn btn-success btn-block btn-login">
                        Login
                    </button>
                </div>

            </form>

        </div>
    </div>

    <?php include_once('./layout/_script.php') ?>

    <script>
    $(document).ready(function() {

        $('form.login').on('submit', function(e) {
            event.preventDefault();

            const data = $(this).serialize()

            $.ajax({
                url: './action/auth.php',
                type: 'POST',
                data: data,
                dataType: 'json',
                success: function(res) {
                    if( res.success ){
                        window.location = './index.php'
                    }else{
                        $('.alert-error').text( res.msg )
                        $('.alert-error').removeClass( 'd-none' )
                    }
                },
                error: function(res) {
                    alert('Error')
                }
            })


        })

    })
    </script>

</body>

</html>