<?php declare(strict_types=1);

namespace NotesIO;

use Psr\Container\ContainerInterface;

class BaseController {

    protected $view;

    protected $db;

    public function __construct(ContainerInterface $container) {
        $this->view = $container->get('view');
        $this->db   = $container->get('db');
    }

}
