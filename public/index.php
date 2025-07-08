<?php
$expectedUser = 'admin';
$expectedPass = '1234';

$headers = apache_request_headers();
if (!isset($headers['Authorization']) && !isset($_SERVER['PHP_AUTH_USER'])) {
    header('WWW-Authenticate: Basic realm="User CRUD API"');
    http_response_code(401);
    echo json_encode(['error' => 'Authentication required']);
    exit;
}

$user = $_SERVER['PHP_AUTH_USER'] ?? '';
$pass = $_SERVER['PHP_AUTH_PW'] ?? '';

if ($user !== $expectedUser || $pass !== $expectedPass) {
    http_response_code(401);
    echo json_encode(['error' => 'Invalid credentials']);
    exit;
}


require_once __DIR__ . '/../src/User.php';
header('Content-Type: application/json');

$method = $_SERVER['REQUEST_METHOD'];
$path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

if ($method === 'GET' && $path === '/users') {
    echo json_encode(User::all());
    exit;
}

if ($method === 'POST' && $path === '/users') {
    $data = json_decode(file_get_contents('php://input'), true);
    if (!isset($data['name']) || !isset($data['email'])) {
        http_response_code(400);
        echo json_encode(['error' => 'Missing name or email']);
        exit;
    }

    $created = User::create($data['name'], $data['email']);
    echo json_encode(['success' => $created]);
    exit;
}


if ($method === 'DELETE' && $path === '/users') {
    User::deleteAll();
    echo json_encode(['success' => true]);
    exit;
}

http_response_code(404);
echo json_encode(['error' => 'Not found']);
