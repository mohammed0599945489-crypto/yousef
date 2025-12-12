<?php

$encryption_method = "AES-256-CBC";

$encryption_key = openssl_random_pseudo_bytes(32);

$iv_length = openssl_cipher_iv_length($encryption_method);
$encryption_iv = openssl_random_pseudo_bytes($iv_length);

session_start();
if (!isset($_SESSION['aes_key'])) {
    $_SESSION['aes_key'] = $encryption_key;
    $_SESSION['aes_iv'] = $encryption_iv;
} else {
    $encryption_key = $_SESSION['aes_key'];
    $encryption_iv = $_SESSION['aes_iv'];
}

$plain_text = isset($_POST['plain_text']) ? $_POST['plain_text'] : '';
$encrypted_text = isset($_POST['encrypted_text']) ? $_POST['encrypted_text'] : '';
$decrypted_result = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['encrypt_action'])) {
        // Encrypt the plain text
        if (!empty($plain_text)) {
            $encrypted_text = openssl_encrypt($plain_text, $encryption_method, $encryption_key, 0, $encryption_iv);
        }
    }
    
    if (isset($_POST['decrypt_action'])) {
        // Decrypt the encrypted text
        if (!empty($encrypted_text)) {
            $decrypted_result = openssl_decrypt($encrypted_text, $encryption_method, $encryption_key, 0, $encryption_iv);
        }
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>AES-256-CBC Encryption Assignment</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
            background-color: #f5f5f5;
        }
        .container {
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        h1, h2, h3 {
            color: #333;
            text-align: center;
        }
        .form-group {
            margin: 20px 0;
        }
        label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
        }
        textarea {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 14px;
            resize: vertical;
            min-height: 100px;
        }
        .buttons {
            text-align: center;
            margin: 30px 0;
        }
        input[type="submit"] {
            padding: 12px 30px;
            margin: 0 10px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            font-weight: bold;
        }
        .encrypt-btn {
            background-color: #4CAF50;
            color: white;
        }
        .decrypt-btn {
            background-color: #2196F3;
            color: white;
        }
        .result-box {
            background-color: #e8f5e9;
            padding: 20px;
            border-radius: 5px;
            margin: 20px 0;
            border-left: 5px solid #4CAF50;
        }
        .info-box {
            background-color: #e3f2fd;
            padding: 15px;
            border-radius: 5px;
            margin: 20px 0;
            font-size: 14px;
        }
        .output {
            background-color: #fff3e0;
            padding: 15px;
            border-radius: 5px;
            margin: 15px 0;
            border: 1px solid #ffb74d;
        }
        .code-box {
            background-color: #263238;
            color: #ffffff;
            padding: 15px;
            border-radius: 5px;
            font-family: monospace;
            font-size: 14px;
            margin: 15px 0;
            overflow-x: auto;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>🔐 AES-256-CBC Encryption System</h1>
        <h2>WEB SECURITY - Lab Assignment</h2>
        <h3>Eng: Suhaib Ibraheem Abu Shaar</h3>
        
        <div class="info-box">
            <strong>Encryption:</strong> Process of converting plain text into ciphertext<br>
            <strong>Decryption:</strong> Process of converting ciphertext back to plain text<br>
            <strong>Algorithm:</strong> AES-256-CBC (Advanced Encryption Standard)
        </div>
        
        <!-- Encryption Form -->
        <form method="POST" action="">
            <div class="form-group">
                <label for="plain_text">Enter Plain Text to Encrypt:</label>
                <textarea id="plain_text" name="plain_text" placeholder="Type your message here..."><?php echo htmlspecialchars($plain_text); ?></textarea>
            </div>
            
            <div class="buttons">
                <input type="submit" name="encrypt_action" value="🔒 Encrypt" class="encrypt-btn">
                <input type="submit" name="decrypt_action" value="🔓 Decrypt" class="decrypt-btn">
            </div>
            
            <div class="form-group">
                <label for="encrypted_text">Encrypted Text (Base64 Output):</label>
                <textarea id="encrypted_text" name="encrypted_text" placeholder="Encrypted text will appear here..."><?php echo htmlspecialchars($encrypted_text); ?></textarea>
            </div>
        </form>
        
        <!-- Decryption Result -->
        <?php if (!empty($decrypted_result)): ?>
            <div class="result-box">
                <h3>Decryption Result:</h3>
                <div class="output">
                    <?php echo htmlspecialchars($decrypted_result); ?>
                </div>
            </div>
        <?php endif; ?>
        
        <!-- PHP Code Example -->
        <div class="code-box">
            // PHP Code for AES-256-CBC Encryption<br>
            $method = "AES-256-CBC";<br>
            $key = openssl_random_pseudo_bytes(32);<br>
            $iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length($method));<br>
            $encrypted = openssl_encrypt($data, $method, $key, 0, $iv);<br>
            $decrypted = openssl_decrypt($encrypted, $method, $key, 0, $iv);
        </div>
        
        <!-- System Information -->
        <div class="info-box">
            <h4>System Information:</h4>
            <p><strong>Encryption Key (Base64):</strong> <?php echo base64_encode($encryption_key); ?></p>
            <p><strong>IV (Base64):</strong> <?php echo base64_encode($encryption_iv); ?></p>
            <p><strong>Key Length:</strong> 32 bytes (256 bits)</p>
            <p><strong>IV Length:</strong> <?php echo $iv_length; ?> bytes</p>
            <p><strong>PHP Version:</strong> <?php echo phpversion(); ?></p>
            <p><strong>OpenSSL Available:</strong> <?php echo extension_loaded('openssl') ? 'Yes' : 'No'; ?></p>
        </div>
        
        <div style="text-align: center; margin-top: 30px; color: #666; font-size: 12px;">
            Islamic University of Gaza - Department of Multimedia and Web Development<br>
            Assignment 1 - Data Encryption and Decryption using AES-256-CBC
        </div>
    </div>
</body>
</html>
