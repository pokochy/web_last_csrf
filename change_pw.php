<?php
function update_password($user, $new_pw) {
    $lines = file_exists("password.txt") ? file("password.txt", FILE_IGNORE_NEW_LINES) : [];
    $updated = false;
    foreach ($lines as &$line) {
        list($u, $pw) = explode(":", $line, 2);
        if ($u === $user) {
            $line = "$user:$new_pw";
            $updated = true;
        }
    }
    if (!$updated) {
        $lines[] = "$user:$new_pw";
    }
    file_put_contents("password.txt", implode("\n", $lines));
}

if (!isset($_COOKIE['user'])) {
    echo "❌ 쿠키 없음 - 로그인 안됨";
    exit;
}

$user = $_COOKIE['user'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $new_pw = $_POST['new_pw'] ?? '';
    update_password($user, $new_pw);
    echo "✅ {$user}님의 비밀번호가 <b>$new_pw</b>로 변경되었습니다.";
    exit;
}
?>

<form method="POST">
  새 비밀번호: <input type="text" name="new_pw">
  <button type="submit">변경</button>
</form>

