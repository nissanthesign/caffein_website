<?php
// admin.php

// Set up the database connection.
$db_name = 'mysql:host=localhost;dbname=coffee_db';
$username = 'root';
$password = ''; // Use your correct password (empty if default)

try {
    $conn = new PDO($db_name, $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die('Connection failed: ' . $e->getMessage());
}

// --- Handle Create Operation ---
if (isset($_POST['create'])) {
    $name = filter_var($_POST['name'], FILTER_SANITIZE_STRING);
    $number = filter_var($_POST['number'], FILTER_SANITIZE_NUMBER_INT);
    $guests = filter_var($_POST['guests'], FILTER_SANITIZE_NUMBER_INT);

    $stmt = $conn->prepare("INSERT INTO coffee_form(name, number, guests) VALUES(?, ?, ?)");
    $stmt->execute([$name, $number, $guests]);
    header("Location: admin.php");
    exit;
}

// --- Handle Update Operation ---
if (isset($_POST['update'])) {
    $id = $_POST['id'];
    $name = filter_var($_POST['name'], FILTER_SANITIZE_STRING);
    $number = filter_var($_POST['number'], FILTER_SANITIZE_NUMBER_INT);
    $guests = filter_var($_POST['guests'], FILTER_SANITIZE_NUMBER_INT);

    $stmt = $conn->prepare("UPDATE coffee_form SET name = ?, number = ?, guests = ? WHERE id = ?");
    $stmt->execute([$name, $number, $guests, $id]);
    header("Location: admin.php");
    exit;
}

// --- Handle Delete Operation ---
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $stmt = $conn->prepare("DELETE FROM coffee_form WHERE id = ?");
    $stmt->execute([$id]);
    header("Location: admin.php");
    exit;
}

// --- Check if we are editing a record ---
$editMode = false;
$editRow = null;
if (isset($_GET['edit'])) {
    $editMode = true;
    $id = $_GET['edit'];
    $stmt = $conn->prepare("SELECT * FROM coffee_form WHERE id = ?");
    $stmt->execute([$id]);
    $editRow = $stmt->fetch(PDO::FETCH_ASSOC);
}
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Admin Panel - Coffee Shop CRUD</title>
    <style>
        /* Base variables */
        :root {
            --main-color: #be9c79;
            /* Main coffee theme color */
            --secondary-color: #a1887f;
            /* Secondary warm tone */
            --background: #f8f5f2;
            /* Mild background */
            --text-color: #333;
            /* Dark text */
            --white: #fff;
            --box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.1);
        }

        /* Global Styles */
        body {
            background-color: var(--background);
            font-family: 'Nunito', sans-serif;
            margin: 0;
            padding: 0;
            color: var(--text-color);
        }

        header {
            background-color: var(--main-color);
            padding: 1rem 2rem;
            text-align: center;
            color: var(--white);
        }

        header h1 {
            margin: 0;
            font-size: 3rem;
            font-family: 'Merienda One', cursive;
        }

        /* Main Container */
        .container {
            max-width: 1200px;
            margin: 2rem auto;
            padding: 0 2rem;
        }

        /* Table Styles */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 2rem;
            background-color: var(--white);
            box-shadow: var(--box-shadow);
            border-radius: 0.5rem;
            overflow: hidden;
        }

        thead {
            background-color: var(--secondary-color);
            color: var(--white);
        }

        table th,
        table td {
            padding: 1rem;
            text-align: left;
            font-size: 1.6rem;
        }

        table tbody tr:nth-child(even) {
            background-color: #f0ece9;
        }

        table tbody tr:hover {
            background-color: #e8e2dc;
        }

        a.action-link {
            color: var(--main-color);
            text-decoration: none;
            font-weight: bold;
            margin-right: 0.5rem;
        }

        a.action-link:hover {
            text-decoration: underline;
        }

        /* Form Styles */
        form {
            background-color: var(--white);
            padding: 2rem;
            box-shadow: var(--box-shadow);
            border-radius: 0.5rem;
            margin-bottom: 2rem;
        }

        form h2 {
            margin-top: 0;
            font-size: 2.5rem;
            color: var(--main-color);
        }

        form label {
            display: block;
            font-size: 1.6rem;
            margin: 1rem 0 0.5rem;
        }

        form input[type="text"],
        form input[type="number"] {
            width: 100%;
            padding: 1rem;
            font-size: 1.6rem;
            margin-bottom: 1.5rem;
            border: 0.1rem solid #ccc;
            border-radius: 0.3rem;
        }

        form input[type="submit"] {
            padding: 1rem 2rem;
            font-size: 1.6rem;
            background-color: var(--main-color);
            color: var(--white);
            border: none;
            border-radius: 0.3rem;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        form input[type="submit"]:hover {
            background-color: var(--secondary-color);
        }

        /* Responsive adjustments */
        @media (max-width: 768px) {
            header h1 {
                font-size: 2.5rem;
            }

            table th,
            table td {
                font-size: 1.4rem;
            }

            form h2 {
                font-size: 2rem;
            }
        }
    </style>
    <!-- Optional: Include Google Fonts -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Merienda+One&family=Nunito:wght@200;300;400;500;600&display=swap">
</head>

<body>
    <a href="index.php" class="btn-back">← Back to Website</a>

    <header>
        <a href="index.php" class="btn-back">← Back to Website</a>

        <h1>Admin Panel</h1>
    </header>
    <div class="container">
        <!-- Display Records -->
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Number</th>
                    <th>Guests</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $stmt = $conn->query("SELECT * FROM coffee_form");
                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    echo "<tr>
                        <td>{$row['id']}</td>
                        <td>" . htmlspecialchars($row['name']) . "</td>
                        <td>" . htmlspecialchars($row['number']) . "</td>
                        <td>" . htmlspecialchars($row['guests']) . "</td>
                        <td>
                            <a class='action-link' href='admin.php?edit={$row['id']}'>Edit</a>
                            <a class='action-link' href='admin.php?delete={$row['id']}' onclick=\"return confirm('Are you sure you want to delete this record?');\">Delete</a>
                        </td>
                      </tr>";
                }
                ?>
            </tbody>
        </table>

        <!-- Form for Create or Edit -->
        <form action="admin.php" method="post">
            <h2><?php echo ($editMode ? "Edit Record" : "Create New Record"); ?></h2>
            <?php if ($editMode): ?>
                <input type="hidden" name="id" value="<?php echo $editRow['id']; ?>">
            <?php endif; ?>
            <label for="name">Name:</label>
            <input type="text" name="name" id="name" required value="<?php echo ($editMode ? htmlspecialchars($editRow['name']) : ''); ?>">

            <label for="number">Number:</label>
            <input type="text" name="number" id="number" required value="<?php echo ($editMode ? htmlspecialchars($editRow['number']) : ''); ?>">

            <label for="guests">Guests:</label>
            <input type="number" name="guests" id="guests" required value="<?php echo ($editMode ? htmlspecialchars($editRow['guests']) : ''); ?>">

            <input type="submit" name="<?php echo ($editMode ? "update" : "create"); ?>" value="<?php echo ($editMode ? "Update Record" : "Create Record"); ?>">
        </form>

        <?php if ($editMode): ?>
            <p><a class="action-link" href="admin.php">Cancel Edit</a></p>
        <?php endif; ?>
    </div>
</body>

</html>