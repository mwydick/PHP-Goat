<?php declare(strict_types=1);

namespace NotesIO;

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

class SignInController extends BaseController {

    public function get_sign_in(Request $request, Response $response, array $args) {
        return $this->view->render($response, 'sign-in.twig');
    }

    public function post_sign_in(Request $request, Response $response, array $args) {
        $data = $request->getParsedBody();

        $username = $data['username'] ?? '';
        $password = $data['password'] ?? '';

        $user_result = $this->db->query("
            SELECT * FROM users WHERE username = '$username' LIMIT 1
        ");

        $user = $user_result->fetchArray();

        if (empty($user)) {
            return $this->view->render($response, 'sign-in.twig', [
                'error' => "Username $username does not exist :T"
            ]);
        }

        if ($user['password'] != $password) {
            return $this->view->render($response, 'sign-in.twig', [
                'error' => "Incorrect password."
            ]);
        }

        AuthenticationCookie::mint($username);

        return $response->withRedirect("/user/$username", 301);
    }

    public function get_register(Request $request, Response $response, array $args) {
        return $this->view->render($response, 'register.twig');
    }

    public function post_register(Request $request, Response $response, array $args) {
        $data = $request->getParsedBody();

        $username = $data['username'] ?? '';
        $password = $data['password'] ?? '';

        if (empty($username) || empty($password)) {
            return $this->view->render($response, 'register.twig', [
                'error' => "Please enter both a username and password."
            ]);
        }

        $insert_result = @$this->db->exec("
            REPLACE INTO users (username, password)
            VALUES ('$username', '$password')
        ");

        if ($insert_result === false) {
            $error_msg = $this->db->lastErrorMsg();

            return $this->view->render($response, 'register.twig', [
                'error' => "<strong>Database error:</strong> $error_msg"
            ]);
        }

        AuthenticationCookie::mint($username);

        return $response->withRedirect("/user/$username", 301);
    }

}
