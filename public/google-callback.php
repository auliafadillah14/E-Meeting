<?php
session_start();
require '../config/google-config.php';

if (!isset($_GET['code'])) {
    die('Kode tidak ditemukan');
}

// Ambil token dari Google
$token = $client->fetchAccessTokenWithAuthCode($_GET['code']);

// ✅ Pastikan set access token ke client
$client->setAccessToken($token);

// ✅ Cek kalau token valid
if ($client->isAccessTokenExpired()) {
    die('Token tidak valid atau sudah expired.');
}

// Ambil info user
$oauth = new Google_Service_Oauth2($client);
$google_account_info = $oauth->userinfo->get();

// Simpan ke session
$_SESSION['access_token'] = $token;
$_SESSION['user_id'] = $google_account_info->id;
$_SESSION['user_name'] = $google_account_info->name; // atau email

// Redirect ke dashboard
header("Location: dashboard.php");
exit();