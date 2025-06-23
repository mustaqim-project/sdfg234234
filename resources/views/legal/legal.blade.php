<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Miluv Legal Documents - Kebijakan Privasi & Syarat Ketentuan</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@300;400;500;600;700&family=Orbitron:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            /* Dark Theme (Default) */
            --primary-gradient: linear-gradient(135deg, #ff6b9d, #c44bff, #4facfe);
            --primary-gradient-hover: linear-gradient(135deg, #ff7ba7, #d05cff, #5fb7fe);
            --dark-bg: #0a0a0f;
            --secondary-dark: #121218;
            --accent-purple: #6e3bdc;
            --accent-pink: #ff6b9d;
            --accent-blue: #4facfe;
            --text-primary: #ffffff;
            --text-secondary: rgba(255, 255, 255, 0.8);
            --text-muted: rgba(255, 255, 255, 0.6);
            --glass-bg: rgba(255, 255, 255, 0.05);
            --glass-border: rgba(255, 255, 255, 0.1);
            --container-width: 1200px;
            --transition-speed: 0.4s;
            --border-radius-sm: 10px;
            --border-radius-md: 20px;
            --border-radius-lg: 30px;
            --shadow-sm: 0 5px 15px rgba(0, 0, 0, 0.2);
            --shadow-md: 0 10px 30px rgba(0, 0, 0, 0.3);
            --shadow-lg: 0 20px 40px rgba(0, 0, 0, 0.4);
        }

        /* Light Theme */
        [data-theme="light"] {
            --dark-bg: #f8fafc;
            --secondary-dark: #ffffff;
            --text-primary: #1a202c;
            --text-secondary: rgba(26, 32, 44, 0.8);
            --text-muted: rgba(26, 32, 44, 0.6);
            --glass-bg: rgba(255, 255, 255, 0.8);
            --glass-border: rgba(203, 213, 225, 0.3);
            --shadow-sm: 0 5px 15px rgba(0, 0, 0, 0.1);
            --shadow-md: 0 10px 30px rgba(0, 0, 0, 0.15);
            --shadow-lg: 0 20px 40px rgba(0, 0, 0, 0.2);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Space Grotesk', -apple-system, BlinkMacSystemFont, sans-serif;
            background: var(--dark-bg);
            color: var(--text-primary);
            line-height: 1.6;
            min-height: 100vh;
            position: relative;
            overflow-x: hidden;
            transition: all var(--transition-speed) ease;
        }

        /* Animated Background */
        .bg-container {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: -2;
            background: radial-gradient(ellipse at center, #1a1a2e 0%, #0f0f1a 70%, #000000 100%);
            overflow: hidden;
        }

        [data-theme="light"] .bg-container {
            background: radial-gradient(ellipse at center, #e2e8f0 0%, #f1f5f9 70%, #ffffff 100%);
        }

        .stars {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: -1;
        }

        .star {
            position: absolute;
            background: #ffffff;
            border-radius: 50%;
            animation: twinkle 2s infinite alternate;
        }

        [data-theme="light"] .star {
            background: var(--accent-pink);
            opacity: 0.3;
        }

        @keyframes twinkle {
            0% { opacity: 0.3; transform: scale(1); }
            100% { opacity: 1; transform: scale(1.2); }
        }

        /* Header */
        .header {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 1000;
            padding: 15px 0;
            background: rgba(10, 10, 15, 0.9);
            backdrop-filter: blur(20px);
            border-bottom: 1px solid var(--glass-border);
            transition: all var(--transition-speed) ease;
        }

        [data-theme="light"] .header {
            background: rgba(248, 250, 252, 0.9);
        }

        .nav {
            display: flex;
            justify-content: space-between;
            align-items: center;
            max-width: var(--container-width);
            margin: 0 auto;
            padding: 0 20px;
        }

        .logo {
            font-family: 'Orbitron', monospace;
            font-size: 24px;
            font-weight: 900;
            background: var(--primary-gradient);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            text-decoration: none;
            transition: all var(--transition-speed) ease;
        }

        .logo:hover {
            transform: scale(1.05);
        }

        .nav-controls {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .control-btn {
            width: 40px;
            height: 40px;
            border: none;
            border-radius: 50%;
            background: var(--glass-bg);
            backdrop-filter: blur(10px);
            border: 1px solid var(--glass-border);
            color: var(--text-primary);
            cursor: pointer;
            transition: all var(--transition-speed) ease;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 16px;
        }

        .control-btn:hover {
            background: var(--accent-pink);
            color: white;
            transform: translateY(-2px);
            box-shadow: var(--shadow-md);
        }

        .container {
            max-width: var(--container-width);
            margin: 0 auto;
            padding: 80px 20px 40px;
        }

        .glass-card {
            background: var(--glass-bg);
            backdrop-filter: blur(20px);
            border: 1px solid var(--glass-border);
            border-radius: var(--border-radius-md);
            box-shadow: var(--shadow-md);
            transition: all var(--transition-speed) ease;
            margin-bottom: 30px;
        }

        .glass-card:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow-lg);
        }

        .gradient-text {
            background: var(--primary-gradient);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        h1 {
            font-family: 'Orbitron', monospace;
            font-size: clamp(2rem, 4vw, 3rem);
            font-weight: 700;
            margin-bottom: 1rem;
            text-align: center;
        }

        h2 {
            font-size: clamp(1.5rem, 3vw, 2rem);
            font-weight: 600;
            margin: 2rem 0 1rem 0;
            color: var(--accent-pink);
        }

        h3 {
            font-size: clamp(1.25rem, 2.5vw, 1.5rem);
            font-weight: 600;
            margin: 1.5rem 0 0.75rem 0;
            color: var(--accent-blue);
        }

        h4 {
            font-size: clamp(1.125rem, 2vw, 1.25rem);
            font-weight: 500;
            margin: 1rem 0 0.5rem 0;
            color: var(--accent-purple);
        }

        p {
            margin-bottom: 1rem;
            color: var(--text-secondary);
            font-size: clamp(0.875rem, 1.5vw, 1rem);
        }

        .section {
            margin-bottom: 2rem;
            padding: clamp(1rem, 3vw, 2rem);
        }

        .icon {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 2.5rem;
            height: 2.5rem;
            border-radius: 50%;
            background: var(--primary-gradient);
            margin-right: 1rem;
            font-size: 1.25rem;
            color: white;
            flex-shrink: 0;
        }

        .nav-item {
            padding: 0.75rem 1.5rem;
            border-radius: var(--border-radius-sm);
            transition: all var(--transition-speed) ease;
            cursor: pointer;
            margin-bottom: 0.5rem;
            display: flex;
            align-items: center;
        }

        .nav-item:hover {
            background: var(--glass-bg);
            transform: translateX(8px);
        }

        .nav-item.active {
            background: var(--primary-gradient);
            color: white;
        }

        .nav-item a {
            color: inherit;
            text-decoration: none;
            display: flex;
            align-items: center;
            width: 100%;
        }

        ul, ol {
            margin-left: 1.5rem;
            margin-bottom: 1rem;
        }

        li {
            margin-bottom: 0.5rem;
            color: var(--text-secondary);
        }

        .highlight {
            background: linear-gradient(90deg, var(--accent-pink), var(--accent-purple));
            padding: 0.25rem 0.5rem;
            border-radius: var(--border-radius-sm);
            color: white;
            font-weight: 500;
        }

        .warning-box {
            background: rgba(255, 107, 157, 0.1);
            border-left: 4px solid var(--accent-pink);
            padding: 1rem;
            margin: 1rem 0;
            border-radius: var(--border-radius-sm);
        }

        .info-box {
            background: rgba(79, 172, 254, 0.1);
            border-left: 4px solid var(--accent-blue);
            padding: 1rem;
            margin: 1rem 0;
            border-radius: var(--border-radius-sm);
        }

        .success-box {
            background: rgba(110, 59, 220, 0.1);
            border-left: 4px solid var(--accent-purple);
            padding: 1rem;
            margin: 1rem 0;
            border-radius: var(--border-radius-sm);
        }

        /* Toast Notification */
        #toast-container {
            position: fixed;
            bottom: 20px;
            left: 50%;
            transform: translateX(-50%);
            z-index: 10000;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 10px;
        }

        .toast {
            background: rgba(0, 0, 0, 0.8);
            color: white;
            padding: 15px 25px;
            border-radius: var(--border-radius-sm);
            display: flex;
            align-items: center;
            gap: 10px;
            opacity: 0;
            transition: opacity 0.3s ease, transform 0.3s ease;
            backdrop-filter: blur(10px);
            border: 1px solid var(--glass-border);
            box-shadow: var(--shadow-sm);
            transform: translateY(20px);
            min-width: 250px;
            max-width: 90%;
        }

        .toast.show {
            opacity: 1;
            transform: translateY(0);
        }

        .toast-icon {
            font-size: 1.2rem;
            flex-shrink: 0;
        }

        .toast.success .toast-icon { color: #4CAF50; }
        .toast.error .toast-icon { color: #F44336; }
        .toast.warning .toast-icon { color: #FFC107; }
        .toast.info .toast-icon { color: var(--accent-blue); }

        /* Responsive Design */
        @media (max-width: 1200px) {
            .container {
                padding: 80px 15px 40px;
            }
        }

        @media (max-width: 992px) {
            .nav {
                padding: 0 15px;
            }

            .logo {
                font-size: 20px;
            }

            .control-btn {
                width: 36px;
                height: 36px;
                font-size: 14px;
            }
        }

        @media (max-width: 768px) {
            .container {
                padding: 80px 10px 40px;
            }

            .section {
                padding: 1rem;
            }

            .nav-item {
                padding: 0.5rem 1rem;
                font-size: 0.875rem;
            }

            .icon {
                width: 2rem;
                height: 2rem;
                font-size: 1rem;
            }

            .nav-item a {
                font-size: 0.875rem;
            }
        }

        @media (max-width: 480px) {
            .nav {
                padding: 0 10px;
            }

            .nav-controls {
                gap: 10px;
            }

            .control-btn {
                width: 32px;
                height: 32px;
                font-size: 12px;
            }

            .container {
                padding: 70px 5px 30px;
            }

            h1 {
                text-align: center;
            }
        }

        /* Extra small devices */
        @media (max-width: 320px) {
            .logo {
                font-size: 18px;
            }

            .section {
                padding: 0.75rem;
            }
        }

        /* Print styles for PDF */
        @media print {
            .header {
                position: static !important;
                background: white !important;
                box-shadow: none !important;
                border-bottom: 1px solid #ddd !important;
            }

            body {
                background: white !important;
                color: black !important;
            }

            .bg-container {
                display: none !important;
            }

            .glass-card {
                background: white !important;
                border: 1px solid #ddd !important;
                box-shadow: none !important;
                break-inside: avoid;
            }

            .gradient-text {
                -webkit-text-fill-color: #6e3bdc !important;
                color: #6e3bdc !important;
            }

            h2 { color: #ff6b9d !important; }
            h3 { color: #4facfe !important; }
            h4 { color: #6e3bdc !important; }

            .control-btn {
                display: none !important;
            }

            .container {
                padding-top: 20px !important;
            }

            .toast {
                display: none !important;
            }
        }

        /* Fullscreen styles */
        .fullscreen-active {
            padding: 20px !important;
        }

        .fullscreen-active .header {
            background: rgba(10, 10, 15, 0.95) !important;
        }

        [data-theme="light"] .fullscreen-active .header {
            background: rgba(248, 250, 252, 0.95) !important;
        }
    </style>
</head>
<body>
    <!-- Background -->
    <div class="bg-container">
        <div class="stars" id="stars"></div>
    </div>

    <!-- Header -->
    <header class="header">
        <nav class="nav">
            <a href="#" class="logo">Miluv Legal</a>
            <div class="nav-controls">
                <button class="control-btn" id="themeToggle" title="Toggle Theme">
                    <i class="fas fa-moon" id="themeIcon"></i>
                </button>
                <button class="control-btn" id="fullscreenBtn" title="Toggle Fullscreen">
                    <i class="fas fa-expand" id="fullscreenIcon"></i>
                </button>
            </div>
        </nav>
    </header>

    <div class="container">
        <!-- Header -->
        <div class="text-center mb-12">
            <h1 class="gradient-text">
                <i class="fas fa-heart mr-4"></i>
                Miluv Legal Documents
            </h1>
            <p class="text-xl" style="color: var(--text-secondary);">Kebijakan Privasi & Syarat Ketentuan</p>
            <div class="w-24 h-1 mx-auto mt-4 rounded-full" style="background: var(--primary-gradient);"></div>
        </div>

        <!-- Table of Contents -->
        <div class="glass-card">
            <div class="section">
                <h2 class="gradient-text mb-6">
                    <i class="fas fa-list mr-3"></i>
                    Daftar Isi
                </h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="nav-item">
                        <i class="fas fa-user-shield mr-3"></i>
                        <a href="#health-privacy">1. Kebijakan Privasi Data Kesehatan</a>
                    </div>
                    <div class="nav-item">
                        <i class="fas fa-shield-alt mr-3"></i>
                        <a href="#general-privacy">2. Kebijakan Privasi Umum</a>
                    </div>
                    <div class="nav-item">
                        <i class="fas fa-file-contract mr-3"></i>
                        <a href="#terms">3. Syarat & Ketentuan</a>
                    </div>
                    <div class="nav-item">
                        <i class="fas fa-question-circle mr-3"></i>
                        <a href="#faq">4. Pusat Bantuan (FAQ)</a>
                    </div>
                    <div class="nav-item">
                        <i class="fas fa-cookie-bite mr-3"></i>
                        <a href="#cookies">5. Kebijakan Cookie</a>
                    </div>
                </div>
            </div>
        </div>

        <!-- 1. Health Data Privacy Policy -->
        <div id="health-privacy" class="glass-card">
            <div class="section">
                <h2>
                    <i class="icon fas fa-user-shield"></i>
                    1. Kebijakan Privasi Data Kesehatan Konsumen
                </h2>

                <div class="warning-box">
                    <p><strong><i class="fas fa-exclamation-triangle mr-2"></i>Penting:</strong> Dokumen ini khusus mengatur perlindungan data kesehatan dan psikologis yang dikumpulkan melalui aplikasi Miluv, termasuk hasil tes psikologi dan preferensi pribadi.</p>
                </div>

                <h3>1.1 Definisi Data Kesehatan</h3>
                <p>Data kesehatan yang kami kumpulkan meliputi:</p>
                <ul>
                    <li><span class="highlight">Data Psikologis:</span> Hasil tes MBTI, DISC, temperamen, dan bahasa cinta</li>
                    <li><span class="highlight">Data Fisik:</span> Tinggi badan, berat badan, kebiasaan merokok dan minum</li>
                    <li><span class="highlight">Data Kesiapan Pernikahan:</span> Hasil marriage test dan penilaian kesiapan</li>
                    <li><span class="highlight">Data Preferensi:</span> Keinginan memiliki anak, preferensi zodiak</li>
                </ul>

                <h3>1.2 Dasar Hukum Pemrosesan</h3>
                <p>Pemrosesan data kesehatan Anda didasarkan pada:</p>
                <ol>
                    <li><strong>Persetujuan Eksplisit:</strong> Anda memberikan persetujuan khusus untuk setiap jenis tes psikologi</li>
                    <li><strong>Kepentingan Sah:</strong> Untuk memberikan layanan matching yang akurat dan personal</li>
                    <li><strong>Pelaksanaan Kontrak:</strong> Sebagai bagian dari layanan premium Miluv</li>
                </ol>

                <h3>1.3 Perlindungan Khusus Data Kesehatan</h3>
                <div class="success-box">
                    <h4>Enkripsi End-to-End</h4>
                    <p>Semua data kesehatan dienkripsi menggunakan standar AES-256 dan disimpan di server terpisah dengan akses terbatas.</p>
                </div>

                <div class="info-box">
                    <h4>Akses Terbatas</h4>
                    <p>Hanya algoritma matching yang diizinkan mengakses data kesehatan untuk keperluan pencocokan. Tim Miluv tidak dapat melihat data individual.</p>
                </div>

                <h3>1.4 Hak Khusus Data Kesehatan</h3>
                <p>Untuk data kesehatan, Anda memiliki hak tambahan:</p>
                <ul>
                    <li><strong>Penarikan Persetujuan:</strong> Dapat menarik persetujuan kapan saja tanpa mempengaruhi layanan dasar</li>
                    <li><strong>Portabilitas Data:</strong> Mendapatkan salinan lengkap data kesehatan dalam format yang dapat dibaca</li>
                    <li><strong>Penghapusan Langsung:</strong> Data kesehatan akan dihapus dalam 24 jam setelah permintaan</li>
                    <li><strong>Audit Log:</strong> Melihat siapa dan kapan data kesehatan Anda diakses</li>
                </ul>

                <h3>1.5 Retensi Data Kesehatan</h3>
                <p>Data kesehatan akan disimpan selama:</p>
                <ul>
                    <li><strong>Akun Aktif:</strong> Selama akun Anda aktif dan Anda tidak menarik persetujuan</li>
                    <li><strong>Setelah Deaktivasi:</strong> Maksimal 30 hari untuk keperluan pemulihan akun</li>
                    <li><strong>Penghapusan Permanen:</strong> Data akan dihapus secara permanen setelah periode retensi</li>
                </ul>

                <h3>1.6 Berbagi Data Kesehatan</h3>
                <div class="warning-box">
                    <p><strong>Kebijakan Tidak Berbagi:</strong> Data kesehatan TIDAK AKAN PERNAH dibagikan kepada pihak ketiga, termasuk untuk keperluan iklan atau penelitian, kecuali dengan persetujuan eksplisit Anda atau diwajibkan oleh hukum.</p>
                </div>

                <h3>1.7 Keamanan Data Kesehatan</h3>
                <p>Langkah-langkah keamanan khusus untuk data kesehatan:</p>
                <ul>
                    <li>Server terpisah dengan akses multi-faktor</li>
                    <li>Audit keamanan berkala oleh pihak ketiga</li>
                    <li>Monitoring akses real-time</li>
                    <li>Backup terenkripsi di lokasi berbeda</li>
                    <li>Protokol incident response khusus</li>
                </ul>
            </div>
        </div>

        <!-- 2. General Privacy Policy -->
        <div id="general-privacy" class="glass-card">
            <div class="section">
                <h2>
                    <i class="icon fas fa-shield-alt"></i>
                    2. Kebijakan Privasi Umum
                </h2>

                <p class="text-lg mb-6">Efektif sejak: <strong>1 Januari 2024</strong> | Terakhir diperbarui: <strong>1 Januari 2024</strong></p>

                <h3>2.1 Informasi yang Kami Kumpulkan</h3>

                <h4>Data Akun Dasar</h4>
                <ul>
                    <li><strong>Identitas:</strong> Nama lengkap, alamat email, password (terenkripsi)</li>
                    <li><strong>Status:</strong> Status akun, aktivitas terakhir, zona waktu</li>
                    <li><strong>Demografis:</strong> Tanggal lahir, gender, bio pribadi</li>
                </ul>

                <h4>Data Profil Lanjutan</h4>
                <ul>
                    <li><strong>Fisik:</strong> Tinggi badan, berat badan</li>
                    <li><strong>Sosial Ekonomi:</strong> Tingkat pendidikan, pekerjaan, perusahaan, kisaran pendapatan</li>
                    <li><strong>Preferensi:</strong> Agama, keinginan memiliki anak, zodiak, kebiasaan merokok/minum</li>
                </ul>

                <h4>Data Lokasi</h4>
                <ul>
                    <li><strong>Koordinat GPS:</strong> Longitude dan latitude untuk fitur matching berdasarkan jarak</li>
                    <li><strong>Lokasi Perkiraan:</strong> Kota/wilayah untuk rekomendasi acara dan pengguna terdekat</li>
                </ul>

                <h3>2.2 Cara Kami Menggunakan Informasi</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="info-box">
                        <h4><i class="fas fa-heart mr-2"></i>Layanan Matching</h4>
                        <ul>
                            <li>Algoritma pencocokan berdasarkan kompatibilitas</li>
                            <li>Rekomendasi pengguna yang sesuai</li>
                            <li>Analisis kecocokan psikologis</li>
                        </ul>
                    </div>
                    <div class="success-box">
                        <h4><i class="fas fa-cog mr-2"></i>Peningkatan Layanan</h4>
                        <ul>
                            <li>Personalisasi pengalaman pengguna</li>
                            <li>Analisis tren penggunaan (anonim)</li>
                            <li>Pengembangan fitur baru</li>
                        </ul>
                    </div>
                </div>

                <h3>2.3 Berbagi Informasi</h3>
                <p>Kami membagikan informasi Anda dalam situasi berikut:</p>

                <h4>Dengan Pengguna Lain</h4>
                <ul>
                    <li><strong>Profil Publik:</strong> Nama, foto, bio, informasi dasar (dengan kontrol privasi)</li>
                    <li><strong>Hasil Matching:</strong> Tingkat kompatibilitas (tanpa detail spesifik)</li>
                    <li><strong>Status Online:</strong> Informasi keaktifan (dapat dinonaktifkan)</li>
                </ul>

                <h4>Dengan Penyedia Layanan</h4>
                <ul>
                    <li><strong>Cloud Computing:</strong> Penyimpanan data terenkripsi</li>
                    <li><strong>Analytics:</strong> Data penggunaan anonim untuk analisis performa</li>
                    <li><strong>Customer Support:</strong> Informasi minimal untuk menyelesaikan masalah</li>
                </ul>

                <h3>2.4 Keamanan Data</h3>
                <div class="warning-box">
                    <h4><i class="fas fa-lock mr-2"></i>Langkah-langkah Keamanan</h4>
                    <ul>
                        <li><strong>Enkripsi:</strong> Data dalam transit dan penyimpanan menggunakan enkripsi AES-256</li>
                        <li><strong>Autentikasi:</strong> Sistem login aman dengan opsi two-factor authentication</li>
                        <li><strong>Akses Terbatas:</strong> Akses data hanya untuk personel yang berwenang</li>
                        <li><strong>Monitoring:</strong> Sistem deteksi intrusi dan monitoring 24/7</li>
                        <li><strong>Backup:</strong> Backup rutin data dengan enkripsi penuh</li>
                    </ul>
                </div>

                <h3>2.5 Hak Pengguna</h3>
                <p>Sesuai dengan GDPR dan regulasi privasi internasional, Anda memiliki hak:</p>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="nav-item">
                        <i class="fas fa-eye mr-3"></i>
                        <span><strong>Hak Akses:</strong> Melihat data pribadi yang kami miliki</span>
                    </div>
                    <div class="nav-item">
                        <i class="fas fa-edit mr-3"></i>
                        <span><strong>Hak Koreksi:</strong> Memperbaiki data yang tidak akurat</span>
                    </div>
                    <div class="nav-item">
                        <i class="fas fa-trash mr-3"></i>
                        <span><strong>Hak Penghapusan:</strong> Menghapus data pribadi Anda</span>
                    </div>
                    <div class="nav-item">
                        <i class="fas fa-download mr-3"></i>
                        <span><strong>Hak Portabilitas:</strong> Mengunduh data dalam format standar</span>
                    </div>
                    <div class="nav-item">
                        <i class="fas fa-ban mr-3"></i>
                        <span><strong>Hak Pembatasan:</strong> Membatasi pemrosesan data</span>
                    </div>
                    <div class="nav-item">
                        <i class="fas fa-times mr-3"></i>
                        <span><strong>Hak Keberatan:</strong> Menolak pemrosesan untuk tujuan tertentu</span>
                    </div>
                </div>

                <h3>2.6 Retensi Data</h3>
                <p>Kami menyimpan data Anda selama:</p>
                <ul>
                    <li><strong>Akun Aktif:</strong> Selama Anda menggunakan layanan Miluv</li>
                    <li><strong>Setelah Deaktivasi:</strong> 90 hari untuk kemungkinan pemulihan akun</li>
                    <li><strong>Data Transaksi:</strong> 7 tahun untuk keperluan perpajakan dan audit</li>
                    <li><strong>Data Anonim:</strong> Dapat disimpan tanpa batas waktu untuk analisis tren</li>
                </ul>

                <h3>2.7 Transfer Data Internasional</h3>
                <div class="info-box">
                    <p>Data Anda dapat diproses di server yang berlokasi di berbagai negara. Kami memastikan transfer data internasional dilakukan dengan perlindungan yang memadai melalui:</p>
                    <ul>
                        <li>Standard Contractual Clauses (SCC)</li>
                        <li>Adequacy decisions dari komisi Eropa</li>
                        <li>Binding Corporate Rules untuk grup perusahaan</li>
                    </ul>
                </div>

                <h3>2.8 Perubahan Kebijakan</h3>
                <p>Kami akan memberitahu Anda tentang perubahan material pada kebijakan ini melalui:</p>
                <ul>
                    <li>Notifikasi dalam aplikasi</li>
                    <li>Email ke alamat terdaftar</li>
                    <li>Pengumuman di website</li>
                </ul>
            </div>
        </div>

        <!-- 3. Terms and Conditions -->
        <div id="terms" class="glass-card">
            <div class="section">
                <h2>
                    <i class="icon fas fa-file-contract"></i>
                    3. Syarat & Ketentuan Penggunaan
                </h2>

                <p class="text-lg mb-6">Dengan menggunakan aplikasi Miluv, Anda menyetujui syarat dan ketentuan berikut:</p>

                <h3>3.1 Kelayakan Pengguna</h3>
                <div class="warning-box">
                    <p><strong>Persyaratan Usia:</strong> Anda harus berusia minimal 18 tahun untuk menggunakan Miluv. Kami dapat meminta verifikasi usia kapan saja.</p>
                </div>

                <p>Persyaratan tambahan:</p>
                <ul>
                    <li>Memiliki kapasitas hukum untuk mengikat kontrak</li>
                    <li>Tidak dilarang menggunakan layanan kami berdasarkan hukum yang berlaku</li>
                    <li>Belum pernah dihapus dari platform karena pelanggaran</li>
                </ul>

                <h3>3.2 Akun Pengguna</h3>
                <h4>Pembuatan Akun</h4>
                <ul>
                    <li>Informasi yang Anda berikan harus akurat dan terkini</li>
                    <li>Satu orang hanya boleh memiliki satu akun aktif</li>
                    <li>Anda bertanggung jawab menjaga kerahasiaan login Anda</li>
                    <li>Laporkan segera jika akun Anda diretas atau disalahgunakan</li>
                </ul>

                <h4>Verifikasi Akun</h4>
                <p>Untuk keamanan dan kualitas platform, kami dapat meminta verifikasi melalui:</p>
                <ul>
                    <li>Verifikasi nomor telepon</li>
                    <li>Verifikasi email</li>
                    <li>Verifikasi foto/video untuk mencegah akun palsu</li>
                    <li>Verifikasi dokumen identitas untuk fitur premium</li>
                </ul>

                <h3>3.3 Aturan Penggunaan</h3>

                <h4>Perilaku yang Diizinkan</h4>
                <div class="success-box">
                    <ul>
                        <li>Berkomunikasi dengan hormat dan sopan</li>
                        <li>Menggunakan foto profil yang sesuai dan merupakan foto Anda</li>
                        <li>Memberikan informasi yang jujur dalam profil</li>
                        <li>Melaporkan perilaku yang tidak pantas</li>
                        <li>Menghormati keputusan dan batasan pengguna lain</li>
                    </ul>
                </div>

                <h4>Perilaku yang Dilarang</h4>
                <div class="warning-box">
                    <p><strong>Pelanggaran Serius - Dapat Mengakibatkan Penghapusan Akun:</strong></p>
                    <ul>
                        <li><strong>Pelecehan:</strong> Mengirim pesan yang mengancam, melecehkan, atau tidak pantas</li>
                        <li><strong>Penipuan:</strong> Menggunakan identitas palsu atau informasi yang menyesatkan</li>
                        <li><strong>Spam:</strong> Mengirim pesan massal atau konten promosi tanpa izin</li>
                        <li><strong>Konten Terlarang:</strong> Membagikan konten pornografi, kekerasan, atau ilegal</li>
                        <li><strong>Diskriminasi:</strong> Perilaku diskriminatif berdasarkan ras, agama, gender, dll</li>
                    </ul>
                </div>

                <h3>3.4 Layanan Premium</h3>
                <p>Miluv menawarkan layanan premium dengan fitur tambahan:</p>

                <h4>Fitur Premium</h4>
                <ul>
                    <li><strong>Unlimited Likes:</strong> Tidak ada batasan jumlah profil yang dapat di-like</li>
                    <li><strong>Super Likes:</strong> Prioritas notifikasi ke pengguna yang Anda sukai</li>
                    <li><strong>Advanced Matching:</strong> Algoritma matching yang lebih detail</li>
                    <li><strong>Read Receipts:</strong> Melihat status baca pesan</li>
                    <li><strong>Profile Boost:</strong> Profil ditampilkan lebih sering</li>
                </ul>

                <h4>Pembayaran dan Penagihan</h4>
                <ul>
                    <li>Pembayaran diproses melalui platform yang aman</li>
                    <li>Berlangganan diperpanjang otomatis kecuali dibatalkan</li>
                    <li>Refund sesuai dengan kebijakan app store masing-masing</li>
                    <li>Harga dapat berubah dengan pemberitahuan 30 hari sebelumnya</li>
                </ul>

                <h3>3.5 Konten Pengguna</h3>
                <h4>Kepemilikan Konten</h4>
                <p>Anda tetap memiliki hak atas konten yang Anda unggah, namun dengan menggunakan Miluv, Anda memberikan kami lisensi untuk:</p>
                <ul>
                    <li>Menampilkan konten Anda kepada pengguna lain</li>
                    <li>Memproses konten untuk fitur matching dan rekomendasi</li>
                    <li>Membuat salinan backup untuk keamanan data</li>
                    <li>Menggunakan konten untuk pengembangan algoritma (secara anonim)</li>
                </ul>

                <h4>Moderasi Konten</h4>
                <div class="info-box">
                    <p>Kami menggunakan kombinasi teknologi AI dan review manual untuk memoderasi konten. Konten yang melanggar dapat dihapus tanpa pemberitahuan sebelumnya.</p>
                </div>

                <h3>3.6 Penangguhan dan Penghentian</h3>
                <p>Kami berhak menangguhkan atau menghentikan akun Anda jika:</p>
                <ul>
                    <li>Melanggar syarat dan ketentuan ini</li>
                    <li>Terlibat dalam aktivitas penipuan atau ilegal</li>
                    <li>Menerima laporan pelanggaran yang berulang</li>
                    <li>Tidak aktif dalam waktu yang lama (>1 tahun)</li>
                </ul>

                <h3>3.7 Batasan Tanggung Jawab</h3>
                <div class="warning-box">
                    <p><strong>Disclaimer:</strong> Miluv adalah platform untuk mempertemukan orang. Kami tidak bertanggung jawab atas:</p>
                    <ul>
                        <li>Hasil atau kualitas hubungan yang terbentuk</li>
                        <li>Keakuratan informasi yang diberikan pengguna lain</li>
                        <li>Kerugian yang timbul dari interaksi dengan pengguna lain</li>
                        <li>Gangguan teknis atau ketidaktersediaan layanan</li>
                    </ul>
                </div>

                <h3>3.8 Hukum yang Berlaku</h3>
                <p>Syarat dan ketentuan ini tunduk pada hukum Republik Indonesia. Setiap sengketa akan diselesaikan melalui:</p>
                <ol>
                    <li><strong>Mediasi:</strong> Upaya penyelesaian secara musyawarah</li>
                    <li><strong>Arbitrase:</strong> Melalui lembaga arbitrase yang disepakati</li>
                    <li><strong>Pengadilan:</strong> Pengadilan Negeri Jakarta Selatan sebagai pilihan terakhir</li>
                </ol>
            </div>
        </div>

        <!-- 4. FAQ -->
        <div id="faq" class="glass-card">
            <div class="section">
                <h2>
                    <i class="icon fas fa-question-circle"></i>
                    4. Pusat Bantuan (FAQ)
                </h2>

                <h3>4.1 Pertanyaan Umum tentang Privasi</h3>

                <div class="space-y-4">
                    <div class="glass-card" style="padding: 1rem;">
                        <h4><i class="fas fa-question mr-2" style="color: var(--accent-pink);"></i>Apakah data saya aman di Miluv?</h4>
                        <p>Ya, kami menggunakan enkripsi tingkat militer (AES-256) dan mematuhi standar keamanan internasional. Data Anda disimpan di server yang dilindungi dengan sistem keamanan berlapis.</p>
                    </div>

                    <div class="glass-card" style="padding: 1rem;">
                        <h4><i class="fas fa-question mr-2" style="color: var(--accent-pink);"></i>Bisakah saya menghapus akun dan data saya sepenuhnya?</h4>
                        <p>Tentu. Anda dapat menghapus akun melalui pengaturan aplikasi. Semua data pribadi akan dihapus dalam 30 hari. Data yang telah dianonimkan untuk analisis statistik akan tetap ada.</p>
                    </div>

                    <div class="glass-card" style="padding: 1rem;">
                        <h4><i class="fas fa-question mr-2" style="color: var(--accent-pink);"></i>Apakah Miluv menjual data pribadi saya?</h4>
                        <p>Tidak, kami TIDAK PERNAH menjual data pribadi Anda. Ini adalah komitmen fundamental kami. Kami hanya menggunakan data untuk memberikan layanan yang lebih baik kepada Anda.</p>
                    </div>

                    <div class="glass-card" style="padding: 1rem;">
                        <h4><i class="fas fa-question mr-2" style="color: var(--accent-pink);"></i>Siapa yang bisa melihat profil saya?</h4>
                        <p>Hanya pengguna Miluv yang telah diverifikasi. Anda dapat mengatur tingkat privasi profil di pengaturan, termasuk membatasi siapa yang dapat melihat informasi tertentu.</p>
                    </div>
                </div>

                <h3>4.2 Pertanyaan tentang Data Kesehatan</h3>

                <div class="space-y-4">
                    <div class="glass-card" style="padding: 1rem;">
                        <h4><i class="fas fa-brain mr-2" style="color: var(--accent-blue);"></i>Mengapa Miluv memerlukan tes psikologi?</h4>
                        <p>Tes psikologi membantu kami memberikan rekomendasi pasangan yang lebih kompatibel dengan Anda. Semua tes bersifat opsional dan Anda dapat memilih tes mana yang ingin diikuti.</p>
                    </div>

                    <div class="glass-card" style="padding: 1rem;">
                        <h4><i class="fas fa-brain mr-2" style="color: var(--accent-blue);"></i>Apakah hasil tes psikologi saya akan dibagikan?</h4>
                        <p>Tidak. Hasil detail tes Anda bersifat rahasia. Yang dibagikan hanya tingkat kompatibilitas secara umum, tanpa detail spesifik tentang hasil tes Anda.</p>
                    </div>

                    <div class="glass-card" style="padding: 1rem;">
                        <h4><i class="fas fa-brain mr-2" style="color: var(--accent-blue);"></i>Bisakah saya mengubah atau menghapus hasil tes?</h4>
                        <p>Ya, Anda dapat mengulang tes kapan saja untuk memperbarui hasil. Anda juga dapat menghapus hasil tes tertentu jika tidak ingin digunakan untuk matching.</p>
                    </div>
                </div>

                <h3>4.3 Pertanyaan tentang Keamanan</h3>

                <div class="space-y-4">
                    <div class="glass-card" style="padding: 1rem;">
                        <h4><i class="fas fa-shield-alt mr-2" style="color: var(--accent-purple);"></i>Bagaimana cara melaporkan pengguna yang mencurigakan?</h4>
                        <p>Tap profil pengguna → pilih "Laporkan" → pilih alasan → kirim laporan. Tim kami akan meninjau dalam 24 jam dan mengambil tindakan yang diperlukan.</p>
                    </div>

                    <div class="glass-card" style="padding: 1rem;">
                        <h4><i class="fas fa-shield-alt mr-2" style="color: var(--accent-purple);"></i>Apa yang harus dilakukan jika akun saya diretas?</h4>
                        <p>Segera hubungi customer support kami dan ganti password. Aktifkan two-factor authentication untuk keamanan tambahan. Kami akan membantu mengamankan akun Anda.</p>
                    </div>

                    <div class="glass-card" style="padding: 1rem;">
                        <h4><i class="fas fa-shield-alt mr-2" style="color: var(--accent-purple);"></i>Bagaimana cara mengaktifkan two-factor authentication?</h4>
                        <p>Buka Pengaturan → Keamanan → Two-Factor Authentication → Ikuti petunjuk untuk menghubungkan aplikasi authenticator atau nomor telepon.</p>
                    </div>
                </div>

                <h3>4.4 Pertanyaan tentang Layanan Premium</h3>

                <div class="space-y-4">
                    <div class="glass-card" style="padding: 1rem;">
                        <h4><i class="fas fa-crown mr-2" style="color: #fbbf24;"></i>Apa keuntungan berlangganan premium?</h4>
                        <p>Premium memberikan unlimited likes, super likes, advanced matching, read receipts, profile boost, dan akses ke modul edukasi "12 Bulan Menuju Pernikahan".</p>
                    </div>

                    <div class="glass-card" style="padding: 1rem;">
                        <h4><i class="fas fa-crown mr-2" style="color: #fbbf24;"></i>Bisakah saya membatalkan langganan?</h4>
                        <p>Ya, Anda dapat membatalkan langganan kapan saja melalui pengaturan akun atau app store. Fitur premium akan tetap aktif hingga periode berlangganan berakhir.</p>
                    </div>

                    <div class="glass-card" style="padding: 1rem;">
                        <h4><i class="fas fa-crown mr-2" style="color: #fbbf24;"></i>Apakah ada garansi uang kembali?</h4>
                        <p>Kebijakan refund mengikuti aturan app store (Google Play/App Store). Untuk kasus khusus, silakan hubungi customer support kami.</p>
                    </div>
                </div>

                <h3>4.5 Kontak Support</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="info-box">
                        <h4><i class="fas fa-envelope mr-2"></i>Email Support</h4>
                        <p>support@miluv.id</p>
                        <p class="text-sm">Response time: 24 jam</p>
                    </div>
                    <div class="success-box">
                        <h4><i class="fas fa-comments mr-2"></i>Live Chat</h4>
                        <p>Tersedia dalam aplikasi</p>
                        <p class="text-sm">Online: 09:00 - 21:00 WIB</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- 5. Cookie Policy -->
        <div id="cookies" class="glass-card">
            <div class="section">
                <h2>
                    <i class="icon fas fa-cookie-bite"></i>
                    5. Kebijakan Cookie
                </h2>

                <p class="text-lg mb-6">Dokumen ini menjelaskan bagaimana Miluv menggunakan cookie dan teknologi pelacakan serupa.</p>

                <h3>5.1 Apa itu Cookie?</h3>
                <p>Cookie adalah file teks kecil yang disimpan di perangkat Anda saat mengunjungi website atau menggunakan aplikasi. Cookie membantu kami mengingat preferensi Anda dan meningkatkan pengalaman pengguna.</p>

                <h3>5.2 Jenis Cookie yang Kami Gunakan</h3>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="glass-card" style="padding: 1rem;">
                        <h4><i class="fas fa-cog mr-2" style="color: var(--accent-blue);"></i>Cookie Fungsional</h4>
                        <p><strong>Tujuan:</strong> Mengingat pengaturan dan preferensi Anda</p>
                        <p><strong>Contoh:</strong></p>
                        <ul class="text-sm">
                            <li>Bahasa yang dipilih</li>
                            <li>Zona waktu</li>
                            <li>Preferensi notifikasi</li>
                            <li>Status login</li>
                        </ul>
                        <p><strong>Durasi:</strong> 1 tahun</p>
                    </div>

                    <div class="glass-card" style="padding: 1rem;">
                        <h4><i class="fas fa-chart-line mr-2" style="color: #10b981;"></i>Cookie Analitik</h4>
                        <p><strong>Tujuan:</strong> Memahami cara penggunaan aplikasi</p>
                        <p><strong>Contoh:</strong></p>
                        <ul class="text-sm">
                            <li>Halaman yang paling sering dikunjungi</li>
                            <li>Waktu yang dihabiskan</li>
                            <li>Fitur yang paling digunakan</li>
                            <li>Error yang terjadi</li>
                        </ul>
                        <p><strong>Durasi:</strong> 2 tahun</p>
                    </div>

                    <div class="glass-card" style="padding: 1rem;">
                        <h4><i class="fas fa-shield-alt mr-2" style="color: #ef4444;"></i>Cookie Keamanan</h4>
                        <p><strong>Tujuan:</strong> Melindungi akun dan mencegah fraud</p>
                        <p><strong>Contoh:</strong></p>
                        <ul class="text-sm">
                            <li>Token autentikasi</li>
                            <li>Deteksi login mencurigakan</li>
                            <li>Verifikasi sesi</li>
                            <li>Pencegahan bot</li>
                        </ul>
                        <p><strong>Durasi:</strong> Session/30 hari</p>
                    </div>

                    <div class="glass-card" style="padding: 1rem;">
                        <h4><i class="fas fa-bullseye mr-2" style="color: var(--accent-purple);"></i>Cookie Personalisasi</h4>
                        <p><strong>Tujuan:</strong> Memberikan pengalaman yang dipersonalisasi</p>
                        <p><strong>Contoh:</strong></p>
                        <ul class="text-sm">
                            <li>Rekomendasi profil</li>
                            <li>Konten yang dipersonalisasi</li>
                            <li>Pengaturan filter</li>
                            <li>Riwayat pencarian</li>
                        </ul>
                        <p><strong>Durasi:</strong> 6 bulan</p>
                    </div>
                </div>

                <h3>5.3 Cookie Pihak Ketiga</h3>
                <p>Kami juga menggunakan cookie dari penyedia layanan pihak ketiga:</p>

                <div class="space-y-4">
                    <div class="info-box">
                        <h4>Google Analytics</h4>
                        <p><strong>Tujuan:</strong> Analisis penggunaan website dan aplikasi</p>
                        <p><strong>Data yang dikumpulkan:</strong> Statistik penggunaan anonim</p>
                        <p><strong>Kontrol:</strong> Dapat dinonaktifkan melalui Google Analytics Opt-out</p>
                    </div>

                    <div class="info-box">
                        <h4>Firebase Analytics</h4>
                        <p><strong>Tujuan:</strong> Analisis performa dan crash reporting</p>
                        <p><strong>Data yang dikumpulkan:</strong> Event aplikasi, performa, error</p>
                        <p><strong>Kontrol:</strong> Dapat dinonaktifkan di pengaturan aplikasi</p>
                    </div>

                    <div class="info-box">
                        <h4>Customer Support Tools</h4>
                        <p><strong>Tujuan:</strong> Memberikan dukungan pelanggan yang lebih baik</p>
                        <p><strong>Data yang dikumpulkan:</strong> Riwayat chat, preferensi support</p>
                        <p><strong>Kontrol:</strong> Aktif hanya saat menggunakan fitur chat</p>
                    </div>
                </div>

                <h3>5.4 Mengelola Preferensi Cookie</h3>

                <h4>Melalui Aplikasi Miluv</h4>
                <ul>
                    <li>Buka <strong>Pengaturan</strong> → <strong>Privasi</strong> → <strong>Cookie</strong></li>
                    <li>Pilih kategori cookie yang ingin dikelola</li>
                    <li>Aktifkan/nonaktifkan sesuai preferensi Anda</li>
                    <li>Simpan pengaturan</li>
                </ul>

                <h4>Melalui Browser</h4>
                <ul>
                    <li><strong>Chrome:</strong> Settings → Privacy and Security → Cookies</li>
                    <li><strong>Safari:</strong> Preferences → Privacy → Manage Website Data</li>
                    <li><strong>Firefox:</strong> Options → Privacy & Security → Cookies</li>
                    <li><strong>Edge:</strong> Settings → Cookies and Site Permissions</li>
                </ul>

                <h3>5.5 Konsekuensi Menonaktifkan Cookie</h3>
                <div class="warning-box">
                    <p><strong>Perhatian:</strong> Menonaktifkan cookie tertentu dapat mempengaruhi fungsionalitas aplikasi:</p>
                    <ul>
                        <li><strong>Cookie Fungsional:</strong> Anda mungkin perlu login berulang dan mengatur preferensi setiap kali</li>
                        <li><strong>Cookie Keamanan:</strong> Fitur keamanan mungkin tidak berfungsi optimal</li>
                        <li><strong>Cookie Personalisasi:</strong> Rekomendasi menjadi kurang akurat</li>
                        <li><strong>Cookie Analitik:</strong> Tidak mempengaruhi fungsionalitas, hanya data analisis</li>
                    </ul>
                </div>

                <h3>5.6 Teknologi Pelacakan Lainnya</h3>

                <h4>Local Storage</h4>
                <p>Menyimpan data aplikasi di perangkat Anda untuk performa yang lebih baik:</p>
                <ul>
                    <li>Cache gambar profil</li>
                    <li>Data offline untuk akses cepat</li>
                    <li>Pengaturan aplikasi</li>
                </ul>

                <h4>Device Fingerprinting</h4>
                <p>Untuk keamanan dan pencegahan fraud:</p>
                <ul>
                    <li>Identifikasi perangkat unik</li>
                    <li>Deteksi akun palsu</li>
                    <li>Pencegahan spam</li>
                </ul>

                <h4>Push Notifications</h4>
                <p>Dengan izin Anda, untuk:</p>
                <ul>
                    <li>Notifikasi match baru</li>
                    <li>Pesan masuk</li>
                    <li>Update fitur penting</li>
                    <li>Reminder aktivitas</li>
                </ul>

                <h3>5.7 Pembaruan Kebijakan Cookie</h3>
                <p>Kebijakan ini dapat diperbarui untuk mencerminkan perubahan dalam teknologi atau regulasi. Kami akan memberitahu Anda tentang perubahan material melalui:</p>
                <ul>
                    <li>Notifikasi dalam aplikasi</li>
                    <li>Email notification</li>
                    <li>Banner di website</li>
                </ul>

                <h3>5.8 Kontak untuk Pertanyaan Cookie</h3>
                <div class="success-box">
                    <p>Jika Anda memiliki pertanyaan tentang penggunaan cookie:</p>
                    <ul>
                        <li><strong>Email:</strong> privacy@miluv.id</li>
                        <li><strong>Subject:</strong> "Cookie Policy Inquiry"</li>
                        <li><strong>Response Time:</strong> 48 jam</li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Footer -->
        <div class="glass-card">
            <div class="section text-center">
                <h3 class="gradient-text mb-4">
                    <i class="fas fa-heart mr-3"></i>
                    Miluv - The Future of Smart Dating
                </h3>
                <p style="color: var(--text-muted); margin-bottom: 1rem;">
                    Dokumen ini terakhir diperbarui pada <strong>1 Januari 2024</strong>
                </p>
                <div class="flex flex-wrap justify-center gap-6 text-sm">
                    <a href="mailto:legal@miluv.id" style="color: var(--accent-pink);" class="hover:opacity-80 transition-opacity">
                        <i class="fas fa-envelope mr-2"></i>legal@miluv.id
                    </a>
                    <a href="mailto:support@miluv.id" style="color: var(--accent-blue);" class="hover:opacity-80 transition-opacity">
                        <i class="fas fa-life-ring mr-2"></i>support@miluv.id
                    </a>
                    <a href="mailto:privacy@miluv.id" style="color: var(--accent-purple);" class="hover:opacity-80 transition-opacity">
                        <i class="fas fa-shield-alt mr-2"></i>privacy@miluv.id
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Toast Container -->
    <div id="toast-container"></div>

    <script>
        document.addEventListener("DOMContentLoaded", () => {
            // --- Constants and Variables ---
            const starsContainer = document.getElementById("stars");
            const themeToggle = document.getElementById("themeToggle");
            const themeIcon = document.getElementById("themeIcon");
            const fullscreenBtn = document.getElementById("fullscreenBtn");
            const fullscreenIcon = document.getElementById("fullscreenIcon");
            const toastContainer = document.getElementById("toast-container");

            // --- Theme Management ---
            function initTheme() {
                const savedTheme = localStorage.getItem('miluv-theme') || 'dark';
                document.documentElement.setAttribute('data-theme', savedTheme);
                updateThemeIcon(savedTheme);
            }

            function updateThemeIcon(theme) {
                if (theme === 'light') {
                    themeIcon.className = 'fas fa-sun';
                } else {
                    themeIcon.className = 'fas fa-moon';
                }
            }

            function toggleTheme() {
                const currentTheme = document.documentElement.getAttribute('data-theme') || 'dark';
                const newTheme = currentTheme === 'dark' ? 'light' : 'dark';

                document.documentElement.setAttribute('data-theme', newTheme);
                localStorage.setItem('miluv-theme', newTheme);
                updateThemeIcon(newTheme);

                showToast(`Switched to ${newTheme} mode`, 'success', 2000);
            }

            // --- Fullscreen Management ---
            function toggleFullscreen() {
                if (!document.fullscreenElement) {
                    document.documentElement.requestFullscreen().then(() => {
                        fullscreenIcon.className = 'fas fa-compress';
                        document.body.classList.add('fullscreen-active');
                        showToast('Entered fullscreen mode', 'info', 2000);
                    }).catch((err) => {
                        showToast('Could not enter fullscreen mode', 'error', 3000);
                    });
                } else {
                    document.exitFullscreen().then(() => {
                        fullscreenIcon.className = 'fas fa-expand';
                        document.body.classList.remove('fullscreen-active');
                        showToast('Exited fullscreen mode', 'info', 2000);
                    });
                }
            }

            // Listen for fullscreen changes (including F11 or Esc key)
            document.addEventListener('fullscreenchange', () => {
                if (!document.fullscreenElement) {
                    fullscreenIcon.className = 'fas fa-expand';
                    document.body.classList.remove('fullscreen-active');
                }
            });

            // --- Background Effects ---
            function createStars(container, count = 100) {
                if (!container) return;
                for (let i = 0; i < count; i++) {
                    const star = document.createElement("div");
                    star.classList.add("star");
                    star.style.width = `${Math.random() * 2 + 1}px`;
                    star.style.height = star.style.width;
                    star.style.left = `${Math.random() * 100}%`;
                    star.style.top = `${Math.random() * 100}%`;
                    star.style.animationDelay = `${Math.random() * 2}s`;
                    star.style.animationDuration = `${Math.random() * 3 + 2}s`;
                    container.appendChild(star);
                }
            }

            // --- Toast Notifications ---
            function showToast(message, type = "info", duration = 3000) {
                if (!toastContainer) return;

                const toast = document.createElement("div");
                toast.classList.add("toast", type);

                let iconClass = "fas fa-info-circle";
                if (type === "success") iconClass = "fas fa-check-circle";
                if (type === "error") iconClass = "fas fa-times-circle";
                if (type === "warning") iconClass = "fas fa-exclamation-triangle";

                toast.innerHTML = `
                    <i class="toast-icon ${iconClass}"></i>
                    <span>${message}</span>
                `;

                toastContainer.appendChild(toast);

                setTimeout(() => {
                    toast.classList.add("show");
                }, 10);

                setTimeout(() => {
                    toast.classList.remove("show");
                    toast.addEventListener("transitionend", () => {
                        toast.remove();
                    });
                }, duration);
            }

            // --- Smooth Scrolling ---
            document.querySelectorAll('a[href^="#"]').forEach(anchor => {
                anchor.addEventListener('click', function (e) {
                    e.preventDefault();
                    const target = document.querySelector(this.getAttribute('href'));
                    if (target) {
                        target.scrollIntoView({
                            behavior: 'smooth',
                            block: 'start'
                        });
                    }
                });
            });

            // --- Active Navigation ---
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        const id = entry.target.getAttribute('id');
                        document.querySelectorAll('.nav-item').forEach(item => {
                            item.classList.remove('active');
                        });
                        const activeItem = document.querySelector(`a[href="#${id}"]`)?.parentElement;
                        if (activeItem) {
                            activeItem.classList.add('active');
                        }
                    }
                });
            }, { threshold: 0.3 });

            document.querySelectorAll('[id]').forEach(section => {
                observer.observe(section);
            });

            // --- Event Listeners ---
            if (themeToggle) {
                themeToggle.addEventListener('click', toggleTheme);
            }

            if (fullscreenBtn) {
                fullscreenBtn.addEventListener('click', toggleFullscreen);
            }

            // --- Initialize ---
            initTheme();
            createStars(starsContainer);

            // Show welcome toast
            setTimeout(() => {
                showToast('Welcome to Miluv Legal Documents', 'info', 3000);
            }, 1000);
        });
    </script>
</body>
</html>
