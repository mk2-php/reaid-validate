<?php

require "../src/Validate.php";

use Reald\Validator\Validate;

$v = new Validate;

echo "<pre>";
print_r($v->verify([])->toJuge());
