<?php
$page_title = "Food Streets - FoodFinder Karachi";
include 'config/database.php';
$conn = getConnection();

$favoriteAdded = false;
$favoriteRemoved = false;
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['favorite_action'], $_POST['street_id'])) {
    $streetId = intval($_POST['street_id']);
    if ($_POST['favorite_action'] === 'add') {
        $streetStmt = $conn->prepare("SELECT * FROM food_streets WHERE id = ?");
        $streetStmt->bind_param('i', $streetId);
        $streetStmt->execute();
        $streetResult = $streetStmt->get_result();
        $streetRow = $streetResult->fetch_assoc();
        if ($streetRow) {
            addFavoriteItem('food_street', $streetRow['id'], [
                'name' => $streetRow['name'],
                'url' => 'food-street.php?id=' . $streetRow['id'],
                'subtitle' => $streetRow['location']
            ]);
            $favoriteAdded = true;
        }
        $streetStmt->close();
    }
    if ($_POST['favorite_action'] === 'remove') {
        removeFavoriteItem('food_street', $streetId);
        $favoriteRemoved = true;
    }
    header('Location: food-streets.php');
    exit();
}

$foodStreets = getFoodStreets($conn);
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
    <?php include 'includes/nav.php'; ?>
    <div style="height:76px"></div>
    <section class="hero text-center">
        <div class="container">
            <h1 class="hero-title">Karachi's Famous Food Streets</h1>
            <p class="hero-subtitle">Explore the city's best street food destinations, hotspots, and culinary corridors.</p>
        </div>
    </section>
    <div class="container my-5">
        <div class="row g-4">
            <?php if (empty($foodStreets)): ?>
                <div class="col-12">
                    <div class="glass-card p-4 text-center">
                        <p class="mb-0">No food streets are available right now.</p>
                    </div>
                </div>
            <?php else: ?>
                <?php foreach ($foodStreets as $street): ?>
                    <div class="col-md-6 col-xl-4">
                        <div class="glass-card place-card">
                            <div class="restaurant-image" style="background-image: url('<?php echo !empty($street['image']) ? htmlspecialchars($street['image']) : 'https://images.unsplash.com/photo-1517248135467-4c7edcad34c4?w=1200'; ?>'); background-size: cover; background-position: center;"></div>
                            <div class="p-3">
                                <h5><?php echo htmlspecialchars($street['name']); ?></h5>
                                <div class="rating mb-2"><i class="fas fa-star"></i> <?php echo number_format($street['rating'], 1); ?></div>
                                <p class="small text-secondary mb-2"><i class="fas fa-map-marker-alt"></i> <?php echo htmlspecialchars($street['location']); ?></p>
                                <p class="small mb-3"><?php echo htmlspecialchars($street['famous_for']); ?></p>
                                <form method="POST" class="mb-3">
                                    <input type="hidden" name="street_id" value="<?php echo intval($street['id']); ?>">
                                    <?php if (isFavoriteItem('food_street', $street['id'])): ?>
                                        <button type="submit" name="favorite_action" value="remove" class="btn btn-outline-gold w-100 mb-2">Remove Favorite</button>
                                    <?php else: ?>
                                        <button type="submit" name="favorite_action" value="add" class="btn btn-gold w-100 mb-2">Add Favorite</button>
                                    <?php endif; ?>
                                </form>
                                <a href="food-street.php?id=<?php echo $street['id']; ?>" class="btn btn-outline-gold w-100">View Details</a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
    <footer>
        <div class="container text-center">
            <p class="mb-1">FoodFinder Karachi</p>
            <small>Discover popular street food corridors across the city.</small>
        </div>
    </footer>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>