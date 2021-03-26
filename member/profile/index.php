<?php 
    require_once '../../config/init.php';
    if(Session::exists('member') || Session::exists('admin')){
        $member = Session::name('member');
        // print_r($member); die();
        $profile = $db->readData('tbl_users', 'email_user', $member);
        // print_r($profile); die();
    }else{
        Redirect::to($url);
    }

    // echo $profile->id_user;
    // // die();

    $error_msg = '';
    $file_folder = '../../assets/images/profile-users/';
    if(Input::get('goEdit')){
        $file = $_FILES['file']['name'];
        $file_tmp = $_FILES['file']['tmp_name'];
        $file_error = $_FILES['file']['error'];
        $file_size = $_FILES['file']['size'];
        $file_type = $_FILES['file']['type'];
        $file_name = date('dmYHis').' - '.$file;
        $file_location = $file_folder.$file_name;
        $email = addslashes(Input::get('email'));
        $nama_lengkap = addslashes(Input::get('nama_lengkap'));
        $deskripsi = addslashes(Input::get('deskripsi'));

        // if(Input::required($email) && Input::required($nama_lengkap) && Input::required($deskripsi)){
            if($file_error == 0){
                if($file_size <= 3000000){
                    if($file_type = 'image/jpg' || $file_type = 'image/jpeg' || $file_type = 'image/png'){
                        if(move_uploaded_file($file_tmp, $file_location)){
                            if(file_exists($file_folder.$profile->foto_profile_user)){
                                unlink($file_folder.$profile->foto_profile_user);
                            }
                            $db->updateData('tbl_users', array(
                                // 'email_user' => $email,
                                'nama_user' => $nama_lengkap,
                                'foto_profile_user' => $file_name,
                                'deskripsi_user' => $deskripsi
                            ), 'id_user', $profile->id_user);
                            echo "<script>alert('Profil berhasil diubah');</script>";
                            echo "<meta http-equiv='refresh' content='1 url=../profile/'>";
                        }
                    }else{
                        $error_msg = 'Format gambar yang didukung hanya JPG, JPEG, PNG';
                    }
                }else{
                    $error_msg = 'Ukuran gambar maksiml 3MB';
                }
            }else if($file_error == 1){
                $db->updateData('tbl_users', array(
                    // 'email_user' => $email,
                    'nama_user' => $nama_lengkap,
                    'deskripsi_user' => $deskripsi
                ), 'id_user', $profile->id_user);
                echo "<script>alert('Resep berhasil dibuat');</script>";
                echo "<meta http-equiv='refresh' content='1 url=../resep/'>";
            }else{
                $error_msg = 'Gambar tidak valid/error';
            }
        // }else{
        //     $error_msg = 'Ups maaf, form harus diisi dengan benar, tidak boleh ada yang kosong';
        // }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title><?= $profile->nama_user; ?></title>
    <?php require_once '../../views/css.php'; ?>
</head>
<body>
<!-- Navbar -->
<?php require_once '../../views/navbar.php'; ?>

<div class="col-md-4 form-inner form-inner-profile">
    <p class="form-heading"><i class="fas fa-cog"></i>&nbsp; Edit Profil <b>SCOAPP</b></p>
    <div class="form-line-heading"></div>
    <?php if($error_msg !=''): ?>
        <div class="alert alert-danger"><?= $error_msg; ?></div>
    <?php endif; ?>
    <form action="<?= $_SERVER['PHP_SELF']; ?>" method="post" enctype="multipart/form-data">
        <div class="form-group">
            <label><i class="fas fa-images"></i>&nbsp; Foto Profil:</label><br>
            <label for="addPicture" class="add-profile-picture">
                <img src="../../assets/images/upload-image.png" id="imageDefault" alt="Upload Icon">
                <input type="file" id="addPicture" name="file">
            </label>
        </div>
        <div class="form-group">
            <label for=""><i class="fas fa-envelope"></i>&nbsp; Alamat Email:</label>
            <input type="email" class="form-control disabled-form" placeholder="Masukkan Alamat Email..." value="<?= $profile->email_user; ?>" name="email" disabled>
        </div>
        <div class="form-group">
            <label for=""><i class="fas fa-user"></i>&nbsp; Nama Lengkap:</label>
            <input type="text" class="form-control" placeholder="Masukkan Nama Lengkap..." value="<?= $profile->nama_user; ?>" name="nama_lengkap">
        </div>
        <div class="form-group">
            <label for=""><i class="far fa-sticky-note"></i>&nbsp; Deskripsi Singkat:</label>
            <textarea class="form-control" placeholder="Masukkan Deskripsi Singkat Anda" name="deskripsi"><?= $profile->deskripsi_user; ?></textarea>
        </div>
        <button type="submit" name="goEdit" class="btn" value="Submit">Submit</button>
    </form>
</div>


<?php require_once '../../views/js.php'; ?>
</body>
</html>