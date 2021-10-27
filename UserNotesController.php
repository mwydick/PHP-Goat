<?php declare(strict_types=1);

namespace NotesIO;

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

class UserNotesController extends BaseController {

    private function require_user(Request $request, string $username) {
        if ($request->getAttribute("user") !== $username) {
            throw new \Exception("Not Authorized");
        }
    }

    public function get_list(Request $request, Response $response, array $args) {
        $username = $args['username'] ?? '';
        $this->require_user($request, $username);

        $notes_result = $this->db->query("
            SELECT * FROM notes
            WHERE username = '$username'
            ORDER BY note_id DESC
        ");

        $notes = [];

        while($note = $notes_result->fetchArray(SQLITE3_ASSOC)) {
            $notes[] = $note;
        }

        return $this->view->render($response, 'user-note-list.twig', [
            'user' => $request->getAttribute('user'),
            'notes' => $notes
        ]);
    }

    public function get_new_note(Request $request, Response $response, array $args) {
        $username = $args['username'] ?? '';
        $this->require_user($request, $username);

        return $this->view->render($response, 'new-note.twig', [
            'user' => $request->getAttribute('user')
        ]);
    }

    public function post_new_note(Request $request, Response $response, array $args) {
        $username = $args['username'] ?? '';
        $this->require_user($request, $username);

        $data = $request->getParsedBody();

        $title  = $data['title'] ?? '';
        $note   = $data['note'] ?? '';
        $public = $data['public'] ? 1 : 0;

        $insert_result = @$this->db->exec("
            INSERT INTO notes (username, title, body, is_public)
            VALUES ('$username', '$title', '$note', $public)
        ");

        if ($insert_result === false) {
            $error_msg = $this->db->lastErrorMsg();

            // This will never happen
            throw new \Exception("Database error: $error_msg");
        }

        return $response->withRedirect("/user/$username", 301);
    }

    public function get_note(Request $request, Response $response, array $args) {
        $username = $args['username'] ?? '';
        $this->require_user($request, $username);

        $note_id = $args['note_id'];

        $note_result = $this->db->query("
            SELECT * FROM notes WHERE note_id = '$note_id' LIMIT 1
        ");

        $note = $note_result->fetchArray();

        return $this->view->render($response, 'view-note.twig', [
            'user' => $request->getAttribute('user'),
            'note' => $note
        ]);
    }

}
