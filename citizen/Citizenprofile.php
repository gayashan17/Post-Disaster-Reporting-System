<?php
if (session_status() === PHP_SESSION_NONE) // to fix session already started error
{
    session_start();
}

include '../classes/User.php';

// --- Auth check -------------------------------------------------
// Picture upload is a plain form POST (redirects back on failure),
// profile-details update is AJAX (returns JSON on failure)
if (!isset($_SESSION['username']) || !isset($_SESSION['user_Id']) || $_SESSION['user_Id'] == null) {
    if (isset($_FILES['profile_picture'])) {
        header('Location: ../LoginForm.php');
        exit;
    }
    header('Content-Type: application/json');
    http_response_code(401);
    echo json_encode(['success' => false, 'message' => 'Not logged in.']);
    exit;
}

$userID = $_SESSION['user_Id'];

/* ==========================================================================
   BRANCH 1: Profile picture upload
   Triggered by the small #profilePicForm (multipart/form-data, plain POST,
   full page reload) — distinguished by the presence of $_FILES['profile_picture']
   ========================================================================== */
if (isset($_FILES['profile_picture'])) {

    if ($_FILES['profile_picture']['error'] !== UPLOAD_ERR_OK) {
        header('Location: CitizenprofileForm.php?pic=error&msg=' . urlencode('No file was uploaded, or the upload failed.'));
        exit;
    }

    $file = $_FILES['profile_picture'];

    // Server-side validation (never trust the client)
    $allowedMimeTypes = ['image/png', 'image/jpeg', 'image/webp'];
    $maxSize = 5 * 1024 * 1024; // 5MB

    $finfo = finfo_open(FILEINFO_MIME_TYPE);
    $mimeType = finfo_file($finfo, $file['tmp_name']);
    finfo_close($finfo);

    if (!in_array($mimeType, $allowedMimeTypes, true)) {
        header('Location: CitizenprofileForm.php?pic=error&msg=' . urlencode('Invalid file type. Please upload a PNG, JPG, or WEBP image.'));
        exit;
    }

    if ($file['size'] > $maxSize) {
        header('Location: CitizenprofileForm.php?pic=error&msg=' . urlencode('File is too large. Maximum size is 5MB.'));
        exit;
    }

    // Delegate to your existing User class method (it opens/closes its own DB connection)
    $user = new User();
    $result = $user->updateProfilePicture($userID, $file);

    if (isset($result['success']) && $result['success'] === true) {
        header('Location: CitizenprofileForm.php?pic=success');
    } else {
        $msg = $result['message'] ?? 'Failed to update profile picture.';
        header('Location: CitizenprofileForm.php?pic=error&msg=' . urlencode($msg));
    }
    exit;
}

/* ==========================================================================
   BRANCH 2: Profile details update
   Triggered by #profile-form via fetch() with a JSON body
   ========================================================================== */
header('Content-Type: application/json');

include '../DBconnection.php';

$input = json_decode(file_get_contents('php://input'), true);

if (!$input) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Invalid or empty request body.']);
    exit;
}

function clean($value) {
    return htmlspecialchars(trim($value ?? ''), ENT_QUOTES, 'UTF-8');
}

$fullName = clean($input['fullName'] ?? '');
$gender   = clean($input['gender'] ?? '');
$NIC      = clean($input['NIC'] ?? '');
$email    = filter_var(trim($input['email'] ?? ''), FILTER_SANITIZE_EMAIL);
$phoneNo  = clean($input['phoneNo'] ?? '');
$address  = clean($input['address'] ?? '');

$newPassword     = $input['newPassword'] ?? '';
$confirmPassword = $input['confirmPassword'] ?? '';

$errors = [];

if ($fullName === '') $errors[] = 'Full name is required.';
if (!in_array($gender, ['Male', 'Female', 'Other'], true)) $errors[] = 'Invalid gender.';
if (!preg_match('/^([0-9]{9}[vVxX]|[0-9]{12})$/', $NIC)) $errors[] = 'Invalid NIC format.';
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = 'Invalid email address.';
if (!preg_match('/^[0-9]{10}$/', $phoneNo)) $errors[] = 'Invalid phone number.';
if ($address === '') $errors[] = 'Address is required.';

if ($newPassword !== '' || $confirmPassword !== '') {
    if (strlen($newPassword) < 6) {
        $errors[] = 'New password must be at least 6 characters.';
    } elseif ($newPassword !== $confirmPassword) {
        $errors[] = 'Passwords do not match.';
    }
}

if (!empty($errors)) {
    http_response_code(422);
    echo json_encode(['success' => false, 'message' => implode(' ', $errors)]);
    exit;
}

// --- Update via the User class ----------------------------------------
$user = new User();
$user->setUserID($userID);
$user->setFullName($fullName);
$user->setGender($gender);
$user->setNIC($NIC);
$user->setEmail($email);
$user->setPhoneNo($phoneNo);
$user->setAddress($address);

if ($newPassword !== '') {
    $user->setPassword(password_hash($newPassword, PASSWORD_DEFAULT));
}

try {
    $updated = $user->updateUser($con);

    if ($updated) {
        // keep session in sync so the topbar/sidebar reflect the change immediately
        $_SESSION['email']  = $email;
        $_SESSION['gender'] = $gender;

        echo json_encode([
            'success' => true,
            'message' => 'Profile updated successfully.'
        ]);
    } else {
        http_response_code(500);
        echo json_encode(['success' => false, 'message' => 'Update failed. Please try again.']);
    }
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}

mysqli_close($con);
