<?php
require_once 'SesiTayang.php';
session_start();

// Handler utilitas untuk mereset keseluruhan array session
if (isset($_POST['reset_data'])) {
    session_unset();
    session_destroy();
    header("Location: Main.php");
    exit(); 
}

// Menginisialisasi array penampung entitas pada memori session jika belum ada
if (!isset($_SESSION['daftarSesi'])) {
    $_SESSION['daftarSesi'] = []; 
}

$message = '';
$message_type = '';

// Helper function untuk validasi jaminan ID unik dalam kumpulan data
function isIdExists($id, $list) {
    foreach ($list as $item) 
    {
        if ($item->getId() === $id) 
        {
            return true;
        }
    }
    return false; 
}

// Controller penambahan entitas (Triggered by POST submit)
if (isset($_POST['tambah'])) {
    $id_sesi = trim($_POST['id_sesi']); 
    $judul_film = trim($_POST['judul_film']); 
    $jadwal = trim($_POST['jadwal']); 
    $harga = $_POST['harga']; 

    // Filter sanitasi dan validasi kelengkapan form
    if (empty($id_sesi) || empty($judul_film) || empty($jadwal) || !is_numeric($harga) || $harga < 0) {
        $message = "Error: Input invalid. Pastikan field string terisi dan field angka bernilai positif.";
        $message_type = 'error';
    } elseif (isIdExists($id_sesi, $_SESSION['daftarSesi'])) 
    {
        $message = "Error: ID Sesi bentrok dengan data yang sudah ada.";
        $message_type = 'error';
    } else {
        // Pemrosesan logikal file gambar upload
        $gambar = '';
        if (!empty($_FILES['gambar']['name']) && $_FILES['gambar']['error'] == 0) 
        {
            $target_dir = "./images/"; 
            if (!is_dir($target_dir)) mkdir($target_dir); 
            $target_file = $target_dir . time() . "_" . basename($_FILES["gambar"]["name"]); 
            if (move_uploaded_file($_FILES["gambar"]["tmp_name"], $target_file)) 
            {
                $gambar = $target_file; 
            }
        }

        // Instansiasi dan appendent objek ke storage session
        $sesi_baru = new SesiTayang($id_sesi, $judul_film, $jadwal, (float)$harga, $gambar); 
        $_SESSION['daftarSesi'][] = $sesi_baru; 

        $message = "Sesi tayang berhasil ditambahkan"; 
        $message_type = 'success';
    }
}

// Controller penghapusan entitas (Triggered by GET parameters)
if (isset($_GET['action']) && $_GET['action'] === 'hapus' && isset($_GET['id'])) {
    $id_hapus = $_GET['id']; 
    // Filter array mempertahankan elemen di mana klausul non-match terpenuhi
    $_SESSION['daftarSesi'] = array_values(array_filter($_SESSION['daftarSesi'], fn($p) => $p->getId() !== $id_hapus)); 
    $message = "🗑️ Sesi tayang berhasil dihapus."; 
    $message_type = 'success';
    header("Location: Main.php"); 
    exit();
}

// Controller fungsi pembaruan entitas berdasarkan spesifikasi ID
function updateSesi($id_update) {
    global $message, $message_type;
    foreach ($_SESSION['daftarSesi'] as $sesi) 
    {
        if ($sesi->getId() === $id_update) 
        {
            $id_baru = trim($_POST['id_baru']);
            $judul_baru = trim($_POST['judul_film']);
            $jadwal_baru = trim($_POST['jadwal']);
            $harga_baru = $_POST['harga'];

            // Validasi format constraint sebelum aplikasi pembaruan
            if (empty($judul_baru) || empty($jadwal_baru) || !is_numeric($harga_baru) || $harga_baru < 0) {
                $message = "Error: Pembaruan gagal. Format input field tidak memenuhi syarat validasi.";
                $message_type = 'error';
                return [$message, $message_type];
            }

            // Pengecekan restriksi duplikat untuk update ID
            if (!empty($id_baru) && $id_baru !== $sesi->getId())
            {
                if (isIdExists($id_baru, $_SESSION['daftarSesi'])) 
                {
                    $message = "⚠️ Peringatan: ID Baru telah eksis. Field ID gagal diperbarui.";
                    $message_type = 'warning';
                } else {
                    $sesi->setId($id_baru); 
                }
            }

            // Pembaruan properti standar
            $sesi->setJudul($judul_baru);
            $sesi->setJadwal($jadwal_baru);
            $sesi->setHarga((float)$harga_baru);

            // Pembaruan file gambar jika payload upload berisikan file baru
            if (!empty($_FILES['gambar']['name']) && $_FILES['gambar']['error'] == 0) {
                $target_dir = "./images/"; 
                if (!is_dir($target_dir)) mkdir($target_dir); 
                $target_file = $target_dir . time() . "_" . basename($_FILES["gambar"]["name"]);
                if (move_uploaded_file($_FILES["gambar"]["tmp_name"], $target_file))
                {
                    $sesi->setGambar($target_file); 
                }
            }
            
            // Output keberhasilan jika validasi warning di atas lolos
            if ($message_type !== 'warning') {
                $message = "Data sesi tayang telah berhasil diperbarui.";
                $message_type = 'success';
            }

            return [$message, $message_type]; 
        }
    }
    $message = "Sesi tayang target gagal ditemukan dalam direktori data.";
    $message_type = 'error';
    return [$message, $message_type]; 
}

// Router untuk meloloskan task update 
if (isset($_POST['update'])) {
    [$message, $message_type] = updateSesi($_POST['id_sesi']); 
}

// Controller modul pencarian spesifik (Searching Engine)
$hasil_cari = $_SESSION['daftarSesi'];
if (isset($_GET['cari'])) 
{
    $id_cari = trim($_GET['cari_id']); 
    // Return array subset hanya dari objek yang matching dengan filter parameter ID
    $hasil_cari = array_values(array_filter($_SESSION['daftarSesi'], fn($p) => $p->getId() === $id_cari)); 
    if (empty($hasil_cari)) {
        $message = "Sesi tayang bernomor ID '$id_cari' tidak ada.";
        $message_type = 'warning';
    }
}

// Utility penjemputan entitas objek spesifik untuk dimuat di form update
function getSesiById($id) {
    foreach ($_SESSION['daftarSesi'] as $sesi) 
    {
        if ($sesi->getId() === $id) 
        {
            return $sesi; 
        }
    }
    return null; 
}

$edit_id = $edit_judul = $edit_jadwal = $edit_harga = $edit_gambar = ''; // Nilai awal reset
if (isset($_GET['edit_id'])) 
{
    $sesi = getSesiById($_GET['edit_id']); 
    if ($sesi !== null) {
        // Melakukan data binding ke local var untuk form rendering
        $edit_id     = $sesi->getId(); 
        $edit_judul  = $sesi->getJudul(); 
        $edit_jadwal = $sesi->getJadwal(); 
        $edit_harga  = $sesi->getHarga(); 
        $edit_gambar = $sesi->getGambar(); 
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Manajemen Sesi Tayang Bioskop</title>

</head>
<body>
<div class="container">
    <h1>Manajemen Sesi Tayang Bioskop Cimahi 2067</h1>

    <?php if ($message): ?> 
        <div class="message <?= $message_type; ?>"><?= $message; ?></div>
    <?php endif; ?>

    <form action="Main.php" method="POST" enctype="multipart/form-data">
        <h2><?= $edit_id ? 'Update Sesi Tayang' : 'Tambah Sesi Tayang'; ?></h2>
        <?php if ($edit_id): ?>
            <input type="hidden" name="id_sesi" value="<?= htmlspecialchars($edit_id); ?>"> 
            <input type="text" name="id_baru" value="<?= htmlspecialchars($edit_id); ?>" placeholder="ID Sesi" required> <br>
        <?php else: ?>
            <input type="text" name="id_sesi" placeholder="ID Sesi" required> <br>
        <?php endif; ?>

        <input type="text" name="judul_film" value="<?= htmlspecialchars($edit_judul); ?>" placeholder="Judul Film" required> <br>
        <input type="text" name="jadwal" value="<?= htmlspecialchars($edit_jadwal); ?>" placeholder="Jadwal Tayang (contoh: 20-09-2026 19:00)" required><br>
        <input type="number" step="0.01" name="harga" value="<?= htmlspecialchars($edit_harga); ?>" placeholder="Harga Tiket" required>
        <br>
        
        <button type="submit" name="<?= $edit_id ? 'update' : 'tambah'; ?>" class="<?= $edit_id ? 'btn-update' : 'btn-tambah'; ?>">
            <?= $edit_id ? 'Update' : 'Tambah'; ?>
        </button>
    </form>

    <div class="search-container">
        <form action="Main.php" method="GET" style="display:flex; gap:10px; width:100%; max-width:500px;">
            <input type="text" name="cari_id" placeholder="Cari berdasarkan ID Sesi" required>
            <button type="submit" name="cari">Cari</button>
        </form>
    </div>

    <table border="2">
        <thead>
            <tr>
                <th>ID Sesi</th>
                <th>Judul Film</th>
                <th>Jadwal Tayang</th>
                <th>Harga Tiket</th>
                <th>edit</th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($hasil_cari)): ?>
                <tr><td colspan="6" style="text-align:center;">Tidak ada data sesi tayang</td></tr>
            <?php else: ?>
                <?php foreach ($hasil_cari as $sesi): ?>
                    <tr>
                        <td><?= htmlspecialchars($sesi->getId()); ?></td>
                        <td><?= htmlspecialchars($sesi->getJudul()); ?></td>
                        <td><?= htmlspecialchars($sesi->getJadwal()); ?></td>
                        <td><?= 'Rp ' . number_format($sesi->getHarga(), 2, ',', '.'); ?></td>
                        <td class="actions">
                            <a href="Main.php?edit_id=<?= urlencode($sesi->getId()); ?>" class="edit">Update</a>
                            <a href="Main.php?action=hapus&id=<?= urlencode($sesi->getId()); ?>" class="delete" onclick="return confirm('Yakin hapus sesi tayang ini dari sistem?');">Hapus</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>

    <?php if (isset($_GET['cari'])): ?>
        <div style="text-align:center;">
            <a href="Main.php" class="btn-showall">Tampilkan Semua</a>
        </div>
    <?php endif; ?>

    <div class="reset-container">
        <form action="Main.php" method="POST">
            <button type="submit" name="reset_data" class="btn-reset" onclick="return confirm('Peringatan: Seluruh data sesi tayang akan direset dan hilang. Lanjutkan?');">Reset Semua Data</button>
        </form>
    </div>
</div>
</body>
</html>