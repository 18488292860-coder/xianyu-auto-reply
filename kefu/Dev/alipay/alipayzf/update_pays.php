<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['newAmount'])) {
    $newAmount = $_POST['newAmount'];
    
    $htmlFilePath = 'index.php';
    
    $htmlContent = file_get_contents($htmlFilePath);
    
    $htmlContent = preg_replace('/<span id="pays">(.*?)<\/span>/i', '<span id="pays">'.$newAmount.'</span>', $htmlContent);
    
    file_put_contents($htmlFilePath, $htmlContent);
    
    header('Location: success.php');
    exit();
} else {
    include 'update_pay.php'; 
}
?>