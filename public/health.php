<?php  
header('Content-Type: application/json');  
  
try {  
    $status = array('status' => 'OK', 'timestamp' => date('c'));  
    echo json_encode($status);  
} catch (Exception $e) {  
    http_response_code(500);  
    $error = array('status' => 'ERROR', 'message' => $e->getMessage());  
    echo json_encode($error);  
} 
