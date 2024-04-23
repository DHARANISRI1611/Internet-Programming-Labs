<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "job_applications";
$port = 3306;
$nameErr = $emailErr = $cvErr = "";
$conn = new mysqli($servername, $username, $password, $database, $port);
if ($conn->connect_error) {
    echo("Connection failed: " . $conn->connect_error);
}
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST["name"];
    $email = $_POST["email"];
    $cv_path = $_FILES["cv"]["name"];
    if (empty($name)) {
        $nameErr = "Name is required";
    }
    if (empty($email)) {
        $emailErr = "Email is required";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $emailErr = "Invalid email format";
    }
    if (empty($cv_path)) {
        $cvErr = "CV is required";
    }
    if (empty($nameErr) && empty($emailErr) && empty($cvErr)) {
        $target_dir = "cv_uploads/";
        $target_file = $target_dir . basename($_FILES["cv"]["name"]);
        if (move_uploaded_file($_FILES["cv"]["tmp_name"], $target_file)) {
            $sql = "INSERT INTO applications (name, email, cv_path) VALUES (?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("sss", $name, $email, $target_file);
            if ($stmt->execute()) {
                echo "Application submitted successfully";
            } else {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }
            $stmt->close();
        } else {
            echo "Error uploading file";
        }
    }
}
$conn->close();
?>
<!DOCTYPE html>
<html>
<head>
    <title>Job Application Form</title>
    <style>
        form {
            border: 1px solid white;
            width: 400px;
            height: 400px;
            margin-top: 20px;
        }

        .error {
            color: red;
        }
    </style>
</head>
<body>
    <center>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" enctype="multipart/form-data">
            <label for="name">Name:</label>
            <input type="text" id="name" name="name">
            <span class="error"><?php echo $nameErr; ?></span><br><br>
            <label for="email">Email:</label>
            <input type="email" id="email" name="email">
            <span class="error"><?php echo $emailErr; ?></span><br><br>
            <label for="cv">CV:</label>
            <input type="file" id="cv" name="cv">
            <span class="error"><?php echo $cvErr; ?></span><br><br>
            <input type="submit" value="Submit">
        </form>
    </center>
</body>
</html>
