<?php
$vars = [
  "template" => null,
  "dbname" => "develop",
  "tbname" => "develop",
  "tables" => [],
  "columns" => null,
  "where" => null,
  "order" => null,
  "children" => null,
];
?>
<?php switch ($vars['template']): ?>
<?php
  case "default": ?>
    <?php break; ?>
  <?php
  default: ?>
    SELECT * FROM `<? echo $vars['dbname'] ?>`.`<? echo $vars['tbname'] ?>`
    <?php break; ?>
<?php endswitch; ?>