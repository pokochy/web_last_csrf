<?php
function get_stored_password($user) {
    if (!file_exists("password.txt")) return null;
    $lines = file("password.txt", FILE_IGNORE_NEW_LINES);
    foreach ($lines as $line) {
        list($u, $pw) = explode(":", $line, 2);
        if ($u === $user) {
            return trim($pw);
        }
    }
    return null;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user = $_POST['user'] ?? '';
    $pw = $_POST['pw'] ?? '';
    $stored_pw = get_stored_password($user);

    if ($stored_pw !== null && $pw === $stored_pw) {
        // 쿠키 설정 (1시간 유지)
        setcookie("user", $user, time() + 3600);
        echo "✅ 로그인 성공! <a href='change_pw.php'>비밀번호 변경하기</a>";
        exit;
    } else {
        echo "❌ 로그인 실패!";
    }
}
?>

<form method="POST">
  ID: <input type="text" name="user"><br>
  PW: <input type="text" name="pw"><br>
  <button type="submit">로그인</button>
</form>
