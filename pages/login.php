<?php
function indexAction() {
    $error = '';
    if (!empty($_GET['error'])) {
    	$error = $_GET['error'];
    }

    echo render('tlogin.php', [
        'title' => 'Авторизация',
        'h1' => 'Авторизация',
        'error' => $error,
    ]);
}



function authorizationAction() {
   $error = '';
   if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
      $error .= 'Неверно указан email.<br>';
   }
   if (empty($_POST['password'])) {
      $error .= 'Не указан пароль.<br>';
   }
   if (!empty($error)) {
      header("Location: /?p=login&error={$error}");
      exit;
   }

   $sql = "SELECT * FROM users WHERE email = '" . $_POST['email'] ."'";
   $result = mysqli_query(getLink(), $sql);

   if (mysqli_num_rows($result) == 0) {
      $error = 'Неверно указан логин или пароль.';
   	  header("Location: /?p=login&error={$error}");
      exit;
   }

   $row = mysqli_fetch_assoc($result);
   if (!password_verify($_POST['password'], $row['password'])) {
      $error = 'Неверно указан логин или пароль.';
   	  header("Location: /?p=login&error={$error}");
      exit;
   }

   $_SESSION['user']['authorized'] = true;
   $_SESSION['user']['id'] = $row['id'];
   $_SESSION['user']['name'] = $row['name'];
   $_SESSION['user']['is_amin'] = $row['is_admin'];
   $_SESSION['user']['number_of_products'] = $row['number_of_products'];

   header("Location: /?p=personal_area");
   exit;
}
