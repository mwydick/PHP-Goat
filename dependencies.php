<?php declare(strict_types=1);

global $app;
global $project_dir;

// assume that $app is defined and represents a Slim App

$container = $app->getContainer();

// Register Twig renderer
$container['view'] = function ($container) use ($project_dir) {
    $view = new \Slim\Views\Twig(
        "$project_dir/templates",
        $container->get('settings')['renderer']
    );

    return $view;
};

// Register PDO
$container['db'] = function($container) use ($project_dir) {
    $db = new \SQLite3("$project_dir/data/db.sqlite3");

    $db->exec("
        CREATE TABLE IF NOT EXISTS users (
            username text NOT NULL PRIMARY KEY,
            password text
        )
    ");

    $db->exec("
        CREATE TABLE IF NOT EXISTS notes (
            note_id integer NOT NULL PRIMARY KEY,
            username text,
            title text,
            body text,
            is_public int
        )
    ");

    return $db;
};
