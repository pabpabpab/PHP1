<h1><?= $h1 ?></h1>
<?php if (!empty($msg)): ?>
  <div class='error'><?= $msg ?></div>
<?php endif; ?>
<form method='post' action='?p=adduser'>
   <input type='text' placeholder='Ваше имя' name='name' class='field'><br><br>
   <input type='email' placeholder='Ваш email' name='email' class='field'><br><br>
   <input type='password' placeholder='Пароль' name='password' class='field'><br><br>
   <input type='password' placeholder='Повторите пароль' name='password2' class='field'><br><br>
   <input type='submit' class='field'>
</form>
