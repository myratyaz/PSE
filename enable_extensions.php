<?php

$phpIniPath = 'C:\Users\Murik\Desktop\php-8.2.28-Win32-vs16-x64\php.ini';
$extensions = [
    'extension=php_openssl.dll',
    'extension=php_pdo_pgsql.dll',
    'extension=php_pgsql.dll'
];

// Read the current php.ini content
$content = file_get_contents($phpIniPath);

// Enable each extension
foreach ($extensions as $extension) {
    if (strpos($content, $extension) === false) {
        $content .= "\n" . $extension;
    }
}

// Write back to php.ini
file_put_contents($phpIniPath, $content);

echo "Extensions have been enabled in php.ini\n"; 