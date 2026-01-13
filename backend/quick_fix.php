<?php

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ./');
    exit;
}

// Collect form data safely
$firstName   = $_POST['first_name'] ?? '';
$lastName    = $_POST['last_name'] ?? '';
$school      = $_POST['school'] ?? '';
$level       = $_POST['level'] ?? '';
$phoneNumber = $_POST['phone'] ?? '';

//Let sanitize these details 
$firstName = htmlspecialchars($firstName, ENT_QUOTES, 'UTF-8');
$lastName  = htmlspecialchars($lastName, ENT_QUOTES, 'UTF-8');
$school    = htmlspecialchars($school, ENT_QUOTES, 'UTF-8');
$level     = htmlspecialchars($level, ENT_QUOTES, 'UTF-8');
$phoneNumber = htmlspecialchars($phoneNumber, ENT_QUOTES, 'UTF-8');

// Validate file upload
if (!isset($_FILES['photo']) || $_FILES['photo']['error'] !== UPLOAD_ERR_OK) {
    die('No file uploaded or upload error occurred.');
}

$photo = $_FILES['photo'];

// Validate file size (1MB max)
if ($photo['size'] > 1_000_000) {
    die('File size exceeds limit.');
}

// Validate MIME type using finfo (secure)
$finfo = finfo_open(FILEINFO_MIME_TYPE);
$mime  = finfo_file($finfo, $photo['tmp_name']);
finfo_close($finfo);

$allowedTypes = ['image/jpeg', 'image/png'];

if (!in_array($mime, $allowedTypes, true)) {
    die('Invalid image type.');
}

// Resolve upload directory
$uploadDir = __DIR__ . '/uploads/';

// Ensure directory exists
if (!is_dir($uploadDir)) {
    die('Upload directory does not exist.');
}

// Ensure directory is writable
if (!is_writable($uploadDir)) {
    die('Upload directory is not writable.');
}

// Generate safe unique filename
$extension = pathinfo($photo['name'], PATHINFO_EXTENSION);
$filename  = uniqid('photo_', true) . '.' . strtolower($extension);
$destination = $uploadDir . $filename;

// Move uploaded file
if (!move_uploaded_file($photo['tmp_name'], $destination)) {
    die('Failed to move uploaded file.');
}


// next let call the database to check if the phone number already exists and user already registered as an ambassador 
// Database configuration
$host = 'localhost';
$dbname = 'dnactzqo_zonixx';
$username = 'dnactzqo_zonixx';
$password = '@Spectacular141';

try {
    // Create a new PDO instance
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "<p class='text-red-500'>Database connection failed: " . htmlspecialchars($e->getMessage()) . "</p>";

}

//Check if the person already applied 
$stmt = $pdo->prepare("SELECT * FROM ambassadors WHERE phone = :phone");
$stmt->execute(['phone' => $phoneNumber]);
$existingUser = $stmt->fetch(PDO::FETCH_ASSOC);

if($existingUser){
    echo "<p class='text-red-500'>Phone number already registered. Please use a different phone number.</p>";
    exit;
} 

//Else let enter the details into the database
$stmt = $pdo->prepare("INSERT INTO ambassadors (first_name, last_name, school, level, phone, photo) VALUES (:first_name, :last_name, :school, :level, :phone, :photo)");
$stmt->execute([
    ':first_name' => $firstName,
    ':last_name'  => $lastName,
    ':school'     => $school,
    ':level'      => $level,
    ':phone'      => $phoneNumber,
    ':photo'      => $filename
]);

//Check if the insertion was successful
if($stmt->rowCount() > 0){
    echo "<p class='text-green-500'>Ambassador registered successfully!</p>";
} else {
    echo "<p class='text-red-500'>Failed to register ambassador. Please try again.</p>";
}

