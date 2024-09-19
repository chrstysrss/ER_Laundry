<nav class="navbar navbar-expand-md navbar-vertical fixed-left bg-dark-blue">
    <div class="container-fluid">
        <!-- Toggler -->
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <!-- Brand -->
        <a class="navbar-brand p-0" href="dashboard.php">
            <img src="../../src/pictures/logo.png" class="navbar-brand-img">
        </a>
        <!-- Collapse -->
        <div class="collapse navbar-collapse flex-column" id="navbarSupportedContent">
            <!-- Navigation -->
            <ul class="navbar-nav flex-column">
                <li class="nav-item">
                    <a class="nav-link" href="dashboard.php">
                        <i class="fa-solid fa-qrcode fa-xl"></i> 
                        <span>DASHBOARD</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="new_order.php">
                        <i class="fa-regular fa-note-sticky fa-xl"></i> 
                        <span>NEW ORDER</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="orders.php">
                        <i class="fa-solid fa-receipt fa-xl"></i> 
                        <span>ORDERS</span> 
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="products.php">
                        <i class="fa-solid fa-inbox fa-xl"></i> 
                        <span>CONSUMABLES</span> 
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="user_list.php">
                        <i class="fa-solid fa-user-group fa-xl"></i> 
                        <span>USER LIST</span> 
                    </a>
                </li>
            </ul>
            <!-- Divider -->
            <div class="my-4"></div>
            <!-- Navigation -->
            <ul class="navbar-nav mb-3">
                <li class="nav-item">
                    <a class="nav-link" href="../logout.php">
                        <i class="fa-solid fa-arrow-right-from-bracket fa-xl"></i> 
                        <span>SIGN OUT</span>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>