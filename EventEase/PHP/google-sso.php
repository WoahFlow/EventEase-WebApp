<?php
require_once 'vendor/autoload.php'; // Include Composer's autoloader

session_start();

// Replace with your credentials
$clientID = '363070854123-d5kc5j3p6hg7gemt1lt8mv74dd6f3i3k.apps.googleusercontent.com';
$clientSecret = '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';
$redirectUri = 'http://localhost/eventease/EventEase/Login-Signup.php';

// Create Google Client
$client = new Google_Client();
$client->setClientId($clientID);
$client->setClientSecret($clientSecret);
$client->setRedirectUri($redirectUri);
$client->addScope("email");
$client->addScope("profile");

// Handle OAuth response
if (isset($_GET['code'])) {
    $token = $client->fetchAccessTokenWithAuthCode($_GET['code']);
    $client->setAccessToken($token);

    // Get user profile info
    $googleService = new Google_Service_Oauth2($client);
    $userInfo = $googleService->userinfo->get();

    // Store user info in session
    $_SESSION['user'] = [
        'id' => $userInfo->id,
        'name' => $userInfo->name,
        'email' => $userInfo->email,
        'picture' => $userInfo->picture,
    ];

    // Redirect to dashboard
    header('Location: dashboard.php');
    exit();
} else {
    // Redirect back to login if no code is provided
    header('Location: Login-Signup.php');
    exit();
}
