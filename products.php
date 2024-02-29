<?php
// include koneksi.php
include_once 'koneksi.php';

// set header response type
header('Content-Type: application/json');

// get http referer
if (isset($_SERVER['HTTP_REFERER'])) {
    $referer = $_SERVER['HTTP_REFERER'];
    $referer = substr($referer, strrpos($referer, '/') + 1);
} else {
    $referer = '';
}

// cek method request
$req_method = $_SERVER['REQUEST_METHOD'];

// jika referer dari halaman index maka $req_method adalah POST request dengan id _method
if (($referer == 'PUT' || $referer == 'DELETE') && isset($_POST['_method']) && $_POST['_method'] != '') {
    $req_method = $_POST['_method'];
}
switch ($req_method) {
    case 'GET':
        // ambil id dari method GET
        $id = isset($_GET['id']) ? $_GET['id'] : '';
        // jika id ada, maka ambil data produk berdasarkan id
        if ($id != '') {
            // ambil data produk berdasarkan id
            $sql = "SELECT * FROM products WHERE id_product = $id";
        } else {
            // ambil semua data produk
            $sql = "SELECT * FROM products";
        }
        $result = mysqli_query($conn, $sql);
        if (mysqli_num_rows($result) > 0) {
            $data = array();
            while ($row = mysqli_fetch_assoc($result)) {
                $data[] = $row;
            }
            echo json_encode($data);
        } else {
            // jika data produk kosong
            echo json_encode(array('message' => 'Produk tidak ditemukan'));
        }
        break;
    case 'POST':
        foreach ($_POST as $key => $value) {
            // escape karakter khusus
            $_POST[$key] = mysqli_real_escape_string($conn, $value);
        }
        // if data from json
        $data = json_decode(file_get_contents('php://input'), true);
        foreach ($data as $key => $value) {
            // escape karakter khusus
            $_POST[$key] = mysqli_real_escape_string($conn, $value);
        }
        // tambahkan field created
        $_POST['created'] = date('Y-m-d H:i:s');
        // tambahkan data produk baru
        $sql = "INSERT INTO products (";
        $sql .= implode(", ", array_keys($_POST));
        $sql .= ") VALUES ('";
        $sql .= implode("', '", array_values($_POST));
        $sql .= "')";
        try {
            if (mysqli_query($conn, $sql)) {
                echo json_encode(array('message' => 'Produk berhasil ditambahkan'));
            } else {
                throw new Exception('Gagal menambahkan produk');
            }
        } catch (Exception $e) {
            echo json_encode(array('message' => $e->getMessage()));
        }
        break;
    case 'PUT':
        // ambil id dari method GET
        $id = isset($_GET['id']) ? $_GET['id'] : '';
        // ambil data dari body request
        $data = json_decode(file_get_contents('php://input'), true);
        if ($referer == 'PUT') {
            $data = $_POST;
        }
        unset($data['_method']);
        foreach ($data as $key => $value) {
            // escape karakter khusus
            $data[$key] = mysqli_real_escape_string($conn, $value);
        }
        // update data produk
        $sql = "UPDATE products SET ";
        $sql .= implode(", ", array_map(function ($v, $k) {
            return $k . "='" . $v . "'";
        }, $data, array_keys($data)));
        $sql .= " WHERE id_product = $id";
        try {
            if (mysqli_query($conn, $sql)) {
                echo json_encode(array('message' => 'Produk berhasil diupdate'));
            } else {
                throw new Exception('Gagal mengupdate produk');
            }
        } catch (Exception $e) {
            echo json_encode(array('message' => $e->getMessage()));
        }
        break;
    case 'DELETE':
        // ambil id dari method GET
        $id = isset($_GET['id']) ? $_GET['id'] : '';
        // jika referer dari halaman index maka ambil id dari body request
        if ($referer == 'DELETE') {
            $id = $_POST['id_product'];
        }
        $sql = "DELETE FROM products WHERE id_product = $id";
        if (mysqli_query($conn, $sql)) {
            echo json_encode(array('message' => 'Produk berhasil dihapus'));
        } else {
            echo json_encode(array('message' => 'Gagal menghapus produk'));
        }
        break;
    default:
        // method tidak diizinkan
        echo json_encode(array('message' => 'Method tidak diizinkan'));
        break;
}

// jika referer PUT atau DELETE maka header kembali
if (($referer == 'PUT' || $referer == 'DELETE') && isset($_POST['_method']) && $_POST['_method'] != '') {
    header('Location: ' . $_SERVER['HTTP_REFERER']);
}
