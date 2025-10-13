<?php
session_start();  // Always at the top
require 'D:/event-management/PHPMailer/Exception.php';
require 'D:/event-management/PHPMailer/PHPMailer.php';
require 'D:/event-management/PHPMailer/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

include '../includes/db.php';
header('Content-Type: application/json');



$action = $_GET['action'] ?? '';

if ($action == 'add') {
    addEvent($conn);
} elseif ($action == 'get') {
    getEvents($conn);
} elseif ($action == 'register') {
    register($conn);
} elseif ($action == 'checkEmail') {
    checkEmail($conn);
} else if ($action == 'eventbyDate') {
    eventbyDate($conn);
} else if ($action == 'getRequiredDocs') {
    getRequiredDocs($conn);
} else if ($action == 'getUploadedDocs') {
    getUploadedDocs($conn);
} else if ($action == 'updateDocuments') {
    updateRegistrationDocuments($conn);
} else if ($action == 'update') {
    updateEvent($conn);
} else if ($action == 'delete') {
    deleteEvent($conn);
} else if ($action == 'login') {
    login($conn);
} else if ($action == 'getUser') {
    getUser($conn);
} else if ($action == 'addUser') {
    addUser($conn);
} elseif ($action === 'updateUser') {
    updateUser($conn);
} elseif ($action === 'deleteUser') {
    deleteUser($conn);
} else if ($action == 'logout') {
    logout($conn);
} else if ($action == 'getUserEvents') {
    getUserEvents($conn);
} else if ($action == 'sendMessage') {
    $name = $_POST['name'] ?? '';
    $email = $_POST['email'] ?? '';
    $message = $_POST['message'] ?? '';
    echo json_encode(sendMessage($name, $email, $message));
    exit;
} else if ($action == 'getEventsWithHistory') {
    getEventsWithHistory($conn);
} else if (isset($_GET['id'])) {
    // single event fetch
    getEventWithHistory($conn, intval($_GET['id']));
} else if ($action == 'saveOrUpdateEventHistory') {
    saveOrUpdateEventHistory($conn);
} else if ($action == 'getuserstable') {
    getuserstable($conn);
} else {
    echo json_encode(['error' => 'Invalid action']);
}

// ✅ Add Event
function addEvent($conn)
{

    // This function receives the event form data from JS,
    // processes uploaded images or URLs, and saves everything in the DB 


    // javaScript sends form data and PHP receives(get) it using $_POST 


    // If user not logged in, block event creation
    if (!isset($_SESSION['user_id'])) {
        echo json_encode(['status' => 'error', 'message' => 'You must be logged in to add an event.']);
        exit;
    }


    $title = $_POST['title'];
    $category = $_POST['category'];
    $desc = $_POST['description'];
    $date = $_POST['date'];
    $author = $_POST['author'];
    $venue = $_POST['venue'];
    $fees = $_POST['fees'];
    $contact = $_POST['contact'];

    $imageName = '';
    $required_docs = isset($_POST['required_docs']) ? json_encode($_POST['required_docs']) : '[]';

    // Priority: use image_url if provided, otherwise use uploaded image
    if (!empty($_POST['image_url'])) {
        $imageName = $_POST['image_url']; // Use URL directly
    } elseif (isset($_FILES['image']) && $_FILES['image']['name'] != '') {
        $imageName = time() . '_' . basename($_FILES["image"]["name"]);
        move_uploaded_file($_FILES["image"]["tmp_name"], "../uploads/events/" . $imageName);
    }

    $user_id = $_SESSION['user_id'];

    //  insert everthing in db 
    $sql = "INSERT INTO events (title, category,description, date, author, venue, fees, contact, image,required_documents,users)
            VALUES ('$title',  '$category','$desc', '$date', '$author', '$venue', '$fees', '$contact', '$imageName','$required_docs','$user_id')";

    if ($conn->query($sql)) {
        echo json_encode(['status' => 'success', 'message' => 'Event added successfully!']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Failed to add event.']);
    }
    exit;
}
function updateEvent($conn)
{

    $id = $_GET['id'] ?? 0;
    // $user_id = $_SESSION['user_id'];

    // make sure this event belongs to user
    $check = $conn->query("SELECT * FROM events WHERE id='$id'");
    if ($check->num_rows === 0) {
        echo json_encode(['status' => 'error', 'message' => 'Event not found or not yours']);
        exit;
    }

    $title = $_POST['title'];
    $category = $_POST['category'];
    $desc = $_POST['description'];
    $date = $_POST['date'];
    $author = $_POST['author'];
    $venue = $_POST['venue'];
    $fees = $_POST['fees'];
    $contact = $_POST['contact'];

    $required_docs = isset($_POST['required_docs']) ? json_encode($_POST['required_docs']) : '[]';

    $imageName = $check->fetch_assoc()['image']; // keep old image
    if (!empty($_POST['image_url'])) {
        $imageName = $_POST['image_url'];
    } elseif (isset($_FILES['image']) && $_FILES['image']['name'] != '') {
        $imageName = time() . '_' . basename($_FILES["image"]["name"]);
        move_uploaded_file($_FILES["image"]["tmp_name"], "../uploads/events/" . $imageName);
    }

    $sql = "UPDATE events SET 
              title='$title',
              category='$category',
              description='$desc',
              date='$date',
              author='$author',
              venue='$venue',
              fees='$fees',
              contact='$contact',
              image='$imageName',
              required_documents='$required_docs'
            WHERE id='$id'";

    if ($conn->query($sql)) {
        echo json_encode(['status' => 'success', 'message' => 'Event updated successfully!']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Update failed.']);
    }
    exit;
}
function deleteEvent($conn)
{

    $id = $_GET['id'] ?? 0;
    // $user_id = $_SESSION['user_id'];

    // Only allow if this event belongs to the user
    $sql = "DELETE FROM events WHERE id='$id'";
    if ($conn->query($sql)) {
        echo json_encode(['status' => 'success', 'message' => 'Event deleted successfully!']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Delete failed.']);
    }
    exit;
}

// ✅ Get Events
function getEvents($conn)
{
    // Check if event_id is sent, else default 0
    $event_id = isset($_GET['event_id']) ? intval($_GET['event_id']) : 0;
    if ($event_id > 0) {
        // Fetch only one event by ID
        $stmt = $conn->prepare("SELECT * FROM events WHERE id = ?");
        $stmt->bind_param("i", $event_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $event = $result->fetch_assoc();
        echo json_encode($event ?: new stdClass());  // return single event as object
    } else {
        // Fetch all events as before
        $sql = "SELECT * FROM events ORDER BY date DESC";
        $result = $conn->query($sql);
        $events = [];
        if ($result && $result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $events[] = $row;
            }
        }
        echo json_encode($events);
    }
}
function getUserEvents($conn)
{
    // session_start();

    // Agar user login hi nahi hai
    if (!isset($_SESSION['user_id'])) {
        echo json_encode(['status' => 'error', 'message' => 'User not logged in', 'events' => []]);
        exit;
    }

    $userId = $_SESSION['user_id'];

    // Fetch events jaha users = logged in user ka id
    $stmt = $conn->prepare("SELECT * FROM events WHERE users = ?");
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $result = $stmt->get_result();

    $events = [];
    while ($row = $result->fetch_assoc()) {
        $events[] = $row;
    }

    echo json_encode(['status' => 'success', 'events' => $events]);
    exit;
}


function eventbyDate($conn)
{
    $date = $_GET['date']; // You could sanitize this too
    $sql = "SELECT * FROM events WHERE DATE(date) = '$date' ORDER BY date DESC";
    $result = $conn->query($sql);
    $events = [];

    if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $events[] = $row;
        }
    }

    echo json_encode($events);
}
function getRequiredDocs($conn)
{
    $eventId = $_GET['event_id'];
    $stmt = $conn->prepare("SELECT required_documents FROM events WHERE id = ?");
    $stmt->bind_param("i", $eventId);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($row = $result->fetch_assoc()) {
        echo json_encode(["status" => "success", "docs" => json_decode($row['required_documents'])]);
    } else {
        echo json_encode(["status" => "error", "message" => "Event not found"]);
    }
    exit;
}
// ✅ Register for Event
function register($conn)
{
    $email = $_POST['email'] ?? '';
    $event_id = isset($_POST['event_id']) ? intval($_POST['event_id']) : 0;
    $name = $_POST['name'] ?? '';
    $documents = [];
    $documentsJson = json_encode($documents);

    if (!$email || !$event_id || !$name) {
        echo json_encode(['status' => 'error', 'message' => 'Missing required fields!']);
        return;
    }

    // Insert new registration
    $insertStmt = $conn->prepare("INSERT INTO registrations (event_id, name, email, documents) VALUES (?, ?, ?, ?)");
    $insertStmt->bind_param("isss", $event_id, $name, $email, $documentsJson);

    if ($insertStmt->execute()) {
        $id = $insertStmt->insert_id;

        // ✅ Fetch the inserted record back
        $result = $conn->query("SELECT * FROM registrations WHERE id = $id");
        $row = $result->fetch_assoc();

        $data = [
            "name" => $row['name'],
            "email" => $row['email'],
            "registered_at" => $row['created_at'] ?? date("Y-m-d H:i:s"),
            "documents" => json_decode($row['documents'], true) ?? []
        ];

        echo json_encode(['status' => 'success', 'data' => $data]);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Failed to register.']);
    }
}


function getUploadedDocs($conn)
{
    $email = $_GET['email'] ?? '';
    $event_id = isset($_GET['event_id']) ? intval($_GET['event_id']) : 0;

    if (!$email || !$event_id) {
        echo json_encode(['status' => 'error', 'message' => 'Missing email or event ID!']);
        return;
    }

    $stmt = $conn->prepare("SELECT documents FROM registrations WHERE email = ? AND event_id = ?");
    $stmt->bind_param("si", $email, $event_id);
    $stmt->execute();
    $result = $stmt->get_result();

    $uploadedDocs = [];
    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $uploadedDocs = json_decode($row['documents'], true) ?: [];
    }

    echo json_encode(['status' => 'success', 'uploadedDocs' => $uploadedDocs]);
}



// ✅ Check if email already registered
function checkEmail($conn)
{
    $email = $_POST['email'] ?? '';
    $event_id = isset($_POST['event_id']) ? intval($_POST['event_id']) : 0;

    if (!$email || !$event_id) {
        echo json_encode(['status' => 'error', 'message' => 'Missing email or event ID.']);
        exit;
    }

    $stmt = $conn->prepare("SELECT * FROM registrations WHERE email = ? AND event_id = ?");
    $stmt->bind_param("si", $email, $event_id);
    $stmt->execute();

    $result = $stmt->get_result(); // ✅ works with mysqlnd
    $registrationData = [];

    if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $registrationData[] = $row;
        }
        echo json_encode(["status" => "found", "data" => $registrationData]);
    } else {
        echo json_encode(["status" => "not_found"]);
    }
    exit;
}
// ✅ Update Event

function updateRegistrationDocuments($conn)
{
    $email = $_POST['email'] ?? '';
    $event_id = isset($_POST['event_id']) ? intval($_POST['event_id']) : 0;

    if (!$email || !$event_id) {
        echo json_encode(['status' => 'error', 'message' => 'Missing required fields!']);
        return;
    }

    // Fetch existing registration
    $stmt = $conn->prepare("SELECT documents FROM registrations WHERE email=? AND event_id=? LIMIT 1");
    $stmt->bind_param("si", $email, $event_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $existing = $result->fetch_assoc();

    $existingDocs = [];
    if (!empty($existing['documents'])) {
        $existingDocs = json_decode($existing['documents'], true);
        if (!is_array($existingDocs)) $existingDocs = [];
    }

    // Handle new uploads
    $newDocs = [];
    if (isset($_FILES['documents'])) {
        foreach ($_FILES['documents']['name'] as $docName => $fileName) {
            if (!empty($fileName)) {
                $tmpName = $_FILES['documents']['tmp_name'][$docName];
                $safeName = time() . "_" . basename($fileName);
                $uploadDir = "../uploads/events/";
                if (!is_dir($uploadDir)) mkdir($uploadDir, 0777, true);
                $uploadPath = $uploadDir . $safeName;

                if (move_uploaded_file($tmpName, $uploadPath)) {
                    $newDocs[$docName] = $safeName;
                }
            }
        }
    }

    // Merge existing + new docs
    $allDocs = array_merge($existingDocs, $newDocs);
    $documentsJson = json_encode($allDocs);

    // Update DB
    $updateStmt = $conn->prepare("UPDATE registrations SET documents=? WHERE email=? AND event_id=?");
    $updateStmt->bind_param("ssi", $documentsJson, $email, $event_id);

    if ($updateStmt->execute()) {
        echo json_encode(['status' => 'success', 'message' => 'Documents updated!', 'uploaded' => $newDocs]);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Failed to update documents']);
    }
}
function login($conn)
{
    // Get POST data
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';

    // Check if fields are empty
    if (empty($email) || empty($password)) {
        echo json_encode(['status' => 'error', 'message' => 'Email and password are required.']);
        return;
    }

    // Prepare SQL to prevent SQL injection
    $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if user exists
    if ($result->num_rows === 0) {
        echo json_encode(['status' => 'error', 'message' => 'Invalid email or password.']);
        return;
    }

    $user = $result->fetch_assoc();

    // Verify password (assuming passwords are hashed)
    if (password_verify($password, $user['password'])) {
        // ✅ Successful login: set session
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['user_name'] = $user['name'];
        $_SESSION['user_role'] = $user['role'];
        $_SESSION['user_email'] = $user['email'];

        // 👉 Update last_login with current date & time
        $update = $conn->prepare("UPDATE users SET last_login = NOW() WHERE id = ?");
        $update->bind_param("i", $user['id']);
        $update->execute();

        // ✅ Return JSON only (JS will handle redirection)
        echo json_encode([
            'status' => 'success',
            'message' => 'Login successful!',
            'result' => [
                'id' => $user['id'],
                'name' => $user['name'],
                'email' => $user['email'],
                'role' => $user['role']
            ]
        ]);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Invalid email or password.']);
    }
}

function getUser($conn)
{
    // session_start();
    if (isset($_SESSION['user_id'])) {
        echo json_encode([
            'status' => 'success',
            'id' => $_SESSION['user_id'],
            'name' => $_SESSION['user_name'],
            'email' => $_SESSION['user_email'],
        ]);
    } else {
        echo json_encode([
            'status' => 'error',
            'message' => 'Not logged in'
        ]);
    }
}

function getuserstable($conn)
{
    $stmt = $conn->prepare("SELECT * FROM users");
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if no users exist
    if ($result->num_rows === 0) {
        echo json_encode(['status' => 'error', 'message' => 'No users found.']);
        return;
    }

    $users = [];
    while ($row = $result->fetch_assoc()) {
        $users[] = $row;
    }

    // ✅ Return JSON with all users
    echo json_encode([
        'status' => 'success',
        'message' => 'Users fetched successfully!',
        'result' => $users
    ]);
}

// to add users manually   
function addUser($conn)
{
    $adminKey = $_POST['admin_key'] ?? '';
    if ($adminKey !== 'mySecretKey123') {
        echo json_encode(['status' => 'error', 'message' => 'Access denied!']);
        return;
    }

    $name = $_POST['name'] ?? '';
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';
    $role = $_POST['role'] ?? 'admin'; // ✅ default admin

    if (!$name || !$email || !$password) {
        echo json_encode(['status' => 'error', 'message' => 'All fields are required!']);
        return;
    }

    $hashed = password_hash($password, PASSWORD_DEFAULT);

    $stmt = $conn->prepare("INSERT INTO users (name, email, password, role) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $name, $email, $hashed, $role);

    if ($stmt->execute()) {
        echo json_encode(['status' => 'success', 'message' => 'User added successfully!']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Database error: ' . $stmt->error]);
    }
}
function updateUser($conn)
{
    $adminKey = $_POST['admin_key'] ?? '';
    if ($adminKey !== 'mySecretKey123') {
        echo json_encode(['status' => 'error', 'message' => 'Access denied!']);
        return;
    }

    $id = $_POST['id'] ?? '';
    $name = $_POST['name'] ?? '';
    $email = $_POST['email'] ?? '';
    $password = trim($_POST['password'] ?? ''); // new password (optional)

    if (!$id || !$name || !$email) {
        echo json_encode(['status' => 'error', 'message' => 'Name and Email are required!']);
        return;
    }

    if ($password !== "") {
        $hashed = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $conn->prepare("UPDATE users SET name=?, email=?, password=? WHERE id=? AND role='admin'");
        $stmt->bind_param("sssi", $name, $email, $hashed, $id);
        $passwordChanged = true;
    } else {
        $stmt = $conn->prepare("UPDATE users SET name=?, email=? WHERE id=? AND role='admin'");
        $stmt->bind_param("ssi", $name, $email, $id);
        $passwordChanged = false;
    }

    if ($stmt->execute()) {
        echo json_encode([
            'status' => 'success',
            'message' => $passwordChanged ? 'User updated successfully (Password changed).' : 'User updated successfully (Password unchanged).'
        ]);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Database error: ' . $stmt->error]);
    }
}


function deleteUser($conn)
{
    $adminKey = $_POST['admin_key'] ?? '';
    if ($adminKey !== 'mySecretKey123') {
        echo json_encode(['status' => 'error', 'message' => 'Access denied!']);
        return;
    }

    $id = $_POST['id'] ?? '';
    if (!$id) {
        echo json_encode(['status' => 'error', 'message' => 'User ID is required!']);
        return;
    }

    $stmt = $conn->prepare("DELETE FROM users WHERE id=? AND role='admin'");
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        echo json_encode(['status' => 'success', 'message' => 'User deleted successfully!']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Database error: ' . $stmt->error]);
    }
}

function logout($conn)
{
    // session_start();
    session_unset();
    session_destroy();

    echo json_encode([
        'status' => 'success',
        'message' => 'Logged out successfully!'
    ]);
}
function sendMessage($name, $email, $message)
{
    if (empty($name) || empty($email) || empty($message)) {
        return ["status" => "error", "message" => "All fields are required"];
    }
    $mail = new PHPMailer(true);
    try {
        // Enable verbose debug output (for troubleshooting)
        $mail->SMTPDebug = 2; // Change to 0 in production
        $mail->Debugoutput = function ($str, $level) {
            error_log("PHPMailer Debug [$level]: $str");
        };

        // Server settings
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'anjalikushwah3333@gmail.com';   // your Gmail
        $mail->Password   = 'zegwsoghhjzzvqwr';        // 16-char Gmail App Password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;  // or 'tls'
        $mail->Port       = 587;

        // Recipients
        $mail->setFrom('anjalikushwah3333@gmail.com', $name); // must be Gmail address!
        $mail->addReplyTo($email, $name); // user's email set as reply-to
        $mail->addAddress('anjalikushwah3333@gmail.com'); // where you want the message

        // Content
        $mail->isHTML(false);
        $mail->Subject = "New Contact Form Message from $name";
        $mail->Body    = "Name: $name\nEmail: $email\n\nMessage:\n$message";

        $mail->send();
        return ["status" => "success", "message" => "Message sent successfully!"];
    } catch (Exception $e) {
        return [
            "status"  => "error",
            "message" => "Mailer Error: " . $mail->ErrorInfo
        ];
    }
}

function saveOrUpdateEventHistory($conn)
{
    $event_id    = $_POST['event_id'];
    $summary     = $_POST['summary'] ?? '';
    $highlights  = $_POST['highlights'] ?? '';
    $attendees   = ($_POST['attendees'] !== '') ? intval($_POST['attendees']) : 0;
    $guests      = $_POST['guests'] ?? '';
    $budget      = ($_POST['budget'] !== '') ? floatval($_POST['budget']) : 0;
    $longSummary = $_POST['long_summary'] ?? '';
    $lessons     = $_POST['lessons'] ?? '';

    // ✅ Folder for this event
    $uploadDir = "../uploads/history/event_$event_id/";
    if (!is_dir($uploadDir)) mkdir($uploadDir, 0777, true);

    // New media to store (start empty)
    $mediaLinks = ['photos' => [], 'videos' => []];

    // Handle photos
    if (!empty($_FILES['photos']['name'][0])) {
        foreach ($_FILES['photos']['name'] as $i => $name) {
            $tmpName  = $_FILES['photos']['tmp_name'][$i];
            $fileName = uniqid() . "_" . basename($name);
            $filePath = $uploadDir . $fileName;

            if (move_uploaded_file($tmpName, $filePath)) {
                $mediaLinks['photos'][] = "/uploads/history/event_$event_id/" . $fileName;
            }
        }
    }

    // Handle videos
    if (!empty($_FILES['videos']['name'][0])) {
        foreach ($_FILES['videos']['name'] as $i => $name) {
            $tmpName  = $_FILES['videos']['tmp_name'][$i];
            $fileName = uniqid() . "_" . basename($name);
            $filePath = $uploadDir . $fileName;

            if (move_uploaded_file($tmpName, $filePath)) {
                $mediaLinks['videos'][] = "/uploads/history/event_$event_id/" . $fileName;
            }
        }
    }

    // ✅ Check if history exists already
    $stmt = $conn->prepare("SELECT media_links FROM history WHERE event_id=?");
    $stmt->bind_param("i", $event_id);
    $stmt->execute();
    $res = $stmt->get_result();

    if ($res->num_rows) {
        $existing = json_decode($res->fetch_assoc()['media_links'], true) ?? ['photos' => [], 'videos' => []];

        // Only keep existing photos if no new photos uploaded
        if (empty($mediaLinks['photos'])) {
            $mediaLinks['photos'] = $existing['photos'] ?? [];
        }

        // Only keep existing videos if no new videos uploaded
        if (empty($mediaLinks['videos'])) {
            $mediaLinks['videos'] = $existing['videos'] ?? [];
        }
    }

    // Now $mediaLinks contains exactly what should be stored
    $mediaJson = json_encode($mediaLinks, JSON_UNESCAPED_SLASHES);


    // ✅ Save/Update history
    $sql = "INSERT INTO history 
             (event_id, summary, highlights, attendees_count, guests, budget_spent, long_summary, lessons_learned, media_links, created_at)
             VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, NOW())
             ON DUPLICATE KEY UPDATE 
               summary=VALUES(summary),
               highlights=VALUES(highlights),
               attendees_count=VALUES(attendees_count),
               guests=VALUES(guests),
               budget_spent=VALUES(budget_spent),
               long_summary=VALUES(long_summary),
               lessons_learned=VALUES(lessons_learned),
               media_links=VALUES(media_links),
               created_at=NOW()";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param(
        "issisdsss",
        $event_id,
        $summary,
        $highlights,
        $attendees,
        $guests,
        $budget,
        $longSummary,
        $lessons,
        $mediaJson
    );

    if ($stmt->execute()) {
        echo "success|History saved/updated successfully!";
    } else {
        echo "error|" . $stmt->error;
    }
}


function getEventsWithHistory($conn)
{
    $sql = "
    SELECT 
        e.id, e.title, e.category, e.description, e.date, e.author, 
        e.venue, e.image, e.fees, e.contact,
        h.summary, 
        h.highlights, 

        h.attendees_count AS attendees,   -- alias for JS
        h.guests, 
        h.budget_spent AS budget,         -- alias for JS
        h.long_summary,   -- alias for JS
        h.lessons_learned AS lessons,     -- alias for JS
        h.media_links, 
        h.created_at
    FROM events e
    LEFT JOIN history h ON e.id = h.event_id
    ORDER BY e.date DESC
    ";

    $result = $conn->query($sql);
    $data = [];

    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }

    header('Content-Type: application/json');
    echo json_encode($data);
}
function getEventWithHistory($conn, $event_id)
{
    $sql = "
    SELECT 
        e.id, e.title, e.category, e.description, e.date, e.author, 
        e.venue, e.image, e.fees, e.contact,
        h.summary, 
        h.highlights, 
        h.attendees_count AS attendees,
        h.guests, 
        h.budget_spent AS budget,
        h.long_summary AS long_summary, 
        h.lessons_learned AS lessons,
        h.media_links, 
        h.created_at
    FROM events e
    LEFT JOIN history h ON e.id = h.event_id
    WHERE e.id = ?
    LIMIT 1
    ";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $event_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $data = $result->fetch_assoc(); // single row

    header('Content-Type: application/json');
    echo json_encode($data);
}
