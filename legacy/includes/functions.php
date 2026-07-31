<?php
/**
 * Emmanuel Amadi Portfolio Helper Functions
 */

function get_firebase_database() {
    global $firebaseDatabase;

    if (!$firebaseDatabase) {
        throw new RuntimeException('Firebase database is not available.');
    }

    return $firebaseDatabase;
}

function normalize_firebase_items($snapshot) {
    $items = [];

    if (!$snapshot || !$snapshot->exists()) {
        return $items;
    }

    $value = $snapshot->getValue();
    if (!is_array($value)) {
        return $items;
    }

    foreach ($value as $id => $item) {
        if (!is_array($item)) {
            continue;
        }

        $item['id'] = $id;
        $items[] = $item;
    }

    return $items;
}

function firebase_list($path, $database = null) {
    $db = $database ?: get_firebase_database();
    $snapshot = $db->getReference($path)->getSnapshot();
    return normalize_firebase_items($snapshot);
}

function firebase_create($path, $data, $database = null) {
    $db = $database ?: get_firebase_database();
    $reference = $db->getReference($path)->push($data);
    return $reference->getKey();
}

function firebase_update($path, $id, $data, $database = null) {
    $db = $database ?: get_firebase_database();
    $db->getReference($path . '/' . $id)->update($data);
    return true;
}

function firebase_delete($path, $id, $database = null) {
    $db = $database ?: get_firebase_database();
    $db->getReference($path . '/' . $id)->remove();
    return true;
}

function get_categories($database = null) {
    $items = firebase_list('categories', $database);

    usort($items, function ($a, $b) {
        return strcmp($a['name'] ?? '', $b['name'] ?? '');
    });

    return $items;
}

function get_projects($database = null, $limit = null) {
    $items = firebase_list('projects', $database);
    $categories = [];

    foreach (get_categories($database) as $category) {
        $categories[$category['id']] = $category;
    }

    foreach ($items as $index => $project) {
        $category = $categories[$project['category_id']] ?? [];
        $items[$index]['category_name'] = $category['name'] ?? '';
        $items[$index]['category_slug'] = $category['slug'] ?? '';
    }

    usort($items, function ($a, $b) {
        return strtotime($b['created_at'] ?? 'now') <=> strtotime($a['created_at'] ?? 'now');
    });

    if ($limit !== null) {
        $items = array_slice($items, 0, (int) $limit);
    }

    return $items;
}

function get_reviews($database = null) {
    $items = firebase_list('reviews', $database);

    usort($items, function ($a, $b) {
        return strtotime($b['created_at'] ?? 'now') <=> strtotime($a['created_at'] ?? 'now');
    });

    return $items;
}

function ensure_default_admin($database = null) {
    $db = $database ?: get_firebase_database();
    $admins = firebase_list('admins', $db);

    if (!empty($admins)) {
        return $admins[0];
    }

    $username = defined('ADMIN_USERNAME') ? ADMIN_USERNAME : 'admin';
    $password = defined('ADMIN_PASSWORD') ? ADMIN_PASSWORD : 'admin123';

    firebase_create('admins', [
        'username' => $username,
        'password' => password_hash($password, PASSWORD_DEFAULT),
    ], $db);

    return ['username' => $username];
}

function verify_admin($database = null, $username, $password) {
    $db = $database ?: get_firebase_database();
    $admins = firebase_list('admins', $db);

    foreach ($admins as $admin) {
        if (($admin['username'] ?? '') === $username && password_verify($password, $admin['password'] ?? '')) {
            $admin['id'] = $admin['id'] ?? '';
            return $admin;
        }
    }

    return null;
}

function get_requests($database = null) {
    $items = firebase_list('contact_requests', $database);

    usort($items, function ($a, $b) {
        return strtotime($b['created_at'] ?? 'now') <=> strtotime($a['created_at'] ?? 'now');
    });

    return $items;
}

function count_unread_requests($database = null) {
    $requests = get_requests($database);
    $count = 0;

    foreach ($requests as $request) {
        if (($request['status'] ?? 'unread') === 'unread') {
            $count++;
        }
    }

    return $count;
}

function upload_file_to_remote($file, $url = 'https://crystalsbusinesssolution.com/file_upload_api/upload.php') {
    if (!is_array($file) || empty($file['tmp_name']) || !is_uploaded_file($file['tmp_name'])) {
        return false;
    }

    $postFields = [];
    $fieldNames = ['file', 'image', 'upload'];

    foreach ($fieldNames as $fieldName) {
        $postFields[$fieldName] = new CURLFile(
            $file['tmp_name'],
            $file['type'] ?: 'application/octet-stream',
            $file['name'] ?: 'upload'
        );
    }

    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $postFields);
    curl_setopt($ch, CURLOPT_TIMEOUT, 60);

    $response = curl_exec($ch);
    $curlError = curl_error($ch);
    curl_close($ch);

    if ($response === false || !empty($curlError)) {
        return false;
    }

    $decoded = json_decode($response, true);
    if (is_array($decoded)) {
        foreach (['url', 'file_url', 'image_url', 'path', 'data'] as $key) {
            if (!empty($decoded[$key])) {
                return $decoded[$key];
            }
        }

        if (!empty($decoded['result']['url'])) {
            return $decoded['result']['url'];
        }
    }

    if (filter_var($response, FILTER_VALIDATE_URL)) {
        return $response;
    }

    if (preg_match('#https?://[^\s"\']+#i', $response, $matches)) {
        return $matches[0];
    }

    return false;
}

function resolve_media_url($value) {
    if (empty($value)) {
        return '';
    }

    if (filter_var($value, FILTER_VALIDATE_URL)) {
        return $value;
    }

    return 'uploads/' . ltrim($value, '/');
}
?>
