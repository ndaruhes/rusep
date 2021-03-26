<?php 
    require_once 'config/init.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Share Cooking App - Bagikan Resep Bersama Kami</title>
    <?php require_once 'views/css.php'; ?>
</head>
<body>
    <!-- Navbar -->
    <?php require_once 'views/navbar.php' ?>

    <!-- Slider -->
    <?php require_once 'views/slider.php' ?>

    <!-- Content -->
    <div class="container opening">
        <h1><i class="fas fa-paper-plane"></i>&nbsp; Resep Terpopuler</h1>
        <div class="line"></div>
        <!-- <h3>Share Cooking App</h3>
        <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p> -->
    </div>

    <div class="container">
        <div class="row">
            <?php $datas = $db->readJoinDataThree('tbl_resep', 'tbl_kategori', 'id_kategori_resep', 'id_kategori', 'tbl_users', 'id_user_resep', 'id_user', '', ''); foreach($datas as $data): ?>
                <div class="col-md-3 card-spacing">
                    <div class="col-md-12 card-section">
                        <img src="<?= 'assets/images/resep/'.$data->gambar_resep; ?>" class="card-img-top" alt="<?= $data->judul_resep; ?>">
                        <div class="card-body">
                            <h5 class="card-title"><?= $data->judul_resep; ?></h5>
                            <p class="card-text"><?= Show::excerpt($data->deskripsi_resep); ?></p>
                            <p class="card-author"><i class="fas fa-user"></i>&nbsp; <span>oleh</span> <?= $data->nama_user ?></p>
                            <a href="pages/single-resep.php?resep=<?= $data->id_resep; ?>" class="btn card-read-button">Lihat Selengkapnya &nbsp;<i class="fas fa-angle-double-right"></i></a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

    <!-- Footer -->
    <?php require_once 'views/footer.php'; ?>

    <?php require_once 'views/js.php'; ?>
</body>
</html>