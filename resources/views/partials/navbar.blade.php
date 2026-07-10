<nav class="navbar navbar-dark bg-black border-bottom border-secondary">

    <div class="container-fluid">

        <span class="navbar-brand fw-bold">
            🌍 Global Supply Chain Risk Intelligence Platform
        </span>

        <div class="d-flex align-items-center text-white">

            {{-- Jam --}}
            <span id="clock" class="me-4"></span>

            {{-- Status --}}
            <span class="me-4">
                <i class="fas fa-circle text-success"></i>
                Online
            </span>

            {{-- Nama User --}}
            <span class="me-3">
                <i class="fas fa-user-circle text-info"></i>
                {{ Auth::user()->name }}
            </span>

            {{-- Logout --}}
            <form method="POST" action="{{ route('logout') }}">
                @csrf

                <button type="submit" class="btn btn-danger btn-sm">
                    <i class="fas fa-sign-out-alt"></i>
                    Logout
                </button>
            </form>

        </div>

    </div>

</nav>

<script>

setInterval(function () {

    document.getElementById('clock').innerHTML =
        new Date().toLocaleTimeString();

}, 1000);

</script>