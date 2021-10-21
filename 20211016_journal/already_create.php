<?php
// var_dump($_GET);
// exit();




include('functions.php');

$user_id = $_GET['user_id'];
$journal_id = $_GET['journal_id'];

$pdo = connect_to_db();

// $sql = 'INSERT INTO like_table (id, user_id, todo_id, created_at) VALUES (NULL, :user_id, :todo_id, sysdate())';
$sql = 'SELECT COUNT(*) FROM already_table WHERE user_id=:user_id AND journal_id=:journal_id';
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':user_id', $user_id, PDO::PARAM_STR);
$stmt->bindValue(':journal_id', $journal_id, PDO::PARAM_STR);
$status = $stmt->execute();

if ($status == false) {
$error = $stmt->errorInfo();
echo json_encode(["error_msg" => "{$error[2]}"]);
exit();
} else {
// header("Location:todo_read.php");
// exit();
$already_count = $stmt->fetchColumn();
  // まずはデータ確認
// var_dump($like_count);
// exit();
if ($already_count != 0) {
    // いいねされている状態
    $sql = 'DELETE FROM already_table WHERE user_id=:user_id AND journal_id=:journal_id';
    } else {
    // いいねされていない状態
    $sql = 'INSERT INTO already_table (id, user_id, journal_id, created_at) VALUES (NULL, :user_id, :journal_id, sysdate())';
    }

  // 以下は前項と変更なし
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':user_id', $user_id, PDO::PARAM_STR);
    $stmt->bindValue(':journal_id', $journal_id, PDO::PARAM_STR);
    $status = $stmt->execute();

    if ($status == false) {
    $error = $stmt->errorInfo();
    echo json_encode(["error_msg" => "{$error[2]}"]);
    exit();
    } else {
    header("Location:journal_read.php");
    exit();
    }
}