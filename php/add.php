<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Tambah Siswa</title>
</head>
<body>
    <h1>Tambah Siswa</h1>
    <form method="POST" action="/add">
        <label for="name">Nama:</label>
        <input type="text" id="name" name="name" required><br><br>
        
        <label for="age">Umur:</label>
        <input type="number" id="age" name="age" required><br><br>
        
        <label for="grade">Grade:</label>
        <input type="text" id="grade" name="grade" required><br><br>
        
        <button type="submit">Tambah</button>
    </form>
</body>
</html>
