<?php  
  
use Illuminate\Http\Request;  
  
// Controllo temporaneo per debug delle variabili d'ambiente  
if (isset($_GET['debug-env'])) {  
    header('Content-Type: application/json');  
    echo json_encode([  
        'DB_HOST' => getenv('DB_HOST') ?: 'NOT SET',  
        'DB_DATABASE' => getenv('DB_DATABASE') ?: 'NOT SET',  
        'DB_USERNAME' => getenv('DB_USERNAME') ?: 'NOT SET',  
        'DB_PASSWORD' => getenv('DB_PASSWORD') ? 'SET' : 'NOT SET'  
    ]);  
    exit;  
}  
  
// Controllo per verificare che l'autoloader esista  
if (isset($_GET['debug-composer'])) {  
    header('Content-Type: application/json');  
    $composerCheck = [  
        'autoload_exists' => file_exists(__DIR__.'/../vendor/autoload.php'),  
        'vendor_dir_exists' => file_exists(__DIR__.'/../vendor'),  
        'vendor_dir_is_dir' => is_dir(__DIR__.'/../vendor'),  
        'vendor_count' => file_exists(__DIR__.'/../vendor') ? count(glob(__DIR__.'/../vendor/*')) : 0  
    ];  
    echo json_encode($composerCheck);  
    exit;  
}  
  
// Bootstrap Laravel e gestisci la richiesta...  
/** @var Illuminate\Contracts\Foundation\Application $app */  
$app = require_once __DIR__.'/../bootstrap/app.php';  
  
$app->handleRequest(Request::capture()); 
