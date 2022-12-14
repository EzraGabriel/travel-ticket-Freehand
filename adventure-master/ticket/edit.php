<?php
    require_once '../../conn.php';
    require_once '../template/sidebar.php';
    require_once '../template/header.php';

    $sql1 = "SELECT * FROM transportasi JOIN type_transportasi ON transportasi.id_type_transportasi = type_transportasi.id_type_transportasi";
    $stmt1 = sqlsrv_query($conn, $sql1);

    $sql2 = "SELECT * FROM cities JOIN provinces ON cities.prov_id = provinces.prov_id";
    $stmt2 = sqlsrv_query($conn, $sql2);
    $stmt3 = sqlsrv_query($conn, $sql2);

    $id = $_GET['id'];
    $sql4 = "SELECT * FROM tiket WHERE id_tiket= $id";
    $stmt4 = sqlsrv_query($conn, $sql4);
    $data = sqlsrv_fetch_array($stmt4, SQLSRV_FETCH_ASSOC);

    $waktu_berangkat = date_format($data['waktu_berangkat'], "Y/m/d H:i:s");
    $waktu_berangkat = date('Y-m-d\TH:i:s', strtotime($waktu_berangkat));

    $waktu_sampai = date_format($data['waktu_sampai'], "Y/m/d H:i:s");
    $waktu_sampai = date('Y-m-d\TH:i:s', strtotime($waktu_sampai));

?>
<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Ubah Tiket</h1>
</div>
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Ubah Tiket</h6>
    </div>
    <div class="card-body">
        <form action="action_edit.php" method="POST">
            <input type="hidden" name='id' value='<?= $id ?>'>
            <div class="form-group">
                <label>Nama Pesawat</label>
                <select name="type_tras" class='form-control js2' id='transportasi' required>
                    <option value="">--- Pilih Transportasi ---</option>
                    <?php while($dt = sqlsrv_fetch_array($stmt1, SQLSRV_FETCH_ASSOC)): ?>
                    <option value="<?= $dt['id_trasportasi'] ?>"
                        <?= $dt['id_trasportasi'] == $data['id_transportasi'] ? 'selected="selected"' : ''?>>
                        <?= $dt['nama_pesawat'] ?> || <?= $dt['nama_type'] ?>
                    </option>
                    <?php endwhile;?>
                </select>
            </div>
            <div class="form-group">
                <label>Rute Awal</label>
                <select name="rute_awal" class='form-control js2' required>
                    <option value="">--- Pilih Rute Awal ---</option>
                    <?php while($dt = sqlsrv_fetch_array($stmt2, SQLSRV_FETCH_ASSOC)): ?>
                    <option value="<?= $dt['city_id'] ?>"
                        <?= $dt['city_id'] == $data['rute_awal'] ? 'selected="selected"' : ''?>>
                        <?= $dt['prov_name'].' | '. $dt['city_name'] ?>
                    </option>
                    <?php endwhile;?>
                </select>
            </div>
            <div class="form-group">
                <label>Rute Akhir</label>
                <select name="rute_akhir" class='form-control js2' required>
                    <option value="">--- Pilih Rute Akhir ---</option>
                    <?php while($dt = sqlsrv_fetch_array($stmt3, SQLSRV_FETCH_ASSOC)): ?>
                    <option value="<?= $dt['city_id'] ?>"
                        <?= $dt['city_id'] == $data['rute_akhir'] ? 'selected="selected"' : ''?>>
                        <?= $dt['prov_name'].' | '. $dt['city_name'] ?>
                    </option>
                    <?php endwhile;?>
                </select>
            </div>
            <div class="form-group">
                <label>Harga</label>
                <input type="number" name='harga' class='form-control' value='<?= $data['harga'] ?>' placeholder='Harga'
                    required>
            </div>
            <div class="form-group">
                <label>Waktu Berangkat</label>
                <input type="datetime-local" name='waktu_berangkat' class='form-control' value='<?= $waktu_berangkat ?>'
                    required>
            </div>

            <div class="form-group">
                <label>Waktu Sampai</label>
                <input type="datetime-local" name=' waktu_sampai' class='form-control' value='<?= $waktu_sampai ?>'
                    required>
            </div>

            <div class="form-group">
                <label>Sisa Kursi</label>
                <input type="number" name=' sisa' class='form-control' value='<?= $data['sisa_kursi'] ?>' required>
            </div>

            <button type="submit" class="btn btn-warning">Edit</button>

        </form>
    </div>


    <?php
    require_once '../template/footer.php';
?>