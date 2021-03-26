<?php
    require_once '../config/init.php';

    $error = '';
    if(Input::get('goAdd')){
        $file = $_FILES[''];
        $nama = addslashes(Input::get('nama_produk'));
        $harga = addslashes(Input::get('harga_produk'));
        $deskripsi = addslashes(Input::get('deskripsi_produk'));
        $kategori = addslashes(Input::get('kategori_produk'));

        if(Input::required($nama) && Input::get($harga) && Input::get($deskripsi) && Input::get($kategori)){

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
    <title>Selamat Datang Admin - Ndaru Project</title>
    <?php require_once '../views/css.php'; ?>
</head>
<body>
    <!-- Navbar -->
    <?php require_once '../views/navbar.php'; ?>

    <!-- Table -->
    <div class="col-md-10 table-inner">
        <button class="btn btn-primary" data-toggle="modal" data-target="#inputForm"><i class="fas fa-plus"></i>&nbsp; Tambah Produk</button>
        <br><br>
        <?php if($error !=''): ?>
            <div class="alert alert-danger"><?= $error; ?></div>
        <?php endif; ?>
        <table class="table">
            <thead class="thead-dark">
                <tr>
                    <th>#</th>
                    <th>Gambar Produk</th>
                    <th>Nama Produk</th>
                    <th>Harga Produk</th>
                    <th>Deskripsi Produk</th>
                    <th>Kategori Produk</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
            <?php $no = 1; $datas = $db->readJoinData('tbl_produk', 'tbl_kategori', 'id_kategori_produk', 'id_kategori'); foreach($datas as $data): ?>
                <tr>
                    <td>1</td>
                    <td class="tbl-img"><img src="<?= '../assets/images/produk/'.$data->gambar_produk ?>" alt="<?= $data->nama_produk ?>"></td>
                    <td><?= $data->nama_produk ?></td>
                    <td>Rp. <?= number_format($data->harga_produk) ?></td>
                    <td class="tbl-description"><?= Show::excerpt($data->deskripsi_produk) ?></td>
                    <td><?= $data->nama_kategori ?></td>
                    <td>
                        <a href="" class="badge badge-primary"><i class="fas fa-pencil-alt"></i>&nbsp; Ubah</a>
                        <a href="" class="badge badge-danger"><i class="fas fa-trash-alt"></i>&nbsp; Hapus</a>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>

<!-- Modal -->
<div class="modal fade" id="inputForm" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"><i class="fas fa-plus"></i>&nbsp; Tambah Produk </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="<?= $_SERVER['PHP_SELF']; ?>" method="post" enctype="multipart/form-data">
                    <div class="form-group">
                        <label><i class="fas fa-images"></i>&nbsp; Gambar Produk:</label><br>
                        <center>
                            <label for="addPicture" class="col-md-12 add-picture-icon">
                                <i class="fas fa-upload fa-3x"></i><br>
                                <p>Upload File</p>
                                <img src="" id="imageDefault" alt="" style="width: 100%;">
                                <input type="file" class="form-control" id="addPicture" name="gambar_produk">
                            </label>
                        </center>
                    </div>
                    <div class="form-group">
                        <label><i class="fab fa-delicious"></i>&nbsp; Nama Produk:</label>
                        <input type="text" class="form-control" placeholder="Masukkan Nama Produk..." name="nama_produk">
                    </div>
                    <div class="form-group">
                        <label><i class="fas fa-dollar-sign"></i>&nbsp; Harga Produk:</label>
                        <input type="text" class="form-control" placeholder="Contoh: 20000" name="harga_produk">
                    </div>
                    <div class="form-group">
                        <label><i class="far fa-sticky-note"></i>&nbsp; Deskripsi Produk:</label>
                        <textarea class="form-control" name="" placeholder="Masukkan Deskripsi Produk..." name="deskripsi_produk"></textarea>
                    </div>
                    <div class="form-group">
                        <label><i class="far fa-paper-plane"></i>&nbsp; Kategori Produk:</label>
                        <select name="kategori_produk" class="form-control">
                            <?php $datas = $db->readData('tbl_kategori'); foreach($datas as $data): ?>
                            <option value="<?= $data->id_kategori; ?>" class="form-control"><?= $data->nama_kategori; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <button type="submit" name="goAdd" class="btn btn-primary" value="Submit">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

    <?php require_once '../views/js.php'; ?>
</body>
</html>