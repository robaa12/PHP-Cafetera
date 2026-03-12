<?php
require_once __DIR__ . '/../app/config/Database.php';
require_once __DIR__ . '/../app/controllers/HomeController.php';
require_once __DIR__ . '/../app/controllers/OrderController.php';
function handle_cart_action(OrderController $orderController): void
{
    if (empty($_GET['action']) || empty($_GET['id'])) {
        return;
    }
    // index.php?action=add&id=3   =>  action = add, id = 3
    $action = $_GET['action'];
    $id     = (int) $_GET['id'];

    switch ($action) {
        case 'add':
            $orderController->add($id);
            break;

        case 'plus':
            $orderController->increase($id);
            break;

        case 'minus':
            $orderController->decrease($id);
            break;

        default:
            return;
    }
    // POST/Redirect/GET Pattern
    header("Location: index.php");
    exit();
}

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$action = $_GET['action'] ?? 'home';

switch ($action) {
    case 'add':
    case 'plus':
    case 'minus':
        $db   = new Database();
        $conn = $db->connect();
        $orderController = new OrderController($conn);
        handle_cart_action($orderController);
        break;

    case 'home':
    default:
        $home = new HomeController();
        $home->index();
        break;
}


// Get request URI
$uri = parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH);

// Simple page routing
$pages = [
    "/" => __DIR__ . "/../app/views/user/home.php",
    "/login" => __DIR__ . "/../app/views/auth/login.php",
    "/logout" => __DIR__ . "/../app/views/auth/logout.php",
    "/admin/users" => __DIR__ . "/../app/views/admin/users.php",
    "/admin/add-user" => __DIR__ . "/../app/views/admin/add_user.php",
];

// Check if page exists
if (isset($pages[$uri])) {
    require_once $pages[$uri];
    exit();
}

// 404 Not Found
http_response_code(404);
echo "<h1>404 - Page Not Found</h1>";
echo "<p>Requested: " . htmlspecialchars($uri) . "</p>";
echo '<p><a href="/">Go Home</a></p>';
