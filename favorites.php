<?php
$page_title = "Favorites - FoodFinder Karachi";
include 'config/database.php';
$conn = getConnection();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['remove_type'], $_POST['remove_id'])) {
    removeFavoriteItem($_POST['remove_type'], intval($_POST['remove_id']));
    header('Location: favorites.php');
    exit();
}

$favorites = getFavoriteItems();
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
            <h1 class="hero-title">Your Favorites</h1>
            <p class="hero-subtitle">Save your preferred restaurants, cafes, and food streets for easy access.</p>
        </div>
    </section>

    <div class="container my-5">
        <div class="row g-4">
            <?php if (empty($favorites)): ?>
                <div class="col-12">
                    <div class="glass-card p-4 text-center">
                        <h2 class="section-title">No favorites yet</h2>
                        <div class="section-divider"></div>
                        <p class="section-subtitle">Browse restaurants, cafes, and food streets to add favorites.</p>
                        <a href="restaurants.php" class="btn btn-gold me-2">Browse Restaurants</a>
                        <a href="cafes.php" class="btn btn-outline-gold me-2">Browse Cafes</a>
                        <a href="food-streets.php" class="btn btn-outline-gold">Browse Food Streets</a>
                    </div>
                </div>
            <?php else: ?>
                <?php foreach ($favorites as $favorite): ?>
                    <div class="col-md-6 col-xl-4">
                        <div class="glass-card p-4">
                            <div class="d-flex justify-content-between align-items-start mb-3">
                                <div>
                                    <h5 class="mb-1"><?php echo htmlspecialchars($favorite['name']); ?></h5>
                                    <p class="small text-secondary mb-0"><?php echo ucfirst(str_replace('_', ' ', $favorite['type'])); ?></p>
                                </div>
                                <span class="badge bg-warning text-dark">Saved</span>
                            </div>
                            <?php if (!empty($favorite['subtitle'])): ?>
                                <p class="small text-secondary mb-3"><?php echo htmlspecialchars($favorite['subtitle']); ?></p>
                            <?php endif; ?>
                            <div class="d-flex gap-2 flex-wrap">
                                <a href="<?php echo htmlspecialchars($favorite['url']); ?>" class="btn btn-outline-gold flex-grow-1">View</a>
                                <form method="POST" class="m-0 flex-grow-1">
                                    <input type="hidden" name="remove_type" value="<?php echo htmlspecialchars($favorite['type']); ?>">
                                    <input type="hidden" name="remove_id" value="<?php echo intval($favorite['id']); ?>">
                                    <button type="submit" class="btn btn-gold w-100">Remove</button>
                                </form>
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
            <small>Access your saved favorites any time.</small>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>