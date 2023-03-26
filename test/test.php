<?php

require "../src/Validate.php";

use Reald\Validate\Validate;

$v = new Validate;

$post = [];

$rules = [
    "name" => [
        [
            "rule" => "required",
            "message" => "no name entered",
        ],
        [
            "rule" => ["maxLength", 255],
            "message" => "name exceeds 255 characters",
        ],
    ],
    "code" => [
        [
            "rule" => "required",
            "message" => "no code entered",
        ],
    ],
];

echo "<pre>";
print_r($v->verify($post, $rules)->toArray());
