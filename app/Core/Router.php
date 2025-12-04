<?php
class Router {
    private $routes = [];

    public function add($route, $controller, $method) {
        $this->routes[$route] = ['controller' => $controller, 'method' => $method];
    }

    public function dispatch($uri) {
        $path = parse_url($uri, PHP_URL_PATH);

        // === PERBAIKAN DISINI ===
        // Kita paksa hapus nama folder project dari pembacaan sistem
        // Agar /thrifting_app/login terbaca sebagai /login saja
        $path = str_replace('/thrifting_app', '', $path); // Hapus versi underscore
        $path = str_replace('/thriftingapp', '', $path);  // Hapus versi sambung
        
        // Hapus slash di akhir jika ada
        if ($path !== '/') {
            $path = rtrim($path, '/');
        }

        // Cek rute
        if (array_key_exists($path, $this->routes)) {
            $controllerName = $this->routes[$path]['controller'];
            $methodName = $this->routes[$path]['method'];
            
            require_once ROOT_PATH . "/app/Controllers/$controllerName.php";
            $controller = new $controllerName();
            $controller->$methodName();
        } else {
            // Error Handling
            echo "<div style='text-align:center; padding:50px;'>";
            echo "<h1 style='color:red;'>404 - Rute Tidak Ditemukan</h1>";
            echo "<p>Sistem sudah mencoba membersihkan URL menjadi: <strong>$path</strong></p>";
            echo "<p>Tapi tetap tidak cocok dengan daftar rute.</p>";
            echo "</div>";
        }
    }
}
?>