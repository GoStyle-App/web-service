<?php

$projectDir = __DIR__."/../../";

require $projectDir . "vendor/autoload.php";

echo "Wait database...".PHP_EOL;

set_time_limit(10);

(new \Symfony\Component\Dotenv\Dotenv())->load($projectDir.".env");

$host = $_SERVER['POSTGRES_HOST'];

for (; ;) {
    if (@fsockopen($host.":5432")) {
        break;
    }
}
