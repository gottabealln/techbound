<?php
require_once __DIR__ . '/../config/site.php'; // Adjust path if site.php is elsewhere
require_once __DIR__ . '/lib/auth.php';
admin_session_start();
admin_logout();
header('Location: ' . admin_url('login.php'));
exit;