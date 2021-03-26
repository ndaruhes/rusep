<?php
    if(Session::exists('member') || Session::exists('admin')){
        $member = Session::name('member');
        $profile = $db->readData('tbl_users', 'email_user', $member);
    }
?>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark navbar-flat">
    <div class="container">
        <a class="navbar-brand" href="<?= $url; ?>">SCOAPP</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ml-auto">
            <?php if(Session::exists('admin')): ?>
                <li class="nav-item">
                    <a class="nav-link" href="<?= $url.'pages/logout.php'; ?>">Admin</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?= $url.'pages/logout.php'; ?>"><i class="fas fa-power-off"></i>&nbsp; Logout</a>
                </li>
            <?php elseif(Session::exists('member')): ?>
                <li class="nav-item">
                    <a class="nav-link" href="<?= $url; ?>"><i class="fas fa-home"></i>&nbsp; Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?= $url.'member/resep/'; ?>"><i class="fas fa-th-large"></i>&nbsp; Daftar Resep</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fas fa-user"></i>&nbsp; <?= $profile->nama_user; ?>
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="<?= $url.'member/profile/'; ?>"><i class="fas fa-cog"></i>&nbsp; Edit Profil</a>
                        <a class="dropdown-item" href="<?= $url.'pages/logout.php'; ?>"><i class="fas fa-power-off"></i>&nbsp; Logout</a>
                    </div>
                </li>
            <?php else: ?>
                <li class="nav-item">
                    <a class="nav-link" href="<?= $url; ?>"><i class="fas fa-home"></i>&nbsp; Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?= $url.'pages/login.php'; ?>"><i class="fas fa-sign-in-alt"></i>&nbsp; Login</a>
                </li>
        <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>