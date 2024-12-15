<?php
function encrypt_id($id) {
    $key = "BSIT-hrmis-system"; 
    $key = hash('sha256', $key);
    $iv = openssl_random_pseudo_bytes(16);
    $encrypted = openssl_encrypt($id, 'AES-256-CBC', $key, 0, $iv);
    return urlencode(base64_encode($iv . $encrypted));
}

function decrypt_id($encrypted_id) {
    $key = "BSIT-hrmis-system"; 
    $key = hash('sha256', $key); 
    $data = base64_decode(urldecode($encrypted_id));
    $iv = substr($data, 0, 16); 
    $encrypted = substr($data, 16); 
    return openssl_decrypt($encrypted, 'AES-256-CBC', $key, 0, $iv);
}
?>
