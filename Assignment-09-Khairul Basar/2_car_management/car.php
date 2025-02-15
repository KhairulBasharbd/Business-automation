<?php
// Database class for connection
class Database {
    private $host = 'localhost';
    private $dbname = 'car_management';
    private $username = 'root'; 
    private $password = '123'; 
    protected $conn;

    public function __construct() {
        try {
            $this->conn = new PDO("mysql:host=$this->host;dbname=$this->dbname", $this->username, $this->password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die("Database connection failed: " . $e->getMessage());
        }
    }
}

// Car class for CRUD operations
class Car extends Database {
    // Insert a new car
    public function insertCar($brand, $model, $year, $price) {
        $stmt = $this->conn->prepare("INSERT INTO cars (brand, model, year, price) VALUES (:brand, :model, :year, :price)");
        return $stmt->execute([':brand' => $brand, ':model' => $model, ':year' => $year, ':price' => $price]);
    }

    // Retrieve all cars
    public function getAllCars() {
        $stmt = $this->conn->query("SELECT * FROM cars ORDER BY id DESC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Update car details
    public function updateCar($id, $brand, $model, $year, $price) {
        $stmt = $this->conn->prepare("UPDATE cars SET brand = :brand, model = :model, year = :year, price = :price WHERE id = :id");
        return $stmt->execute([':id' => $id, ':brand' => $brand, ':model' => $model, ':year' => $year, ':price' => $price]);
    }

    // Delete a car
    public function deleteCar($id) {
        $stmt = $this->conn->prepare("DELETE FROM cars WHERE id = :id");
        return $stmt->execute([':id' => $id]);
    }
}
?>
