<?php 
require_once($_SERVER["DOCUMENT_ROOT"]."/simpacweb/inc/configuration.php"); 
require_once('qrlib.php'); 
require_once('qrconfig.php'); 

 // how to save PNG codes to server 
$tempDir = EXAMPLE_TMP_URLRELPATH; 
     
$codeContents = '123456DEMSDASDASDO ADASD123456DEMSDASDASDO ADASD123456DEMSDASDASDO ADASD123456DEMSDASDASDO ADASD 123456DEMSDASDASDO ADASD123456DEMSDASDASDO ADASD123456DEMSDASDASDO ADASD123456DEMSDASDASDO ADASD'; 
 
// generating 
QRcode::png($codeContents, QRCODE.".png", QR_ECLEVEL_L, 4); 

echo "<img src='QRCODE.png'>";

?>