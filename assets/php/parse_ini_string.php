<?php

$str = "
[name]
name= 123
";

$ini = parse_ini_string($str);
var_dump($ini);