<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rekapan Tugas</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            margin: 0;
            padding: 20px;
        }

        h2 {
            color: #333;
        }

        table {
            width: 70%;
            border-collapse: collapse;
            margin-bottom: 20px;
            float: left;
        }

        table,
        th,
        td {
            border: 1px solid #ddd;
        }

        th,
        td {
            padding: 12px;
            text-align: left;
        }

        th {
            background-color: #007bff;
            color: white;
        }

        td {
            background-color: #f9f9f9;
        }

        button {
            padding: 6px 10px;
            border: none;
            cursor: pointer;
            border-radius: 4px;
            font-size: 14px;
        }

        .edit-btn {
            background-color: #ffc107;
            color: white;
        }

        .delete-btn {
            background-color: #dc3545;
            color: white;
        }

        .add-btn {
            background-color: #28a745;
            color: white;
            margin-top: 10px;
            display: block;
            font-size: 14px;
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
    </style>
</head>

<body>

    <h2>Input Rekapan Tugas</h2>

    <!-- Frontend form for adding tasks -->
    <form id="tugasForm" method="POST" action="insert-task.php">
        <div>
            <label for="hari">Hari:</label>
            <input type="text" id="hari" name="hari" required>
        </div>
        <div>
            <label for="dosen">Nama Dosen:</label>
            <input type="text" id="dosen" name="dosen" required>
        </div>
        <div>
            <label for="mataKuliah">Mata Kuliah:</label>
            <input type="text" id="mataKuliah" name="mataKuliah" required>
        </div>
        <div>
            <label for="tugas">Tugas:</label>
            <input type="text" id="tugas" name="tugas" required>
        </div>
        <div>
            <label for="deadline">Deadline:</label>
            <input type="date" id="deadline" name="deadline" required>
        </div>
        <div>
            <label for="status">Status:</label>
            <select id="status" name="status" required>
                <option value="Belum Selesai">Belum Selesai</option>
                <option value="Selesai">Selesai</option>
            </select>
        </div>
        <button type="submit" class="add-btn">Tambah Tugas</button>
    </form>

    <h2>Filter Berdasarkan Mata Kuliah</h2>
    <form method="GET">
        <select name="filterMataKuliah">
            <option value="">Semua Mata Kuliah</option>
            <?php
            // Connect to the database
            $conn = new mysqli("localhost", "root", "", "db_rekapan");

            // Get unique mata kuliah for the filter
            $mataKuliahQuery = "SELECT DISTINCT mata_kuliah FROM tasks";
            $mataKuliahResult = $conn->query($mataKuliahQuery);

            while ($mataKuliahRow = $mataKuliahResult->fetch_assoc()) {
                $selected = isset($_GET['filterMataKuliah']) && $_GET['filterMataKuliah'] === $mataKuliahRow['mata_kuliah'] ? 'selected' : '';
                echo "<option value='" . htmlspecialchars($mataKuliahRow['mata_kuliah']) . "' $selected>" . htmlspecialchars($mataKuliahRow['mata_kuliah']) . "</option>";
            }
            ?>
        </select>
        <button type="submit" class="add-btn">Filter</button>
    </form>

    <h2>Rekapan Tugas</h2>

    <table id="rekapanTugas">
        <thead>
            <tr>
                <th>Hari</th>
                <th>Nama Dosen</th>
                <th>Mata Kuliah</th>
                <th>Tugas</th>
                <th>Deadline</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // Apply filter if mata kuliah is selected
            $filterMataKuliah = isset($_GET['filterMataKuliah']) ? $_GET['filterMataKuliah'] : '';

            $sql = "SELECT * FROM tasks";
            if ($filterMataKuliah) {
                $sql .= " WHERE mata_kuliah = '" . $conn->real_escape_string($filterMataKuliah) . "'";
            }

            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($row['hari']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['dosen']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['mata_kuliah']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['tugas']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['deadline']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['status']) . "</td>";
                    echo "<td>";
                    echo "<a href='edit-task.php?id=" . $row['id'] . "'><button class='edit-btn'>Edit</button></a> ";
                    echo "<a href='delete-task.php?id=" . $row['id'] . "' onclick='return confirm(\"Are you sure?\")'><button class='delete-btn'>Delete</button></a>";
                    echo "</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='7'>No tasks found</td></tr>";
            }

            // Close connection
            $conn->close();
            ?>
        </tbody>
    </table>

</body>

</html>