<?php
$page_title = "About - FoodFinder Karachi";
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $page_title; ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,300;14..32,400;14..32,600;14..32,700;14..32,800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="assets/style.css">
</head>

<body>
    <nav class="navbar navbar-expand-lg fixed-top">
        <div class="container">
            <a class="navbar-brand" href="index.php">FoodFinder Karachi</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link" href="index.php">Home</a></li>
                    <li class="nav-item"><a class="nav-link" href="restaurants.php">Restaurants</a></li>
                    <li class="nav-item"><a class="nav-link" href="cafes.php">Cafes</a></li>
                    <li class="nav-item active"><a class="nav-link active" href="about.php">About</a></li>
                    <li class="nav-item"><a class="nav-link" href="contact.php">Contact</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <div style="height:76px"></div>
    <section class="hero text-center">
        <div class="container">
            <h1 class="hero-title">About FoodFinder Karachi</h1>
            <p class="hero-subtitle">Your trusted guide to Karachi's most delicious restaurants and cafes.</p>
        </div>
    </section>

    <div class="container my-5">
        <div class="row g-4">
            <div class="col-lg-6">
                <div class="glass-card p-4">
                    <h2 class="section-title">Our Mission</h2>
                    <div class="section-divider"></div>
                    <p class="section-subtitle">We make it easy to find the best dining spots across Karachi with curated recommendations, authentic reviews, and elegant designs.</p>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="glass-card p-4">
                    <h2 class="section-title">What We Offer</h2>
                    <div class="section-divider"></div>
                    <p class="section-subtitle">A seamless experience to discover cafes, restaurants, street food, and hidden gems with rich visuals, filtering, and quick access to details.</p>
                </div>
            </div>
        </div>

        <div class="row g-4 mt-4">
            <div class="col-md-4">
                <div class="glass-card p-4 feature-card">
                    <h5>Curated Choices</h5>
                    <p class="text-secondary">Handpicked spots and featured listings for every mood, cuisine, and location.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="glass-card p-4 feature-card">
                    <h5>Easy Search</h5>
                    <p class="text-secondary">Filter by cuisine, neighborhood, price range and discover the perfect match fast.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="glass-card p-4 feature-card">
                    <h5>Stylish Interface</h5>
                    <p class="text-secondary">A premium glassmorphism look that feels modern, luxurious and easy to navigate.</p>
                </div>
            </div>
        </div>

        <div class="glass-card p-4 mt-5">
            <div class="row align-items-center gy-4">
                <div class="col-lg-8">
                    <h3 class="mb-3">Browse by category</h3>
                    <p class="text-secondary mb-0">From seaside dining at Do Darya to cozy coffee shops in Clifton, explore curated pages for restaurants and cafes.</p>
                </div>
                <div class="col-lg-4 text-lg-end">
                    <a href="restaurants.php" class="btn btn-gold me-2">Explore Restaurants</a>
                    <a href="cafes.php" class="btn btn-outline-gold">Explore Cafes</a>
                </div>
            </div>
        </div>
    </div>

    <footer>
        <div class="container text-center">
            <p class="mb-1">FoodFinder Karachi</p>
            <small>Your local dining discovery platform.</small>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>