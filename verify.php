<?php
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $uploadDir = 'uploads/';
    if (!is_dir($uploadDir)) mkdir($uploadDir, 0777, true);

    // Allowed image types
    $allowedTypes = ['image/jpeg', 'image/jpg', 'image/png'];

    // Validate ID file
    if (isset($_FILES['idFile'])) {
        if (!in_array($_FILES['idFile']['type'], $allowedTypes)) {
            echo json_encode(['verified' => false, 'message' => '❌ ID must be a JPG or PNG image.']);
            exit;
        }
        $idPath = $uploadDir . basename($_FILES['idFile']['name']);
        move_uploaded_file($_FILES['idFile']['tmp_name'], $idPath);
    } else {
        echo json_encode(['verified' => false, 'message' => '❌ ID file missing.']);
        exit;
    }

    // Validate personal photo
    if (isset($_FILES['personalPhoto'])) {
        if (!in_array($_FILES['personalPhoto']['type'], $allowedTypes)) {
            echo json_encode(['verified' => false, 'message' => '❌ Personal photo must be a JPG or PNG image.']);
            exit;
        }
        $photoPath = $uploadDir . basename($_FILES['personalPhoto']['name']);
        move_uploaded_file($_FILES['personalPhoto']['tmp_name'], $photoPath);
    } else {
        echo json_encode(['verified' => false, 'message' => '❌ Personal photo missing.']);
        exit;
    }

    // Demo “match” check (for real app, use face recognition API)
    // Here, we simulate a match if the filenames share the same first letter
    $idFirstLetter = strtolower($idPath[8]); // after 'uploads/'
    $photoFirstLetter = strtolower($photoPath[8]);
    
    if ($idFirstLetter === $photoFirstLetter) {
        echo json_encode(['verified' => true, 'message' => '✅ Verification successful!']);
    } else {
        echo json_encode(['verified' => false, 'message' => '❌ Verification failed. ID and photo do not match.']);
    }

} else {
    echo json_encode(['verified' => false, 'message' => 'Invalid request']);
}
?>
