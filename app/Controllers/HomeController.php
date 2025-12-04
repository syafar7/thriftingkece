<?php
require_once ROOT_PATH . '/app/Models/Product.php';

class HomeController {
    public function index() {
        $db = (new Database())->getConnection();
        $model = new Product($db);
        
        // Tangkap Filter (Jika kosong string, ubah jadi NULL)
        $keyword = !empty($_GET['q']) ? $_GET['q'] : null;
        $category = !empty($_GET['cat']) ? $_GET['cat'] : null;
        $minPrice = !empty($_GET['min_price']) ? $_GET['min_price'] : null;
        $maxPrice = !empty($_GET['max_price']) ? $_GET['max_price'] : null;
        $size = !empty($_GET['size']) ? $_GET['size'] : null;

        // Panggil model
        $products = $model->getAll($keyword, $category, $minPrice, $maxPrice, $size);
        
        require_once ROOT_PATH . '/views/home/index.php';
    }
}
?>