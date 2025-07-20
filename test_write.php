<?php
// Quick test script - save as test_write.php
$upload_dir = "/opt/lampp/htdocs/f/uploads";
$test_file = $upload_dir . "/test_" . date('Y-m-d_H-i-s') . ".txt";

echo "Testing file creation in: $upload_dir<br>";
echo "PHP running as: " . (function_exists('posix_getpwuid') ? posix_getpwuid(posix_geteuid())['name'] : 'unknown') . "<br>";

if (file_put_contents($test_file, "Test successful at " . date('Y-m-d H:i:s'))) {
    echo "<span style='color: green;'>✅ SUCCESS: Test file created at $test_file</span><br>";
    echo "File contents: " . file_get_contents($test_file) . "<br>";
    
    // Clean up
    if (unlink($test_file)) {
        echo "<span style='color: blue;'>🗑️ Test file deleted successfully</span>";
    }
} else {
    echo "<span style='color: red;'>❌ FAILED: Cannot create test file</span><br>";
    echo "Directory writable: " . (is_writable($upload_dir) ? 'YES' : 'NO') . "<br>";
    echo "Directory permissions: " . substr(sprintf('%o', fileperms($upload_dir)), -4) . "<br>";
}
?>