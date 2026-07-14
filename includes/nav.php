<?php
$user = getCurrentUser();
$currentPage = basename($_SERVER['PHP_SELF']);
?>
<nav class="navbar navbar-expand-lg fixed-top">
    <div class="container">
        <a class="navbar-brand" href="index.php">FoodFinder<span style="color:#F5B041;"> Karachi</span></a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon" style="filter: invert(1);"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav mx-auto mb-2 mb-lg-0">
                <li class="nav-item"><a class="nav-link <?php echo $currentPage === 'index.php' ? 'active' : ''; ?>" href="index.php">Home</a></li>
                <li class="nav-item"><a class="nav-link <?php echo $currentPage === 'restaurants.php' ? 'active' : ''; ?>" href="restaurants.php">Restaurants</a></li>
                <li class="nav-item"><a class="nav-link <?php echo $currentPage === 'cafes.php' ? 'active' : ''; ?>" href="cafes.php">Cafes</a></li>
                <li class="nav-item"><a class="nav-link <?php echo $currentPage === 'food-streets.php' ? 'active' : ''; ?>" href="food-streets.php">Food Streets</a></li>
                <li class="nav-item"><a class="nav-link <?php echo $currentPage === 'favorites.php' ? 'active' : ''; ?>" href="favorites.php">Favorites</a></li>
                <li class="nav-item"><a class="nav-link <?php echo $currentPage === 'about.php' ? 'active' : ''; ?>" href="about.php">About</a></li>
                <li class="nav-item"><a class="nav-link <?php echo $currentPage === 'contact.php' ? 'active' : ''; ?>" href="contact.php">Contact</a></li>
            </ul>
            <div class="d-flex align-items-center gap-2 nav-auth-actions">
                <?php if ($user): ?>
                    <?php $displayName = ($user['role'] === 'admin') ? 'Admin' : $user['name']; ?>
                    <span class="text-light small me-2">Hi, <?php echo htmlspecialchars($displayName); ?></span>
                    <?php if ($user['role'] === 'admin'): ?>
                        <a href="admin-panel.php" class="btn btn-outline-gold btn-sm">Admin</a>
                    <?php endif; ?>
                    <a href="logout.php" class="btn btn-outline-gold btn-sm">Logout</a>
                <?php else: ?>
                    <a href="login.php" class="btn btn-outline-gold btn-sm">Login</a>
                    <a href="signup.php" class="btn btn-gold btn-sm">Sign Up</a>
                <?php endif; ?>
            </div>
        </div>
    </div>
</nav>