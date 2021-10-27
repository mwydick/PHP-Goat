<?php declare(strict_types=1);

return [
    'settings' => [
        'displayErrorDetails' => true, // set to false in production

        'renderer' => [
            // We need this to allow HTML in note bodies
            'autoescape' => false
        ]
    ],
];
