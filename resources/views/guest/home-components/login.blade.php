    <div id="loginModal" class="modal">
        <div class="modal-content">
            <span class="close" data-modal-close>&times;</span>
            <div class="modal-header">
                <h2 class="modal-title">Masuk ke Miluv</h2>
                <p class="modal-subtitle">Lanjutkan perjalanan cinta Anda</p>
            </div>
            <form method="GET" action="{{ url('oauth/google') }}" id="googleLoginForm">
                <button type="submit" class="modal-btn google-btn">
                    <i class="fab fa-google"></i> Masuk dengan Google
                </button>
            </form>
            <div class="modal-footer">
                <p>Belum punya akun?
                    <a href="#" class="modal-link" data-modal-target="registerModal" data-modal-close-current>
                        Daftar di sini
                    </a>
                </p>
            </div>
        </div>
    </div>
