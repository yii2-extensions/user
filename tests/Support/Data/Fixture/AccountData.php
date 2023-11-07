<?php

declare(strict_types=1);

$time = time();

return [
    'confirmed' => [
        'id' => 1,
        'username' => 'admin',
        'email' => 'administrator@example.com',
        'password_hash' => '$argon2i$v=19$m=131072,t=3,p=4$UVVqT2xJcDQvTjRZS0pjaA$CSWrMb1f4BAji0jRzAodqMFMq0u08Q52/wPkXZbZbEo',
        'registration_ip' => '127.0.0.1',
        'created_at' => $time,
        'updated_at' => $time,
        'confirmed_at' => $time,
    ],
];
