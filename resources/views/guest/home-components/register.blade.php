    <div id="registerModal" class="modal">
        <div class="modal-content">
            <span class="close" data-modal-close>&times;</span>
            <div class="modal-header">
                <h2 class="modal-title">Daftar Akun Baru</h2>
                <p class="modal-subtitle">Mulai langkah pertama Anda</p>
            </div>
            <form method="GET" action="{{ url('oauth/google') }}" id="googleRegisterForm">
                <button type="submit" class="modal-btn google-btn">
                    <i class="fab fa-google"></i> Daftar dengan Google
                </button>
            </form>
            <div class="modal-footer">
                <p>Sudah punya akun?
                    <a href="#" class="modal-link" data-modal-target="loginModal" data-modal-close-current>
                        Masuk di sini
                    </a>
                </p>
            </div>
        </div>
    </div>
