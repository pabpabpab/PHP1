<h1><?= $h1 ?></h1>
<?php if (!empty($error)): ?>
<div class='error'><?= $error ?></div>
<?php endif; ?>
<form method='post' action='?p=login&a=authorization'>
   <input type='email' placeholder='Ваш логин (email)' name='email' class='field'><br><br>
   <input type='password' placeholder='Пароль' name='password' class='field'><br><br>
   <input type='submit' class='field'>
</form>
