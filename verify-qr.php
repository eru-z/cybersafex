<?php
header('Content-Type: application/json');
$data = json_decode(file_get_contents('php://input'), true);

if(code){
    qrResult.textContent = `QR Code detected: ${code.data}`;
    
    // For demo, automatically mark verified
    qrResult.textContent = '✅ QR Verification Successful!';
    document.getElementById('verifiedBadge').style.display = 'block';
} else {
    qrResult.textContent = '❌ No QR code detected in the image.';
}

?>
