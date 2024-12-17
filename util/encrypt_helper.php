<?php
function encrypt_id($id) {
    $key = "BSIT-hrmis-system"; 
    $key = hash('sha256', $key, true); 
    $iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length('AES-256-CBC')); 
    $encrypted = openssl_encrypt($id, 'AES-256-CBC', $key, 0, $iv);
    if ($encrypted === false) {
        throw new Exception("Encryption failed");
    }
    return urlencode(base64_encode($iv . $encrypted));
}

function decrypt_id($encrypted_id) {
    $key = "BSIT-hrmis-system"; 
    $key = hash('sha256', $key, true); 
    $data = base64_decode(urldecode($encrypted_id));
    if ($data === false || strlen($data) <= openssl_cipher_iv_length('AES-256-CBC')) {
        return false; 
    }
    $iv_length = openssl_cipher_iv_length('AES-256-CBC');
    $iv = substr($data, 0, $iv_length); 
    $encrypted = substr($data, $iv_length); 
    return openssl_decrypt($encrypted, 'AES-256-CBC', $key, 0, $iv);
}
?>
