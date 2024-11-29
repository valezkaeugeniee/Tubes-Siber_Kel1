<?php
    include 'app.php'; 

    if (isset($_GET['id'])) {
        $id = $_GET['id'];
        $students=selectStudents($id);
    }
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $id = $_POST['id'];
        $name = $_POST['name'];
        $age = $_POST['age'];
        $grade = $_POST['grade'];
    
        // Memanggil fungsi untuk menambah data siswa
        updateStudent($id,$name, $age, $grade); // Fungsi addStudent ada di app.php
    }
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Siswa</title>
</head>
<body>
    <h1>Update Data Siswa</h1>

    <form method="post" action="">
        <input type="hidden" id="id" name="id" value="<?php echo $students[0]['id'] ?>" required>
        
        <label for="name">Nama:</label>
        <input type="text" id="name" name="name" value="<?php echo $students[0]['name'] ?>"  required>

        <label for="age">Usia:</label>
        <input type="number" id="age" name="age" value="<?php echo $students[0]['age'] ?>"  required>

        <label for="grade">Nilai:</label>
        <input type="text" id="grade" name="grade" value="<?php echo $students[0]['grade'] ?>"  required>

        <button type="submit">Update Siswa</button>
    </form>

</body>
</html>