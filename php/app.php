<?php
// Koneksi ke SQLite
$dbFile = 'students.db'; // File database SQLite
$pdo = new PDO("sqlite:$dbFile");
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// Fungsi untuk menampilkan daftar siswa
function getStudents($pdo) {
    $stmt = $pdo->query('SELECT * FROM student');
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Fungsi untuk menambah siswa baru
function addStudent($pdo, $name, $age, $grade) {
    $stmt = $pdo->prepare("INSERT INTO student (name, age, grade) VALUES (:name, :age, :grade)");
    $stmt->execute(['name' => $name, 'age' => $age, 'grade' => $grade]);
}

// Fungsi untuk menghapus siswa
function deleteStudent($pdo, $id) {
    $stmt = $pdo->prepare("DELETE FROM student WHERE id = :id");
    $stmt->execute(['id' => $id]);
}

// Fungsi untuk mengedit data siswa
function editStudent($pdo, $id, $name, $age, $grade) {
    $stmt = $pdo->prepare("UPDATE student SET name = :name, age = :age, grade = :grade WHERE id = :id");
    $stmt->execute(['id' => $id, 'name' => $name, 'age' => $age, 'grade' => $grade]);
}

// Menangani route utama ('/')
// if ($_SERVER['REQUEST_METHOD'] === 'GET' && $_SERVER['REQUEST_URI'] === '/') {
//     $students = getStudents($pdo);
//     // Menampilkan daftar siswa di halaman index.php
//     include 'index.php';
// }
function index($pdo) {
    $students = getAllStudents($pdo); // Memanggil fungsi untuk mengambil data siswa
    include 'index.php'; // Menampilkan halaman index.php dengan daftar siswa
}

// Menangani route '/add' untuk menambah siswa
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_SERVER['REQUEST_URI'] === '/add') {
    $name = $_POST['name'];
    $age = $_POST['age'];
    $grade = $_POST['grade'];
    addStudent($pdo, $name, $age, $grade);
    header('Location: /');
}

// Menangani route '/delete/{id}' untuk menghapus siswa
if (preg_match('/^\/delete\/(\d+)$/', $_SERVER['REQUEST_URI'], $matches)) {
    $id = $matches[1];
    deleteStudent($pdo, $id);
    header('Location: /');
}

// Menangani route '/edit/{id}' untuk mengedit data siswa
if (preg_match('/^\/edit\/(\d+)$/', $_SERVER['REQUEST_URI'], $matches)) {
    $id = $matches[1];
    
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $name = $_POST['name'];
        $age = $_POST['age'];
        $grade = $_POST['grade'];
        editStudent($pdo, $id, $name, $age, $grade);
        header('Location: /');
    } else {
        // Mengambil data siswa untuk ditampilkan di form edit
        $stmt = $pdo->prepare("SELECT * FROM student WHERE id = :id");
        $stmt->execute(['id' => $id]);
        $student = $stmt->fetch(PDO::FETCH_ASSOC);
        include 'edit.php';
    }
}

?>
