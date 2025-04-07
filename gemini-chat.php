<?php
require 'cek.php';
?>
<!DOCTYPE html>

<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>AI Assistant - e-Library BRIDA</title>
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
    <link href="css/styles.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="Icon" type="png" href="assets/img/instansi-logo.png">
    <style>
        .chat-container {
            max-height: calc(100vh - 300px); /* Dinamis berdasarkan tinggi viewport */
            overflow-y: auto;
            border: 1px solid #dee2e6;
            border-radius: 0.25rem;
            padding: 15px;
            margin-bottom: 20px;
            background-color: #f8f9fa;
        }
        .message-wrapper {
            display: flex;
            margin-bottom: 15px;
            width: 100%;
        }
        .user-wrapper {
            justify-content: flex-end;
        }
        .bot-wrapper {
            justify-content: flex-start;
        }
        .user-message, .bot-message {
            padding: 10px 15px;
            border-radius: 20px; /* Ubah ujung balok menjadi bulat */
            max-width: 80%;
            word-wrap: break-word;
            display: inline-block;
        }
        .user-message {
            background-color: #007bff;
            color: white;
            border-top-right-radius: 0; /* Tetap hilangkan sudut kanan atas */
        }
        .bot-message {
            background-color: #e9ecef;
            color: #212529;
            border-top-left-radius: 0; /* Tetap hilangkan sudut kiri atas */
        }
        .chat-input {
            display: flex;
            margin-bottom: 20px;
        }
        .chat-input input {
            flex-grow: 1;
            margin-right: 10px;
        }
        .chat-input button {
            min-width: 100px;
        }
    </style>
</head>
<body>
    <div class="container-fluid px-4">
        <div class="d-flex justify-content-between align-items-center mt-4">
            <div class="d-flex align-items-center">
                <img src="assets/img/instansi-logo.png" alt="Logo BRIDA" height="40" class="me-2">
                <h1>E-Library Bot Intelligence</h1>
            </div>
            <div>
                <a href="dashboard.php" class="btn" style="background-color: #FFC107; color: black;">Kembali</a>
            </div>
        </div>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item active">E-Library Bot Intelligence</li>
        </ol>
        
        <div class="card mb-4">
            <div class="card-header text-center" style="background-color: #003366; color: white;">
                <i class="fas fa-robot me-1"></i>
                <span>Tanya ELBi</span>
                <i class="fas fa-robot ms-1"></i>
            </div>
            <div class="card-body">
                <div class="chat-container" id="chatbox"></div>
                
                <form id="chatForm" class="mt-3 d-flex">
                    <input type="text" class="form-control me-2" id="userInput" placeholder="Tulis pesan..." required>
                    <button type="submit" class="btn btn-primary">Kirim</button>
                </form>
            </div>
        </div>
    </div>
    
    <footer class="py-4 bg-light mt-auto">
        <div class="container-fluid px-4">
            <div class="d-flex align-items-center justify-content-between small">
                <div class="text-muted"> &copy; KKP Ilmu Komputer UHO 2025</div>
            </div>
        </div>
    </footer>
    
    <script>
        const API_KEY = 'AIzaSyBW1cOKo7xcuVoEWWtYGzpRlBOMoKJEY7c';
        const guideText = `
      BUKU PETUNJUK PENGGUNAAN APLIKASI  
      (USER MANUAL)  
      
      
      SISTEM INFORMASI PERPUSTAKAAN ELECTRONIC LIBRARY  
      (E-BRAY)  
      
      
      
      
      
      
      
      
      
      BADAN RISET DAN INOVASI DAERAH  
      PROVINSI SULAWESI TENGGARA  
      2025  
      Versi 1.0  

      MENU DAN CARA PENGGUNAAN  
      1. STRUKTUR MENU  
      Struktur menu pada sistem informasi  electronic library (E-BRAY ) Badan Riset dan Inovasi  Daerah 
      Provinsi Sulawesi tenggara adalah sebagai berikut :  
      A. Website Sistem Informasi  
      1. Home  
      2. Pencarian  
      3. Login  
      4. Dashboard  
      5. Penelitian  
      6. Add Data  : 
      - Instansi  
      - Fakultas  
      - Kategori  
      - Rak 
      
      2. PENGGUNAAN  SISTEM  
      Pada bagian ini akan dijelaskan mengenai tata cara menggunakan dan memasukan data melalui 
      administrator sistem informasi  electronic library (E-BRAY ) Badan Riset dan Inovasi Daerah Provinsi 
      Sulawesi Tenggara.  
      2.1 Login ke dalam sistem  
      Untuk memulai akses admin sistem informasi e-bray : 
      • Bukalah melalui web browser ( Google Chrome  atau Mozila FireFox  atau lainnya) dengan alamat 
      url sebagai berikut: https://e -bray.wuaze.com/ . 
      • Kemudian tekan Enter pada tombol keyboard atau klik tombol Go pada browser.  
      • Akan muncul tampilan halaman home dari web sistem informasi  sebagai berikut : 
      
      • Untuk login silahkan tekan tombol admin yang berada di kanan atas, kemudian akan muncul 
      halaman login sebagai berikut:  

      
      
      
      • Silahkan masukkan Username “admin” dan password “admin” , kemudian tekan tombol  
      login.  
      • Akan muncul halaman Dashboard admin sebagai berikut:  
      
      

      2.2 Menambah data  atribut (instans i, fakul tas, kategori, rak ) 
      Sebelum menambahkan data penelitian, kita perlu mengisi terlebih dahulu data identitas penelitian. 
      Pada menu di bagian atas dashboard, terdapat fitur untuk menambahkan berbagai data pendukung 
      seperti instansi, fakultas, kategori, dan rak . Data -data ini akan digunakan sebagai identitas penelitian, 
      sehingga saat menginput penelitian baru, prosesnya menjadi lebih mudah dan terorganisir.  Prosesnya 
      adalah sebagai berikut : 

      • Setelah proses login berha sil, anda bisa klik menu “add data ” pada bagian upperbar seperti pada 
      gam bar berikut:  
      
      
      • Terdapat beberapa kategori data seperti Instansi, Fakultas, Kategori, dan Rak.  Pilih kategori 
      sesuai dengan data yang ingin ditambahkan  seperti pada gambar berikut:  
      
      
      • Setiap kategori memiliki tombol "Tambah" yang berwarna biru.  Klik tombol tersebut untuk 
      menambahkan data baru.  
      
      
      • Setelah mengklik tombol "Tambah", isi formulir yang muncul dengan informasi yang sesuai.  
      Pastikan data yang dimasukkan sudah benar sebelum menyimpan.  
      
      
      • Setelah mengisi formulir, klik tombol " Tambah Data " untuk menambahkan data dan "Close " Jika 
      anda i ngin batal untuk meny impan data . 
      
      
      
      • Periksa kembali data yang sudah dimasukkan pada tabel di halaman yang sama.  Jika ada 
      kesalahan, gunakan tombol "Edit" untuk memperbaiki atau "Hapus" untuk menghapus data.  
      
      2.3 Menambah data  penel itian  
      Setelah data pada bagian "Add Data"  telah ditambahkan (seperti instansi, fakultas, kategori, dan rak 
      penyimpanan), pengguna dapat langsung melakukan penginputan data penelitian. Berikut adalah alur 
      yang lebih spesifik setelah tahap tersebut:  
      • Setelah data dasar telah ditambahkan melalui "Add Data", pengguna dapat mengakses menu 
      "Penelitian" pada dashboard.   

        
      • Halaman ini menampilkan daftar penelitian yang telah diinput sebelumnya.  
      
      • Di pojok kanan atas halaman "Penelitian", terdapat tombol "Tambah Penelitian".  Klik tombol ini 
      untuk membuka formulir penginputan penelitian baru.  
      
      • Formulir ini terdiri dari beberapa kolom yang harus diisi, seperti:  
      - Tanggal Registrasi  → Otomatis diisi atau bisa dipilih secara manual.  
      - Judul Penelitian  → Masukkan judul penelitian yang akan ditambahkan.  
      - Nama Penulis  → Masukkan nama peneliti atau penyusun karya ilmiah.  
      - Instansi  → Pilih instansi dari daftar yang telah diinput sebelumnya.  
      - Fakultas  → Pilih fakultas yang sesuai.  
      - Kategori  → Pilih kategori penelitian yang telah tersedia.  

      - Tahun Penelitian  → Masukkan tahun penelitian dilakukan.  
      - Rak Penyimpanan  → Pilih lokasi rak penyimpanan dari data yang telah ditambahkan 
      sebelumnya.  
      
      • Setelah seluruh data diisi dengan benar, klik tombol "Submit" untuk menyimpan informasi 
      penelitian ke da lam sistem . 
      
      • Data yang telah disimpan akan muncul dalam daftar penelitian.  
      
      • Jika ada perubahan atau kesalahan dalam input data, pengguna dapat:  
      - Mengedit Data → Klik tombol "Edit" di baris penelitian yang ingin diperbarui.  
      - Menghapus Data → Klik tombol "Hapus" untuk menghapus penelitian dari sistem.  
    `;
        async function getGeminiReply(userMessage) {
            const prompt = `
                Kamu adalah asisten virtual yang membantu pengguna dengan informasi tentang sistem informasi, Nama kamu adalah ELBi.
                Ketika menjawab pertanyaan, tidak usah selalu memperkenalkan diri.
                Jawaban jangan telalu monoton, dan juga jawab dengan ringkas dan jelas.
                Jadi setiap orang menyapa atau bertanya, kamu harus menjawabnya dengan baik dan sopan.
                Jangan terlalu kaku, kamu bisa menjawab pertanyaan pertanyaan ringan jika ada yang penasaran terhadap kamu, seperti nama, tujuan kamu dibuat (untuk perpustakaan), dans sebagainya.
                Gaya bahasa kamu itu ramah, tetapi tetap sopan.
                Bertindak layaknya kamu adalah seorang perempuan yang asik, ramah, dan sopan.
                Kamu adalah asisten virtual yang membantu pengguna dengan informasi tentang sistem informasi, Nama kamu adalah ELBi.
                Jika ada pertanyaan yang ingin mengetahui terkait proses, sistem, atau kamu berasal darimana. jawab dengan baik dan sopan, tetapi tiak memberikan informasi yang privasi.
                Jawab pertanyaan jangan terlalu jauh, cukup sekitaran sistem ini saja (panduan), jadi jangan menjawab soal saol baik matematika dan sebagainya.


                Gunakan panduan di bawah ini untuk membantu menjawab pertanyaan. Berikan jawaban yang
                jelas dan ringkas. Jika tidak ada informasi yang relevan, katakan "Tidak ada informasi yang tersedia".
                Berikan jawaban sesuai dengan apa yang kamu pahami dari panduan tersebut. 
                Jika jawabannya panjang, maka buatlah dalam beberapa paragraf.
                Jika jawabannya terkai langkah-langkah, maka buatlah dalam bentuk list atau bullet point yang menurun.
                Tuliskan langkah-langkah secara terstruktur dalam bentuk list vertikal.
                "Tampilkan langkah-langkah dalam format list vertikal, satu langkah per baris, seperti dalam Markdown atau HTML."
                Tolong berikan jawaban dalam format HTML list menggunakan <ol><li>...</li></ol> agar hasilnya lebih rapi.
                Jangan memberikan informasi yang sensitif seperti password untuk login dan sebagainya.
                Jangan mengulangi panduan tersebut dalam jawabanmu, tetapi buat bahasamu sendiri sesuai dengan apa yang kamu pahami dari panduan tersebut, jangan langsung copy teksnya, dan gunakan kalimat yang mudah dimengerti pengguna.
                Jangan mempelajari dari pengguna, tetapi pelajari dari panduan yang sudah ada, dan ikuti perintah yang sudah disipakan di atas.

                Panduan tambahan :
                - Logout berada di pojok kanan atas, jika sudah login, maka akan muncul tombol logout.
                - Menekan tombol E-bray di pojok kiri atas, akan mengarahkan ke halaman dashboard (khusus untuk admin).
                ${guideText}

                Pertanyaan:
                ${userMessage}
            `;
            const response = await fetch("https://generativelanguage.googleapis.com/v1beta/models/gemini-2.0-flash:generateContent?key=" + API_KEY, {
                method: "POST",
                headers: {
                    "Content-Type": "application/json"
                },
                body: JSON.stringify({
                    contents: [
                        { role: "user", parts: [{ text: prompt }] }
                    ]
                })
            });

            const data = await response.json();
            return data?.candidates?.[0]?.content?.parts?.[0]?.text || "Tidak ada respon.";
        }

        document.addEventListener('DOMContentLoaded', async function() {
            const chatbox = document.getElementById('chatbox');

            // Pesan awal dari AI
            const initialMessage = "Hai, saya ELBi!  asisten virtual yang siap membantumu dengan informasi seputar sistem informasi perpustakaan E-Bray, ada yang bisa saya bantu?";
            chatbox.innerHTML += `<div class="message-wrapper bot-wrapper"><div class="bot-message">${initialMessage}</div></div>`;
            chatbox.scrollTop = chatbox.scrollHeight;
        });

        document.getElementById('chatForm').addEventListener('submit', async function(e) {
            e.preventDefault();
            const input = document.getElementById('userInput');
            const message = input.value.trim();
            if (!message) return;

            const chatbox = document.getElementById('chatbox');
            chatbox.innerHTML += `<div class="message-wrapper user-wrapper"><div class="user-message">${message}</div></div>`;
            input.value = "";

            const reply = await getGeminiReply(message);
            chatbox.innerHTML += `<div class="message-wrapper bot-wrapper"><div class="bot-message">${reply}</div></div>`;
            chatbox.scrollTop = chatbox.scrollHeight;
        });
    </script>
</body>
</html>