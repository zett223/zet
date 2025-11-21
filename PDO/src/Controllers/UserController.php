<?php
require_once __DIR__ . '/../../config/database.php';

class UserController {
    public function index() {
        try {
            $pdo = Database::connection();
            $stmt = $pdo->query("SELECT * FROM users");
            $users = $stmt->fetchAll();
            echo json_encode(["success" => true, "data" => $users]);
        } catch (Exception $e) {
            echo json_encode(["success" => false, "message" => "Database error: " . $e->getMessage()]);
        }
    }

    public function show($id) {
        try {
            $pdo = Database::connection();
            $stmt = $pdo->prepare("SELECT * FROM users WHERE id = ?");
            $stmt->execute([$id]);
            $user = $stmt->fetch();
            if ($user) {
                echo json_encode(["success" => true, "data" => $user]);
            } else {
                echo json_encode(["success" => false, "message" => "User not found"]);
            }
        } catch (Exception $e) {
            echo json_encode(["success" => false, "message" => "Database error: " . $e->getMessage()]);
        }
    }
}
?>
