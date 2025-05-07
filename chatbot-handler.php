<?php
require_once __DIR__ . '/vendor/autoload.php';

putenv('GEMINI_API_KEY=AIzaSyBW1cOKo7xcuVoEWWtYGzpRlBOMoKJEY7c');

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

$apiKey = getenv('GEMINI_API_KEY');
if (!$apiKey) {
    echo json_encode(['error' => 'API key tidak ditemukan.']);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $userMessage = $_POST['message'] ?? '';

    if (empty($userMessage)) {
        echo json_encode(['error' => 'Pesan tidak boleh kosong.']);
        exit;
    }

    $guideText = "
        // Tambahkan panduan Anda di sini
    ";

    $prompt = "
        Kamu adalah asisten virtual yang membantu pengguna dengan informasi tentang sistem informasi, Nama kamu adalah ELBi.
        Gunakan panduan di bawah ini untuk membantu menjawab pertanyaan. Berikan jawaban yang jelas dan ringkas.
        {$guideText}

        Pertanyaan:
        {$userMessage}
    ";

    $url = "https://generativelanguage.googleapis.com/v1beta/models/gemini-2.0-flash:generateContent?key=" . $apiKey;

    $data = [
        "contents" => [
            [
                "parts" => [
                    ["text" => $prompt]
                ]
            ]
        ]
    ];

    $options = [
        "http" => [
            "method" => "POST",
            "header" => "Content-Type: application/json",
            "content" => json_encode($data)
        ]
    ];

    $context = stream_context_create($options);
    $response = file_get_contents($url, false, $context);

    if ($response === FALSE) {
        echo json_encode(['error' => 'Gagal menghubungi API Gemini.']);
        exit;
    }

    $result = json_decode($response, true);
    $reply = $result['candidates'][0]['content']['parts'][0]['text'] ?? 'Tidak ada respon.';

    echo json_encode(['reply' => $reply]);
    exit;
}