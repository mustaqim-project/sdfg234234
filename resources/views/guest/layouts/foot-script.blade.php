


    <script>
        document.getElementById("current-year").textContent = new Date().getFullYear();

        // == Storage and Cookie Management ==
        class StorageManager {
            static setCookie(name, value, days = 365) {
                const expires = new Date();
                expires.setTime(expires.getTime() + (days * 24 * 60 * 60 * 1000));
                document.cookie = `${name}=${value};expires=${expires.toUTCString()};path=/;secure;samesite=strict`;
            }

            static getCookie(name) {
                const nameEQ = name + "=";
                const ca = document.cookie.split(';');
                for (let i = 0; i < ca.length; i++) {
                    let c = ca[i];
                    while (c.charAt(0) == ' ') c = c.substring(1, c.length);
                    if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length, c.length);
                }
                return null;
            }

            static deleteCookie(name) {
                document.cookie = `${name}=;expires=Thu, 01 Jan 1970 00:00:00 UTC;path=/;`;
            }

            static setLocalStorage(key, value) {
                try {
                    const data = {
                        value: value,
                        timestamp: Date.now(),
                        expires: Date.now() + (365 * 24 * 60 * 60 * 1000) // 1 year
                    };
                    localStorage.setItem(key, JSON.stringify(data));
                    return true;
                } catch (e) {
                    console.error('LocalStorage error:', e);
                    return false;
                }
            }

            static getLocalStorage(key) {
                try {
                    const item = localStorage.getItem(key);
                    if (!item) return null;

                    const data = JSON.parse(item);
                    if (Date.now() > data.expires) {
                        localStorage.removeItem(key);
                        return null;
                    }
                    return data.value;
                } catch (e) {
                    console.error('LocalStorage error:', e);
                    return null;
                }
            }

            static clearExpiredData() {
                const keys = Object.keys(localStorage);
                keys.forEach(key => {
                    try {
                        const item = localStorage.getItem(key);
                        if (item) {
                            const data = JSON.parse(item);
                            if (data.expires && Date.now() > data.expires) {
                                localStorage.removeItem(key);
                            }
                        }
                    } catch (e) {
                        // Invalid JSON, possibly not our data
                    }
                });
            }
        }

        // == Permission Manager ==
        class PermissionManager {
            constructor() {
                this.permissions = {
                    camera: 'pending',
                    gallery: 'pending',
                    location: 'pending'
                };
                this.loadPermissionStates();
            }

            async requestCameraPermission() {
                try {
                    const stream = await navigator.mediaDevices.getUserMedia({
                        video: {
                            width: {
                                ideal: 1280
                            },
                            height: {
                                ideal: 720
                            },
                            facingMode: 'user'
                        }
                    });

                    // Stop the stream immediately as we just wanted permission
                    stream.getTracks().forEach(track => track.stop());

                    this.permissions.camera = 'granted';
                    this.updatePermissionUI('camera', 'granted');
                    this.savePermissionStates();

                    showToast('Akses kamera berhasil diberikan!', 'success');
                    return true;
                } catch (error) {
                    console.error('Camera permission denied:', error);
                    this.permissions.camera = 'denied';
                    this.updatePermissionUI('camera', 'denied');
                    this.savePermissionStates();

                    showToast('Akses kamera ditolak. Ubah pengaturan browser untuk mengizinkan.', 'error');
                    return false;
                }
            }

            async requestGalleryPermission() {
                try {
                    // Create file input for gallery access
                    const input = document.createElement('input');
                    input.type = 'file';
                    input.accept = 'image/*,video/*';
                    input.multiple = true;

                    return new Promise((resolve) => {
                        input.onchange = (event) => {
                            const files = event.target.files;
                            if (files.length > 0) {
                                this.permissions.gallery = 'granted';
                                this.updatePermissionUI('gallery', 'granted');
                                this.savePermissionStates();

                                showToast(`${files.length} file dipilih dari galeri!`, 'success');

                                // Process selected files (example)
                                this.processSelectedFiles(files);
                                resolve(true);
                            } else {
                                showToast('Tidak ada file yang dipilih.', 'warning');
                                resolve(false);
                            }
                        };

                        input.oncancel = () => {
                            showToast('Pemilihan file dibatalkan.', 'info');
                            resolve(false);
                        };

                        input.click();
                    });
                } catch (error) {
                    console.error('Gallery access error:', error);
                    this.permissions.gallery = 'denied';
                    this.updatePermissionUI('gallery', 'denied');
                    this.savePermissionStates();

                    showToast('Gagal mengakses galeri.', 'error');
                    return false;
                }
            }

            async requestLocationPermission() {
                if (!navigator.geolocation) {
                    showToast('Geolocation tidak didukung browser Anda.', 'error');
                    return false;
                }

                return new Promise((resolve) => {
                    const options = {
                        enableHighAccuracy: true,
                        timeout: 10000,
                        maximumAge: 300000 // 5 minutes
                    };

                    navigator.geolocation.getCurrentPosition(
                        (position) => {
                            this.permissions.location = 'granted';
                            this.updatePermissionUI('location', 'granted');
                            this.savePermissionStates();

                            const {
                                latitude,
                                longitude
                            } = position.coords;

                            // Store location data
                            StorageManager.setLocalStorage('userLocation', {
                                latitude,
                                longitude,
                                accuracy: position.coords.accuracy,
                                timestamp: Date.now()
                            });

                            showToast(
                                `Lokasi berhasil diperoleh! (${latitude.toFixed(4)}, ${longitude.toFixed(4)})`,
                                'success');
                            resolve(true);
                        },
                        (error) => {
                            console.error('Location permission denied:', error);
                            this.permissions.location = 'denied';
                            this.updatePermissionUI('location', 'denied');
                            this.savePermissionStates();

                            let errorMessage = 'Akses lokasi ditolak.';
                            switch (error.code) {
                                case error.PERMISSION_DENIED:
                                    errorMessage = 'Akses lokasi ditolak oleh pengguna.';
                                    break;
                                case error.POSITION_UNAVAILABLE:
                                    errorMessage = 'Informasi lokasi tidak tersedia.';
                                    break;
                                case error.TIMEOUT:
                                    errorMessage = 'Permintaan lokasi timeout.';
                                    break;
                            }

                            showToast(errorMessage, 'error');
                            resolve(false);
                        },
                        options
                    );
                });
            }

            processSelectedFiles(files) {
                // Example file processing
                Array.from(files).forEach(file => {
                    if (file.type.startsWith('image/')) {
                        // Process image files
                        console.log('Processing image:', file.name);

                        // Example: Create preview
                        const reader = new FileReader();
                        reader.onload = (e) => {
                            // Store image data or create preview
                            console.log('Image loaded:', file.name);
                        };
                        reader.readAsDataURL(file);
                    } else if (file.type.startsWith('video/')) {
                        // Process video files
                        console.log('Processing video:', file.name);
                    }
                });
            }

            updatePermissionUI(type, status) {
                const statusElement = document.getElementById(`${type}Status`);
                const buttonElement = document.getElementById(`request${type.charAt(0).toUpperCase() + type.slice(1)}`);

                if (statusElement) {
                    statusElement.className = `permission-status-indicator ${status}`;
                }

                if (buttonElement) {
                    if (status === 'granted') {
                        buttonElement.textContent = 'Diberikan';
                        buttonElement.disabled = true;
                    } else if (status === 'denied') {
                        buttonElement.textContent = 'Ditolak';
                        buttonElement.disabled = true;
                    }
                }
            }

            savePermissionStates() {
                StorageManager.setLocalStorage('permissions', this.permissions);
            }

            loadPermissionStates() {
                const saved = StorageManager.getLocalStorage('permissions');
                if (saved) {
                    this.permissions = {
                        ...this.permissions,
                        ...saved
                    };

                    // Update UI for each permission
                    Object.keys(this.permissions).forEach(type => {
                        this.updatePermissionUI(type, this.permissions[type]);
                    });
                }
            }
        }

        // == Cookie Consent Manager ==
        class CookieConsent {
            constructor() {
                this.consentGiven = StorageManager.getCookie('cookieConsent') === 'true';
                this.preferences = JSON.parse(StorageManager.getCookie('cookiePreferences') || '{}');

                if (!this.consentGiven) {
                    this.showBanner();
                }

                this.bindEvents();
            }

            showBanner() {
                const banner = document.getElementById('cookieBanner');
                if (banner) {
                    setTimeout(() => {
                        banner.classList.add('show');
                    }, 2000);
                }
            }

            hideBanner() {
                const banner = document.getElementById('cookieBanner');
                if (banner) {
                    banner.classList.remove('show');
                }
            }

            acceptAll() {
                this.consentGiven = true;
                this.preferences = {
                    necessary: true,
                    analytics: true,
                    marketing: true,
                    personalization: true
                };

                this.saveConsent();
                this.hideBanner();
                this.enableFeatures();

                showToast('Semua cookie diterima. Pengalaman optimal tersedia!', 'success');
            }

            declineAll() {
                this.consentGiven = false;
                this.preferences = {
                    necessary: true, // Always required
                    analytics: false,
                    marketing: false,
                    personalization: false
                };

                this.saveConsent();
                this.hideBanner();

                showToast('Cookie non-esensial ditolak.', 'info');
            }

            showSettings() {
                // This would show a detailed cookie settings modal
                showToast('Pengaturan cookie akan segera tersedia!', 'info');

                // For now, just accept all
                this.acceptAll();
            }

            saveConsent() {
                StorageManager.setCookie('cookieConsent', this.consentGiven.toString(), 365);
                StorageManager.setCookie('cookiePreferences', JSON.stringify(this.preferences), 365);

                // Also save to localStorage for faster access
                StorageManager.setLocalStorage('cookieConsent', this.consentGiven);
                StorageManager.setLocalStorage('cookiePreferences', this.preferences);
            }

            enableFeatures() {
                if (this.preferences.analytics) {
                    // Enable analytics tracking
                    console.log('Analytics enabled');
                }

                if (this.preferences.personalization) {
                    // Enable personalization features
                    console.log('Personalization enabled');
                }

                if (this.preferences.marketing) {
                    // Enable marketing cookies
                    console.log('Marketing enabled');
                }
            }

            bindEvents() {
                const acceptBtn = document.getElementById('acceptCookies');
                const declineBtn = document.getElementById('declineCookies');
                const settingsBtn = document.getElementById('cookieSettings');

                if (acceptBtn) {
                    acceptBtn.addEventListener('click', () => this.acceptAll());
                }

                if (declineBtn) {
                    declineBtn.addEventListener('click', () => this.declineAll());
                }

                if (settingsBtn) {
                    settingsBtn.addEventListener('click', () => this.showSettings());
                }
            }
        }

        // == Main Application ==
        document.addEventListener("DOMContentLoaded", () => {
            // --- Constants and Variables ---
            const loadingScreen = document.querySelector(".loading-screen");
            const header = document.querySelector(".header");
            const starsContainer = document.getElementById("stars");
            const particlesContainer = document.getElementById("particles");
            const heartParticlesContainer = document.getElementById("heart-particles");
            const currentYearSpan = document.getElementById("current-year");
            const modals = document.querySelectorAll(".modal");
            const modalTriggers = document.querySelectorAll("[data-modal-target]");
            const modalCloses = document.querySelectorAll("[data-modal-close]");
            const animatedElements = document.querySelectorAll(".animate-on-scroll");
            const toastContainer = document.getElementById("toast-container");
            const mobileNavLinks = document.querySelectorAll(".mobile-bottom-nav .nav-link");
            const desktopNavLinks = document.querySelectorAll(".header .nav-links .nav-link");
            const themeToggle = document.getElementById("themeToggle");
            const fullscreenBtn = document.getElementById("fullscreenBtn");
            const permissionBtn = document.getElementById("permissionBtn");
            const permissionStatus = document.getElementById("permissionStatus");

            // Initialize managers
            const permissionManager = new PermissionManager();
            const cookieConsent = new CookieConsent();

            // Clean up expired localStorage data
            StorageManager.clearExpiredData();

            // --- Initial Setup ---

            // Hide Loading Screen after a delay
            setTimeout(() => {
                if (loadingScreen) {
                    loadingScreen.classList.add("hidden");
                }
            }, 500);

            // Set current year in footer
            if (currentYearSpan) {
                currentYearSpan.textContent = new Date().getFullYear();
            }

            // --- Theme Management ---

            // Load saved theme or default to dark
            const savedTheme = StorageManager.getLocalStorage('theme') || 'dark';
            document.documentElement.setAttribute('data-theme', savedTheme);
            updateThemeIcon(savedTheme);

            function updateThemeIcon(theme) {
                const icon = themeToggle.querySelector('i');
                if (theme === 'dark') {
                    icon.className = 'fas fa-sun';
                    themeToggle.setAttribute('aria-label', 'Switch to light mode');
                } else {
                    icon.className = 'fas fa-moon';
                    themeToggle.setAttribute('aria-label', 'Switch to dark mode');
                }
            }

            if (themeToggle) {
                themeToggle.addEventListener('click', () => {
                    const currentTheme = document.documentElement.getAttribute('data-theme');
                    const newTheme = currentTheme === 'dark' ? 'light' : 'dark';

                    document.documentElement.setAttribute('data-theme', newTheme);
                    StorageManager.setLocalStorage('theme', newTheme);
                    StorageManager.setCookie('theme', newTheme, 365);
                    updateThemeIcon(newTheme);

                    showToast(`Switched to ${newTheme} mode`, 'success');
                });
            }

            // --- Fullscreen Management ---

            let isFullscreen = false;

            function updateFullscreenIcon() {
                const icon = fullscreenBtn.querySelector('i');
                if (isFullscreen) {
                    icon.className = 'fas fa-compress';
                    fullscreenBtn.setAttribute('aria-label', 'Exit fullscreen');
                } else {
                    icon.className = 'fas fa-expand';
                    fullscreenBtn.setAttribute('aria-label', 'Enter fullscreen');
                }
            }

            function toggleFullscreen() {
                if (!document.fullscreenElement) {
                    document.documentElement.requestFullscreen().then(() => {
                        isFullscreen = true;
                        updateFullscreenIcon();
                        showToast('Entered fullscreen mode', 'info');
                    }).catch(err => {
                        console.log(`Error attempting to enable fullscreen: ${err.message}`);
                        showToast('Fullscreen not supported', 'error');
                    });
                } else {
                    document.exitFullscreen().then(() => {
                        isFullscreen = false;
                        updateFullscreenIcon();
                        showToast('Exited fullscreen mode', 'info');
                    });
                }
            }

            if (fullscreenBtn) {
                fullscreenBtn.addEventListener('click', toggleFullscreen);
            }

            // Listen for fullscreen changes (ESC key, etc.)
            document.addEventListener('fullscreenchange', () => {
                isFullscreen = !!document.fullscreenElement;
                updateFullscreenIcon();
            });

            // --- Permission Management ---

            if (permissionBtn && permissionStatus) {
                permissionBtn.addEventListener('click', () => {
                    permissionStatus.classList.toggle('show');
                });

                // Close permission panel when clicking outside
                document.addEventListener('click', (e) => {
                    if (!permissionBtn.contains(e.target) && !permissionStatus.contains(e.target)) {
                        permissionStatus.classList.remove('show');
                    }
                });
            }

            // Bind permission request buttons
            const requestCamera = document.getElementById('requestCamera');
            const requestGallery = document.getElementById('requestGallery');
            const requestLocation = document.getElementById('requestLocation');

            if (requestCamera) {
                requestCamera.addEventListener('click', () => {
                    permissionManager.requestCameraPermission();
                });
            }

            if (requestGallery) {
                requestGallery.addEventListener('click', () => {
                    permissionManager.requestGalleryPermission();
                });
            }

            if (requestLocation) {
                requestLocation.addEventListener('click', () => {
                    permissionManager.requestLocationPermission();
                });
            }

            // --- Background Effects ---

            // Generate Stars
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

            // Generate Particles
            function createParticles(container, className, count = 30, innerHTML = "") {
                if (!container) return;
                for (let i = 0; i < count; i++) {
                    const particle = document.createElement("div");
                    particle.classList.add(className);
                    particle.style.left = `${Math.random() * 100}%`;
                    particle.style.animationDuration = `${Math.random() * 10 + 10}s`;
                    particle.style.animationDelay = `${Math.random() * 15}s`;
                    if (innerHTML) {
                        particle.innerHTML = innerHTML;
                        particle.style.fontSize = `${Math.random() * 6 + 8}px`;
                    }
                    container.appendChild(particle);
                }
            }

            createStars(starsContainer);
            createParticles(particlesContainer, "particle");
            createParticles(heartParticlesContainer, "heart-particle", 15, "❤");

            // --- Header Scroll Effect ---
            function handleScroll() {
                if (header) {
                    if (window.scrollY > 50) {
                        header.classList.add("scrolled");
                    } else {
                        header.classList.remove("scrolled");
                    }
                }
            }

            window.addEventListener("scroll", handleScroll);
            handleScroll();

            // --- Modal Functionality ---
            function openModal(modalId) {
                const modal = document.getElementById(modalId);
                if (modal) {
                    modal.classList.add("show");
                    document.body.style.overflow = "hidden";
                }
            }

            function closeModal(modal) {
                if (modal) {
                    modal.classList.remove("show");
                    document.body.style.overflow = "";
                }
            }

            modalTriggers.forEach(trigger => {
                trigger.addEventListener("click", (e) => {
                    e.preventDefault();
                    const modalId = trigger.getAttribute("data-modal-target");
                    const currentModal = trigger.closest(".modal");

                    if (currentModal && trigger.hasAttribute("data-modal-close-current")) {
                        closeModal(currentModal);
                    }
                    openModal(modalId);
                });
            });

            modalCloses.forEach(closeBtn => {
                closeBtn.addEventListener("click", () => {
                    closeModal(closeBtn.closest(".modal"));
                });
            });

            modals.forEach(modal => {
                modal.addEventListener("click", (e) => {
                    if (e.target === modal) {
                        closeModal(modal);
                    }
                });
            });

            document.addEventListener("keydown", (e) => {
                if (e.key === "Escape") {
                    modals.forEach(modal => {
                        if (modal.classList.contains("show")) {
                            closeModal(modal);
                        }
                    });

                    // Also close permission panel
                    if (permissionStatus) {
                        permissionStatus.classList.remove('show');
                    }
                }
            });

            // --- Scroll Animations ---
            const observerOptions = {
                root: null,
                rootMargin: "0px",
                threshold: 0.1
            };

            const observerCallback = (entries, observer) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        const delay = entry.target.style.getPropertyValue("--animation-delay") || "0s";
                        entry.target.style.transitionDelay = delay;
                        entry.target.classList.add("in-view");
                        observer.unobserve(entry.target);
                    }
                });
            };

            const scrollObserver = new IntersectionObserver(observerCallback, observerOptions);

            animatedElements.forEach(el => {
                scrollObserver.observe(el);
            });

            // --- Toast Notifications ---
            window.showToast = function(message, type = "info", duration = 3000) {
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
            };

            // --- Active Link Highlighting ---
            function updateActiveLink(links) {
                const currentHash = window.location.hash || "#home";
                links.forEach(link => {
                    const href = link.getAttribute("href");
                    if (href === currentHash) {
                        link.classList.add("active");
                    } else {
                        link.classList.remove("active");
                    }
                });
            }

            window.addEventListener("hashchange", () => {
                updateActiveLink(mobileNavLinks);
                updateActiveLink(desktopNavLinks);
            });

            updateActiveLink(mobileNavLinks);
            updateActiveLink(desktopNavLinks);

            mobileNavLinks.forEach(link => {
                link.addEventListener("click", () => {
                    mobileNavLinks.forEach(l => l.classList.remove("active"));
                    link.classList.add("active");
                });
            });

            // --- Smooth Scrolling for Hash Links ---
            document.querySelectorAll('a[href^="#"]').forEach(anchor => {
                anchor.addEventListener('click', function(e) {
                    e.preventDefault();
                    const targetId = this.getAttribute('href');
                    const targetElement = document.querySelector(targetId);

                    if (targetElement) {
                        const headerHeight = header.offsetHeight;
                        const targetPosition = targetElement.offsetTop - headerHeight;

                        window.scrollTo({
                            top: targetPosition,
                            behavior: 'smooth'
                        });
                    }
                });
            });

            // --- Keyboard Navigation Support ---
            document.addEventListener('keydown', (e) => {
                // Alt + T for theme toggle
                if (e.altKey && e.key === 't') {
                    e.preventDefault();
                    if (themeToggle) themeToggle.click();
                }

                // Alt + F for fullscreen toggle
                if (e.altKey && e.key === 'f') {
                    e.preventDefault();
                    if (fullscreenBtn) fullscreenBtn.click();
                }

                // Alt + P for permission panel
                if (e.altKey && e.key === 'p') {
                    e.preventDefault();
                    if (permissionBtn) permissionBtn.click();
                }
            });

            // --- Responsive Control Buttons ---
            function adjustControlButtons() {
                const controlButtons = document.querySelector('.control-buttons');
                const cookieBanner = document.getElementById('cookieBanner');

                if (window.innerWidth <= 575.98) {
                    // Move control buttons to avoid mobile nav collision
                    if (document.querySelector('.mobile-bottom-nav').style.display !== 'none') {
                        controlButtons.style.bottom = '80px';
                    }

                    // Adjust for cookie banner
                    if (cookieBanner && cookieBanner.classList.contains('show')) {
                        controlButtons.style.bottom = '200px';
                    }
                } else {
                    controlButtons.style.bottom = '';
                }
            }

            window.addEventListener('resize', adjustControlButtons);
            adjustControlButtons();

            // --- Performance: Throttle scroll events ---
            let ticking = false;

            function requestTick() {
                if (!ticking) {
                    requestAnimationFrame(handleScroll);
                    ticking = true;
                }
            }

            window.addEventListener('scroll', () => {
                requestTick();
                ticking = false;
            });

            // --- App Functions ---
            window.startReadinessTest = function() {
                // Check if user has granted necessary permissions
                if (permissionManager.permissions.camera !== 'granted') {
                    showToast('Akses kamera diperlukan untuk verifikasi identitas.', 'warning');
                    permissionStatus.classList.add('show');
                    return;
                }

                showToast('Memulai Tes Kesiapan Menikah...', 'info');
                // Implement readiness test logic
            };

            window.findCompatiblePartner = function() {
                // Check if user has granted location permission
                if (permissionManager.permissions.location !== 'granted') {
                    showToast('Akses lokasi diperlukan untuk pencarian pasangan terdekat.', 'warning');
                    permissionStatus.classList.add('show');
                    return;
                }

                showToast('Mencari pasangan compatible di sekitar Anda...', 'info');
                // Implement partner search logic
            };

            window.addEventListener('DOMContentLoaded', function() {
                document.getElementById('googleLoginForm').addEventListener('submit', function(event) {
                    event.preventDefault();

                    showToast('Menghubungkan dengan Google OAuth...', 'info');

                    StorageManager.setLocalStorage('loginAttempt', {
                        method: 'google',
                        timestamp: Date.now()
                    });

                    // Simulasi delay lalu redirect ke Google OAuth
                    setTimeout(() => {
                        showToast('Login berhasil! Selamat datang di Miluv.', 'success');
                        closeModal('loginModal');
                        this.submit(); // lanjutkan redirect ke /oauth/google
                    }, 1000);
                });

                document.getElementById('googleRegisterForm').addEventListener('submit', function(event) {
                    event.preventDefault();

                    showToast('Mendaftar dengan Google OAuth...', 'info');

                    StorageManager.setLocalStorage('registerAttempt', {
                        method: 'google',
                        timestamp: Date.now()
                    });

                    setTimeout(() => {
                        showToast('Registrasi berhasil! Selamat bergabung di Miluv.',
                            'success');
                        closeModal('registerModal');
                        this.submit(); // lanjutkan redirect ke /oauth/google
                    }, 1000);
                });
            });

            function closeModal(modalId) {
                const modal = document.getElementById(modalId);
                if (modal) {
                    modal.classList.remove('show');
                    document.body.style.overflow = "";
                }
            }

            // Success message on load
            setTimeout(() => {
                showToast('Welcome to Miluv 2.0! 💝', 'success');

                // Show permission reminder if not granted
                setTimeout(() => {
                    const hasAllPermissions = Object.values(permissionManager.permissions).every(
                        p => p === 'granted');
                    if (!hasAllPermissions) {
                        showToast(
                            '💡 Izinkan akses kamera, galeri, dan lokasi untuk pengalaman optimal!',
                            'info', 5000);
                    }
                }, 3000);
            }, 1000);

            // Periodic cleanup
            setInterval(() => {
                StorageManager.clearExpiredData();
            }, 60000); // Every minute
        });
    </script>
