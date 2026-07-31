<?php
require __DIR__ . '/../vendor/vendor/autoload.php';

use Kreait\Firebase\Factory;

$firebaseDatabase = null;

try {
    $serviceAccountPath = __DIR__ . '/zippy-pay-9092c-firebase-adminsdk-fbsvc-f936c47e59.json';

    if (!file_exists($serviceAccountPath)) {
        throw new RuntimeException('Firebase service account file is missing.');
    }

    $factory = (new Factory)
        ->withServiceAccount($serviceAccountPath)
        ->withDatabaseUri('https://zippy-pay-9092c-default-rtdb.firebaseio.com/');

    $firebaseDatabase = $factory->createDatabase();
} catch (Throwable $e) {
    error_log('Firebase initialization failed: ' . $e->getMessage());
}
?>