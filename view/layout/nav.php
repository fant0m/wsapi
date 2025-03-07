<nav class="navbar navbar-expand-lg navbar-dark bg-primary mb-4">
    <div class="container">
        <a class="navbar-brand" href="/">WS API Demo</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse">
            <ul class="navbar-nav">
                <li class="nav-item <?php if ($action == $defaultAction) : ?>active<?php endif; ?>">
                    <a class="nav-link" href="./">Home</a>
                </li>
                <li class="nav-item <?php if ($action == 'zones') : ?>active<?php endif; ?>">
                    <a class="nav-link" href="./?action=zones">Zones</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="./random">Unavailable page</a>
                </li>
            </ul>
        </div>
    </div>
</nav>
