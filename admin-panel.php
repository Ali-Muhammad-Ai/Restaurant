<?php
$page_title = "Admin Panel - FoodFinder Karachi";
include 'config/database.php';
$conn = getConnection();
requireAdmin();

$message = '';
$messageType = '';

function sanitizeText($value)
{
    return trim((string) $value);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';

    if ($action === 'save_restaurant') {
        $id = intval($_POST['restaurant_id'] ?? 0);
        $data = [
            sanitizeText($_POST['name'] ?? ''),
            sanitizeText($_POST['description'] ?? ''),
            sanitizeText($_POST['address'] ?? ''),
            sanitizeText($_POST['location'] ?? ''),
            sanitizeText($_POST['cuisine'] ?? ''),
            sanitizeText($_POST['price_range'] ?? ''),
            floatval($_POST['rating'] ?? 0),
            sanitizeText($_POST['opening_hours'] ?? ''),
            sanitizeText($_POST['phone'] ?? ''),
            sanitizeText($_POST['image'] ?? ''),
            isset($_POST['featured']) ? 1 : 0
        ];

        if ($id > 0) {
            $stmt = $conn->prepare("UPDATE restaurants SET name = ?, description = ?, address = ?, location = ?, cuisine = ?, price_range = ?, rating = ?, opening_hours = ?, phone = ?, image = ?, featured = ? WHERE id = ?");
            $stmt->bind_param('ssssssdssssi', $data[0], $data[1], $data[2], $data[3], $data[4], $data[5], $data[6], $data[7], $data[8], $data[9], $data[10], $id);
        } else {
            $stmt = $conn->prepare("INSERT INTO restaurants (name, description, address, location, cuisine, price_range, rating, opening_hours, phone, image, featured) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
            $stmt->bind_param('ssssssdsssi', $data[0], $data[1], $data[2], $data[3], $data[4], $data[5], $data[6], $data[7], $data[8], $data[9], $data[10]);
        }
        $stmt->execute();
        $stmt->close();
        $message = $id > 0 ? 'Restaurant updated.' : 'Restaurant created.';
        $messageType = 'success';
    }

    if ($action === 'delete_restaurant') {
        $id = intval($_POST['restaurant_id'] ?? 0);
        if ($id > 0) {
            $stmt = $conn->prepare("DELETE FROM restaurants WHERE id = ?");
            $stmt->bind_param('i', $id);
            $stmt->execute();
            $stmt->close();
            $message = 'Restaurant deleted.';
            $messageType = 'warning';
        }
    }

    if ($action === 'save_cafe') {
        $id = intval($_POST['cafe_id'] ?? 0);
        $data = [
            sanitizeText($_POST['name'] ?? ''),
            sanitizeText($_POST['description'] ?? ''),
            sanitizeText($_POST['address'] ?? ''),
            sanitizeText($_POST['location'] ?? ''),
            sanitizeText($_POST['coffee_types'] ?? ''),
            floatval($_POST['rating'] ?? 0),
            sanitizeText($_POST['opening_hours'] ?? ''),
            sanitizeText($_POST['phone'] ?? ''),
            sanitizeText($_POST['image'] ?? ''),
            isset($_POST['featured']) ? 1 : 0
        ];

        if ($id > 0) {
            $stmt = $conn->prepare("UPDATE cafes SET name = ?, description = ?, address = ?, location = ?, coffee_types = ?, rating = ?, opening_hours = ?, phone = ?, image = ?, featured = ? WHERE id = ?");
            $stmt->bind_param('sssssdsssi', $data[0], $data[1], $data[2], $data[3], $data[4], $data[5], $data[6], $data[7], $data[8], $data[9], $id);
        } else {
            $stmt = $conn->prepare("INSERT INTO cafes (name, description, address, location, coffee_types, rating, opening_hours, phone, image, featured) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
            $stmt->bind_param('sssssdsssi', $data[0], $data[1], $data[2], $data[3], $data[4], $data[5], $data[6], $data[7], $data[8], $data[9]);
        }
        $stmt->execute();
        $stmt->close();
        $message = $id > 0 ? 'Cafe updated.' : 'Cafe created.';
        $messageType = 'success';
    }

    if ($action === 'delete_cafe') {
        $id = intval($_POST['cafe_id'] ?? 0);
        if ($id > 0) {
            $stmt = $conn->prepare("DELETE FROM cafes WHERE id = ?");
            $stmt->bind_param('i', $id);
            $stmt->execute();
            $stmt->close();
            $message = 'Cafe deleted.';
            $messageType = 'warning';
        }
    }

    if ($action === 'save_street') {
        $id = intval($_POST['street_id'] ?? 0);
        $data = [
            sanitizeText($_POST['name'] ?? ''),
            sanitizeText($_POST['description'] ?? ''),
            sanitizeText($_POST['location'] ?? ''),
            sanitizeText($_POST['famous_for'] ?? ''),
            sanitizeText($_POST['image'] ?? ''),
            floatval($_POST['rating'] ?? 0)
        ];

        if ($id > 0) {
            $stmt = $conn->prepare("UPDATE food_streets SET name = ?, description = ?, location = ?, famous_for = ?, image = ?, rating = ? WHERE id = ?");
            $stmt->bind_param('ssssssi', $data[0], $data[1], $data[2], $data[3], $data[4], $data[5], $id);
        } else {
            $stmt = $conn->prepare("INSERT INTO food_streets (name, description, location, famous_for, image, rating) VALUES (?, ?, ?, ?, ?, ?)");
            $stmt->bind_param('sssssd', $data[0], $data[1], $data[2], $data[3], $data[4], $data[5]);
        }
        $stmt->execute();
        $stmt->close();
        $message = $id > 0 ? 'Food street updated.' : 'Food street created.';
        $messageType = 'success';
    }

    if ($action === 'delete_street') {
        $id = intval($_POST['street_id'] ?? 0);
        if ($id > 0) {
            $stmt = $conn->prepare("DELETE FROM food_streets WHERE id = ?");
            $stmt->bind_param('i', $id);
            $stmt->execute();
            $stmt->close();
            $message = 'Food street deleted.';
            $messageType = 'warning';
        }
    }

    if ($action === 'add_location') {
        $name = sanitizeText($_POST['location_name'] ?? '');
        if ($name !== '') {
            $stmt = $conn->prepare("INSERT IGNORE INTO locations (name) VALUES (?)");
            $stmt->bind_param('s', $name);
            $stmt->execute();
            $stmt->close();
            $message = 'Location saved.';
            $messageType = 'success';
        }
    }

    if ($action === 'delete_location') {
        $id = intval($_POST['location_id'] ?? 0);
        if ($id > 0) {
            $stmt = $conn->prepare("DELETE FROM locations WHERE id = ?");
            $stmt->bind_param('i', $id);
            $stmt->execute();
            $stmt->close();
            $message = 'Location removed.';
            $messageType = 'warning';
        }
    }

    refreshSiteStats($conn);
}

$editRestaurantId = intval($_GET['edit_restaurant'] ?? 0);
$editCafeId = intval($_GET['edit_cafe'] ?? 0);
$editStreetId = intval($_GET['edit_street'] ?? 0);

$editingRestaurant = null;
if ($editRestaurantId > 0) {
    $stmt = $conn->prepare("SELECT * FROM restaurants WHERE id = ?");
    $stmt->bind_param('i', $editRestaurantId);
    $stmt->execute();
    $editingRestaurant = $stmt->get_result()->fetch_assoc();
    $stmt->close();
}

$editingCafe = null;
if ($editCafeId > 0) {
    $stmt = $conn->prepare("SELECT * FROM cafes WHERE id = ?");
    $stmt->bind_param('i', $editCafeId);
    $stmt->execute();
    $editingCafe = $stmt->get_result()->fetch_assoc();
    $stmt->close();
}

$editingStreet = null;
if ($editStreetId > 0) {
    $stmt = $conn->prepare("SELECT * FROM food_streets WHERE id = ?");
    $stmt->bind_param('i', $editStreetId);
    $stmt->execute();
    $editingStreet = $stmt->get_result()->fetch_assoc();
    $stmt->close();
}

$restaurants = $conn->query("SELECT * FROM restaurants ORDER BY name");
$cafes = $conn->query("SELECT * FROM cafes ORDER BY name");
$streets = $conn->query("SELECT * FROM food_streets ORDER BY name");
$locations = $conn->query("SELECT * FROM locations ORDER BY name");
$stats = getSiteStats($conn);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $page_title; ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/style.css">
</head>

<body>
    <?php include 'includes/nav.php'; ?>
    <div style="height: 76px;"></div>

    <section class="container py-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h1 class="section-title mb-1">Admin Panel</h1>
                <p class="text-secondary">Manage listings, locations, and featured content directly from the database.</p>
            </div>
            <a href="index.php" class="btn btn-outline-gold">View Site</a>
        </div>

        <?php if ($message): ?>
            <div class="alert alert-<?php echo $messageType; ?>"><?php echo htmlspecialchars($message); ?></div>
        <?php endif; ?>

        <div class="row g-4 mb-4">
            <div class="col-md-3">
                <div class="glass-card p-3 text-center">
                    <h3 class="fw-bold text-gold"><?php echo $stats['total_restaurants']; ?></h3>
                    <p class="mb-0">Restaurants</p>
                </div>
            </div>
            <div class="col-md-3">
                <div class="glass-card p-3 text-center">
                    <h3 class="fw-bold text-gold"><?php echo $stats['total_cafes']; ?></h3>
                    <p class="mb-0">Cafes</p>
                </div>
            </div>
            <div class="col-md-3">
                <div class="glass-card p-3 text-center">
                    <h3 class="fw-bold text-gold"><?php echo $stats['total_users']; ?></h3>
                    <p class="mb-0">Users</p>
                </div>
            </div>
            <div class="col-md-3">
                <div class="glass-card p-3 text-center">
                    <h3 class="fw-bold text-gold"><?php echo $stats['total_reviews']; ?></h3>
                    <p class="mb-0">Reviews</p>
                </div>
            </div>
        </div>

        <div class="row g-4">
            <div class="col-lg-6">
                <div class="glass-card p-4 mb-4">
                    <h4 class="mb-3">Manage Restaurants</h4>
                    <form method="POST">
                        <input type="hidden" name="action" value="save_restaurant">
                        <input type="hidden" name="restaurant_id" value="<?php echo $editingRestaurant['id'] ?? 0; ?>">
                        <div class="row g-3">
                            <div class="col-12"><input type="text" name="name" class="form-control" placeholder="Restaurant name" value="<?php echo htmlspecialchars($editingRestaurant['name'] ?? ''); ?>" required></div>
                            <div class="col-12"><textarea name="description" class="form-control" rows="2" placeholder="Description"><?php echo htmlspecialchars($editingRestaurant['description'] ?? ''); ?></textarea></div>
                            <div class="col-md-6"><input type="text" name="address" class="form-control" placeholder="Address" value="<?php echo htmlspecialchars($editingRestaurant['address'] ?? ''); ?>"></div>
                            <div class="col-md-6"><input type="text" name="location" class="form-control" placeholder="Location" value="<?php echo htmlspecialchars($editingRestaurant['location'] ?? ''); ?>"></div>
                            <div class="col-md-6"><input type="text" name="cuisine" class="form-control" placeholder="Cuisine" value="<?php echo htmlspecialchars($editingRestaurant['cuisine'] ?? ''); ?>"></div>
                            <div class="col-md-6"><input type="text" name="price_range" class="form-control" placeholder="Price range" value="<?php echo htmlspecialchars($editingRestaurant['price_range'] ?? ''); ?>"></div>
                            <div class="col-md-6"><input type="number" step="0.1" name="rating" class="form-control" placeholder="Rating" value="<?php echo htmlspecialchars($editingRestaurant['rating'] ?? '0'); ?>"></div>
                            <div class="col-md-6"><input type="text" name="opening_hours" class="form-control" placeholder="Opening hours" value="<?php echo htmlspecialchars($editingRestaurant['opening_hours'] ?? ''); ?>"></div>
                            <div class="col-md-6"><input type="text" name="phone" class="form-control" placeholder="Phone" value="<?php echo htmlspecialchars($editingRestaurant['phone'] ?? ''); ?>"></div>
                            <div class="col-md-6"><input type="text" name="image" class="form-control" placeholder="Image URL" value="<?php echo htmlspecialchars($editingRestaurant['image'] ?? ''); ?>"></div>
                            <div class="col-12"><label><input type="checkbox" name="featured" value="1" <?php echo !empty($editingRestaurant['featured']) ? 'checked' : ''; ?>> Featured</label></div>
                        </div>
                        <button class="btn btn-gold mt-3">Save Restaurant</button>
                    </form>
                    <div class="table-responsive mt-4">
                        <table class="table table-dark table-striped">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Location</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php while ($row = $restaurants->fetch_assoc()): ?>
                                    <tr>
                                        <td><?php echo htmlspecialchars($row['name']); ?></td>
                                        <td><?php echo htmlspecialchars($row['location']); ?></td>
                                        <td>
                                            <a href="admin-panel.php?edit_restaurant=<?php echo $row['id']; ?>" class="btn btn-sm btn-outline-gold">Edit</a>
                                            <form method="POST" class="d-inline">
                                                <input type="hidden" name="action" value="delete_restaurant">
                                                <input type="hidden" name="restaurant_id" value="<?php echo $row['id']; ?>">
                                                <button class="btn btn-sm btn-outline-danger">Delete</button>
                                            </form>
                                        </td>
                                    </tr>
                                <?php endwhile; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="col-lg-6">
                <div class="glass-card p-4 mb-4">
                    <h4 class="mb-3">Manage Cafes</h4>
                    <form method="POST">
                        <input type="hidden" name="action" value="save_cafe">
                        <input type="hidden" name="cafe_id" value="<?php echo $editingCafe['id'] ?? 0; ?>">
                        <div class="row g-3">
                            <div class="col-12"><input type="text" name="name" class="form-control" placeholder="Cafe name" value="<?php echo htmlspecialchars($editingCafe['name'] ?? ''); ?>" required></div>
                            <div class="col-12"><textarea name="description" class="form-control" rows="2" placeholder="Description"><?php echo htmlspecialchars($editingCafe['description'] ?? ''); ?></textarea></div>
                            <div class="col-md-6"><input type="text" name="address" class="form-control" placeholder="Address" value="<?php echo htmlspecialchars($editingCafe['address'] ?? ''); ?>"></div>
                            <div class="col-md-6"><input type="text" name="location" class="form-control" placeholder="Location" value="<?php echo htmlspecialchars($editingCafe['location'] ?? ''); ?>"></div>
                            <div class="col-12"><input type="text" name="coffee_types" class="form-control" placeholder="Coffee types" value="<?php echo htmlspecialchars($editingCafe['coffee_types'] ?? ''); ?>"></div>
                            <div class="col-md-6"><input type="number" step="0.1" name="rating" class="form-control" placeholder="Rating" value="<?php echo htmlspecialchars($editingCafe['rating'] ?? '0'); ?>"></div>
                            <div class="col-md-6"><input type="text" name="opening_hours" class="form-control" placeholder="Opening hours" value="<?php echo htmlspecialchars($editingCafe['opening_hours'] ?? ''); ?>"></div>
                            <div class="col-md-6"><input type="text" name="phone" class="form-control" placeholder="Phone" value="<?php echo htmlspecialchars($editingCafe['phone'] ?? ''); ?>"></div>
                            <div class="col-md-6"><input type="text" name="image" class="form-control" placeholder="Image URL" value="<?php echo htmlspecialchars($editingCafe['image'] ?? ''); ?>"></div>
                            <div class="col-12"><label><input type="checkbox" name="featured" value="1" <?php echo !empty($editingCafe['featured']) ? 'checked' : ''; ?>> Featured</label></div>
                        </div>
                        <button class="btn btn-gold mt-3">Save Cafe</button>
                    </form>
                    <div class="table-responsive mt-4">
                        <table class="table table-dark table-striped">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Location</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php while ($row = $cafes->fetch_assoc()): ?>
                                    <tr>
                                        <td><?php echo htmlspecialchars($row['name']); ?></td>
                                        <td><?php echo htmlspecialchars($row['location']); ?></td>
                                        <td>
                                            <a href="admin-panel.php?edit_cafe=<?php echo $row['id']; ?>" class="btn btn-sm btn-outline-gold">Edit</a>
                                            <form method="POST" class="d-inline">
                                                <input type="hidden" name="action" value="delete_cafe">
                                                <input type="hidden" name="cafe_id" value="<?php echo $row['id']; ?>">
                                                <button class="btn btn-sm btn-outline-danger">Delete</button>
                                            </form>
                                        </td>
                                    </tr>
                                <?php endwhile; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="row g-4">
            <div class="col-lg-7">
                <div class="glass-card p-4 mb-4">
                    <h4 class="mb-3">Manage Food Streets</h4>
                    <form method="POST">
                        <input type="hidden" name="action" value="save_street">
                        <input type="hidden" name="street_id" value="<?php echo $editingStreet['id'] ?? 0; ?>">
                        <div class="row g-3">
                            <div class="col-12"><input type="text" name="name" class="form-control" placeholder="Food street name" value="<?php echo htmlspecialchars($editingStreet['name'] ?? ''); ?>" required></div>
                            <div class="col-12"><textarea name="description" class="form-control" rows="2" placeholder="Description"><?php echo htmlspecialchars($editingStreet['description'] ?? ''); ?></textarea></div>
                            <div class="col-md-6"><input type="text" name="location" class="form-control" placeholder="Location" value="<?php echo htmlspecialchars($editingStreet['location'] ?? ''); ?>"></div>
                            <div class="col-md-6"><input type="text" name="famous_for" class="form-control" placeholder="Famous for" value="<?php echo htmlspecialchars($editingStreet['famous_for'] ?? ''); ?>"></div>
                            <div class="col-md-6"><input type="text" name="image" class="form-control" placeholder="Image URL" value="<?php echo htmlspecialchars($editingStreet['image'] ?? ''); ?>"></div>
                            <div class="col-md-6"><input type="number" step="0.1" name="rating" class="form-control" placeholder="Rating" value="<?php echo htmlspecialchars($editingStreet['rating'] ?? '0'); ?>"></div>
                        </div>
                        <button class="btn btn-gold mt-3">Save Food Street</button>
                    </form>
                    <div class="table-responsive mt-4">
                        <table class="table table-dark table-striped">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Location</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php while ($row = $streets->fetch_assoc()): ?>
                                    <tr>
                                        <td><?php echo htmlspecialchars($row['name']); ?></td>
                                        <td><?php echo htmlspecialchars($row['location']); ?></td>
                                        <td>
                                            <a href="admin-panel.php?edit_street=<?php echo $row['id']; ?>" class="btn btn-sm btn-outline-gold">Edit</a>
                                            <form method="POST" class="d-inline">
                                                <input type="hidden" name="action" value="delete_street">
                                                <input type="hidden" name="street_id" value="<?php echo $row['id']; ?>">
                                                <button class="btn btn-sm btn-outline-danger">Delete</button>
                                            </form>
                                        </td>
                                    </tr>
                                <?php endwhile; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="col-lg-5">
                <div class="glass-card p-4">
                    <h4 class="mb-3">Manage Locations</h4>
                    <form method="POST">
                        <input type="hidden" name="action" value="add_location">
                        <div class="input-group">
                            <input type="text" name="location_name" class="form-control" placeholder="Add a new location">
                            <button class="btn btn-gold">Add</button>
                        </div>
                    </form>
                    <div class="mt-4">
                        <?php while ($location = $locations->fetch_assoc()): ?>
                            <div class="d-flex justify-content-between align-items-center border-bottom py-2">
                                <span><?php echo htmlspecialchars($location['name']); ?></span>
                                <form method="POST" class="d-inline">
                                    <input type="hidden" name="action" value="delete_location">
                                    <input type="hidden" name="location_id" value="<?php echo $location['id']; ?>">
                                    <button class="btn btn-sm btn-outline-danger">Remove</button>
                                </form>
                            </div>
                        <?php endwhile; ?>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>