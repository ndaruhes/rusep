<?php
    require_once '../config/init.php';

    if(Session::exists('admin') || Session::exists('member')){
        Redirect::to('../');
    }
    
    $error = '';
    if(Input::get('goRegister')){
        $email = addslashes(Input::get('email'));
        $nama = addslashes(Input::get('nama_lengkap'));
        $password = addslashes(Input::get('password'));
        $retype_password = addslashes(Input::get('retype_password'));

        if(Input::required($email) && Input::required($nama) && Input::required($password) && Input::required($retype_password)){
            if($password === $retype_password){
                $cekEmail = $db->checkData('tbl_users', 'email_user', $email);
                if($cekEmail == ''){
                    $db->insertData('tbl_users', array(
                        'email_user' => $email,
                        'password_user' => password_hash($password, PASSWORD_DEFAULT),
                        'nama_user' => $nama
                    ));
                    echo "<script>alert('Akun berhasil dibuat');</script>";
                    echo "<meta http-equiv='refresh' content='1 url=login.php'>";
                }else{
                    $error = 'Email <b>'.$email.' </b>sudah terdaftar, silahkan login';
                }
            }else{
                $error = 'Ups maaf, kata sandi harus sama';
            }
        }else{
            $error = 'Ups maaf, form harus diisi dengan benar, tidak boleh ada yang kosong';
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Register</title>
    <?php require_once '../views/css.php'; ?>
    <style>
        body{
            background: #f2f2f2;
        }
    </style>
</head>
<body>
    <div class="col-md-3 form-inner">
    <p class="form-heading">Buat Akun <b>SCOAPP</b></p>
    <div class="form-line-heading"></div>
    <p class="form-caption-option">Masuk <a href="login.php">disini</a> jika sudah punya akun!</p>
    <?php if($error !=''): ?>
        <div class="alert alert-danger"><?= $error; ?></div>
    <?php endif; ?>
        <form action="<?= $_SERVER['PHP_SELF']; ?>" method="post">
            <div class="form-group">
                <label><i class="fas fa-envelope"></i>&nbsp; Email:</label>
                <input type="email" class="form-control" placeholder="Masukkan Alamat Email..." name="email">
            </div>
            <div class="form-group">
                <label><i class="fas fa-user"></i>&nbsp; Nama Lengkap:</label>
                <input type="text" class="form-control" placeholder="Masukkan Nama Lengkap..." name="nama_lengkap">
            </div>
            <div class="form-group">
                <label><i class="fas fa-key"></i>&nbsp;  Password:</label>
                <input type="password" class="form-control" placeholder="Masukkan Kata Sandi..." name="password">
            </div>
            <div class="form-group">
                <label><i class="fas fa-key"></i>&nbsp;  Ketik Ulang Password:</label>
                <input type="password" class="form-control" placeholder="Masukkan Ulang Kata Sandi..." name="retype_password">
            </div>
            <input type="hidden" name="goRegister" value="Submit">
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>

    <?php require_once '../views/js.php'; ?>
</body>
</html>