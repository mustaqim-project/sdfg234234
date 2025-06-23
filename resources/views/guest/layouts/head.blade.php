<!DOCTYPE html>
<html lang="id" dir="ltr">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="robots" content="index, follow" />
    <meta name="googlebot" content="index, follow" />

    <!-- Title & Description -->
    <title>Miluv - Kenali Dulu, Jadian Kemudian | Aplikasi Jodoh Serius Berbasis AI</title>
    <meta name="description" content="Miluv bantu kamu menemukan pasangan yang benar-benar cocok lewat tes kepribadian & teknologi AI. Serius cari jodoh? Kenali dulu, jadian kemudian." />
    <meta name="keywords" content="aplikasi jodoh, cari pasangan serius, jodoh online, tes kepribadian, ai matchmaking, jodoh masa depan, pasangan hidup, miluv app" />

    <!-- Canonical URL -->
    <link rel="canonical" href="https://www.miluv.app/" />

    <!-- Open Graph -->
    <meta property="og:title" content="Miluv - Kenali Dulu, Jadian Kemudian" />
    <meta property="og:description" content="Aplikasi jodoh berbasis AI yang bantu kamu ketemu pasangan yang benar-benar cocok. Bukan buat main-main. Serius? Mulai dari kenalan dulu." />
    <meta property="og:type" content="website" />
    <meta property="og:url" content="https://www.miluv.app/" />
    <meta property="og:image" content="https://www.miluv.app/images/miluv-social-preview.jpg" />
    <meta property="og:site_name" content="Miluv" />


    <!-- Twitter Card -->
    <meta name="twitter:card" content="summary_large_image" />
    <meta name="twitter:title" content="Miluv - Kenali Dulu, Jadian Kemudian" />
    <meta name="twitter:description" content="Cari pasangan serius yang cocok lewat kepribadian & AI. Miluv bantu kamu mulai dari kenal, lalu jadian. Hubungan yang tumbuh dari kecocokan." />
    <meta name="twitter:image" content="https://www.miluv.app/images/miluv-twitter-card.jpg" />


    <!-- Icons -->
    <link rel="icon" href="/favicon.ico" type="image/x-icon" />
    <link rel="apple-touch-icon" href="/apple-touch-icon.png" />

    <!-- Fonts & Icons -->
    <link rel="preload" href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@300;400;500;600;700&family=Orbitron:wght@400;500;600;700&display=swap" as="style" />
    <link rel="preload" href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@6.4.0/css/all.min.css" as="style" />
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@300;400;500;600;700&family=Orbitron:wght@400;500;600;700&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@6.4.0/css/all.min.css" />

    <!-- Schema JSON-LD -->
    <script type="application/ld+json">
    {
        "@context": "https://schema.org",
        "@type": "WebApplication",
        "name": "Miluv",
        "url": "https://www.miluv.app",
        "description": "Miluv adalah aplikasi jodoh modern untuk kamu yang serius menjalin hubungan. Temukan pasangan lewat tes kepribadian dan sistem AI yang cerdas. Kenali dulu, jadian kemudian.",
        "applicationCategory": "DatingApplication",
        "operatingSystem": "Android, iOS",
        "offers": {
            "@type": "Offer",
            "price": "0",
            "priceCurrency": "IDR"
        },
        "aggregateRating": {
            "@type": "AggregateRating",
            "ratingValue": "4.9",
            "reviewCount": "1287"
        },
        "author": {
            "@type": "Organization",
            "name": "Miluv Team"
        },
        "sameAs": [
            "https://www.instagram.com/miluv.app",
            "https://www.facebook.com/miluv.app",
            "https://www.tiktok.com/@miluv.app",
            "https://www.youtube.com/@miluvapp"
        ]
    }
    </script>

    <style>
        /* == Global Styles & Variables == */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        :root {
            /* Dark Theme (Default) */
            --primary-gradient: linear-gradient(135deg, #ff6b9d, #c44bff, #4facfe);
            --primary-gradient-hover: linear-gradient(135deg, #ff7ba7, #d05cff, #5fb7fe);
            --bg-primary: #0a0a0f;
            --bg-secondary: #121218;
            --bg-tertiary: rgba(255, 255, 255, 0.05);
            --accent-purple: #6e3bdc;
            --accent-pink: #ff6b9d;
            --accent-blue: #4facfe;
            --text-primary: #ffffff;
            --text-secondary: rgba(255, 255, 255, 0.8);
            --text-muted: rgba(255, 255, 255, 0.6);
            --glass-bg: rgba(255, 255, 255, 0.05);
            --glass-border: rgba(255, 255, 255, 0.1);
            --shadow-color: rgba(0, 0, 0, 0.3);
            --star-color: #ffffff;
            --container-width: 1200px;
            --transition-speed: 0.4s;
            --border-radius-sm: 10px;
            --border-radius-md: 20px;
            --border-radius-lg: 30px;
            --shadow-sm: 0 5px 15px var(--shadow-color);
            --shadow-md: 0 10px 30px var(--shadow-color);
            --shadow-lg: 0 20px 40px var(--shadow-color);
        }

        /* Light Theme */
        [data-theme="light"] {
            --bg-primary: #f8fafc;
            --bg-secondary: #ffffff;
            --bg-tertiary: rgba(0, 0, 0, 0.05);
            --text-primary: #1a202c;
            --text-secondary: rgba(26, 32, 44, 0.8);
            --text-muted: rgba(26, 32, 44, 0.6);
            --glass-bg: rgba(255, 255, 255, 0.8);
            --glass-border: rgba(0, 0, 0, 0.1);
            --shadow-color: rgba(0, 0, 0, 0.1);
            --star-color: #ffd700;
        }

        html {
            scroll-behavior: smooth;
        }

        body {
            font-family: 'Space Grotesk', -apple-system, BlinkMacSystemFont, sans-serif;
            background: var(--bg-primary);
            color: var(--text-primary);
            overflow-x: hidden;
            min-height: 100vh;
            position: relative;
            line-height: 1.6;
            transition: background-color var(--transition-speed) ease, color var(--transition-speed) ease;
        }

        .container {
            max-width: var(--container-width);
            margin: 0 auto;
            padding: 0 1rem;
        }

        a {
            color: var(--accent-pink);
            text-decoration: none;
            transition: color var(--transition-speed) ease;
        }

        a:hover {
            color: var(--accent-blue);
        }

        img {
            max-width: 100%;
            height: auto;
            display: block;
        }

        /* == Utility Classes == */
        .text-gradient {
            background: var(--primary-gradient);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        /* == Cookie Consent Banner == */
        .cookie-banner {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            background: var(--bg-secondary);
            backdrop-filter: blur(20px);
            border-top: 1px solid var(--glass-border);
            padding: 1.5rem;
            z-index: 10000;
            transform: translateY(100%);
            transition: transform 0.4s ease;
            box-shadow: var(--shadow-lg);
        }

        .cookie-banner.show {
            transform: translateY(0);
        }

        .cookie-content {
            max-width: var(--container-width);
            margin: 0 auto;
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            gap: 1.5rem;
            justify-content: space-between;
        }

        .cookie-text {
            flex: 1;
            min-width: 300px;
        }

        .cookie-title {
            font-size: 1.1rem;
            font-weight: 600;
            margin-bottom: 0.5rem;
            color: var(--text-primary);
        }

        .cookie-desc {
            color: var(--text-secondary);
            font-size: 0.9rem;
            line-height: 1.5;
        }

        .cookie-buttons {
            display: flex;
            gap: 1rem;
            flex-wrap: wrap;
        }

        .cookie-btn {
            padding: 0.75rem 1.5rem;
            border: none;
            border-radius: var(--border-radius-sm);
            font-weight: 600;
            cursor: pointer;
            transition: all var(--transition-speed) ease;
            font-size: 0.9rem;
            white-space: nowrap;
        }

        .cookie-btn.accept {
            background: var(--primary-gradient);
            color: white;
        }

        .cookie-btn.accept:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(255, 107, 157, 0.4);
        }

        .cookie-btn.decline {
            background: transparent;
            border: 1px solid var(--glass-border);
            color: var(--text-secondary);
        }

        .cookie-btn.decline:hover {
            background: var(--bg-tertiary);
            color: var(--text-primary);
        }

        .cookie-btn.settings {
            background: var(--bg-tertiary);
            color: var(--text-primary);
        }

        .cookie-btn.settings:hover {
            background: rgba(255, 107, 157, 0.1);
        }

        /* == Permission Status Bar == */
        .permission-status {
            position: fixed;
            top: 80px;
            right: 20px;
            background: var(--glass-bg);
            backdrop-filter: blur(15px);
            border: 1px solid var(--glass-border);
            border-radius: var(--border-radius-md);
            padding: 1.5rem;
            max-width: 300px;
            z-index: 999;
            transform: translateX(120%);
            transition: transform 0.4s ease;
            box-shadow: var(--shadow-md);
        }

        .permission-status.show {
            transform: translateX(0);
        }

        .permission-status h3 {
            font-size: 1rem;
            margin-bottom: 1rem;
            color: var(--text-primary);
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .permission-item {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0.5rem 0;
            border-bottom: 1px solid var(--glass-border);
        }

        .permission-item:last-child {
            border-bottom: none;
        }

        .permission-label {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            font-size: 0.9rem;
            color: var(--text-secondary);
        }

        .permission-status-indicator {
            width: 12px;
            height: 12px;
            border-radius: 50%;
            display: inline-block;
        }

        .permission-status-indicator.granted {
            background: #4CAF50;
        }

        .permission-status-indicator.denied {
            background: #F44336;
        }

        .permission-status-indicator.pending {
            background: #FFC107;
        }

        .permission-request-btn {
            background: transparent;
            border: 1px solid var(--accent-pink);
            color: var(--accent-pink);
            padding: 0.25rem 0.75rem;
            border-radius: var(--border-radius-sm);
            font-size: 0.8rem;
            cursor: pointer;
            transition: all var(--transition-speed) ease;
        }

        .permission-request-btn:hover {
            background: rgba(255, 107, 157, 0.1);
        }

        .permission-request-btn:disabled {
            opacity: 0.5;
            cursor: not-allowed;
        }

        /* == Control Buttons == */
        .control-buttons {
            position: fixed;
            top: 50%;
            right: 20px;
            transform: translateY(-50%);
            z-index: 1001;
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .control-btn {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            border: none;
            background: var(--glass-bg);
            backdrop-filter: blur(15px);
            border: 1px solid var(--glass-border);
            color: var(--text-primary);
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all var(--transition-speed) ease;
            box-shadow: var(--shadow-sm);
        }

        .control-btn:hover {
            transform: scale(1.1);
            background: var(--accent-pink);
            color: white;
        }

        .theme-toggle {
            font-size: 1.2rem;
        }

        .fullscreen-btn {
            font-size: 1.1rem;
        }

        .permission-btn {
            font-size: 1rem;
        }

        /* == Loading Screen == */
        .loading-screen {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: var(--bg-primary);
            z-index: 9999;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            transition: opacity 0.5s ease, visibility 0.5s ease;
            visibility: visible;
            opacity: 1;
        }

        .loading-screen.hidden {
            opacity: 0;
            visibility: hidden;
        }

        .loading-spinner {
            width: 50px;
            height: 50px;
            border: 3px solid var(--glass-border);
            border-radius: 50%;
            border-top-color: var(--accent-pink);
            animation: spin 1s ease-in-out infinite;
            margin-bottom: 20px;
        }

        @keyframes spin {
            to {
                transform: rotate(360deg);
            }
        }

        .loading-text {
            font-family: 'Orbitron', sans-serif;
            font-size: 1.2rem;
            background: var(--primary-gradient);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        /* == Animated Background == */
        .bg-container {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: -2;
            background: var(--bg-primary);
            overflow: hidden;
            transition: background var(--transition-speed) ease;
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
            background: var(--star-color);
            border-radius: 50%;
            animation: twinkle 2s infinite alternate;
            transition: background-color var(--transition-speed) ease;
        }

        @keyframes twinkle {
            0% {
                opacity: 0.3;
                transform: scale(1);
            }

            100% {
                opacity: 1;
                transform: scale(1.2);
            }
        }

        /* Floating particles */
        #particles,
        #heart-particles {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            pointer-events: none;
            z-index: -1;
        }

        .particle {
            position: absolute;
            width: 4px;
            height: 4px;
            background: var(--primary-gradient);
            border-radius: 50%;
            animation: float 15s infinite linear;
            opacity: 0;
        }

        .heart-particle {
            position: absolute;
            color: var(--accent-pink);
            font-size: 12px;
            animation: float-heart 20s infinite linear;
            opacity: 0;
        }

        @keyframes float {
            0% {
                transform: translateY(100vh) translateX(0px) rotate(0deg);
                opacity: 0;
            }

            10% {
                opacity: 1;
            }

            90% {
                opacity: 1;
            }

            100% {
                transform: translateY(-100px) translateX(100px) rotate(360deg);
                opacity: 0;
            }
        }

        @keyframes float-heart {
            0% {
                transform: translateY(100vh) translateX(0px) rotate(0deg);
                opacity: 0;
            }

            10% {
                opacity: 0.7;
            }

            90% {
                opacity: 0.7;
            }

            100% {
                transform: translateY(-100px) translateX(100px) rotate(360deg);
                opacity: 0;
            }
        }

        /* == Header == */
        .header {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 1000;
            padding: 1rem 0;
            background: rgba(10, 10, 15, 0.7);
            backdrop-filter: blur(15px);
            border-bottom: 1px solid var(--glass-border);
            transition: all var(--transition-speed) ease;
        }

        [data-theme="light"] .header {
            background: rgba(248, 250, 252, 0.9);
        }

        .header.scrolled {
            padding: 0.75rem 0;
            background: rgba(10, 10, 15, 0.9);
            box-shadow: var(--shadow-sm);
        }

        [data-theme="light"] .header.scrolled {
            background: rgba(248, 250, 252, 0.95);
        }

        .nav {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .logo {
            font-family: 'Orbitron', monospace;
            font-size: clamp(1.5rem, 4vw, 1.75rem);
            font-weight: 900;
            background: var(--primary-gradient);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            text-shadow: 0 0 30px rgba(255, 107, 157, 0.5);
            transition: all var(--transition-speed) ease;
            text-decoration: none;
        }

        .logo:hover {
            transform: scale(1.05);
        }

        .nav-links {
            display: flex;
            gap: 2rem;
            align-items: center;
        }

        .nav-link {
            color: var(--text-secondary);
            text-decoration: none;
            font-weight: 500;
            transition: all var(--transition-speed) ease;
            position: relative;
            padding-bottom: 5px;
            font-size: 0.9rem;
        }

        .nav-link:hover {
            color: var(--accent-pink);
        }

        .nav-link::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 0;
            height: 2px;
            background: var(--accent-pink);
            transition: width var(--transition-speed) ease;
        }

        .nav-link:hover::after,
        .nav-link.active::after {
            width: 100%;
        }

        .nav-link.active {
            color: var(--accent-pink);
        }

        .login-btn {
            background: var(--primary-gradient);
            color: white;
            border: none;
            padding: 0.6rem 1.2rem;
            border-radius: 25px;
            font-weight: 600;
            cursor: pointer;
            transition: all var(--transition-speed) ease;
            font-size: 0.9rem;
        }

        .login-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(255, 107, 157, 0.4);
            background: var(--primary-gradient-hover);
        }

        /* == Hero Section == */
        .hero-section {
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            text-align: center;
            padding: 8rem 1rem 6rem;
            position: relative;
            overflow: hidden;
        }

        .hero-badge {
            background: var(--glass-bg);
            backdrop-filter: blur(10px);
            border: 1px solid var(--accent-pink);
            border-radius: var(--border-radius-lg);
            padding: 0.75rem 1.5rem;
            font-size: 0.9rem;
            color: var(--accent-pink);
            margin-bottom: 2rem;
            box-shadow: 0 0 20px rgba(255, 107, 157, 0.3);
        }

        .hero-title {
            font-family: 'Orbitron', monospace;
            font-size: clamp(2.5rem, 8vw, 5rem);
            font-weight: 900;
            line-height: 1.1;
            margin-bottom: 1.5rem;
            background: var(--primary-gradient);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            text-shadow: 0 0 50px rgba(255, 107, 157, 0.5);
        }

        .hero-subtitle {
            font-size: clamp(1.1rem, 3vw, 1.4rem);
            color: var(--text-secondary);
            margin-bottom: 2.5rem;
            max-width: 600px;
            line-height: 1.6;
        }

        .hero-buttons {
            display: flex;
            gap: 1rem;
            flex-wrap: wrap;
            justify-content: center;
        }

        /* Hero Animations */
        .animate-float-badge {
            animation: float-badge 3s ease-in-out infinite;
        }

        @keyframes float-badge {

            0%,
            100% {
                transform: translateY(0px);
            }

            50% {
                transform: translateY(-10px);
            }
        }

        .animate-title-glow {
            animation: title-glow 3s ease-in-out infinite alternate;
        }

        @keyframes title-glow {
            0% {
                filter: drop-shadow(0 0 20px rgba(255, 107, 157, 0.5));
            }

            100% {
                filter: drop-shadow(0 0 40px rgba(196, 75, 255, 0.7));
            }
        }

        .animate-fade-in-up {
            transform: translateY(20px);
            opacity: 0;
            animation: fadeInUp 0.6s ease forwards;
            animation-delay: var(--animation-delay, 0s);
        }

        @keyframes fadeInUp {
            to {
                transform: translateY(0);
                opacity: 1;
            }
        }

        /* == Buttons == */
        .cta-button {
            padding: 1rem 2rem;
            border: none;
            border-radius: 50px;
            background: var(--primary-gradient);
            color: #ffffff;
            font-weight: 600;
            font-size: 1rem;
            cursor: pointer;
            transition: all var(--transition-speed) ease;
            box-shadow: 0 8px 25px rgba(255, 107, 157, 0.4);
            position: relative;
            overflow: hidden;
        }

        .cta-button::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
            transition: left 0.6s ease;
        }

        .cta-button:hover::before {
            left: 100%;
        }

        .cta-button:hover {
            transform: translateY(-3px);
            box-shadow: 0 12px 35px rgba(255, 107, 157, 0.6);
            background: var(--primary-gradient-hover);
        }

        .secondary-button {
            background: transparent;
            border: 1px solid var(--accent-pink);
            color: var(--accent-pink);
            box-shadow: none;
        }

        .secondary-button:hover {
            background: rgba(255, 107, 157, 0.1);
            box-shadow: 0 8px 25px rgba(255, 107, 157, 0.2);
        }

        /* == Section Styling == */
        .section {
            padding: 6rem 0;
            position: relative;
        }

        .section-title {
            font-family: 'Orbitron', monospace;
            font-size: clamp(1.8rem, 5vw, 2.5rem);
            margin-bottom: 1.5rem;
            text-align: center;
            background: linear-gradient(135deg, var(--text-primary), var(--accent-pink));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .section-subtitle {
            font-size: clamp(1rem, 2.5vw, 1.2rem);
            color: var(--text-secondary);
            text-align: center;
            max-width: 800px;
            margin: 0 auto 3rem;
            line-height: 1.6;
            padding: 0 1rem;
        }

        /* Scroll Animation Base */
        .animate-on-scroll {
            opacity: 0;
            transform: translateY(30px);
            transition: opacity 0.6s ease, transform 0.6s ease;
            transition-delay: var(--animation-delay, 0s);
        }

        .animate-on-scroll.in-view {
            opacity: 1;
            transform: translateY(0);
        }

        /* == About Section == */
        .about-content {
            display: grid;
            grid-template-columns: 1fr 1fr;
            align-items: start;
            gap: 3rem;
            margin-bottom: 4rem;
        }

        .about-text {
            padding-right: 1rem;
        }

        .about-description {
            margin-bottom: 1.5rem;
            line-height: 1.8;
            color: var(--text-secondary);
            font-size: 1.1rem;
        }

        .about-future {
            border-radius: var(--border-radius-md);
            overflow: hidden;
            box-shadow: var(--shadow-lg);
            background: var(--glass-bg);
            backdrop-filter: blur(15px);
            border: 1px solid var(--glass-border);
            padding: 2rem;
        }

        .about-future-grid {
            display: grid;
            grid-template-columns: 1fr;
            gap: 1.5rem;
        }

        .about-future-card {
            background: var(--bg-tertiary);
            padding: 1.5rem;
            border-radius: var(--border-radius-sm);
            border: 1px solid var(--glass-border);
            transition: transform var(--transition-speed) ease;
        }

        .about-future-card:hover {
            transform: translateY(-5px);
        }

        .about-future-title {
            font-size: 1.1rem;
            margin-bottom: 0.75rem;
            color: var(--accent-pink);
            font-weight: 600;
        }

        .about-future-desc {
            font-size: 0.9rem;
            color: var(--text-secondary);
            line-height: 1.5;
        }

        /* == Features Section == */
        .features-section {
            background: var(--bg-tertiary);
            backdrop-filter: blur(20px);
        }

        .features-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 2rem;
        }

        .feature-card {
            background: var(--glass-bg);
            backdrop-filter: blur(15px);
            border: 1px solid var(--glass-border);
            border-radius: var(--border-radius-md);
            padding: 2.5rem 2rem;
            text-align: center;
            transition: all var(--transition-speed) ease;
            position: relative;
            overflow: hidden;
        }

        .feature-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 2px;
            background: var(--primary-gradient);
            transform: scaleX(0);
            transform-origin: left;
            transition: transform var(--transition-speed) ease;
        }

        .feature-card:hover::before {
            transform: scaleX(1);
        }

        .feature-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 20px 40px rgba(255, 107, 157, 0.2);
            border-color: var(--accent-pink);
        }

        .feature-icon {
            font-size: 3rem;
            margin-bottom: 1.5rem;
            display: inline-block;
            color: var(--accent-pink);
        }

        .feature-title {
            font-weight: 700;
            margin-bottom: 1rem;
            color: var(--text-primary);
            font-size: 1.4rem;
        }

        .feature-desc {
            font-size: 1rem;
            color: var(--text-secondary);
            line-height: 1.6;
        }

        /* == How It Works Section == */
        .steps-container {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 2rem;
            position: relative;
        }

        .step {
            text-align: center;
            position: relative;
            padding: 0 1rem;
        }

        .step-number {
            width: 60px;
            height: 60px;
            background: var(--primary-gradient);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            font-weight: 700;
            margin: 0 auto 1.5rem;
            color: white;
            box-shadow: 0 0 15px rgba(255, 107, 157, 0.5);
        }

        .step-title {
            font-size: 1.3rem;
            margin-bottom: 1rem;
            color: var(--accent-pink);
            font-weight: 600;
        }

        .step-desc {
            color: var(--text-secondary);
            line-height: 1.6;
        }

        /* == Pricing Section == */
        .pricing-section {
            background: var(--bg-tertiary);
            backdrop-filter: blur(20px);
        }

        .pricing-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 2rem;
        }

        .pricing-card {
            background: var(--glass-bg);
            backdrop-filter: blur(15px);
            border: 1px solid var(--glass-border);
            border-radius: var(--border-radius-md);
            padding: 2.5rem 2rem;
            text-align: center;
            transition: all var(--transition-speed) ease;
            position: relative;
            overflow: hidden;
        }

        .pricing-card.popular {
            border: 2px solid var(--accent-pink);
            transform: scale(1.03);
            z-index: 1;
        }

        .popular-badge {
            position: absolute;
            top: 0;
            right: 20px;
            background: var(--accent-pink);
            color: white;
            padding: 0.3rem 1rem;
            border-bottom-left-radius: var(--border-radius-sm);
            border-bottom-right-radius: var(--border-radius-sm);
            font-size: 0.8rem;
            font-weight: 600;
        }

        .pricing-card:not(.popular):hover {
            transform: translateY(-10px);
            box-shadow: var(--shadow-md);
        }

        .pricing-card.popular:hover {
            box-shadow: 0 20px 40px rgba(255, 107, 157, 0.3);
        }

        .pricing-title {
            font-size: 1.5rem;
            margin-bottom: 1rem;
            color: var(--text-primary);
            font-weight: 600;
        }

        .pricing-price {
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
            color: var(--text-primary);
            background: var(--primary-gradient);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .pricing-period {
            font-size: 1rem;
            color: var(--text-muted);
            display: block;
            margin-bottom: 1.5rem;
        }

        .pricing-features {
            list-style: none;
            margin-bottom: 2rem;
            padding: 0;
        }

        .pricing-features li {
            padding: 0.75rem 0;
            color: var(--text-secondary);
            border-bottom: 1px solid var(--glass-border);
        }

        .pricing-features li:last-child {
            border-bottom: none;
        }

        /* == Footer == */
        .footer {
            padding: 5rem 0 2rem;
            background: var(--bg-secondary);
            border-top: 1px solid var(--glass-border);
        }

        .footer-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 2.5rem;
            margin-bottom: 3rem;
        }

        .footer-logo {
            font-family: 'Orbitron', monospace;
            font-size: 1.75rem;
            font-weight: 900;
            background: var(--primary-gradient);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            margin-bottom: 1.5rem;
            display: inline-block;
            text-decoration: none;
        }

        .footer-text {
            color: var(--text-muted);
            line-height: 1.6;
            margin-bottom: 1.5rem;
            font-size: 0.95rem;
        }

        .footer-title {
            font-size: 1.2rem;
            margin-bottom: 1.5rem;
            color: var(--text-primary);
            font-weight: 600;
        }

        .footer-links {
            list-style: none;
            padding: 0;
        }

        .footer-link {
            margin-bottom: 0.75rem;
        }

        .footer-link a {
            color: var(--text-muted);
            text-decoration: none;
            transition: color var(--transition-speed) ease;
        }

        .footer-link a:hover {
            color: var(--accent-pink);
        }

        .social-links {
            display: flex;
            gap: 1rem;
            margin-top: 1.5rem;
        }

        .social-link {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: var(--bg-tertiary);
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--text-primary);
            transition: all var(--transition-speed) ease;
            font-size: 1rem;
        }

        .social-link:hover {
            background: var(--accent-pink);
            transform: translateY(-3px);
        }

        .download-buttons {
            display: flex;
            flex-direction: column;
            gap: 0.75rem;
            margin-top: 1.5rem;
        }

        .download-btn {
            padding: 0.75rem 1rem;
            background: var(--bg-tertiary);
            border-radius: var(--border-radius-sm);
            display: flex;
            align-items: center;
            justify-content: center;
            transition: background var(--transition-speed) ease;
            text-decoration: none;
            color: var(--text-primary);
            font-size: 0.9rem;
        }

        .download-btn i {
            margin-right: 0.5rem;
            font-size: 1.1rem;
        }

        .download-btn:hover {
            background: rgba(255, 107, 157, 0.2);
        }

        .copyright {
            text-align: center;
            margin-top: 3rem;
            padding-top: 2rem;
            border-top: 1px solid var(--glass-border);
            color: var(--text-muted);
            font-size: 0.9rem;
        }

        /* == Modal Styles == */
        .modal {
            display: none;
            position: fixed;
            z-index: 9999;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.8);
            backdrop-filter: blur(10px);
            animation: fadeIn 0.3s ease;
            overflow-y: auto;
            align-items: center;
            justify-content: center;
        }

        .modal.show {
            display: flex;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
            }

            to {
                opacity: 1;
            }
        }

        .modal-content {
            background: var(--glass-bg);
            backdrop-filter: blur(20px);
            border: 1px solid var(--glass-border);
            border-radius: var(--border-radius-md);
            padding: 2.5rem;
            width: 90%;
            max-width: 450px;
            position: relative;
            box-shadow: var(--shadow-lg);
            animation: slideIn 0.3s ease;
            margin: 1.5rem auto;
        }

        [data-theme="light"] .modal-content {
            background: rgba(255, 255, 255, 0.95);
        }

        @keyframes slideIn {
            from {
                transform: translateY(-50px);
                opacity: 0;
            }

            to {
                transform: translateY(0);
                opacity: 1;
            }
        }

        .modal-header {
            text-align: center;
            margin-bottom: 2rem;
        }

        .modal-title {
            font-size: 1.8rem;
            font-weight: 700;
            background: var(--primary-gradient);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            margin-bottom: 0.75rem;
        }

        .modal-subtitle {
            color: var(--text-muted);
            font-size: 0.9rem;
        }

        .close {
            position: absolute;
            top: 1rem;
            right: 1.25rem;
            font-size: 1.75rem;
            font-weight: bold;
            color: var(--text-muted);
            cursor: pointer;
            transition: color var(--transition-speed) ease;
            line-height: 1;
        }

        .close:hover {
            color: var(--accent-pink);
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-label {
            display: block;
            margin-bottom: 0.5rem;
            color: var(--text-secondary);
            font-weight: 500;
            font-size: 0.9rem;
        }

        .form-input {
            width: 100%;
            padding: 0.75rem 1rem;
            background: var(--bg-tertiary);
            border: 1px solid var(--glass-border);
            border-radius: var(--border-radius-sm);
            color: var(--text-primary);
            font-size: 1rem;
            transition: all var(--transition-speed) ease;
        }

        .form-input:focus {
            outline: none;
            border-color: var(--accent-pink);
            box-shadow: 0 0 0 3px rgba(255, 107, 157, 0.2);
        }

        .form-input::placeholder {
            color: var(--text-muted);
        }

        .password-input-group {
            position: relative;
        }

        .password-toggle {
            position: absolute;
            right: 0.75rem;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            color: var(--text-muted);
            cursor: pointer;
            font-size: 1.1rem;
            transition: color var(--transition-speed) ease;
            padding: 0;
        }

        .password-toggle:hover {
            color: var(--accent-pink);
        }

        .form-checkbox {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            margin-bottom: 1.5rem;
        }

        .form-checkbox input {
            width: 18px;
            height: 18px;
            accent-color: var(--accent-pink);
            cursor: pointer;
        }

        .form-checkbox label {
            color: var(--text-secondary);
            font-size: 0.9rem;
            cursor: pointer;
        }

        .modal-btn {
            width: 100%;
            padding: 1rem;
            background: var(--primary-gradient);
            border: none;
            border-radius: var(--border-radius-sm);
            color: white;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all var(--transition-speed) ease;
            margin-bottom: 1.5rem;
        }

        .modal-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(255, 107, 157, 0.4);
            background: var(--primary-gradient-hover);
        }

        .google-btn {
            background-color: var(--bg-secondary);
            color: var(--text-primary);
            border: 1px solid var(--glass-border);
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
        }

        [data-theme="light"] .google-btn {
            background-color: #ffffff;
            color: #444;
            border: 1px solid #ccc;
        }

        .google-btn i {
            font-size: 1rem;
        }

        .modal-footer {
            text-align: center;
            margin-top: 1.5rem;
        }

        .modal-footer p {
            color: var(--text-muted);
            font-size: 0.9rem;
            margin-bottom: 0.5rem;
        }

        .modal-link {
            color: var(--accent-pink);
            text-decoration: none;
            transition: color var(--transition-speed) ease;
            font-weight: 500;
        }

        .modal-link:hover {
            color: var(--accent-blue);
            text-decoration: underline;
        }

        /* == Mobile Bottom Navigation == */
        .mobile-bottom-nav {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            background: var(--bg-secondary);
            backdrop-filter: blur(20px);
            border-top: 1px solid var(--glass-border);
            z-index: 999;
            display: none;
            padding: 0.5rem 0;
        }

        .mobile-bottom-nav .nav-container {
            max-width: 100%;
            margin: 0 auto;
        }

        .mobile-bottom-nav .nav-list {
            display: flex;
            justify-content: space-around;
            list-style: none;
            margin: 0;
            padding: 0;
        }

        .mobile-bottom-nav .nav-item {
            flex: 1;
        }

        .mobile-bottom-nav .nav-link {
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 0.5rem 0.25rem;
            text-decoration: none;
            color: var(--text-muted);
            transition: all var(--transition-speed) ease;
            border-radius: var(--border-radius-sm);
        }

        .mobile-bottom-nav .nav-link.active,
        .mobile-bottom-nav .nav-link:active {
            color: var(--accent-pink);
            background: rgba(255, 107, 157, 0.1);
        }

        .mobile-bottom-nav .nav-icon-container {
            margin-bottom: 0.25rem;
        }

        .mobile-bottom-nav .nav-icon {
            font-size: 1.2rem;
        }

        .mobile-bottom-nav .nav-text {
            font-size: 0.7rem;
            font-weight: 500;
            white-space: nowrap;
        }

        /* == Toast Notification == */
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
            background: var(--bg-secondary);
            color: var(--text-primary);
            padding: 1rem 1.5rem;
            border-radius: var(--border-radius-sm);
            display: flex;
            align-items: center;
            gap: 0.75rem;
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

        .toast.success .toast-icon {
            color: #4CAF50;
        }

        .toast.error .toast-icon {
            color: #F44336;
        }

        .toast.warning .toast-icon {
            color: #FFC107;
        }

        .toast.info .toast-icon {
            color: var(--accent-blue);
        }

        /* == Custom Scrollbar == */
        ::-webkit-scrollbar {
            width: 8px;
            height: 8px;
        }

        ::-webkit-scrollbar-track {
            background: var(--bg-primary);
        }

        ::-webkit-scrollbar-thumb {
            background: var(--accent-pink);
            border-radius: 4px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: #ff5a8a;
        }

        /* == Responsive Design == */

        /* Extra Small Devices (Portrait Phones, less than 576px) */
        @media (max-width: 575.98px) {
            .container {
                padding: 0 0.75rem;
            }

            .control-buttons {
                right: 10px;
                gap: 8px;
            }

            .control-btn {
                width: 40px;
                height: 40px;
                font-size: 0.9rem;
            }

            .permission-status {
                right: 10px;
                max-width: calc(100% - 20px);
                top: 70px;
            }

            .cookie-content {
                flex-direction: column;
                gap: 1rem;
            }

            .cookie-text {
                min-width: auto;
            }

            .cookie-buttons {
                justify-content: center;
                width: 100%;
            }

            .cookie-btn {
                flex: 1;
                min-width: 80px;
            }

            .nav-links,
            .login-btn {
                display: none;
            }

            .mobile-bottom-nav {
                display: block;
            }

            .hero-section {
                padding: 6rem 0.75rem 5rem;
            }

            .hero-buttons {
                flex-direction: column;
                align-items: stretch;
                gap: 0.75rem;
            }

            .cta-button {
                padding: 0.875rem 1.5rem;
                font-size: 0.9rem;
            }

            .section {
                padding: 4rem 0;
            }

            .about-content {
                grid-template-columns: 1fr;
                gap: 2rem;
            }

            .about-text {
                padding-right: 0;
                order: 2;
            }

            .about-future {
                order: 1;
                padding: 1.5rem;
            }

            .features-grid {
                grid-template-columns: 1fr;
                gap: 1.5rem;
            }

            .feature-card {
                padding: 2rem 1.5rem;
            }

            .steps-container {
                grid-template-columns: 1fr;
                gap: 2.5rem;
            }

            .pricing-grid {
                grid-template-columns: 1fr;
            }

            .pricing-card.popular {
                transform: scale(1);
            }

            .footer-grid {
                grid-template-columns: 1fr;
                text-align: center;
                gap: 2rem;
            }

            .modal-content {
                padding: 2rem 1.5rem;
                margin: 1rem;
                max-width: calc(100% - 2rem);
            }
        }

        /* Small Devices (Landscape Phones, 576px and up) */
        @media (min-width: 576px) and (max-width: 767.98px) {
            .mobile-bottom-nav {
                display: block;
            }

            .nav-links,
            .login-btn {
                display: none;
            }

            .about-content {
                grid-template-columns: 1fr;
                gap: 2.5rem;
            }

            .about-text {
                padding-right: 0;
            }

            .steps-container {
                grid-template-columns: repeat(2, 1fr);
            }

            .pricing-card.popular {
                transform: scale(1);
            }

            .cookie-content {
                flex-wrap: nowrap;
            }
        }

        /* Medium Devices (Tablets, 768px and up) */
        @media (min-width: 768px) and (max-width: 991.98px) {
            .mobile-bottom-nav {
                display: none;
            }

            .nav-links {
                gap: 1.5rem;
            }

            .about-content {
                grid-template-columns: 1fr;
                gap: 3rem;
            }

            .about-text {
                padding-right: 0;
            }

            .steps-container {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        /* Large Devices (Desktops, 992px and up) */
        @media (min-width: 992px) {
            .mobile-bottom-nav {
                display: none !important;
            }

            .about-content {
                grid-template-columns: 1fr 1fr;
            }

            .steps-container {
                grid-template-columns: repeat(4, 1fr);
            }

            .steps-container::before {
                content: '';
                position: absolute;
                top: 30px;
                left: 15%;
                right: 15%;
                height: 2px;
                background: repeating-linear-gradient(90deg,
                        var(--accent-pink),
                        var(--accent-pink) 5px,
                        transparent 5px,
                        transparent 10px);
                z-index: -1;
            }
        }

        /* Extra Large Devices (Large Desktops, 1200px and up) */
        @media (min-width: 1200px) {
            .container {
                padding: 0 2rem;
            }
        }

        /* High DPI/Retina Displays */
        @media (-webkit-min-device-pixel-ratio: 2),
        (min-resolution: 192dpi) {
            .hero-title {
                text-rendering: optimizeLegibility;
            }
        }

        /* Landscape Orientation for Mobile */
        @media (max-width: 767.98px) and (orientation: landscape) {
            .hero-section {
                min-height: 80vh;
                padding: 5rem 1rem 4rem;
            }

            .mobile-bottom-nav {
                padding: 0.25rem 0;
            }

            .mobile-bottom-nav .nav-text {
                font-size: 0.6rem;
            }

            .cookie-banner {
                padding: 1rem;
            }

            .permission-status {
                top: 60px;
                max-width: 250px;
            }
        }

        /* Reduced Motion */
        @media (prefers-reduced-motion: reduce) {
            * {
                animation-duration: 0.01ms !important;
                animation-iteration-count: 1 !important;
                transition-duration: 0.01ms !important;
            }
        }
    </style>
</head>
