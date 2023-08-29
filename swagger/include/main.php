<?php
$config = require_once('config.php');
$account = require_once('account.php');
$user = require_once('user.php');
$loan = require_once('loanRequest.php');
$invest = require_once('investRequest.php');
$setting = require_once('settingRequest.php');
$wallet = require_once('wallet.php');
$rating = require_once('ratingRequest.php');
$chat = require_once('chat.php');
$payment = require_once('payment.php');

$array = array_merge(
    $account['paths'],
    $user['paths'],
    $loan['paths'],
    $invest['paths'],
    $wallet['paths'],
    $setting['paths'],
    $rating['paths'],
    $chat['paths'],
    $payment['paths']

);
$definitions = array_merge(
    $account['definitions'],
    $user['definitions'],
    $loan['definitions'],
    $invest['definitions'],
    $wallet['definitions'],
    $setting['definitions'],
    $rating['definitions'],
    $chat['definitions'],
    $payment['definitions']

);
$json = [
    "swagger" => "2.0",
    "info" => [
        "version" => "2.0.0",
        "title" => "Lendkash API"
    ],
    "host" => $config['baseUrl'],
    "basePath" => "/api",
    "schemes" => [

    ],
    "tags" => [

        [
            "name" => 'account',
            "description" => "All account api"
        ],
        [
            "name" => 'user',
            "description" => "All user api"
        ],
        [
            "name" => 'loan',
            "description" => "All loans api"
        ],
        [
            "name" => 'invest',
            "description" => "All invest api"
        ],
        [
            "name" => 'wallet',
            "description" => "All wallet api"
        ],
        [
            "name" => 'setting',
            "description" => "All setting api"
        ],
        [
            "name" => 'rating',
            "description" => "All rating api"
        ],
        [
            "name" => 'chat',
            "description" => "All chat api"
        ],
        [
            "name" => 'payment',
            "description" => "All payment api"
        ],



    ],
    'paths' => $array,
    'definitions' => $definitions
];
echo json_encode($json);

