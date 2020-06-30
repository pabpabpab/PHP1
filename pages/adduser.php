<?php
function indexAction() {
   $error = '';
   if (empty($_POST['name'])) {
      $error .= 'Не указано имя.<br>';
   }
   if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
      $error .= 'Неверно указан email.<br>';
   }
   if (empty($_POST['password'])) {
      $error .= 'Не указан пароль.<br>';
   }
   if (empty($_POST['password2'])) {
      $error .= 'Не указано подтверждение пароля.<br>';
   }
   if (!empty($error)) {
      setMSG($error);
      redirect('/?p=registration');
      return;
   }

   if ($_POST['password'] !== $_POST['password2']) {
      setMSG('Пароль подтвержден неверно.');
      redirect('/?p=registration');
      return;
   }

   $hashPassword = password_hash($_POST['password'], PASSWORD_DEFAULT);
   if ($hashPassword === false) {
      setMSG('Не удалось сохранить пароль.');
      redirect('/?p=registration');
      return;
   }

   $name = stripInjection($_POST['name']);

   $userEmail = $_POST['email'];

   $sql = "INSERT INTO
            users
                (name, email, password)
            VALUES
                ('$name','$userEmail', '$hashPassword')";
    mysqli_query(getLink(), $sql);
    $userId = mysqli_insert_id(getLink());


    if ($userId == 0) {
       setMSG('Не удалось создать регистрацию.');
       redirect('/?p=registration');
       return;
    }

    $_SESSION['user']['authorized'] = true;
    $_SESSION['user']['id'] = $userId;
    $_SESSION['user']['name'] = $name;
    $_SESSION['user']['is_admin'] = 0;
    $_SESSION['user']['number_of_products'] = 0;
    $_SESSION['user']['orders_count'] = 0;


    // Пока так
    $subject = 'Регистрация на сайте ' . $_SERVER['SERVER_NAME'];
    $message = 'На ваш e-mail создана регистрация на сайте ' . $_SERVER['SERVER_NAME'];
    mail($userEmail, $subject, $message);

    redirect('/?p=personal_area');
}



