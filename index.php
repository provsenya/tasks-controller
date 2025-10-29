<?php
require 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['employee_name'], $_POST['task_name'])) {
    $name = $conn->real_escape_string($_POST['employee_name']);
    $task = $conn->real_escape_string($_POST['task_name']);
    $conn->query("INSERT INTO tasks (employee_name, task_name) VALUES ('$name', '$task')");
    header("Location: index.php");
    exit;
}

$status_filter = isset($_GET['status']) ? $conn->real_escape_string($_GET['status']) : '';
$query = "SELECT * FROM tasks";
if ($status_filter !== '') {
    $query .= " WHERE status='$status_filter'";
}
$query .= " ORDER BY created_at ASC";
$result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Список задач</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 30px; }
        table { border-collapse: collapse; width: 100%; margin-top: 15px; }
        th, td { border: 1px solid #ccc; padding: 8px; text-align: left; }
        select, input, button { padding: 6px; }

        .modal {
            display: none;
            position: fixed;
            z-index: 10;
            left: 0; top: 0;
            width: 100%; height: 100%;
            background-color: rgba(0,0,0,0.5);
        }
        .modal-content {
            background: #fff;
            margin: 10% auto;
            padding: 20px;
            border-radius: 5px;
            width: 300px;
            position: relative;
        }
        .close {
            position: absolute;
            right: 10px; top: 10px;
            cursor: pointer;
            font-size: 20px;
        }
        button.add-task-btn {
            margin-top: 10px;
        }
    </style>
</head>
<body>

<h1>Список задач</h1>

<form method="GET">
    <label>Фильтр по статусу:
        <select name="status" onchange="this.form.submit()">
            <option value="">Все</option>
            <option value="new" <?= $status_filter=='new'?'selected':'' ?>>Новые</option>
            <option value="in_progress" <?= $status_filter=='in_progress'?'selected':'' ?>>В работе</option>
            <option value="done" <?= $status_filter=='done'?'selected':'' ?>>Готово</option>
        </select>
    </label>
</form>

<table>
    <tr>
        <th>ID</th>
        <th>Сотрудник</th>
        <th>Задача</th>
        <th>Статус</th>
        <th>Создано</th>
    </tr>
    <?php while ($row = $result->fetch_assoc()): ?>
    <tr>
        <td><?= $row['id'] ?></td>
        <td><?= htmlspecialchars($row['employee_name']) ?></td>
        <td><?= htmlspecialchars($row['task_name']) ?></td>
        <td><?= $row['status'] ?></td>
        <td><?= $row['created_at'] ?></td>
    </tr>
    <?php endwhile; ?>
</table>

<button class="add-task-btn" onclick="openModal()">Добавить задачу</button>

<div id="taskModal" class="modal" onclick="outsideClick(event)">
    <div class="modal-content">
        <span class="close" onclick="closeModal()">&times;</span>
        <h2>Добавить задачу</h2>
        <form method="POST">
            <label>Имя сотрудника:<br>
                <input type="text" name="employee_name" required>
            </label><br><br>
            <label>Название задачи:<br>
                <input type="text" name="task_name" required>
            </label><br><br>
            <button type="submit">Добавить</button>
        </form>
    </div>
</div>

<script>
function openModal() {
    document.getElementById('taskModal').style.display = 'block';
}
function closeModal() {
    document.getElementById('taskModal').style.display = 'none';
}
function outsideClick(event) {
    if (event.target.id === 'taskModal') closeModal();
}
</script>

</body>
</html>

