<?php declare(strict_types=1);

global $app;
global $project_dir;

// assume that $app is defined and represents a Slim App

// Register a middleware for detecting signed-in users
$app->add(new \NotesIO\SessionManager($app->getContainer()));

$app->get('/', \NotesIO\PublicNotesController::class . ':index');
$app->get('/public/{filtered_user}', \NotesIO\PublicNotesController::class . ':index');
$app->get('/public/{filtered_user}/note/{note_id}', \NotesIO\PublicNotesController::class . ':get_public_note');

$app->get('/sign-in', \NotesIO\SignInController::class . ':get_sign_in');
$app->post('/sign-in', \NotesIO\SignInController::class . ':post_sign_in');
$app->get('/register', \NotesIO\SignInController::class . ':get_register');
$app->post('/register', \NotesIO\SignInController::class . ':post_register');

$app->get('/user/{username}', \NotesIO\UserNotesController::class . ':get_list');
$app->get('/user/{username}/note/new', \NotesIO\UserNotesController::class . ':get_new_note');
$app->post('/user/{username}/note/new', \NotesIO\UserNotesController::class . ':post_new_note');
$app->get('/user/{username}/note/{note_id}', \NotesIO\UserNotesController::class . ':get_note');


