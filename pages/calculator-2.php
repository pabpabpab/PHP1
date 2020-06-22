<?php

$title = 'Калькулятор 2';
require_once dirname(__FILE__, 2) . '/engine/arithmetic_functions.php';


function calculator($operand1, $operand2, $operation) {
   $arithmeticFunctions = ['+' => 'addition', '-' => 'subtraction', '/' => 'division', '*' => 'multiplication'];
   $func = $arithmeticFunctions[$operation];

   if (empty($func)) {
      return "Выбрана неизвестная арифметическая операция.";
   }

   if ($operand2 === 0 && $operation === '/') {
      return "Нельзя делить на ноль";
   }

   return "{$operand1} {$operation} {$operand2} = " . $func($operand1, $operand2);
}


$result = '';
if (allKeysExist(['operation', 'operand1', 'operand2'], $_GET)) {
   $operand1 = getNumeric($_GET['operand1']);
   $operand2 = getNumeric($_GET['operand2']);
   $operation = $_GET['operation'][0];
   $result = calculator($operand1, $operand2, $operation);
}

if (!empty($result)) {
    $result = "<div class='result'>{$result}</div>";
}


echo <<<phtml
{$result}
<form method='get' class='form'>
    <input type='hidden' name='page' value='3'>
    <input type="text" placeholder='операнд 1' name='operand1' class='field'>
    <input type='text' placeholder='операнд 2' name='operand2' class='field'>
    <input type='submit' name='operation[]' value='+' class='field'>
    <input type='submit' name='operation[]' value='-' class='field'>
    <input type='submit' name='operation[]' value='*' class='field'>
    <input type='submit' name='operation[]' value='/' class='field'>
</form>
phtml;

?>