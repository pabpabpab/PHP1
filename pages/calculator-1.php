<?php

$title = 'Калькулятор 1';
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



$selected = ['+' => '', '-' => '', '/' => '', '*' => ''];
$result = '';
if (allKeysExist(['calculate', 'operand1', 'operand2', 'operation'], $_GET)) {
   $operand1 = getNumeric($_GET['operand1']);
   $operand2 = getNumeric($_GET['operand2']);
   $operation = $_GET['operation'];
   $selected[$operation] = ' selected';
   $result = calculator($operand1, $operand2, $operation);
}


if (!empty($result)) {
    $result = "<div class='result'>{$result}</div>";
}


echo <<<phtml
{$result}
<form method='get' class='form'>
    <input type='hidden' name='page' value='2'>
    <input type="text" placeholder='операнд 1' name='operand1' class='field'>
    <select name='operation' class='field'>
       <option{$selected['+']}>+</option>
       <option{$selected['-']}>-</option>
       <option{$selected['*']}>*</option>
       <option{$selected['/']}>/</option>
    </select>
    <input type='text' placeholder='операнд 2' name='operand2' class='field'>
    <input type='submit' name='calculate' value='Посчитать' class='field'>
</form>
phtml;

?>