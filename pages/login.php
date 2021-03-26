<?php
require_once '../config/init.php';

if (Session::exists('admin') || Session::exists('member')) {
    Redirect::to('../');
}

$error = '';
if (Input::get('goLogin')) {
    $email = addslashes(Input::get('email'));
    $password = addslashes(Input::get('password'));

    if (Input::required($email) && Input::required($password)) {
        $cek_email = $db->checkData('tbl_users', 'email_user', $email);
        if ($cek_email != '') {
            $data = $db->readData('tbl_users', 'email_user', $email);
            if (password_verify($password, $data->password_user)) {
                if ($data->level_user === 'Admin') {
                    Session::set('admin', $email);
                    Redirect::to('../admin/');
                } else if ($data->level_user == 'Member') {
                    Session::set('member', $email);
                    Redirect::to('../');
                }
            } else {
                $error = 'Kombinasi email dan password tidak sesuai';
            }
        } else {
            $error = 'Daftar Dulu Sebelum Login';
        }
    } else {
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
    <title>Login - Ndaru Project</title>
    <?php require_once '../views/css.php'; ?>
    <style>
        body {
            background: #f2f2f2;
        }
    </style>
</head>

<body>
    <div class="col-md-3 form-inner">
        <p class="form-heading">Login <b>SCOAPP</b></p>
        <div class="form-line-heading"></div>
        <p class="form-caption-option">Belum punya akun? <a href="register.php">Daftar disini</a></p>
        <?php if ($error != '') : ?>
            <div class="alert alert-danger"><?= $error; ?></div>
        <?php endif; ?>
        <form action="<?= $_SERVER['PHP_SELF']; ?>" method="post">
            <div class="form-group">
                <label><i class="fas fa-envelope"></i>&nbsp; Email:</label>
                <input type="email" class="form-control" placeholder="Masukkan Alamat Email..." name="email">
            </div>
            <div class="form-group">
                <label><i class="fas fa-key"></i>&nbsp; Password:</label>
                <input type="password" class="form-control" placeholder="Masukkan Kata Sandi..." name="password">
            </div>
            <!-- <input type="hidden" > -->
            <button type="submit" class="btn" name="goLogin" value="Submit">Submit</button>
        </form>
    </div>

    <?php require_once '../views/js.php'; ?>
</body>

</html>