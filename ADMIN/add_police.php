<?php
// Include the database connection
include '../Database/db_con.php';
include 'constants/sidebar.php';

// Define variables to store form data
$police_id = $police_email = $password = $name = $rank = $police_id_number = '';
$error_message = '';
$success_message = '';

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data and sanitize
    $police_id = mysqli_real_escape_string($conn, $_POST['police_id']);
    $police_email = mysqli_real_escape_string($conn, $_POST['police_email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $rank = mysqli_real_escape_string($conn, $_POST['rank']);
    $police_id_number = mysqli_real_escape_string($conn, $_POST['police_id_number']);

    // Check for duplicate police_id
    $check_id_query = "SELECT * FROM police WHERE police_id = '$police_id'";
    $result_id = mysqli_query($conn, $check_id_query);

    // Check for duplicate police_email
    $check_email_query = "SELECT * FROM police WHERE police_email = '$police_email'";
    $result_email = mysqli_query($conn, $check_email_query);

    if (mysqli_num_rows($result_id) > 0) {
        // Set error message for duplicate police_id
        $error_message = "Error: Police ID already exists!";
    } elseif (mysqli_num_rows($result_email) > 0) {
        // Set error message for duplicate police_email
        $error_message = "Error: Police Email already exists!";
    } else {
        // Insert the police record into the database
        $insert_query = "INSERT INTO police (police_id, police_email, password, name, rank, police_id_number)
                         VALUES ('$police_id', '$police_email', '$password', '$name', '$rank', '$police_id_number')";
        if (mysqli_query($conn, $insert_query)) {
            // Set success message
            $success_message = "Police officer added successfully!";
        } else {
            $error_message = "Error: " . mysqli_error($conn);
        }
    }
}

// Close the database connection
mysqli_close($conn);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Police</title>
    <link rel="stylesheet" href="css/add_police.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        body, html {
            height: 100%;
            margin: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: Arial, sans-serif;
        }
        .form-container {
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100%;
            padding-top: 60px; /* Adjust this value according to the height of your navbar */
        }
        form {
            background-color: #f2f2f2;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        form label {
            display: block;
            margin-bottom: 5px;
        }
        form input, form select, form button {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        form button {
            background-color: #4CAF50;
            color: white;
            border: none;
        }
        form button:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    <?php if (!empty($error_message)): ?>
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Error!',
                text: '<?php echo $error_message; ?>'
            });
        </script>
    <?php endif; ?>

    <?php if (!empty($success_message)): ?>
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Success!',
                text: '<?php echo $success_message; ?>'
            });
        </script>
    <?php endif; ?>

    <div class="form-container">
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <label for="police_id">Police ID:</label>
            <input type="text" id="police_id" name="police_id" required>

            <label for="police_email">Police Email:</label>
            <input type="email" id="police_email" name="police_email" required>

            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>

            <label for="name">Name:</label>
            <input type="text" id="name" name="name" required>

            <label for="rank">Rank:</label>
            <select id="rank" name="rank" required>
                <option value="Constable">Constable</option>
                <option value="Corporal">Corporal</option>
                <!-- Add other options as needed -->
            </select>

            <label for="police_id_number">ID Number:</label>
            <input type="text" id="police_id_number" name="police_id_number" required>

            <button type="submit">Add Police</button>
        </form>
    </div>

</body>
</html>
