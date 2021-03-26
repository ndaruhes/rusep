<?php 
    require_once '../../config/init.php'; 

    $id = $_GET['delete'];
    $data = $db->readData('tbl_resep', 'id_resep', $id);

    $db->deleteData('tbl_resep', 'id_resep', $id);

    if(file_exists('../../assets/images/resep/'.$data->gambar_resep)){
        unlink('../../assets/images/resep/'.$data->gambar_resep);
    }

    echo "<script>alert('Resep berhasil dihapus');</script>";
    echo "<meta http-equiv='refresh' content='1 url=../resep/'>";

?>