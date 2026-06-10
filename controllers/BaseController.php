<?php
class BaseController {
    protected $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    protected function view($viewName, $data = []) {
        extract($data);
        $viewFile = 'views/' . $viewName . '.php';
        if (file_exists($viewFile)) {
            require_once $viewFile;
        } else {
            echo "View not found: " . $viewName;
        }
    }

    protected function redirect($url) {
        // Assume base path is /ADSSU DORMITORY SYSTEM/
        // To make it dynamic based on the project path
        $base = dirname($_SERVER['SCRIPT_NAME']);
        if ($base == '/' || $base == '\\') $base = '';
        header("Location: " . $base . "/" . $url);
        exit();
    }
}
?>
