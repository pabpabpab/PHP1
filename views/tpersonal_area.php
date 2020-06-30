<h1><?= $h1 ?></h1>
<div class='private_content'>
	<div class='private_column_left'>
		<?= $privateMenu ?>
	</div>
	<div class='private_column_right'>
		<?php if (!empty($msg)): ?>
          <div class='error'><?= $msg ?></div>
        <?php endif; ?>
		<?= $privateContent ?>
	</div>
</div>



