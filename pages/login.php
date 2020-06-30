<?php
function indexAction() {
    echo render('tlogin.php', [
        'title' => 'Авторизация',
        'h1' => 'Авторизация',
        'msg' => getMSG(),
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
      setMSG($error);
      redirect('/?p=login');
      return;
   }

   $sql = "SELECT * FROM users WHERE email = '" . $_POST['email'] ."'";
   $result = mysqli_query(getLink(), $sql);

   if (mysqli_num_rows($result) == 0) {
      setMSG('Неверно указан логин или пароль.');
      redirect('/?p=login');
      return;
   }

   $row = mysqli_fetch_assoc($result);
   if (!password_verify($_POST['password'], $row['password'])) {
      setMSG('Неверно указан логин или пароль.');
      redirect('/?p=login');
      return;
   }

   $_SESSION['user']['authorized'] = true;
   $_SESSION['user']['id'] = $row['id'];
   $_SESSION['user']['name'] = $row['name'];
   $_SESSION['user']['is_admin'] = $row['is_admin'];
   $_SESSION['user']['number_of_products'] = $row['number_of_products'];

   if (isAdmin()) {
       $_SESSION['user']['orders_count'] = userOrdersCounter();
   } else {
       $_SESSION['user']['orders_count'] = $row['number_of_orders'];
   }

   redirect('/?p=personal_area');
}
