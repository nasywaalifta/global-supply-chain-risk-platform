<nav class="navbar navbar-dark bg-black border-bottom border-secondary">

    <div class="container-fluid">

        <span class="navbar-brand">

            🌍 Global Supply Chain Risk Intelligence Platform

        </span>

        <div class="text-white">

            <span id="clock"></span>

            <span class="ms-4">

                <i class="fas fa-circle text-success"></i>

                Online

            </span>

        </div>

    </div>

</nav>

<script>

setInterval(function(){

    document.getElementById('clock').innerHTML =
        new Date().toLocaleTimeString();

},1000);

</script>