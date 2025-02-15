<?php
require 'Car.php';
$car = new Car();
$editMode = false;
$editCar = ['id' => '', 'brand' => '', 'model' => '', 'year' => '', 'price' => ''];

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['add'])) {
        $brand = $_POST['brand'];
        $model = $_POST['model'];
        $year = $_POST['year'];
        $price = $_POST['price'];
        if (!empty($brand) && !empty($model) && !empty($year) && !empty($price)) {
            $car->insertCar($brand, $model, $year, $price);
        }
    } elseif (isset($_POST['update'])) {
        $id = $_POST['id'];
        $brand = $_POST['brand'];
        $model = $_POST['model'];
        $year = $_POST['year'];
        $price = $_POST['price'];
        if (!empty($id) && !empty($brand) && !empty($model) && !empty($year) && !empty($price)) {
            $car->updateCar($id, $brand, $model, $year, $price);
        }
    } elseif (isset($_POST['delete'])) {
        $id = $_POST['id'];
        if (!empty($id)) {
            $car->deleteCar($id);
        }
    }
}

// Fetch all cars and put into cars variavle for iterating 
$cars = $car->getAllCars();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Car Management System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2 class="mb-4">Car Management System</h2>

        <!-- Add/Edit Car Form -->
        <form method="POST" class="mb-4">
            <input type="hidden" name="id" id="carId">
            <div class="mb-3">
                <label for="brand" class="form-label">Brand</label>
                <input type="text" class="form-control" id="brand" name="brand" required>
            </div>
            <div class="mb-3">
                <label for="model" class="form-label">Model</label>
                <input type="text" class="form-control" id="model" name="model" required>
            </div>
            <div class="mb-3">
                <label for="year" class="form-label">Year</label>
                <input type="number" class="form-control" id="year" name="year" required>
            </div>
            <div class="mb-3">
                <label for="price" class="form-label">Price</label>
                <input type="number" step="0.01" class="form-control" id="price" name="price" required>
            </div>
            <button type="submit" name="add" class="btn btn-primary" id="addButton">Add Car</button>
            <button type="submit" name="update" class="btn btn-warning" id="updateButton" style="display:none;">Update Car</button>
        </form>

        <!-- Display Cars in a Table -->
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Brand</th>
                    <th>Model</th>
                    <th>Year</th>
                    <th>Price</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($cars as $car): ?>
                    <tr>
                        <td><?php echo $car['id']; ?></td>
                        <td><?php echo $car['brand']; ?></td>
                        <td><?php echo $car['model']; ?></td>
                        <td><?php echo $car['year']; ?></td>
                        <td><?php echo $car['price']; ?></td>
                        <td>
                            <form method="POST" style="display:inline;">
                                <input type="hidden" name="id" value="<?php echo $car['id']; ?>">
                                <button type="submit" name="delete" class="btn btn-danger btn-sm">Delete</button>
                            </form>
                            <button class="btn btn-info btn-sm edit-btn" data-id="<?php echo $car['id']; ?>" data-brand="<?php echo $car['brand']; ?>" data-model="<?php echo $car['model']; ?>" data-year="<?php echo $car['year']; ?>" data-price="<?php echo $car['price']; ?>">Edit</button>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <!-- JavaScript for Edit Functionality -->
    <script>
        document.querySelectorAll('.edit-btn').forEach(button => {
            button.addEventListener('click', () => {
                document.getElementById('carId').value = button.getAttribute('data-id');
                document.getElementById('brand').value = button.getAttribute('data-brand');
                document.getElementById('model').value = button.getAttribute('data-model');
                document.getElementById('year').value = button.getAttribute('data-year');
                document.getElementById('price').value = button.getAttribute('data-price');

                document.getElementById('addButton').style.display = 'none';
                document.getElementById('updateButton').style.display = 'inline-block';
            });
        });
    </script>
</body>
</html>
