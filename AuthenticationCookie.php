<?php declare(strict_types=1);

namespace NotesIO;

final class AuthenticationCookie {


    public static function mint(string $username) {
        $signature = hash_hmac('sha256', $username, $username);
        $cookie_value = json_encode(['username' => $username, 'signature' => $signature]);

        setcookie('sign-in', $cookie_value);
    }

    public static function read() {
        $cookie_value = $_COOKIE['sign-in'] ?? "";
        $decoded      = json_decode($cookie_value, true);

        if ($decoded !== false) {
            $username = $decoded['username'] ?? null;
            $expected_signature = hash_hmac('sha256', $username, $username);
            if ($expected_signature == $decoded['signature']) {
                return $username
            }
        }

        return null;
    }

    public static function delete() {
        setcookie('sign-in', '', 0);
    }

}
