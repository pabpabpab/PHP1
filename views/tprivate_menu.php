<ul class="private_menu">
    <?php if (isAdmin()): ?>
       <li><a href="/?p=personal_area" class="private_menu_link">Админ: <?= $_SESSION['user']['name'] ?></a></li>
       <li><a href="/?p=personal_area&a=myProducts" class="private_menu_link">Мои товары (<?= $_SESSION['user']['number_of_products'] ?>)</a></li>
       <li><a href="/?p=personal_area&a=newProduct" class="private_menu_link">Добавить товар</a></li>
       <li><a href="/?p=orders" class="private_menu_link">Заказы  (<?= $_SESSION['user']['orders_count'] ?>)</a></li>
    <?php else: ?>
       <li><a href="/?p=personal_area" class="private_menu_link"><?= $_SESSION['user']['name'] ?></a></li>
       <li><a href="/?p=orders" class="private_menu_link">Мои заказы  (<?= $_SESSION['user']['orders_count'] ?>)</a></li>
    <?php endif; ?>
    <li><a href="/?p=logout" class="private_menu_link">Выход</a></li>
</ul>
