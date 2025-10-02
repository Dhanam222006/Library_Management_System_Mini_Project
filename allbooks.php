<?php
session_start();
require 'db1.php'; // database connection file

// Fetch all books ordered by category and then title
$sql = "SELECT * FROM books ORDER BY category ASC, title ASC";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>All Books</title>
    <style>
        body {
          background: linear-gradient(270deg, #1d3557, #d66bd1ff, #a8dadc, #e63946);
  background-size: 800% 800%;  /* makes gradient wide so it can move */
  animation: gradientMove 12s ease infinite; /* Blue theme */
            font-family: Arial, sans-serif;
            color: white;
            margin: 0;
            padding: 0;
        }
        @keyframes gradientMove {
  0% { background-position: 0% 50%; }
  50% { background-position: 100% 50%; }
  100% { background-position: 0% 50%; }
}

        .container {
            width: 90%;
            margin: 30px auto;
        }
        .top-bar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 15px;
        }
        .title {
            font-size: 28px;
            font-weight: bold;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            background: #ffffff10;
            border-radius: 10px;
            overflow: hidden;
        }
        th, td {
            padding: 12px;
            text-align: center;
        }
        th {
            background-color: #83a2c0ff;
            color: #fff;
        }
        tr:nth-child(even) {
            background-color: #ffffff20;
        }
        tr.category-header {
            background-color: #f8fbfcff;
            font-weight: bold;
            text-align: left;
            color: black;
        }
        .btn {
            background-color: #28a745;
            border: none;
            padding: 8px 12px;
            border-radius: 6px;
            color: white;
            font-weight: bold;
            cursor: pointer;
            text-decoration: none;
        }
        .btn:hover {
            background-color: #218838;
        }
        .btn.disabled {
            background-color: #6c757d;
            cursor: not-allowed;
        }
        .back-btn {
            background-color: #ffc107;
            padding: 8px 14px;
            border-radius: 6px;
            text-decoration: none;
            color: black;
            font-weight: bold;
        }
        .back-btn:hover {
            background-color: #e0a800;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="top-bar">
            <div class="title">📚 All Books</div>
            <a href="borrow_return.php" class="back-btn">⬅ Back</a>
        </div>

        <table border="1">
            <tr>
                <th>ID</th>
                <th>Title</th>
                <th>Author</th>
                <th>Category</th>
                <th>Available Count</th>
                <th>Action</th>
            </tr>
            <?php
            if ($result->num_rows > 0) {
                $currentCategory = '';
                while ($row = $result->fetch_assoc()) {
                    $category = htmlspecialchars($row['category']);
                    if ($category !== $currentCategory) {
                        $currentCategory = $category;
                        echo "<tr class='category-header'><td colspan='6'>Category: {$currentCategory}</td></tr>";
                    }

                    $id = $row['id'];
                    $title = htmlspecialchars($row['title']);
                    $author = htmlspecialchars($row['author']);
                    $avail = htmlspecialchars($row['available_count']);

                    echo "<tr>
                        <td>{$id}</td>
                        <td>{$title}</td>
                        <td>{$author}</td>
                        <td>{$category}</td>
                        <td>{$avail}</td>";

                    if ($row['available_count'] > 0) {
                        echo "<td><a class='btn' href='borrow_return.php?book_id={$id}'>Book Now</a></td>";
                    } else {
                        echo "<td><span class='btn disabled'>Not Available</span></td>";
                    }

                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='6'>No books found</td></tr>";
            }
            ?>
        </table>
    </div>
</body>
</html>
