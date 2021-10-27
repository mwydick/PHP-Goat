<?php declare(strict_types=1);

global $project_dir;

$project_dir   = __DIR__ . '/..';
$bootstrap_dir = "$project_dir/bootstrap";

require_once __DIR__ . '/../vendor/autoload.php';

$settings = require_once "$bootstrap_dir/settings.php";

$app = new \Slim\App($settings);

require_once "$bootstrap_dir/dependencies.php";
require_once "$bootstrap_dir/routes.php";

$app->run();
