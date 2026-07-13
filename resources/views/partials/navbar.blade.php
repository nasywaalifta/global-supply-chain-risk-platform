<nav class="navbar navbar-dark bg-black border-bottom border-secondary shadow-sm">

    <div class="container-fluid">

        <!-- Judul -->
        <span class="navbar-brand fw-bold">
            🌍 Global Supply Chain Risk Intelligence Platform
        </span>

        <div class="d-flex align-items-center text-white">

            <!-- Jam -->
            <span id="clock" class="me-4 text-info fw-semibold"></span>

            <!-- Status -->
            <span class="me-4">
                <i class="fas fa-circle text-success"></i>
                Sistem Aktif
            </span>

            <!-- Pengguna -->
            <span class="me-3">
                <i class="fas fa-user-circle text-info"></i>
                {{ Auth::user()->name }}
            </span>

            <!-- Tombol Keluar -->
            <form method="POST" action="{{ route('logout') }}">
                @csrf

                <button type="submit" class="btn btn-danger btn-sm">
                    <i class="fas fa-sign-out-alt"></i>
                    Keluar
                </button>
            </form>

        </div>

    </div>

</nav>

<script>
setInterval(function () {

    const now = new Date();

    document.getElementById('clock').innerHTML =
        now.toLocaleDateString('id-ID') +
        ' | ' +
        now.toLocaleTimeString('id-ID');

}, 1000);
</script>