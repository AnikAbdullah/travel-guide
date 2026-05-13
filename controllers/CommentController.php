<?php
require_once __DIR__ . "/../config/db.php";
session_start();

class CommentController {
    public function add() {
        global $pdo;
        $post_id = $_POST['post_id'];
        $user_id = $_SESSION['user_id'];
        $content = htmlspecialchars($_POST['content']);

        $stmt = $pdo->prepare("INSERT INTO comments (post_id, user_id, content) VALUES (?,?,?)");
        $stmt->execute([$post_id, $user_id, $content]);

        echo json_encode(["status"=>"success","message"=>"Comment added"]);
    }

    public function delete() {
        global $pdo;
        $id = $_POST['id'];
        $user_id = $_SESSION['user_id'];

        $stmt = $pdo->prepare("DELETE FROM comments WHERE id=? AND user_id=?");
        $stmt->execute([$id, $user_id]);

        echo json_encode(["status"=>"success","message"=>"Comment deleted"]);
    }
}
?>
