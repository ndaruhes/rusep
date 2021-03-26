<?php 
    require_once '../config/init.php'; 
    $id = $_GET['resep'];
    $data = $db->readJoinDataThree('tbl_resep', 'tbl_kategori', 'id_kategori_resep', 'id_kategori', 'tbl_users', 'id_user_resep', 'id_user', 'id_resep', $id);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title><?= $data->judul_resep; ?></title>
    <style>
        body{
            background: url('https://i.ibb.co/CmgVky5/bg-blogtukang.png');
        }
    </style>
    <?php require_once '../views/css.php'; ?>
</head>
<body>
    <!-- Navbar -->
    <?php require_once '../views/navbar.php'; ?>

    <!-- Content -->
    <div class="container single-page-body">
        <div class="row">
            <div class="col-md-8 content-spacing">
                <div class="col-md-12 content-inner">
                    <img src="<?= '../assets/images/resep/'.$data->gambar_resep; ?>" alt="<?= $data->judul_resep; ?>">
                    <h1><?= $data->judul_resep; ?></h1>
                    <div class="single-line"></div>
                    <div class="col-md-12 content">
                        <div class="part-content">
                            <p><?= $data->deskripsi_resep; ?></p>
                        </div>
                        <div class="part-content">
                            <h1 class="content-heading">Alat dan Bahan</h1>
                            <p><?= $data->alat_bahan_resep; ?></p>
                        </div>
                        <div class="part-content">
                            <h1 class="content-heading">Langkah - Langkah</h1>
                            <p><?= $data->isi_resep; ?></p>
                        </div>
                        <div class="part-content">
                            <h1 class="content-heading">Tentang Penulis</h1>
                            <div class="row author">
                                <div class="col-md-3 author-image">
                                    <img src="<?= '../assets/images/profile-users/'.$data->foto_profile_user; ?>" alt="<?= $data->nama_user; ?>" class="rounded-circle">
                                </div>
                                <div class="col-md-9 author-about">
                                    <h1><?= $data->nama_user; ?></h1>
                                    <p><?= $data->deskripsi_user; ?></p>
                                </div>
                            </div>
                        </div>
                        <br>
                        <div class="part-content">
                            <div id="disqus_thread"></div>
                                <script>
                                    (function() {  // DON'T EDIT BELOW THIS LINE
                                        var d = document, s = d.createElement('script');
                                        
                                        s.src = 'https://crotchas.disqus.com/embed.js';
                                        
                                        s.setAttribute('data-timestamp', +new Date());
                                        (d.head || d.body).appendChild(s);
                                    })();
                                </script>
                                <noscript>Please enable JavaScript to view the <a href="https://disqus.com/?ref_noscript" rel="nofollow">comments powered by Disqus.</a></noscript>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- <div class="col-md-4">
                <div class="col-md-12 sidebar">

                </div>
            </div> -->
        </div>
    </div>

    <!-- Footer -->
    <?php require_once '../views/footer.php'; ?>
    
    <?php require_once '../views/js.php'; ?>
</body>
</html>