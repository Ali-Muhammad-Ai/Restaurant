<?php
$page_title = "Restaurant Details - FoodFinder Karachi";
include 'config/database.php';
$conn = getConnection();

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
if ($id <= 0) {
    header('Location: restaurants.php');
    exit();
}

$stmt = $conn->prepare("SELECT * FROM restaurants WHERE id = ?");
$stmt->bind_param('i', $id);
$stmt->execute();
$result = $stmt->get_result();
$restaurant = $result->fetch_assoc();
if (!$restaurant) {
    header('Location: restaurants.php');
    exit();
}

$favoriteAdded = false;
$favoriteRemoved = false;
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['favorite_action'])) {
    if ($_POST['favorite_action'] === 'add') {
        addFavoriteItem('restaurant', $restaurant['id'], [
            'name' => $restaurant['name'],
            'url' => 'restaurant.php?id=' . $restaurant['id'],
            'subtitle' => $restaurant['cuisine'] . ' · ' . $restaurant['location']
        ]);
        $favoriteAdded = true;
    }
    if ($_POST['favorite_action'] === 'remove') {
        removeFavoriteItem('restaurant', $restaurant['id']);
        $favoriteRemoved = true;
    }
}

$isFavorite = isFavoriteItem('restaurant', $restaurant['id']);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($restaurant['name']) . ' - FoodFinder Karachi'; ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,300;14..32,400;14..32,600;14..32,700;14..32,800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="assets/style.css">
</head>

<body>
    <?php include 'includes/nav.php'; ?>

    <div style="height:76px"></div>
    <section class="detail-hero" style="background-image: url('<?php echo !empty($restaurant['image']) ? htmlspecialchars($restaurant['image']) : 'https://images.unsplash.com/photo-1517248135467-4c7edcad34c4?w=1600'; ?>');">
        <div class="container text-white detail-header py-5">
            <div class="row align-items-end">
                <div class="col-lg-8">
                    <span class="badge bg-warning text-dark mb-3">Restaurant</span>
                    <h1 class="display-5 fw-bold"><?php echo htmlspecialchars($restaurant['name']); ?></h1>
                    <p class="lead text-white-75"><?php echo htmlspecialchars($restaurant['cuisine']); ?> · <?php echo htmlspecialchars($restaurant['location']); ?></p>
                </div>
                <div class="col-lg-4 text-lg-end">
                    <div class="glass-card detail-card text-start">
                        <div class="mb-3">
                            <span class="rating"><i class="fas fa-star"></i> <?php echo number_format($restaurant['rating'], 1); ?></span>
                        </div>
                        <p class="mb-2"><i class="fas fa-map-marker-alt"></i> <?php echo htmlspecialchars($restaurant['address']); ?></p>
                        <p class="mb-2"><i class="fas fa-clock"></i> <?php echo htmlspecialchars($restaurant['opening_hours']); ?></p>
                        <p class="mb-0"><i class="fas fa-phone"></i> <?php echo htmlspecialchars($restaurant['phone']); ?></p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <div class="container my-5">
        <div class="row g-4">
            <div class="col-lg-8">
                <div class="glass-card p-4">
                    <h2 class="section-title">About this restaurant</h2>
                    <div class="section-divider"></div>
                    <p class="section-subtitle"><?php echo nl2br(htmlspecialchars($restaurant['description'])); ?></p>
                    <div class="row g-3 mt-4">
                        <div class="col-md-6">
                            <div class="glass-card p-4">
                                <h6 class="mb-2">Cuisine</h6>
                                <p class="mb-0"><?php echo htmlspecialchars($restaurant['cuisine']); ?></p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="glass-card p-4">
                                <h6 class="mb-2">Price Range</h6>
                                <p class="mb-0"><?php echo htmlspecialchars($restaurant['price_range']); ?></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="glass-card p-4">
                    <?php if ($favoriteAdded): ?>
                        <div class="alert alert-success">Added to favorites.</div>
                    <?php elseif ($favoriteRemoved): ?>
                        <div class="alert alert-warning">Removed from favorites.</div>
                    <?php endif; ?>
                    <h5>Quick Actions</h5>
                    <p class="text-secondary mb-3">Plan your visit or explore more top venues in Karachi.</p>
                    <form method="POST" class="mb-3">
                        <?php if ($isFavorite): ?>
                            <button type="submit" name="favorite_action" value="remove" class="btn btn-outline-gold w-100 mb-2">Remove from Favorites</button>
                        <?php else: ?>
                            <button type="submit" name="favorite_action" value="add" class="btn btn-gold w-100 mb-2">Add to Favorites</button>
                        <?php endif; ?>
                    </form>
                    <a href="restaurants.php" class="btn btn-outline-gold w-100 mb-2">Back to Restaurants</a>
                    <a href="contact.php" class="btn btn-gold w-100">Need Help?</a>
                </div>
            </div>
        </div>
    </div>

    <footer>
        <div class="container text-center">
            <p class="mb-1">FoodFinder Karachi</p>
            <small>Discover the best dining spots across Karachi.</small>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
<?php
$stmt->close();
$conn->close();
?>