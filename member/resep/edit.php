<?php 
    require_once '../../config/init.php';
    $id = $_GET['edit'];
    $data = $db->readData('tbl_resep', 'id_resep', $id);

    $error_msg = '';
    $file_folder = '../../assets/images/resep/';
    if(Input::get('goEdit')){
        $file = $_FILES['file']['name'];
        $file_tmp = $_FILES['file']['tmp_name'];
        $file_error = $_FILES['file']['error'];
        $file_size = $_FILES['file']['size'];
        $file_type = $_FILES['file']['type'];
        $file_name = date('dmYHis').' - '.$file;
        $file_location = $file_folder.$file_name;
        $judul = addslashes(Input::get('judul_resep'));
        $deskripsi = addslashes(Input::get('deskripsi_resep'));
        $alat_bahan = addslashes(Input::get('alat_bahan'));
        $isi = addslashes(Input::get('isi_resep'));
        $kategori = addslashes(Input::get('kategori_resep'));

        if(Input::required($judul) && Input::required($deskripsi) && Input::required($alat_bahan) && Input::required($isi)){
            if($file_error == 0){
                if($file_size <= 3000000){
                    if($file_type = 'image/jpg' || $file_type = 'image/jpeg' || $file_type = 'image/png'){
                        if(move_uploaded_file($file_tmp, $file_location)){
                            if(file_exists($file_folder.$data->gambar_resep)){
                                unlink($file_folder.$data->gambar_resep);
                            }
                            $db->updateData('tbl_resep', array(
                                'gambar_resep' => $file_name,
                                'judul_resep' => $judul,
                                'deskripsi_resep' => $deskripsi,
                                'alat_bahan_resep' => $alat_bahan,
                                'isi_resep' => $isi,
                                'id_kategori_resep' => $kategori
                            ), 'id_resep', $id);
                            echo "<script>alert('Resep berhasil dibuat');</script>";
                            echo "<meta http-equiv='refresh' content='1 url=../resep/'>";
                        }
                    }else{
                        $error_msg = 'Format gambar yang didukung hanya JPG, JPEG, PNG';
                    }
                }else{
                    $error_msg = 'Ukuran gambar maksiml 3MB';
                }
            }else if($file_error == 1){
                $db->updateData('tbl_resep', array(
                    'judul_resep' => $judul,
                    'deskripsi_resep' => $deskripsi,
                    'alat_bahan_resep' => $alat_bahan,
                    'isi_resep' => $isi,
                    'id_kategori_resep' => $kategori
                ), 'id_resep', $id);
                echo "<script>alert('Resep berhasil diubah');</script>";
                echo "<meta http-equiv='refresh' content='1 url=../resep/'>";
            }else{
                $error_msg = 'Gambar tidak valid/error';
            }
        }else{
            $error_msg = 'Ups maaf, form harus diisi dengan benar, tidak boleh ada yang kosong';
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Ubah <?= $data->judul_resep; ?></title>
    <?php require_once '../../views/css.php'; ?>
</head>
<body>
<!-- Navbar -->
<?php require_once '../../views/navbar.php'; ?>

<!-- Content -->
<?php if($error_msg !=''): ?>
    <div class="alert alert-danger"><?= $error_msg; ?></div>
<?php endif; ?>
<div class="col-md-4">
    <form action="" method="post" enctype="multipart/form-data">
        <div class="form-group">
            <label><i class="fas fa-images"></i>&nbsp; Gambar Resep/Masakan:</label><br>
            <center>
                <label for="addPicture" class="col-md-12 add-picture-icon">
                    <i class="fas fa-upload fa-3x"></i><br>
                    <p>Upload File</p>
                    <img src="" id="imageDefault" alt="" style="width: 100%;">
                    <input type="file" class="form-control" id="addPicture" name="file">
                </label>
            </center>
        </div>
        <div class="form-group">
            <label><i class="fab fa-delicious"></i>&nbsp; Judul Resep:</label>
            <input type="text" class="form-control" placeholder="Masukkan Judul Resep..." name="judul_resep" value="<?= $data->judul_resep; ?>">
        </div>
        <div class="form-group">
            <label><i class="far fa-sticky-note"></i>&nbsp; Deskripsi Resep:</label>
            <textarea class="form-control" placeholder="Masukkan Deskripsi Resep..." name="deskripsi_resep"><?= $data->deskripsi_resep; ?></textarea>
        </div>
        <div class="form-group">
            <label><i class="far fa-sticky-note"></i>&nbsp; Alat dan Bahan:</label>
            <textarea class="form-control" placeholder="Masukkan Alat dan Bahan..." name="alat_bahan"><?= $data->alat_bahan_resep; ?></textarea>
        </div>
        <div class="form-group">
            <label><i class="far fa-sticky-note"></i>&nbsp; Isi Resep:</label>
            <textarea class="form-control" placeholder="Masukkan Resep Kamu..." name="isi_resep"><?= $data->isi_resep; ?></textarea>
        </div>
        <div class="form-group">
            <label><i class="far fa-paper-plane"></i>&nbsp; Kategori Resep:</label>
            <select name="kategori_resep" class="form-control">
                <?php $datas = $db->readData('tbl_kategori'); foreach($datas as $data): ?>
                <option value="<?= $data->id_kategori; ?>" class="form-control"><?= $data->nama_kategori; ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="form-group">
            <button type="submit" name="goEdit" class="btn btn-primary" value="Submit">Submit</button>
        </div>
    </form>
</div>
<?php require_once '../../views/js.php'; ?>
</body>
</html>