<?php
$page_title = "FoodFinder Karachi - Discover Best Cafes & Restaurants";
include 'config/database.php';
$conn = getConnection();

$favoriteAdded = false;
$favoriteRemoved = false;
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['item_type'], $_POST['item_id'])) {
    $itemType = $_POST['item_type'];
    $itemId = intval($_POST['item_id']);

    if ($_POST['favorite_action'] === 'add') {
        if ($itemType === 'restaurant') {
            $itemStmt = $conn->prepare("SELECT * FROM restaurants WHERE id = ?");
            $itemStmt->bind_param('i', $itemId);
            $itemStmt->execute();
            $itemResult = $itemStmt->get_result();
            $itemRow = $itemResult->fetch_assoc();
            if ($itemRow) {
                addFavoriteItem('restaurant', $itemRow['id'], [
                    'name' => $itemRow['name'],
                    'url' => 'restaurant.php?id=' . $itemRow['id'],
                    'subtitle' => $itemRow['cuisine'] . ' · ' . $itemRow['location']
                ]);
            }
            $itemStmt->close();
        } elseif ($itemType === 'cafe') {
            $itemStmt = $conn->prepare("SELECT * FROM cafes WHERE id = ?");
            $itemStmt->bind_param('i', $itemId);
            $itemStmt->execute();
            $itemResult = $itemStmt->get_result();
            $itemRow = $itemResult->fetch_assoc();
            if ($itemRow) {
                addFavoriteItem('cafe', $itemRow['id'], [
                    'name' => $itemRow['name'],
                    'url' => 'cafe.php?id=' . $itemRow['id'],
                    'subtitle' => $itemRow['coffee_types'] . ' · ' . $itemRow['location']
                ]);
            }
            $itemStmt->close();
        } elseif ($itemType === 'food_street') {
            $itemStmt = $conn->prepare("SELECT * FROM food_streets WHERE id = ?");
            $itemStmt->bind_param('i', $itemId);
            $itemStmt->execute();
            $itemResult = $itemStmt->get_result();
            $itemRow = $itemResult->fetch_assoc();
            if ($itemRow) {
                addFavoriteItem('food_street', $itemRow['id'], [
                    'name' => $itemRow['name'],
                    'url' => 'food-street.php?id=' . $itemRow['id'],
                    'subtitle' => $itemRow['location']
                ]);
            }
            $itemStmt->close();
        }
        $favoriteAdded = true;
    }

    if ($_POST['favorite_action'] === 'remove') {
        removeFavoriteItem($itemType, $itemId);
        $favoriteRemoved = true;
    }

    header('Location: index.php');
    exit();
}

// Get all dynamic data
$stats = getSiteStats($conn);
$featuredRestaurants = getFeaturedRestaurants($conn);
$featuredCafes = getFeaturedCafes($conn);
$foodStreets = getFoodStreets($conn);
$recentReviews = getRecentReviews($conn);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $page_title; ?></title>

    <!-- Bootstrap 5 + Icons + Fonts -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,300;14..32,400;14..32,600;14..32,700;14..32,800&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="assets/style.css">
</head>

<body>

    <?php include 'includes/nav.php'; ?>

    <div style="height: 76px;"></div>

    <!-- Hero Section with Beautiful Image -->
    <section class="hero">
        <div class="container text-center">
            <h1 class="hero-title mb-3 animate-fade-up">
                Discover The Best <span style="color:#F5B041;">Cafes & Restaurants</span><br>in Karachi
            </h1>
            <p class="hero-subtitle mb-4 animate-fade-up" style="animation-delay: 0.1s;">
                Explore 700+ top cafes, restaurants and famous food streets near you
            </p>

            <!-- Location Quick Chips -->
            <div class="d-flex flex-wrap justify-content-center gap-2 mb-5 animate-fade-up" style="animation-delay: 0.2s;">
                <span class="location-badge" onclick="searchLocation('Burns Road')">
                    <i class="fas fa-fire"></i> Burns Road
                </span>
                <span class="location-badge" onclick="searchLocation('Do Darya')">
                    <i class="fas fa-water"></i> Do Darya
                </span>
                <span class="location-badge" onclick="searchLocation('Boat Basin')">
                    <i class="fas fa-ship"></i> Boat Basin
                </span>
                <span class="location-badge" onclick="searchLocation('Hussainabad')">
                    <i class="fas fa-drumstick-bite"></i> Hussainabad
                </span>
                <span class="location-badge" onclick="searchLocation('Bahadurabad')">
                    <i class="fas fa-mug-hot"></i> Bahadurabad
                </span>
                <span class="location-badge" onclick="searchLocation('Zamzama')">
                    <i class="fas fa-gem"></i> Zamzama
                </span>
            </div>

            <!-- Search Bar -->
            <div class="search-bar d-flex flex-wrap align-items-center justify-content-between w-75 mx-auto gap-2 animate-fade-up" style="animation-delay: 0.3s;">
                <input type="text" id="searchInput" class="flex-grow-1" placeholder="Search for restaurant, cafe, or cuisine..." style="min-width: 200px;">
                <select id="locationSelect" class="bg-transparent">
                    <option value="">📍 All Locations</option>
                    <option value="Clifton">🌊 Clifton</option>
                    <option value="DHA">✨ DHA</option>
                    <option value="Gulshan">🌳 Gulshan</option>
                    <option value="Do Darya">⛵ Do Darya</option>
                    <option value="Bahadurabad">☕ Bahadurabad</option>
                    <option value="Zamzama">💎 Zamzama</option>
                </select>
                <button class="search-btn btn-gold px-4" onclick="performSearch()">
                    <i class="fas fa-search me-2"></i> Find Food
                </button>
            </div>

            <!-- Statistics Section -->
            <div class="row mt-5 pt-4 g-4 animate-fade-up" style="animation-delay: 0.4s;">
                <div class="col-md-3 col-6">
                    <div class="stat-number"><?php echo $stats['total_restaurants']; ?>+</div>
                    <div><i class="fas fa-utensils me-1"></i> Restaurants</div>
                </div>
                <div class="col-md-3 col-6">
                    <div class="stat-number"><?php echo $stats['total_cafes']; ?>+</div>
                    <div><i class="fas fa-mug-hot me-1"></i> Cafes</div>
                </div>
                <div class="col-md-3 col-6">
                    <div class="stat-number"><?php echo number_format($stats['total_users'] / 1000, 1); ?>K+</div>
                    <div><i class="fas fa-users me-1"></i> Happy Foodies</div>
                </div>
                <div class="col-md-3 col-6">
                    <div class="stat-number"><?php echo $stats['total_reviews']; ?>+</div>
                    <div><i class="fas fa-star me-1"></i> Reviews</div>
                </div>
            </div>
        </div>
    </section>

    <!-- Featured Cafes Section -->
    <div class="container mt-5 pt-3">
        <div class="d-flex justify-content-between align-items-center">
            <h2 class="fw-bold">
                <i class="fas fa-mug-hot" style="color: var(--gold);"></i>
                Featured Cafes
            </h2>
            <a href="cafes.php" class="text-decoration-none" style="color: var(--gold);">
                View All <i class="fas fa-arrow-right"></i>
            </a>
        </div>
        <div class="row g-4 mt-2">
            <?php foreach ($featuredCafes as $cafe): ?>
                <div class="col-md-3 col-sm-6">
                    <div class="glass-card p-3 text-center">
                        <div class="mb-3">
                            <i class="fas fa-mug-hot fa-3x" style="color: #F5B041;"></i>
                        </div>
                        <h5 class="mt-2 fw-bold"><?php echo htmlspecialchars($cafe['name']); ?></h5>
                        <p class="small text-secondary mb-1">
                            <i class="fas fa-map-marker-alt"></i> <?php echo htmlspecialchars($cafe['location']); ?>
                        </p>
                        <div class="rating">⭐ <?php echo number_format($cafe['rating'], 1); ?></div>
                        <small class="text-secondary d-block mt-2">
                            <i class="fas fa-coffee me-1"></i> <?php echo substr(htmlspecialchars($cafe['coffee_types']), 0, 30); ?>
                        </small>
                        <form method="POST" class="mt-3">
                            <input type="hidden" name="item_type" value="cafe">
                            <input type="hidden" name="item_id" value="<?php echo intval($cafe['id']); ?>">
                            <?php if (isFavoriteItem('cafe', $cafe['id'])): ?>
                                <button type="submit" name="favorite_action" value="remove" class="btn btn-outline-gold w-100">Remove Favorite</button>
                            <?php else: ?>
                                <button type="submit" name="favorite_action" value="add" class="btn btn-gold w-100">Add Favorite</button>
                            <?php endif; ?>
                        </form>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

    <!-- Top Restaurants Section -->
    <div class="container mt-5">
        <div class="d-flex justify-content-between align-items-center">
            <h2 class="fw-bold">
                <i class="fas fa-utensils" style="color: var(--gold);"></i>
                Top Restaurants
            </h2>
            <a href="restaurants.php" class="text-decoration-none" style="color: var(--gold);">
                View All <i class="fas fa-arrow-right"></i>
            </a>
        </div>
        <div class="row g-4 mt-2">
            <?php foreach ($featuredRestaurants as $restaurant): ?>
                <div class="col-md-3 col-sm-6">
                    <div class="glass-card p-3">
                        <div class="text-center mb-2">
                            <i class="fas fa-utensils fa-2x" style="color: var(--gold);"></i>
                        </div>
                        <h5 class="fw-bold text-center"><?php echo htmlspecialchars($restaurant['name']); ?></h5>
                        <p class="small text-secondary text-center mb-1">
                            <i class="fas fa-map-marker-alt"></i> <?php echo htmlspecialchars($restaurant['location']); ?>
                        </p>
                        <p class="small text-secondary text-center mb-2">
                            <i class="fas fa-tag"></i> <?php echo htmlspecialchars($restaurant['cuisine']); ?>
                        </p>
                        <div class="rating text-center">⭐ <?php echo number_format($restaurant['rating'], 1); ?></div>
                        <div class="text-center mt-2">
                            <small class="text-secondary">
                                <i class="far fa-clock"></i> <?php echo substr(htmlspecialchars($restaurant['opening_hours']), 0, 15); ?>...
                            </small>
                        </div>
                        <form method="POST" class="mt-3">
                            <input type="hidden" name="item_type" value="restaurant">
                            <input type="hidden" name="item_id" value="<?php echo intval($restaurant['id']); ?>">
                            <?php if (isFavoriteItem('restaurant', $restaurant['id'])): ?>
                                <button type="submit" name="favorite_action" value="remove" class="btn btn-outline-gold w-100">Remove Favorite</button>
                            <?php else: ?>
                                <button type="submit" name="favorite_action" value="add" class="btn btn-gold w-100">Add Favorite</button>
                            <?php endif; ?>
                        </form>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

    <!-- Famous Food Streets -->
    <div class="container my-5">
        <h2 class="fw-bold mb-4">
            <i class="fas fa-road" style="color: var(--gold);"></i>
            Famous Food Streets
        </h2>
        <div class="row g-4">
            <?php
            $streetIcons = [
                'Burns Road' => 'fire',
                'Do Darya' => 'water',
                'Boat Basin' => 'ship',
                'Hussainabad' => 'drumstick-bite',
                'Bahadurabad' => 'mug-hot',
                'Zamzama' => 'gem'
            ];
            foreach ($foodStreets as $street):
            ?>
                <div class="col-md-4">
                    <div class="glass-card food-street-card p-4 text-center"
                        style="background: linear-gradient(135deg, rgba(0,0,0,0.8), rgba(0,0,0,0.5)), url('https://images.unsplash.com/photo-1559339352-11d035aa65de?w=800'); background-size: cover; background-position: center;">
                        <i class="fas fa-<?php echo $streetIcons[$street['name']] ?? 'location-dot'; ?> fa-2x mb-2" style="color: var(--gold);"></i>
                        <h4 class="fw-bold"><?php echo htmlspecialchars($street['name']); ?></h4>
                        <p class="small text-light"><?php echo htmlspecialchars($street['location']); ?></p>
                        <div class="rating mb-2">⭐ <?php echo number_format($street['rating'], 1); ?></div>
                        <p class="small"><?php echo substr(htmlspecialchars($street['famous_for']), 0, 55); ?>...</p>
                        <form method="POST" class="mb-2">
                            <input type="hidden" name="item_type" value="food_street">
                            <input type="hidden" name="item_id" value="<?php echo intval($street['id']); ?>">
                            <?php if (isFavoriteItem('food_street', $street['id'])): ?>
                                <button type="submit" name="favorite_action" value="remove" class="btn btn-outline-gold w-100 mb-2">Remove Favorite</button>
                            <?php else: ?>
                                <button type="submit" name="favorite_action" value="add" class="btn btn-gold w-100 mb-2">Add Favorite</button>
                            <?php endif; ?>
                        </form>
                        <button class="btn btn-outline-gold btn-sm mt-2" onclick="searchLocation('<?php echo $street['name']; ?>')">
                            Explore Food Street <i class="fas fa-arrow-right"></i>
                        </button>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

    <!-- Dashboard Statistics Card -->
    <div class="container my-5">
        <div class="glass-card p-4">
            <h3 class="text-center mb-4">
                <i class="fas fa-chart-line" style="color: var(--gold);"></i>
                FoodFinder Karachi Dashboard
            </h3>
            <div class="row text-center">
                <div class="col-md-3 col-6">
                    <div class="stat-number"><?php echo $stats['total_restaurants']; ?></div>
                    <div><i class="fas fa-utensils"></i> Total Restaurants</div>
                </div>
                <div class="col-md-3 col-6">
                    <div class="stat-number"><?php echo $stats['total_cafes']; ?></div>
                    <div><i class="fas fa-mug-hot"></i> Total Cafes</div>
                </div>
                <div class="col-md-3 col-6">
                    <div class="stat-number"><?php echo number_format($stats['total_users']); ?></div>
                    <div><i class="fas fa-users"></i> Total Users</div>
                </div>
                <div class="col-md-3 col-6">
                    <div class="stat-number"><?php echo number_format($stats['total_reviews']); ?></div>
                    <div><i class="fas fa-star"></i> Total Reviews</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Customer Reviews Section -->
    <div class="container my-5">
        <h2 class="fw-bold text-center mb-4">
            <i class="fas fa-heart" style="color: var(--gold);"></i>
            What Foodies Say
        </h2>
        <div class="row g-4">
            <?php foreach ($recentReviews as $index => $review): ?>
                <div class="col-md-4">
                    <div class="glass-card review-card p-4">
                        <div class="d-flex align-items-center mb-3">
                            <div class="rounded-circle me-3" style="width: 55px; height: 55px; display: flex; align-items: center; justify-content: center; background: linear-gradient(135deg, var(--gold), #E67E22);">
                                <i class="fas fa-user fa-2x text-dark"></i>
                            </div>
                            <div>
                                <h5 class="mb-0 fw-bold"><?php echo htmlspecialchars($review['user_name']); ?></h5>
                                <small class="text-secondary">
                                    <i class="fas fa-store"></i> <?php echo htmlspecialchars($review['place_name']); ?>
                                </small>
                            </div>
                        </div>
                        <div class="rating mb-2">
                            <?php for ($i = 1; $i <= 5; $i++): ?>
                                <i class="fas fa-star<?php echo $i <= $review['rating'] ? '' : '-o'; ?>" style="color: var(--gold); font-size: 14px;"></i>
                            <?php endfor; ?>
                        </div>
                        <p class="small mb-0">"<?php echo htmlspecialchars(substr($review['comment'], 0, 100)); ?>..."</p>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

    <!-- Popular Areas Quick Links -->
    <div class="container my-5">
        <div class="row g-4">
            <div class="col-md-6">
                <div class="glass-card p-4 d-flex align-items-center gap-3" style="cursor: pointer;" onclick="searchLocation('Boat Basin')">
                    <div><i class="fas fa-ship fa-3x" style="color: var(--gold);"></i></div>
                    <div>
                        <h5 class="fw-bold mb-1">Boat Basin <i class="fas fa-arrow-right" style="font-size: 14px;"></i></h5>
                        <p class="mb-1 small">A hub of restaurants and cafes with stunning views.</p>
                        <span class="rating">⭐ 4.5 (120+ places)</span>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="glass-card p-4 d-flex align-items-center gap-3" style="cursor: pointer;" onclick="searchLocation('Hussainabad')">
                    <div><i class="fas fa-drumstick-bite fa-3x" style="color: var(--gold);"></i></div>
                    <div>
                        <h5 class="fw-bold mb-1">Hussainabad Food Street <i class="fas fa-arrow-right" style="font-size: 14px;"></i></h5>
                        <p class="mb-1 small">Famous for BBQ, street food & late night eats until 3 AM.</p>
                        <span class="rating">⭐ 4.6 (80+ places)</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="pt-5 pb-4 mt-5">
        <div class="container">
            <div class="row">
                <div class="col-md-4 mb-4">
                    <h3 class="fw-bold">FoodFinder <span style="color: var(--gold);">Karachi</span></h3>
                    <p class="mt-3">Your ultimate guide to the best food destinations in the city of lights. Discover, Review, and Share your food experiences with thousands of food lovers.</p>
                    <div class="mt-4">
                        <a href="#" class="social-icon"><i class="fab fa-facebook-f"></i></a>
                        <a href="#" class="social-icon"><i class="fab fa-instagram"></i></a>
                        <a href="#" class="social-icon"><i class="fab fa-twitter"></i></a>
                        <a href="#" class="social-icon"><i class="fab fa-tiktok"></i></a>
                        <a href="#" class="social-icon"><i class="fab fa-youtube"></i></a>
                    </div>
                </div>
                <div class="col-md-2 mb-4">
                    <h5>Quick Links</h5>
                    <ul class="list-unstyled mt-3">
                        <li class="mb-2"><a href="about.php" class="text-decoration-none text-secondary">About Us</a></li>
                        <li class="mb-2"><a href="contact.php" class="text-decoration-none text-secondary">Contact</a></li>
                        <li class="mb-2"><a href="#" class="text-decoration-none text-secondary">Blog</a></li>
                        <li class="mb-2"><a href="#" class="text-decoration-none text-secondary">Careers</a></li>
                        <li class="mb-2"><a href="#" class="text-decoration-none text-secondary">Privacy Policy</a></li>
                    </ul>
                </div>
                <div class="col-md-3 mb-4">
                    <h5>Popular Areas</h5>
                    <ul class="list-unstyled mt-3">
                        <li class="mb-2"><i class="fas fa-map-marker-alt me-2" style="color: var(--gold); font-size: 12px;"></i> Clifton</li>
                        <li class="mb-2"><i class="fas fa-map-marker-alt me-2" style="color: var(--gold); font-size: 12px;"></i> DHA</li>
                        <li class="mb-2"><i class="fas fa-map-marker-alt me-2" style="color: var(--gold); font-size: 12px;"></i> Gulshan</li>
                        <li class="mb-2"><i class="fas fa-map-marker-alt me-2" style="color: var(--gold); font-size: 12px;"></i> North Karachi</li>
                        <li class="mb-2"><i class="fas fa-map-marker-alt me-2" style="color: var(--gold); font-size: 12px;"></i> Bahadurabad</li>
                    </ul>
                </div>
                <div class="col-md-3 mb-4">
                    <h5>Download App</h5>
                    <button class="btn btn-outline-gold w-100 mb-2" onclick="alert('Coming Soon! 🚀')">
                        <i class="fab fa-google-play me-2"></i> Google Play
                    </button>
                    <button class="btn btn-outline-gold w-100 mb-3" onclick="alert('Coming Soon! 🚀')">
                        <i class="fab fa-apple me-2"></i> App Store
                    </button>
                    <div class="mt-3">
                        <p><i class="fas fa-phone-alt me-2" style="color: var(--gold);"></i> +92 21 111-FOOD</p>
                        <p><i class="fas fa-envelope me-2" style="color: var(--gold);"></i> info@foodfinder.pk</p>
                    </div>
                </div>
            </div>
            <hr class="bg-secondary">
            <div class="text-center small text-secondary">
                © 2026 FoodFinder Karachi — Discover & Enjoy. All rights reserved. | Made with <i class="fas fa-heart" style="color: var(--gold);"></i> for Karachi Food Lovers
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Search functionality
        function performSearch() {
            const searchTerm = document.getElementById('searchInput').value;
            const location = document.getElementById('locationSelect').value;

            let url = 'restaurants.php?';
            if (searchTerm) url += 'search=' + encodeURIComponent(searchTerm) + '&';
            if (location) url += 'location=' + encodeURIComponent(location);

            window.location.href = url || 'restaurants.php';
        }

        function searchLocation(location) {
            window.location.href = 'restaurants.php?location=' + encodeURIComponent(location);
        }

        // Enter key search
        document.getElementById('searchInput')?.addEventListener('keypress', function(e) {
            if (e.key === 'Enter') performSearch();
        });

        // Smooth scroll for navigation
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function(e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) target.scrollIntoView({
                    behavior: 'smooth'
                });
            });
        });

        // Add animation on scroll
        const observerOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        };

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.style.opacity = '1';
                    entry.target.style.transform = 'translateY(0)';
                }
            });
        }, observerOptions);

        document.querySelectorAll('.glass-card').forEach(card => {
            card.style.opacity = '0';
            card.style.transform = 'translateY(20px)';
            card.style.transition = 'all 0.6s ease-out';
            observer.observe(card);
        });

        // Parallax effect for hero section
        window.addEventListener('scroll', function() {
            const scrolled = window.pageYOffset;
            const hero = document.querySelector('.hero');
            if (hero) {
                hero.style.backgroundPositionY = scrolled * 0.5 + 'px';
            }
        });
    </script>
</body>

</html>
<?php $conn->close(); ?>