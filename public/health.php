<?php  
header('Content-Type: application/json');  
  
// Debug delle variabili d'ambiente  
$dbHost = env('DB_HOST', 'NOT SET');  
$dbDatabase = env('DB_DATABASE', 'NOT SET');  
$dbUsername = env('DB_USERNAME', 'NOT SET');  
$dbPassword = env('DB_PASSWORD', 'NOT SET') ? 'SET' : 'NOT SET';  
  
try {  
    // Carica l'autoloader di Composer  
    require_once __DIR__.'/../vendor/autoload.php';  
  
    // Carica l'applicazione Laravel  
    $app = require_once __DIR__.'/../bootstrap/app.php';  
  
    $result = array(  
        'status' => 'OK',  
        'timestamp' => date('c'),  
        'laravel' => 'loaded',  
        'db_host' => $dbHost,  
        'db_database' => $dbDatabase,  
        'db_username' => $dbUsername,  
        'db_password_set' => $dbPassword  
    );  
    echo json_encode($result);  
} catch (Exception $e) {  
    http_response_code(500);  
    $error = array(  
        'status' => 'ERROR',  
        'message' => $e->getMessage(),  
        'file' => $e->getFile(),  
        'line' => $e->getLine(),  
        'db_host' => $dbHost,  
        'db_database' => $dbDatabase  
    );  
    echo json_encode($error);  
} 
