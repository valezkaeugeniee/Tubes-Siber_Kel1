<?php
// add.php - Form untuk menambahkan data siswa
include 'app.php'; // Menyertakan file koneksi database

// Mengecek apakah form sudah disubmit
// if ($_SERVER['REQUEST_METHOD'] == 'POST') {
//     $name = $_POST['name'];
//     $age = $_POST['age'];
//     $grade = $_POST['grade'];

//     // Memanggil fungsi untuk menambah data siswa
//     $pdo = connectDB();
//     if ($pdo) {
//         addStudent($pdo, $name, $age, $grade); // Fungsi addStudent ada di bawah
//     }
// }
    $students=selectStudents();
    // print_r($data);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Daftar Siswa</title>
</head>
<body>
    <h1>Daftar Siswa</h1>
    <table border="1">
        <tr>
            <th>ID</th>
            <th>Nama</th>
            <th>Umur</th>
            <th>Grade</th>
            <th>Aksi</th>
        </tr>
        <?php foreach ($students as $student): ?>
        <tr>
            <td><?= $student['id'] ?></td>
            <td><?= $student['name'] ?></td>
            <td><?= $student['age'] ?></td>
            <td><?= $student['grade'] ?></td>
            <td>
                <a href="edit.php?id=<?= $student['id'] ?>">Edit</a> |
                <a href="delete.php?id=<?= $student['id'] ?>">Hapus</a>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>
    <a href="add.php">Tambah Siswa</a>
</body>
</html>
