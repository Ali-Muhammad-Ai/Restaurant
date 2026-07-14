<?php
$page_title = "Contact - FoodFinder Karachi";
$success = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $success = 'Thanks for reaching out! We will respond as soon as possible.';
}
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
                    <li class="nav-item"><a class="nav-link" href="about.php">About</a></li>
                    <li class="nav-item"><a class="nav-link active" href="contact.php">Contact</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <div style="height:76px"></div>
    <section class="hero text-center">
        <div class="container">
            <h1 class="hero-title">Get in Touch</h1>
            <p class="hero-subtitle">Have a question about a restaurant, cafe, or your local city guide? Send us a message.</p>
        </div>
    </section>

    <div class="container my-5">
        <div class="row g-4">
            <div class="col-lg-6">
                <div class="glass-card p-4 contact-form">
                    <h2 class="section-title">Contact Us</h2>
                    <div class="section-divider"></div>
                    <?php if (!empty($success)): ?>
                        <div class="alert alert-success" role="alert">
                            <?php echo htmlspecialchars($success); ?>
                        </div>
                    <?php endif; ?>
                    <form method="POST">
                        <div class="mb-3">
                            <label class="form-label">Name</label>
                            <input type="text" class="form-control" name="name" placeholder="Your name">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input type="email" class="form-control" name="email" placeholder="Your email">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Subject</label>
                            <input type="text" class="form-control" name="subject" placeholder="Message subject">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Message</label>
                            <textarea class="form-control" name="message" placeholder="Write your message..."></textarea>
                        </div>
                        <button class="btn btn-gold">Send Message</button>
                    </form>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="glass-card p-4">
                    <h2 class="section-title">Visit Us</h2>
                    <div class="section-divider"></div>
                    <p class="section-subtitle">We’re here to help with restaurant tips, cafe recommendations, and local dining advice.</p>
                    <div class="mt-4">
                        <p><i class="fas fa-map-marker-alt me-2"></i>Karachi, Pakistan</p>
                        <p><i class="fas fa-envelope me-2"></i>support@foodfinder.com</p>
                        <p><i class="fas fa-phone me-2"></i>+92 300 123 4567</p>
                    </div>
                    <div class="glass-card p-3 mt-4">
                        <h5>Need faster support?</h5>
                        <p class="text-secondary">Drop us a quick note and we’ll guide you to the best places to eat right away.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <footer>
        <div class="container text-center">
            <p class="mb-1">FoodFinder Karachi</p>
            <small>Contact our team for the latest restaurant and cafe updates.</small>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>