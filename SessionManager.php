<?php declare(strict_types=1);

namespace NotesIO;

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

use Psr\Container\ContainerInterface;

class SessionManager {

    protected $db;

    public function __construct(ContainerInterface $container) {
        $this->db = $container->get('db');
    }

    public function __invoke(Request $request, Response $response, callable $next) : Response {
        $username = \NotesIO\AuthenticationCookie::read();

        if (empty($username)) {
            return $next($request, $response);
        }

        $user_result = $this->db->query("
            SELECT * FROM users WHERE username = '$username' LIMIT 1
        ");

        $user = $user_result->fetchArray();

        if (empty($user)) {
            \NotesIO\AuthenticationCookie::delete();

            throw new \Exception("Username $username does not exist");
        }

        return $next(
            $request->withAttribute('user', $username),
            $response
        );
    }

}
