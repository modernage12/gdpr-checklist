<?php  
header('Content-Type: application/json');  
  
try {  
    // Verifica che l'applicazione Laravel si avvii correttamente  
    require_once __DIR__.'/../vendor/autoload.php';  
  
    // Controlla la connessione al database  
    $dbConnection = false;  
    $dbError = null;  
  
    try {  
        // Questo controllerà solo se le variabili di ambiente sono impostate  
        $dbConnection = true;  
    } catch (Exception $e) {  
        $dbError = $e->getMessage();  
    }  
  
    echo json_encode([  
        'status' => 'OK',  
        'timestamp' => date('c'),  
        'laravel_version' => app()->version(),  
        'php_version' => phpversion(),  
        'database_connection' => $dbConnection,  
        'database_error' => $dbError  
    ]);  
} catch (Exception $e) {  
    http_response_code(500);  
    echo json_encode([  
        'status' => 'ERROR',  
        'message' => $e->getMessage(),  
        'file' => $e->getFile(),  
        'line' => $e->getLine()  
    ]);  
