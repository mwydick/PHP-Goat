<?php declare(strict_types=1);

namespace NotesIO;

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

class PublicNotesController extends BaseController {

    public function index(Request $request, Response $response, array $args) {
        $filtered_user = $args['filtered_user'] ?? null;

        if ($filtered_user) {
            $optional_filtered_user_clause = "AND username = '$filtered_user'";
        } else {
            $optional_filtered_user_clause = "";
        }

        $notes_result = $this->db->query("
            SELECT * FROM notes
            WHERE is_public = 1
            $optional_filtered_user_clause
            ORDER BY note_id DESC
        ");

        $notes = [];

        while($note = $notes_result->fetchArray(SQLITE3_ASSOC)) {
            $notes[] = $note;
        }

        return $this->view->render($response, 'public-note-list.twig', [
            'user' => $request->getAttribute('user'),
            'filtered_user' => $filtered_user,
            'notes' => $notes
        ]);
    }

    public function get_public_note(Request $request, Response $response, array $args) {
        $filtered_user = $args['filtered_user'] ?? null;
        $note_id       = $args['note_id'];

        $note_result = $this->db->query("
            SELECT * FROM notes
            WHERE username = '$filtered_user'
            AND note_id = '$note_id'
            AND is_public = 1
            LIMIT 1
        ");

        $note = $note_result->fetchArray();

        if (empty($note)) {
            throw new \Exception("Note #$note_id by @$username does not exist.");
        }

        return $this->view->render($response, 'view-note.twig', [
            'user' => $request->getAttribute('user'),
            'note' => $note
        ]);
    }

}
