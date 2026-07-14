<?php
$page_title = "Restaurants - FoodFinder Karachi";
include 'config/database.php';
$conn = getConnection();

$favoriteAdded = false;
$favoriteRemoved = false;
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['favorite_action'], $_POST['restaurant_id'])) {
    $restaurantId = intval($_POST['restaurant_id']);

    if ($_POST['favorite_action'] === 'add') {
        $itemStmt = $conn->prepare("SELECT * FROM restaurants WHERE id = ?");
        $itemStmt->bind_param('i', $restaurantId);
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
        $favoriteAdded = true;
    }

    if ($_POST['favorite_action'] === 'remove') {
        removeFavoriteItem('restaurant', $restaurantId);
        $favoriteRemoved = true;
    }

    $redirectUrl = 'restaurants.php' . (!empty($_SERVER['QUERY_STRING']) ? '?' . $_SERVER['QUERY_STRING'] : '');
    header('Location: ' . $redirectUrl);
    exit();
}

$search = $_GET['search'] ?? '';
$location = $_GET['location'] ?? '';
$cuisine = $_GET['cuisine'] ?? '';

$sql = "SELECT * FROM restaurants WHERE 1=1";
$params = [];
$types = "";

if (!empty($search)) {
    $sql .= " AND (name LIKE ? OR description LIKE ?)";
    $like = "%$search%";
    $params[] = $like;
    $params[] = $like;
    $types .= "ss";
}

if (!empty($location)) {
    $sql .= " AND location = ?";
    $params[] = $location;
    $types .= "s";
}

if (!empty($cuisine)) {
    $sql .= " AND cuisine LIKE ?";
    $params[] = "%$cuisine%";
    $types .= "s";
}

$sql .= " ORDER BY rating DESC";

$stmt = $conn->prepare($sql);

if (!empty($params)) {
    $stmt->bind_param($types, ...$params);
}

$stmt->execute();
$result = $stmt->get_result();

$locations = [];
$locResult = $conn->query("SELECT DISTINCT location FROM restaurants ORDER BY location");
while ($row = $locResult->fetch_assoc()) {
    $locations[] = $row['location'];
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
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,300;14..32,400;14..32,600;14..32,700;14..32,800&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="assets/style.css">
</head>

<body>

    <?php include 'includes/nav.php'; ?>

    <div style="height:76px"></div>

    <section class="hero text-center">
        <div class="container">
            <h1 class="hero-title">Discover Karachi's Best Restaurants</h1>
            <p class="lead">Explore top rated dining destinations across the city.</p>
        </div>
    </section>

    <div class="container my-5">
        <div class="row g-4">

            <!-- Mobile Filter Button -->
            <div class="d-lg-none mb-3">
                <button class="btn btn-gold w-100 d-flex align-items-center justify-content-center" type="button"
                    data-bs-toggle="collapse" data-bs-target="#mobileFilters">
                    <i class="fas fa-sliders-h me-2"></i>
                    Filters
                </button>
            </div>

            <!-- Sidebar -->
            <div class="col-lg-3">

                <div class="collapse d-lg-block mb-4" id="mobileFilters">

                    <div class="glass-card filter-card p-4 sticky-lg-top">

                        <div class="d-flex align-items-center justify-content-between mb-4">
                            <h5 class="mb-0">
                                <i class="fas fa-filter text-warning me-2"></i>
                                Filters
                            </h5>

                            <a href="restaurants.php" class="small text-decoration-none">
                                Reset
                            </a>
                        </div>

                        <form method="GET">

                            <div class="mb-3">

                                <label class="form-label">
                                    <i class="fas fa-search me-2"></i>
                                    Search
                                </label>

                                <input type="text" id="liveSearch" name="search" class="form-control">
                                 <div
                                    class="glass-card restaurant-card"
                                    placeholder="Restaurant name..." value="<?php echo htmlspecialchars($search); ?>">
                                </div>
                    </div>

                    <div class="mb-3">

                        <label class="form-label">
                            <i class="fas fa-map-marker-alt me-2"></i>
                            Location
                        </label>

                        <select name="location" class="form-select">

                            <option value="">All Locations</option>

                            <?php foreach ($locations as $loc): ?>

                                <option value="<?php echo $loc; ?>" <?php echo $location == $loc ? 'selected' : ''; ?>>

                                    <?php echo $loc; ?>

                                </option>

                            <?php endforeach; ?>

                        </select>

                    </div>

                    <div class="mb-4">

                        <label class="form-label">
                            <i class="fas fa-utensils me-2"></i>
                            Cuisine
                        </label>

                        <input type="text" name="cuisine" class="form-control" placeholder="e.g. BBQ"
                            value="<?php echo htmlspecialchars($cuisine); ?>">

                    </div>

                    <button class="btn btn-gold w-100">
                        <i class="fas fa-check-circle me-2"></i>
                        Apply Filters
                    </button>

                    </form>

                </div>

            </div>

        </div>

        <div class="col-lg-9">

            <div class="glass-card p-3 mb-4">
                <h5 class="mb-0">
                    <span id="restaurantCount"><?php echo $result->num_rows; ?></span>
                    Restaurant(s) Found
                </h5>
            </div>

            <div class="row g-4">

                <?php while ($restaurant = $result->fetch_assoc()): ?>
                    <div class="col-md-6 col-xl-4 restaurant-item">
                        <div class="glass-card restaurant-card"
                            data-name="<?php echo strtolower(htmlspecialchars($restaurant['name'])); ?>"
                            data-cuisine="<?php echo strtolower(htmlspecialchars($restaurant['cuisine'])); ?>"
                            data-location="<?php echo strtolower(htmlspecialchars($restaurant['location'])); ?>">

                            <div class="restaurant-image">
                                <i class="fas fa-utensils"></i>
                            </div>

                            <div class="p-3">
                                <h5><?php echo htmlspecialchars($restaurant['name']); ?></h5>

                                <div class="rating mb-2">
                                    <i class="fas fa-star"></i>
                                    <?php echo number_format($restaurant['rating'], 1); ?>
                                </div>

                                <p class="small text-secondary mb-2">
                                    <?php echo htmlspecialchars($restaurant['cuisine']); ?>
                                </p>

                                <p class="small mb-2">
                                    <i class="fas fa-map-marker-alt"></i>
                                    <?php echo htmlspecialchars($restaurant['location']); ?>
                                </p>

                                <p class="small mb-3">
                                    <?php echo htmlspecialchars($restaurant['price_range']); ?>
                                </p>

                                <form method="POST" class="mb-3">
                                    <input type="hidden" name="restaurant_id"
                                        value="<?php echo intval($restaurant['id']); ?>">
                                    <?php if (isFavoriteItem('restaurant', $restaurant['id'])): ?>
                                        <button type="submit" name="favorite_action" value="remove"
                                            class="btn btn-outline-gold w-100 mb-2">Remove Favorite</button>
                                    <?php else: ?>
                                        <button type="submit" name="favorite_action" value="add"
                                            class="btn btn-gold w-100 mb-2">Add Favorite</button>
                                    <?php endif; ?>
                                </form>

                                <a href="restaurant.php?id=<?php echo $restaurant['id']; ?>"
                                    class="btn btn-outline-gold w-100">
                                    View Details
                                </a>
                            </div>

                        </div>
                    </div>
                <?php endwhile; ?>

            </div>
        </div>
    </div>
    </div>
    <footer>
        <div class="container text-center">
            <p class="mb-1">FoodFinder Karachi</p>
            <small>Discover the finest restaurants and cafes across the city.</small>
        </div>
    </footer>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script>

        const searchInput = document.getElementById("liveSearch");

        const cards = document.querySelectorAll(".restaurant-item");

        const counter = document.getElementById("restaurantCount");

        searchInput.addEventListener("keyup", function () {

            const keyword = this.value.toLowerCase().trim();

            let visible = 0;

            cards.forEach(card => {

                const restaurant = card.querySelector(".restaurant-card");

                const text =
                    restaurant.dataset.name +
                    " " +
                    restaurant.dataset.cuisine +
                    " " +
                    restaurant.dataset.location;

                if (text.includes(keyword)) {

                    card.style.display = "";

                    visible++;

                } else {

                    card.style.display = "none";

                }

            });

            counter.textContent = visible;

        });

    </script>
</body>

</html>
<?php
$stmt->close();
$conn->close();
?>