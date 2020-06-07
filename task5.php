<?php
$currentYear = date('Y');
$content = file_get_contents('template.html');
$result = str_replace('{{YEAR}}', $currentYear, $content);
echo $result;
?>