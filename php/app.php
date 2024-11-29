<?php
function connectDB() {
    try {
        // Membuka koneksi ke database SQLite
        $pdo = new PDO('sqlite:students.db'); // Ganti dengan path yang sesuai
        // Set error mode agar mudah mendeteksi error
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $pdo;
    } catch (PDOException $e) {
        echo "Koneksi gagal: " . $e->getMessage();
        return null;
    }
}


// Fungsi untuk mendapatkan data siswa dari database
function selectStudents() {
    // Memanggil fungsi koneksi
    $db = connectDB();
    
    if ($db) {
        try {
            // Query untuk mengambil semua data dari tabel students
            $query = "SELECT * FROM student";
            
            // Menjalankan query
            $stmt = $db->query($query);
            
            // Mengambil semua data dalam bentuk array asosiatif
            $students = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            // Mengembalikan hasil query dalam bentuk array
            return $students;
        } catch (PDOException $e) {
            echo "Query gagal: " . $e->getMessage();
        }
    } else {
        echo "Gagal koneksi ke database.";
    }
}

function addStudent($pdo, $name, $age, $grade) {
    $stmt = $pdo->prepare("INSERT INTO student (name, age, grade) VALUES (:name, :age, :grade)");
    $stmt->execute(['name' => $name, 'age' => $age, 'grade' => $grade]);
    // echo "Data siswa berhasil ditambahkan!";
    header("Location: index.php");
}


?>
