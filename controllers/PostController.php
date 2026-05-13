<?php
require_once __DIR__ . "/../config/db.php";

class PostController {
    public function browse() {
        global $pdo;
        $stmt = $pdo->prepare("SELECT * FROM posts WHERE status='approved'");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function search() {
        global $pdo;
        $q = $_GET['q'] ?? '';
        $stmt = $pdo->prepare("SELECT * FROM posts WHERE status='approved' AND (title LIKE ? OR country LIKE ?)");
        $stmt->execute(["%$q%", "%$q%"]);
        echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
    }

    public function filter() {
        global $pdo;
        $sql = "SELECT * FROM posts WHERE status='approved'";
        $params = [];

        if (!empty($_GET['country'])) { $sql .= " AND country=?"; $params[]=$_GET['country']; }
        if (!empty($_GET['genre']))   { $sql .= " AND genre=?";   $params[]=$_GET['genre']; }
        if (!empty($_GET['cost']))    { $sql .= " AND cost_level=?"; $params[]=$_GET['cost']; }

        $stmt = $pdo->prepare($sql);
        $stmt->execute($params);
        echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
    }
}
?>
