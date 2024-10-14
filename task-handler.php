<?php
// Database connection
$conn = new mysqli("localhost", "root", "", "db_rekapan");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_POST['task_id']) {
    // Update existing task
    $sql = "UPDATE tasks SET 
            hari = '$_POST[hari]',
            dosen = '$_POST[dosen]',
            mata_kuliah = '$_POST[mataKuliah]',
            tugas = '$_POST[tugas]',
            deadline = '$_POST[deadline]',
            status = '$_POST[status]' 
            WHERE id = '$_POST[task_id]'";
} else {
    // Insert new task
    $sql = "INSERT INTO tasks (hari, dosen, mata_kuliah, tugas, deadline, status)
            VALUES ('$_POST[hari]', '$_POST[dosen]', '$_POST[mataKuliah]', '$_POST[tugas]', '$_POST[deadline]', '$_POST[status]')";
}

$conn->query($sql);
$conn->close();
header("Location: index.php");
