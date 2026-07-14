<?php
$page_title = "Food Street Details - FoodFinder Karachi";
include 'config/database.php';
$conn = getConnection();

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
if ($id <= 0) {
    header('Location: food-streets.php');
    exit();
}

$stmt = $conn->prepare("SELECT * FROM food_streets WHERE id = ?");
$stmt->bind_param('i', $id);
$stmt->execute();
$result = $stmt->get_result();
$street = $result->fetch_assoc();
if (!$street) {
    header('Location: food-streets.php');
    exit();
}

$favoriteAdded = false;
$favoriteRemoved = false;
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['favorite_action'])) {
    if ($_POST['favorite_action'] === 'add') {
        addFavoriteItem('food_street', $street['id'], [
            'name' => $street['name'],
            'url' => 'food-street.php?id=' . $street['id'],
            'subtitle' => $street['location']
        ]);
        $favoriteAdded = true;
    }
    if ($_POST['favorite_action'] === 'remove') {
        removeFavoriteItem('food_street', $street['id']);
        $favoriteRemoved = true;
    }
}

$isFavorite = isFavoriteItem('food_street', $street['id']);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($street['name']) . ' - FoodFinder Karachi'; ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,300;14..32,400;14..32,600;14..32,700;14..32,800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="assets/style.css">
</head>

<body>
    <?php include 'includes/nav.php'; ?>

    <div style="height:76px"></div>
    <section class="detail-hero" style="background-image: url('<?php echo !empty($street['image']) ? htmlspecialchars($street['image']) : 'https://images.unsplash.com/photo-1517248135467-4c7edcad34c4?w=1600'; ?>');">
        <div class="container text-white detail-header py-5">
            <div class="row align-items-end">
                <div class="col-lg-8">
                    <span class="badge bg-warning text-dark mb-3">Food Street</span>
                    <h1 class="display-5 fw-bold"><?php echo htmlspecialchars($street['name']); ?></h1>
                    <p class="lead text-white-75"><?php echo htmlspecialchars($street['location']); ?></p>
                </div>
                <div class="col-lg-4 text-lg-end">
                    <div class="glass-card detail-card text-start">
                        <div class="mb-3">
                            <span class="rating"><i class="fas fa-star"></i> <?php echo number_format($street['rating'], 1); ?></span>
                        </div>
                        <p class="mb-2"><i class="fas fa-map-marker-alt"></i> <?php echo htmlspecialchars($street['location']); ?></p>
                        <p class="mb-2"><i class="fas fa-fire"></i> Famous for <?php echo htmlspecialchars($street['famous_for']); ?></p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <div class="container my-5">
        <div class="row g-4">
            <div class="col-lg-8">
                <div class="glass-card p-4">
                    <h2 class="section-title">About this food street</h2>
                    <div class="section-divider"></div>
                    <p class="section-subtitle"><?php echo nl2br(htmlspecialchars($street['description'])); ?></p>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="glass-card p-4">
                    <?php if ($favoriteAdded): ?>
                        <div class="alert alert-success">Added to favorites.</div>
                    <?php elseif ($favoriteRemoved): ?>
                        <div class="alert alert-warning">Removed from favorites.</div>
                    <?php endif; ?>
                    <form method="POST">
                        <?php if ($isFavorite): ?>
                            <button type="submit" name="favorite_action" value="remove" class="btn btn-outline-gold w-100 mb-2">Remove from Favorites</button>
                        <?php else: ?>
                            <button type="submit" name="favorite_action" value="add" class="btn btn-gold w-100 mb-2">Add to Favorites</button>
                        <?php endif; ?>
                    </form>
                    <a href="food-streets.php" class="btn btn-outline-gold w-100">Back to Food Streets</a>
                </div>
            </div>
        </div>
    </div>

    <footer>
        <div class="container text-center">
            <p class="mb-1">FoodFinder Karachi</p>
            <small>Discover street food destinations across Karachi.</small>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>