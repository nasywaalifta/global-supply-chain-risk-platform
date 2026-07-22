<nav class="navbar navbar-expand-lg navbar-light navbar-custom px-4">
    <div class="container-fluid d-flex justify-content-between align-items-center">

        <div class="d-flex align-items-center">

            <button class="btn btn-outline-secondary d-lg-none me-3"
                    id="menu-toggle">
                <i class="fas fa-bars"></i>
            </button>

            <span class="fw-semibold text-secondary"
                style="font-size:0.95rem;font-family:var(--font-heading);">
                @yield('breadcrumb', 'SupplyRisk Platform')
            </span>

        </div>

        <!-- Right Side: Clock and Online Indicator -->
        <div class="d-flex align-items-center gap-3">
            
            <!-- Clock -->
            <div class="rounded-pill px-3 py-1.5 border text-secondary fw-semibold d-flex align-items-center shadow-sm" 
                 style="font-size: 0.85rem; background-color: rgba(255, 255, 255, 0.7); border-color: rgba(226, 232, 240, 0.8) !important; color: var(--text-secondary) !important;">
                <i class="far fa-clock me-2" style="color: var(--primary-color) !important;"></i>
                <span id="nav-clock" style="font-family: monospace; font-size: 0.9rem; letter-spacing: 0.5px;">-</span>
            </div>

            <!-- Online Status -->
            <div class="rounded-pill px-3 py-1.5 border text-success fw-semibold d-flex align-items-center shadow-sm" 
                 style="font-size: 0.85rem; background-color: rgba(255, 255, 255, 0.7); border-color: rgba(226, 232, 240, 0.8) !important;">
                <span class="d-inline-block rounded-circle bg-success me-2" style="width: 8px; height: 8px; animation: pulse 2s infinite;"></span>
                Online
            </div>

        </div>

    </div>
</nav>

<style>
    @keyframes pulse {
        0% {
            transform: scale(0.9);
            box-shadow: 0 0 0 0 rgba(16, 185, 129, 0.7);
        }
        70% {
            transform: scale(1);
            box-shadow: 0 0 0 6px rgba(16, 185, 129, 0);
        }
        100% {
            transform: scale(0.9);
            box-shadow: 0 0 0 0 rgba(16, 185, 129, 0);
        }
    }
</style>

<script>
    function updateClock() {
        const now = new Date();
        const hrs = String(now.getHours()).padStart(2, '0');
        const mins = String(now.getMinutes()).padStart(2, '0');
        const secs = String(now.getSeconds()).padStart(2, '0');

        const el = document.getElementById('nav-clock');

        if (el) {
            el.textContent = `${hrs}:${mins}:${secs}`;
        }
    }

    updateClock();
    setInterval(updateClock, 1000);

    document.addEventListener('DOMContentLoaded', function () {

        const btn = document.getElementById('menu-toggle');
        const sidebar = document.querySelector('.sidebar-custom');

        if (btn && sidebar) {

            btn.addEventListener('click', function () {
                sidebar.classList.toggle('show');
            });

            document.querySelectorAll('.sidebar-custom a').forEach(link => {
                link.addEventListener('click', function () {
                    if (window.innerWidth < 992) {
                        sidebar.classList.remove('show');
                    }
                });
            });

        }

    });
</script>