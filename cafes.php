<?php
$page_title = "Cafes - FoodFinder Karachi";
include 'config/database.php';
$conn = getConnection();

$favoriteAdded = false;
$favoriteRemoved = false;
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['favorite_action'], $_POST['cafe_id'])) {
    $cafeId = intval($_POST['cafe_id']);

    if ($_POST['favorite_action'] === 'add') {
        $itemStmt = $conn->prepare("SELECT * FROM cafes WHERE id = ?");
        $itemStmt->bind_param('i', $cafeId);
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
        $favoriteAdded = true;
    }

    if ($_POST['favorite_action'] === 'remove') {
        removeFavoriteItem('cafe', $cafeId);
        $favoriteRemoved = true;
    }

    $redirectUrl = 'cafes.php' . (!empty($_SERVER['QUERY_STRING']) ? '?' . $_SERVER['QUERY_STRING'] : '');
    header('Location: ' . $redirectUrl);
    exit();
}

$search = $_GET['search'] ?? '';
$location = $_GET['location'] ?? '';
$coffee = $_GET['coffee'] ?? '';

$sql = "SELECT * FROM cafes WHERE 1=1";
$params = [];
$types = "";

if (!empty($search)) {
    $sql .= " AND (name LIKE ? OR description LIKE ? OR coffee_types LIKE ?)";
    $like = "%$search%";
    $params[] = $like;
    $params[] = $like;
    $params[] = $like;
    $types .= "sss";
}

if (!empty($location)) {
    $sql .= " AND location = ?";
    $params[] = $location;
    $types .= "s";
}

if (!empty($coffee)) {
    $sql .= " AND coffee_types LIKE ?";
    $params[] = "%$coffee%";
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
$locResult = $conn->query("SELECT DISTINCT location FROM cafes ORDER BY location");
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
            <h1 class="hero-title">Explore Karachi's Best Cafes</h1>
            <p class="hero-subtitle">From specialty coffee to cozy atmospheres, find your next caffeine fix.</p>
        </div>
    </section>

    <div class="container my-5">
        <div class="row g-4">
            <div class="col-lg-3">
                <div class="glass-card p-4 sidebar sticky-top" style="top:100px;">
                    <h4 class="mb-3">Search Cafes</h4>
                    <form method="GET">
                        <div class="mb-3">
                            <label class="form-label">Search</label>
                            <input type="text" id="liveSearch" name="search" class="form-control"
                                placeholder="Cafe, coffee or vibe" value="<?php echo htmlspecialchars($search); ?>">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Location</label>
                            <select name="location" class="form-select">
                                <option value="">All Locations</option>
                                <?php foreach ($locations as $loc): ?>
                                    <option value="<?php echo htmlspecialchars($loc); ?>" <?php echo $location == $loc ? 'selected' : ''; ?>>
                                        <?php echo htmlspecialchars($loc); ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Coffee Type</label>
                            <input type="text" name="coffee" class="form-control"
                                placeholder="Espresso, latte, cold brew"
                                value="<?php echo htmlspecialchars($coffee); ?>">
                        </div>
                        <button class="btn btn-gold w-100">Update Results</button>
                    </form>
                </div>
            </div>
            <div class="col-lg-9">
                <div class="glass-card p-3 mb-4">
                    <h5 class="mb-0">
                        <span id="cafeCount"><?php echo $result->num_rows; ?></span>
                        Cafe(s) Found
                    </h5>
                </div>
                <div class="row g-4">
                    <?php while ($cafe = $result->fetch_assoc()): ?>
                        <div class="col-md-6 col-xl-4 cafe-item">
                            <div class="glass-card place-card"
                                data-name="<?php echo strtolower(htmlspecialchars($cafe['name'])); ?>"
                                data-coffee="<?php echo strtolower(htmlspecialchars($cafe['coffee_types'])); ?>"
                                data-location="<?php echo strtolower(htmlspecialchars($cafe['location'])); ?>"
                                data-hours="<?php echo strtolower(htmlspecialchars($cafe['opening_hours'])); ?>">
                                <div class="restaurant-image"
                                    style="background-image: url('<?php echo !empty($cafe['image']) ? htmlspecialchars($cafe['image']) : 'https://images.unsplash.com/photo-1517248135467-4c7edcad34c4?w=1200'; ?>'); background-size: cover; background-position: center;">
                                </div>
                                <div class="p-3">
                                    <h5><?php echo htmlspecialchars($cafe['name']); ?></h5>
                                    <div class="rating mb-2">
                                        <i class="fas fa-star"></i> <?php echo number_format($cafe['rating'], 1); ?>
                                    </div>
                                    <p class="small text-secondary mb-2">
                                        <?php echo htmlspecialchars($cafe['coffee_types']); ?>
                                    </p>
                                    <p class="small mb-2"><i class="fas fa-map-marker-alt"></i>
                                        <?php echo htmlspecialchars($cafe['location']); ?></p>
                                    <p class="small mb-3"><?php echo htmlspecialchars($cafe['opening_hours']); ?></p>
                                    <form method="POST" class="mb-3">
                                        <input type="hidden" name="cafe_id" value="<?php echo intval($cafe['id']); ?>">
                                        <?php if (isFavoriteItem('cafe', $cafe['id'])): ?>
                                            <button type="submit" name="favorite_action" value="remove"
                                                class="btn btn-outline-gold w-100 mb-2">Remove Favorite</button>
                                        <?php else: ?>
                                            <button type="submit" name="favorite_action" value="add"
                                                class="btn btn-gold w-100 mb-2">Add Favorite</button>
                                        <?php endif; ?>
                                    </form>
                                    <a href="cafe.php?id=<?php echo $cafe['id']; ?>" class="btn btn-outline-gold w-100">View
                                        Details</a>
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
        const cards = document.querySelectorAll(".cafe-item");
        const counter = document.getElementById("cafeCount");

        searchInput.addEventListener("keyup", function () {

            const keyword = this.value.toLowerCase().trim();

            let visible = 0;

            cards.forEach(card => {

                const cafe = card.querySelector(".place-card");

                const searchableText =
                    cafe.dataset.name +
                    " " +
                    cafe.dataset.coffee +
                    " " +
                    cafe.dataset.location +
                    " " +
                    cafe.dataset.hours;

                if (searchableText.includes(keyword)) {

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