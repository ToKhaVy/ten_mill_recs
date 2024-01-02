<?php
require 'vendor/autoload.php';

use Faker\Factory;

$faker = Factory::create();

echo $faker->name;
