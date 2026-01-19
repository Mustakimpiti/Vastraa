<?php
header('Content-Type: video/mp4');
header('Accept-Ranges: bytes');
header('Access-Control-Allow-Origin: *');

$videoPath = __DIR__ . '/uploads/videos/';
$files = scandir($videoPath);

echo "Videos found:\n";
print_r($files);

// Try to serve the first video
foreach ($files as $file) {
    if (pathinfo($file, PATHINFO_EXTENSION) === 'mp4') {
        echo "\n\nTrying to serve: " . $file;
        readfile($videoPath . $file);
        break;
    }
}
?>