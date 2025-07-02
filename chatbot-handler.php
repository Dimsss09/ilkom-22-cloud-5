<?php
// Memuat file autoload dari Composer
require_once __DIR__ . '/vendor/autoload.php';

// Menetapkan kunci API Gemini secara manual (tidak disarankan dalam produksi)
putenv('GEMINI_API_KEY=AIzaSyBW1cOKo7xcuVoEWWtYGzpRlBOMoKJEY7c');

// Memuat file .env (jika ada) menggunakan library Dotenv
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

// Mengambil API key dari environment variable
$apiKey = getenv('GEMINI_API_KEY');
if (!$apiKey) {
    // Jika API key tidak tersedia, kembalikan error dalam format JSON
    echo json_encode(['error' => 'API key tidak ditemukan.']);
    exit;
}

// Mengecek jika metode request adalah POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Mengambil pesan dari form (POST data)
    $userMessage = $_POST['message'] ?? '';

    // Validasi input: pesan tidak boleh kosong
    if (empty($userMessage)) {
        echo json_encode(['error' => 'Pesan tidak boleh kosong.']);
        exit;
    }

    // Teks panduan tambahan (bisa disesuaikan untuk membentuk jawaban)
    $guideText = "
        // Tambahkan panduan Anda di sini
    ";

    // Prompt untuk dikirim ke model Gemini
    $prompt = "
        Kamu adalah asisten virtual yang membantu pengguna dengan informasi tentang sistem informasi, Nama kamu adalah ELBi.
        Gunakan panduan di bawah ini untuk membantu menjawab pertanyaan. Berikan jawaban yang jelas dan ringkas.
        {$guideText}

        Pertanyaan:
        {$userMessage}
    ";

    // URL endpoint API Gemini 2.0 Flash
    $url = "https://generativelanguage.googleapis.com/v1beta/models/gemini-2.0-flash:generateContent?key=" . $apiKey;

    // Menyusun data permintaan dalam format JSON
    $data = [
        "contents" => [
            [
                "parts" => [
                    ["text" => $prompt]
                ]
            ]
        ]
    ];

    // Opsi HTTP untuk request menggunakan stream context
    $options = [
        "http" => [
            "method" => "POST",
            "header" => "Content-Type: application/json",
            "content" => json_encode($data)
        ]
    ];

    // Membuat stream context untuk dikirim via file_get_contents
    $context = stream_context_create($options);
    $response = file_get_contents($url, false, $context);

    // Jika tidak ada response dari API
    if ($response === FALSE) {
        echo json_encode(['error' => 'Gagal menghubungi API Gemini.']);
        exit;
    }

    // Decode hasil respon API dari JSON
    $result = json_decode($response, true);

    // Ambil isi balasan dari model, jika ada
    $reply = $result['candidates'][0]['content']['parts'][0]['text'] ?? 'Tidak ada respon.';

    // Kirim balasan dalam format JSON
    echo json_encode(['reply' => $reply]);
    exit;
}
