<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="/css/style.css?t=<?= time() ?>">
    <title><?= $title ?></title>
</head>
<body>
    <ul class="menu">
    <li><a href="/" class="menu_link">Главная</a></li>
    <li><a href="/?p=catalog" class="menu_link">Товары</a></li>
    <li><a href="/?p=cart" title="<?= $_SESSION['cart']['totalPrice'] . "&#8381;" ?>" class="menu_link">Корзина (<?= $_SESSION['cart']['count'] ?>)</a></li>
    <?php if ($_SESSION['user']['authorized']): ?>
        <li class='menu_li__personal_area'><a href="/?p=personal_area" class="menu_link">Личный кабинет</a><a href="/?p=personal_area" class='menu__private_name_link'><?= $_SESSION['user']['name'] ?></a></li>
      <li><a href="/?p=logout" class="menu_link">Выйти</a></li>
    <?php else: ?>
      <li><a href="/?p=registration" class="menu_link">Регистрация</a></li>
      <li><a href="/?p=login" class="menu_link">Войти</a></li>
    <?php endif; ?>
    </ul>
    <?= $content ?>
</body>
</html>