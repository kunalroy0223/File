<?php
header('Content-Type: text/plain');

echo "=== File Upload Diagnostic Script ===\n\n";

// Check PHP upload settings
echo "1. PHP Upload Settings:\n";
echo "   upload_max_filesize: " . ini_get('upload_max_filesize') . "\n";
echo "   post_max_size: " . ini_get('post_max_size') . "\n";
echo "   max_file_uploads: " . ini_get('max_file_uploads') . "\n";
echo "   upload_tmp_dir: " . (ini_get('upload_tmp_dir') ?: 'Default system temp') . "\n";
echo "   memory_limit: " . ini_get('memory_limit') . "\n\n";

// Check directory structure and permissions
$upload_dir = "/opt/lampp/htdocs/f/uploads";

echo "2. Directory Analysis:\n";
echo "   Target directory: $upload_dir\n";
echo "   Directory exists: " . (is_dir($upload_dir) ? 'YES' : 'NO') . "\n";

if (is_dir($upload_dir)) {
    echo "   Directory writable: " . (is_writable($upload_dir) ? 'YES' : 'NO') . "\n";
    echo "   Directory permissions: " . substr(sprintf('%o', fileperms($upload_dir)), -4) . "\n";
    echo "   Directory owner: " . (function_exists('posix_getpwuid') ? posix_getpwuid(fileowner($upload_dir))['name'] : fileowner($upload_dir)) . "\n";
} else {
    // Try to create it
    echo "   Attempting to create directory...\n";
    if (mkdir($upload_dir, 0755, true)) {
        echo "   Directory created successfully!\n";
        echo "   Directory permissions: " . substr(sprintf('%o', fileperms($upload_dir)), -4) . "\n";
    } else {
        echo "   FAILED to create directory!\n";
    }
}

echo "\n3. System Information:\n";
echo "   Current user: " . get_current_user() . "\n";
echo "   PHP process owner: " . (function_exists('posix_getpwuid') ? posix_getpwuid(posix_geteuid())['name'] : 'unknown') . "\n";
echo "   Web server: " . ($_SERVER['SERVER_SOFTWARE'] ?? 'unknown') . "\n";
echo "   Operating system: " . php_uname() . "\n";

echo "\n4. Parent Directory Analysis:\n";
$parent_dir = dirname($upload_dir);
echo "   Parent directory: $parent_dir\n";
echo "   Parent exists: " . (is_dir($parent_dir) ? 'YES' : 'NO') . "\n";
echo "   Parent writable: " . (is_writable($parent_dir) ? 'YES' : 'NO') . "\n";

if (is_dir($parent_dir)) {
    echo "   Parent permissions: " . substr(sprintf('%o', fileperms($parent_dir)), -4) . "\n";
    echo "   Parent owner: " . (function_exists('posix_getpwuid') ? posix_getpwuid(fileowner($parent_dir))['name'] : fileowner($parent_dir)) . "\n";
}

echo "\n5. Disk Space:\n";
if (is_dir($upload_dir)) {
    $free_bytes = disk_free_space($upload_dir);
    $total_bytes = disk_total_space($upload_dir);
    echo "   Free space: " . formatBytes($free_bytes) . "\n";
    echo "   Total space: " . formatBytes($total_bytes) . "\n";
} else {
    echo "   Cannot check disk space (directory doesn't exist)\n";
}

echo "\n6. Test File Creation:\n";
if (is_dir($upload_dir) && is_writable($upload_dir)) {
    $test_file = $upload_dir . "/test_write.txt";
    if (file_put_contents($test_file, "Test file creation: " . date('Y-m-d H:i:s'))) {
        echo "   Test file created successfully: $test_file\n";
        // Clean up
        unlink($test_file);
        echo "   Test file deleted\n";
    } else {
        echo "   FAILED to create test file\n";
    }
} else {
    echo "   Cannot test file creation (directory not writable)\n";
}

echo "\n=== End Diagnostic ===\n";

function formatBytes($size, $precision = 2) {
    $base = log($size, 1024);
    $suffixes = array('B', 'KB', 'MB', 'GB', 'TB');
    return round(pow(1024, $base - floor($base)), $precision) . ' ' . $suffixes[floor($base)];
}
?>