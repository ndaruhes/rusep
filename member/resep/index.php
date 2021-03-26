<?php
require_once '../../config/init.php';
$member = Session::name('member');
$data = $db->readData('tbl_users', 'email_user', $member);
$error_msg = '';
if (Input::get('goAdd')) {
    $file = $_FILES['file']['name'];
    $file_tmp = $_FILES['file']['tmp_name'];
    $file_error = $_FILES['file']['error'];
    $file_size = $_FILES['file']['size'];
    $file_type = $_FILES['file']['type'];
    $file_name = date('dmYHis') . ' - ' . $file;
    $file_location = '../../assets/images/resep/' . $file_name;
    $judul = addslashes(Input::get('judul_resep'));
    $deskripsi = addslashes(Input::get('deskripsi_resep'));
    $alat_bahan = addslashes(Input::get('alat_bahan'));
    $isi = addslashes(Input::get('isi_resep'));
    $kategori = addslashes(Input::get('kategori_resep'));

    // if(Input::required($judul) && Input::get($deskripsi) && Input::required($alat_bahan) && Input::required($isi)){
    if ($file_error == 0) {
        if ($file_size <= 3000000) {
            if ($file_type = 'image/jpg' || $file_type = 'image/jpeg' || $file_type = 'image/png') {
                if (move_uploaded_file($file_tmp, $file_location)) {
                    $db->insertData('tbl_resep', array(
                        'gambar_resep' => $file_name,
                        'judul_resep' => $judul,
                        'deskripsi_resep' => $deskripsi,
                        'alat_bahan_resep' => $alat_bahan,
                        'isi_resep' => $isi,
                        'id_kategori_resep' => $kategori,
                        'id_user_resep' => $data->id_user
                    ));
                    echo "<script>alert('Resep berhasil dibuat');</script>";
                    echo "<meta http-equiv='refresh' content='1 url=../resep/'>";
                }
            } else {
                $error_msg = 'Format gambar yang didukung hanya JPG, JPEG, PNG';
            }
        } else {
            $error_msg = 'Ukuran gambar maksiml 3MB';
        }
    } else {
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
    <title>Daftar Resep</title>
    <?php require_once '../../views/css.php'; ?>
</head>

<body>
    <!-- Navbar -->
    <?php require_once '../../views/navbar.php'; ?>

    <!-- Daftar Resep -->
    <?php if ($error_msg != '') : ?>
        <div class="alert alert-danger"><?= $error_msg; ?></div>
    <?php endif; ?>
    <div class="col-md-11 table-inner">
        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addData">
            Buat Resep Baru
        </button>
        <br><br>
        <table class="table table-striped">
            <thead class="thead-dark">
                <tr>
                    <th>No</th>
                    <th>Gambar Resep</th>
                    <th>Judul Resep</th>
                    <th>Deskripsi Resep</th>
                    <th>Alat dan Bahan Resep</th>
                    <th>Isi Resep</th>
                    <th>Kategori Resep</th>
                    <th colspan="2">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php $no = 1;
                $datas = $db->readJoinData('tbl_resep', 'tbl_kategori', 'id_kategori_resep', 'id_kategori', 'id_user_resep', $data->id_user);
                foreach ($datas as $data) : ?>
                    <tr>
                        <td><?= $no++; ?></td>
                        <td class="tbl-img"><img src="<?= '../../assets/images/resep/' . $data->gambar_resep; ?>" alt="<?= $data->judul_resep; ?>"></td>
                        <td><?= $data->judul_resep; ?></td>
                        <td class="tbl-description"><?= Show::excerpt($data->deskripsi_resep); ?></td>
                        <td><?= $data->alat_bahan_resep; ?></td>
                        <td><?= Show::excerpt($data->isi_resep); ?></td>
                        <td><?= $data->nama_kategori; ?></td>
                        <td>
                            <a href="edit.php?edit=<?= $data->id_resep; ?>" class="badge badge-primary"><i class="fas fa-pencil-alt"></i></a>
                            <a href="delete.php?delete=<?= $data->id_resep; ?>" class="badge badge-danger" onclick="return confirm('Anda Yakin Ingin Menghapus?')"><i class="fas fa-trash-alt"></i></a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>


    <!-- Modal -->
    <div class="modal fade" id="addData" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel"><i class="fas fa-plus"></i>&nbsp; Buat Resep </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="<?= $_SERVER['PHP_SELF']; ?>" method="post" enctype="multipart/form-data">
                        <div class="form-group">
                            <label><i class="fas fa-images"></i>&nbsp; Gambar Resep/Masakan:</label><br>
                            <center>
                                <label for="addPicture" class="col-md-12 add-picture-icon">
                                    <img src="../../assets/images/upload-image.png" id="imageDefault" alt="Upload Icon">
                                    <input type="file" class="form-control" id="addPicture" name="file">
                                </label>
                            </center>
                        </div>
                        <div class="form-group">
                            <label><i class="fab fa-delicious"></i>&nbsp; Judul Resep:</label>
                            <input type="text" class="form-control" placeholder="Masukkan Judul Resep..." name="judul_resep">
                        </div>
                        <div class="form-group">
                            <label><i class="far fa-sticky-note"></i>&nbsp; Deskripsi Resep:</label>
                            <textarea class="form-control" placeholder="Masukkan Deskripsi Resep..." name="deskripsi_resep"></textarea>
                        </div>
                        <div class="form-group">
                            <label><i class="far fa-sticky-note"></i>&nbsp; Alat dan Bahan:</label>
                            <textarea class="form-control" placeholder="Masukkan Alat dan Bahan..." name="alat_bahan"></textarea>
                        </div>
                        <div class="form-group">
                            <label><i class="far fa-sticky-note"></i>&nbsp; Isi Resep:</label>
                            <textarea class="form-control" placeholder="Masukkan Resep Kamu..." name="isi_resep"></textarea>
                        </div>
                        <div class="form-group">
                            <label><i class="far fa-paper-plane"></i>&nbsp; Kategori Resep:</label>
                            <select name="kategori_resep" class="form-control">
                                <?php $datas = $db->readData('tbl_kategori');
                                foreach ($datas as $data) : ?>
                                    <option value="<?= $data->id_kategori; ?>" class="form-control"><?= $data->nama_kategori; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <button type="submit" name="goAdd" class="btn btn-primary" value="Submit">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <?php require_once '../../views/js.php'; ?>
</body>

</html>