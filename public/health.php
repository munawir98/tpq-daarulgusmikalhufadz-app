<?php
// Simple health check that bypasses Laravel entirely
http_response_code(200);
header('Content-Type: application/json');
echo json_encode(['status' => 'ok', 'timestamp' => date('c')]);
exit;
