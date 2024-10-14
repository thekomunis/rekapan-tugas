<?php
// Koneksi ke database
$conn = new mysqli("localhost", "root", "", "db_rekapan");

// Periksa koneksi
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Ambil ID dari parameter URL
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Ambil data tugas berdasarkan ID
$sql = "SELECT * FROM tasks WHERE id = $id";
$result = $conn->query($sql);

// Periksa apakah data tugas ditemukan
if ($result->num_rows > 0) {
    $task = $result->fetch_assoc();
} else {
    echo "Tugas tidak ditemukan!";
    exit;
}

// Jika form disubmit, proses update data
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $hari = $_POST['hari'];
    $dosen = $_POST['dosen'];
    $mataKuliah = $_POST['mataKuliah'];
    $tugas = $_POST['tugas'];
    $deadline = $_POST['deadline'];
    $status = $_POST['status'];

    // Update data di database
    $updateSql = "UPDATE tasks SET 
                    hari = '" . $conn->real_escape_string($hari) . "',
                    dosen = '" . $conn->real_escape_string($dosen) . "',
                    mata_kuliah = '" . $conn->real_escape_string($mataKuliah) . "',
                    tugas = '" . $conn->real_escape_string($tugas) . "',
                    deadline = '" . $conn->real_escape_string($deadline) . "',
                    status = '" . $conn->real_escape_string($status) . "'
                  WHERE id = $id";

    if ($conn->query($updateSql) === TRUE) {
        echo "Data tugas berhasil diperbarui!";
        // Redirect kembali ke halaman utama
        header("Location: index.php");
        exit;
    } else {
        echo "Error: " . $conn->error;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Tugas</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            margin: 0;
            padding: 20px;
        }

        form {
            margin-bottom: 20px;
            padding: 20px;
            background-color: white;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        form div {
            margin-bottom: 10px;
        }

        input,
        select {
            padding: 8px;
            width: 100%;
            box-sizing: border-box;
            margin-top: 5px;
            border-radius: 4px;
            border: 1px solid #ddd;
        }

        button {
            padding: 6px 10px;
            background-color: #007bff;
            color: white;
            border: none;
            cursor: pointer;
            border-radius: 4px;
            font-size: 14px;
        }

        .cancel-btn {
            background-color: #dc3545;
            margin-left: 10px;
        }
    </style>
</head>

<body>

    <h2>Edit Tugas</h2>

    <!-- Form untuk mengedit tugas -->
    <form method="POST">
        <div>
            <label for="hari">Hari:</label>
            <input type="text" id="hari" name="hari" value="<?php echo htmlspecialchars($task['hari']); ?>" required>
        </div>
        <div>
            <label for="dosen">Nama Dosen:</label>
            <input type="text" id="dosen" name="dosen" value="<?php echo htmlspecialchars($task['dosen']); ?>" required>
        </div>
        <div>
            <label for="mataKuliah">Mata Kuliah:</label>
            <input type="text" id="mataKuliah" name="mataKuliah" value="<?php echo htmlspecialchars($task['mata_kuliah']); ?>" required>
        </div>
        <div>
            <label for="tugas">Tugas:</label>
            <input type="text" id="tugas" name="tugas" value="<?php echo htmlspecialchars($task['tugas']); ?>" required>
        </div>
        <div>
            <label for="deadline">Deadline:</label>
            <input type="date" id="deadline" name="deadline" value="<?php echo htmlspecialchars($task['deadline']); ?>" required>
        </div>
        <div>
            <label for="status">Status:</label>
            <select id="status" name="status" required>
                <option value="Belum Selesai" <?php echo $task['status'] === 'Belum Selesai' ? 'selected' : ''; ?>>Belum Selesai</option>
                <option value="Selesai" <?php echo $task['status'] === 'Selesai' ? 'selected' : ''; ?>>Selesai</option>
            </select>
        </div>
        <button type="submit">Update Tugas</button>
        <a href="index.php"><button type="button" class="cancel-btn">Batal</button></a>
    </form>

</body>

</html>