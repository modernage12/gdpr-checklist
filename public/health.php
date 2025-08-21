<?php  
header('Content-Type: application/json');  
  
try {  
    // Carica l'autoloader di Composer  
    require_once __DIR__.'/../vendor/autoload.php';  
  
    // Carica l'applicazione Laravel  
    $app = require_once __DIR__.'/../bootstrap/app.php';  
  
    // Crea una richiesta di prova  
    $kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);  
  
    $request = Illuminate\Http\Request::capture();  
    $response = $kernel->handle($request);  
  
    $result = array('status' => 'OK', 'timestamp' => date('c'), 'laravel' => 'loaded', 'request_handled' => true, 'response_status' => $response->status());  
    echo json_encode($result);  
} catch (Exception $e) {  
    http_response_code(500);  
    $error = array('status' => 'ERROR', 'message' => $e->getMessage(), 'file' => $e->getFile(), 'line' => $e->getLine());  
    echo json_encode($error);  
} 
