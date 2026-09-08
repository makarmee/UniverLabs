<?php
$message = "";
$messageType = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fullName = trim($_POST["full_name"] ?? "");
    $email = trim($_POST["email"] ?? "");
    $department = trim($_POST["department"] ?? "");

    if ($fullName === "" || $email === "" || $department === "") {
        $message = "All fields are required.";
        $messageType = "danger";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $message = "Please enter a valid email address.";
        $messageType = "danger";
    } else {
        $conn = new mysqli("localhost", "root", "", "wis_lab");

        if ($conn->connect_error) {
            $message = "Connection failed: " . $conn->connect_error;
            $messageType = "danger";
        } else {
            $stmt = $conn->prepare(
                "INSERT INTO students (full_name, email, department) VALUES (?, ?, ?)"
            );

            if ($stmt) {
                $stmt->bind_param("sss", $fullName, $email, $department);

                if ($stmt->execute()) {
                    $message = "Student added successfully.";
                    $messageType = "success";
                } else {
                    $message = "Error inserting student: " . $stmt->error;
                    $messageType = "danger";
                }
                $stmt->close();
            } else {
                $message = "Error preparing statement: " . $conn->error;
                $messageType = "danger";
            }
            $conn->close();
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Insert Student</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">
    <div class="container py-5">
        <div class="card shadow-sm mx-auto" style="max-width:650px;">
            <div class="card-body">
                <h2 class="mb-4">Student Information</h2>
                <?php if ($message !== ""): ?>
                    <div class="alert alert-<?php echo $messageType; ?>"><?php echo htmlspecialchars($message); ?></div>
                <?php endif; ?>
                <form method="POST">
                    <div class="mb-3">
                        <label class="form-label">Full Name</label>
                        <input type="text" name="full_name" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" name="email" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Department</label>
                        <input type="text" name="department" class="form-control" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Save Student</button>
                    <button type="reset" class="btn btn-secondary">Clear</button>
                </form>
            </div>
        </div>
    </div>
</body>

</html>