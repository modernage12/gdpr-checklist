<?php  
header('Content-Type: application/json');  
  
// Debug delle variabili d'ambiente usando funzioni PHP standard  
$dbHost = getenv('DB_HOST') ?: 'NOT SET';  
$dbDatabase = getenv('DB_DATABASE') ?: 'NOT SET';  
$dbUsername = getenv('DB_USERNAME') ?: 'NOT SET';  
$dbPassword = getenv('DB_PASSWORD') ? 'SET' : 'NOT SET';  
  
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
