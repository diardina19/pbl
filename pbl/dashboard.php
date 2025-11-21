<?php
include 'database.php';


$hariIndo = [
    "Sunday" => "Minggu",
    "Monday" => "Senin",
    "Tuesday" => "Selasa",
    "Wednesday" => "Rabu",
    "Thursday" => "Kamis",
    "Friday" => "Jumat",
    "Saturday" => "Sabtu"
];

$todayName = $hariIndo[date("l")];

// Ambil jadwal hari ini dari database
$stmt = $conn->prepare("SELECT * FROM jadwal WHERE hari = ?");
$stmt->bind_param("s", $todayName);
$stmt->execute();
$result = $stmt->get_result();
$todaySchedule = $result->fetch_all(MYSQLI_ASSOC);
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MySchedule - Jadwal Kuliah</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
</head>

<body class="bg-light">

    <div class="container py-4">
        <h2 class="fw-bold mb-3">Jadwal Hari Ini: <?= $todayName ?></h2>

        <?php if (count($todaySchedule) == 0): ?>
            <div class="alert alert-warning text-center">
                Tidak ada jadwal hari ini 😊
            </div>
        <?php else: ?>
            <?php foreach ($todaySchedule as $j): ?>
                <div class="card mb-3 shadow-sm">
                    <div class="card-body">
                        <h5 class="fw-bold"><?= $j['mataKuliah'] ?></h5>
                        <p class="mb-1"><i class="bi bi-clock"></i>
                            <?= $j['jamMulai'] ?> - <?= $j['jamSelesai'] ?>
                        </p>
                        <p class="mb-1"><i class="bi bi-door-open"></i> <?= $j['ruangan'] ?></p>
                        <p class="mb-1"><i class="bi bi-person-badge"></i> <?= $j['dosen'] ?></p>

                        <a href="edit.php?id=<?= $j['id'] ?>" class="btn btn-primary btn-sm">
                            <i class="bi bi-pencil"></i> Edit
                        </a>

                        <a href="hapus.php?id=<?= $j['id'] ?>" onclick="return confirm('Hapus jadwal?')"
                            class="btn btn-danger btn-sm">
                            <i class="bi bi-trash"></i> Hapus
                        </a>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>

        <a href="tambah.php" class="btn btn-success mt-3">
            <i class="bi bi-plus-circle"></i> Tambah Jadwal
        </a>
    </div>

</body>

</html>