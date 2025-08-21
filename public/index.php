<?php  
  
use Illuminate\Http\Request;  
  
// Controllo temporaneo per debug delle variabili d'ambiente  
if (isset($_GET['debug-env'])) {  
    header('Content-Type: application/json');  
    echo json_encode([  
        'DB_HOST' => $_ENV['DB_HOST'] ?? $_SERVER['DB_HOST'] ?? getenv('DB_HOST') ?? 'NOT SET',  
        'DB_DATABASE' => $_ENV['DB_DATABASE'] ?? $_SERVER['DB_DATABASE'] ?? getenv('DB_DATABASE') ?? 'NOT SET',  
        'DB_USERNAME' => $_ENV['DB_USERNAME'] ?? $_SERVER['DB_USERNAME'] ?? getenv('DB_USERNAME') ?? 'NOT SET',  
        'DB_PASSWORD' => !empty($_ENV['DB_PASSWORD'] ?? $_SERVER['DB_PASSWORD'] ?? getenv('DB_PASSWORD')) ? 'SET' : 'NOT SET'  
    ]);  
    exit;  
}  
  
// Bootstrap Laravel e gestisci la richiesta...  
/** @var Illuminate\Contracts\Foundation\Application $app */  
$app = require_once __DIR__.'/../bootstrap/app.php';  
  
$app->handleRequest(Request::capture()); 
