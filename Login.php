<?php
// Replace with your actual DB credentials
$servername = "localhost";
$db_username = "cnwebtr0v1f0_Applicatons";
$db_password = "cnwebtr0v1f0_clive";
$dbname = "Pass0713519090";

// Create connection
$conn = new mysqli($servername, $db_username, $db_password, $dbname);
if ($conn->connect_error) {
    die(json_encode(['success'=>false, 'error'=>'Database connection error']));
}

// Read username and password from POST
$username = isset($_POST['username']) ? $_POST['username'] : '';
$password = isset($_POST['password']) ? $_POST['password'] : '';

// Query user
$stmt = $conn->prepare('SELECT password FROM users WHERE username = ? LIMIT 1');
$stmt->bind_param('s', $username);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows === 1) {
    $stmt->bind_result($db_password_value);
    $stmt->fetch();
    // For hashed passwords use password_verify($password, $db_password_value)
    if ($password === $db_password_value) {
        echo json_encode(['success'=>true]);
    } else {
        echo json_encode(['success'=>false, 'error'=>'Invalid password']);
    }
} else {
    echo json_encode(['success'=>false, 'error'=>'Invalid username']);
}
$stmt->close();
$conn->close();
?>