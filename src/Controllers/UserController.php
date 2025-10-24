<?php
class UserController {
    public function index() {
        $users = [
            ["id" => 1, "name" => "Admin"],
            ["id" => 2, "name" => "Novi"]
        ];
        echo json_encode(["success" => true, "data" => $users]);
    }

    public function show($id) {
        $user = ["id" => $id, "name" => "User " . $id];
        echo json_encode(["success" => true, "data" => $user]);
    }
}
?>
