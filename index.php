<?php
include_once 'koneksi.php';
if (isset($_GET['method']))
    $method = $_GET['method'];
else
    $method = "GET";
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rest API</title>
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="json-viewer.css">
    <script src="jquery.min.js"></script>
    <script src="bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="json-viewer.js"></script>
</head>

<body style="height: 100vh">
    <div class="container-fluid">
        <div class="row">
            <div class="col-6 p-4">
                <div class="row text-center mb-4">
                    <div class="col-12">
                        <div class="btn-group" role="group" aria-label="Basic example">
                            <a href="POST" class="btn btn-<?php echo $method == "POST" ? "success" : "primary"; ?>">POST</a>
                            <a href="PUT" class="btn btn-<?php echo $method == "PUT" ? "success" : "primary"; ?>">PUT</a>
                            <a href="DELETE" class="btn btn-<?php echo $method == "DELETE" ? "success" : "primary"; ?>">DELETE</a>
                        </div>
                    </div>
                </div>
                <?php if ($method == "POST") : ?>
                    <form action="products.php" method="post">
                        <div class="form-group row">
                            <label for="product_name" class="col-sm-3 col-form-label">Product Name</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="product_name" name="product_name" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="price" class="col-sm-3 col-form-label">Price</label>
                            <div class="col-sm-9">
                                <input type="number" class="form-control" id="price" name="price" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="product_desc" class="col-sm-3 col-form-label">Product Description</label>
                            <div class="col-sm-9">
                                <textarea class="form-control" id="product_desc" name="product_desc" required></textarea>
                            </div>
                        </div>
                        <div class="form-group  row">
                            <label for="jml_produk" class="col-sm-3 col-form-label">Jumlah Produk</label>
                            <div class="col-sm-9">
                                <input type="number" class="form-control" id="jml_produk" name="jml_produk" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="jml_halaman" class="col-sm-3 col-form-label">Jumlah Halaman</label>
                            <div class="col-sm-9">
                                <input type="number" class="form-control" id="jml_halaman" name="jml_halaman" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="tgl_terbit" class="col-sm-3 col-form-label">Tanggal Terbit</label>
                            <div class="col-sm-9">
                                <input type="date" class="form-control" id="tgl_terbit" name="tgl_terbit" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="isbn" class="col-sm-3 col-form-label">ISBN</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="isbn" name="isbn" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="bahasa" class="col-sm-3 col-form-label">Bahasa</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="bahasa" name="bahasa" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="penerbit" class="col-sm-3 col-form-label">Penerbit</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="penerbit" name="penerbit" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="berat" class="col-sm-3 col-form-label">Berat</label>
                            <div class="col-sm-9">
                                <input type="number" class="form-control" id="berat" name="berat" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="lebar" class="col-sm-3 col-form-label">Lebar</label>
                            <div class="col-sm-9">
                                <input type="number" class="form-control" id="lebar" name="lebar" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="panjang" class="col-sm-3 col-form-label">Panjang</label>
                            <div class="col-sm-9">
                                <input type="number" class="form-control" id="panjang" name="panjang" required>
                            </div>
                        </div>
                        <div class="form-group row mt-4">
                            <div class="col-sm-12">
                                <input type="submit" class="btn btn-primary w-100" value="Tambahkan">
                            </div>
                        </div>
                    </form>
                <?php elseif ($method == "PUT") : ?>
                    <?php if (isset($_POST['id_product'])) :
                        $id_product = $_POST['id_product'];
                        $sql = "SELECT * FROM products WHERE id_product = $id_product";
                        $result = mysqli_query($conn, $sql);
                        $data = mysqli_fetch_all($result, MYSQLI_ASSOC);
                    ?>
                        <form action="products/<?php echo $id_product; ?>" method="post">
                            <input type="hidden" name="_method" value="PUT">
                            <div class="form-group row">
                                <label for="product_name" class="col-sm-3 col-form-label">Product Name</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" id="product_name" name="product_name" value="<?php echo $data[0]['product_name']; ?>" required>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="price" class="col-sm-3 col-form-label">Price</label>
                                <div class="col-sm-9">
                                    <input type="number" class="form-control" id="price" name="price" value="<?php echo $data[0]['price']; ?>" required>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="product_desc" class="col-sm-3 col-form-label">Product Description</label>
                                <div class="col-sm-9">
                                    <textarea class="form-control" id="product_desc" name="product_desc" required><?php echo $data[0]['product_desc']; ?></textarea>
                                </div>
                            </div>
                            <div class="form-group  row">
                                <label for="jml_produk" class="col-sm-3 col-form-label">Jumlah Produk</label>
                                <div class="col-sm-9">
                                    <input type="number" class="form-control" id="jml_produk" name="jml_produk" value="<?php echo $data[0]['jml_produk']; ?>" required>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="jml_halaman" class="col-sm-3 col-form-label">Jumlah Halaman</label>
                                <div class="col-sm-9">
                                    <input type="number" class="form-control" id="jml_halaman" name="jml_halaman" value="<?php echo $data[0]['jml_halaman']; ?>" required>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="tgl_terbit" class="col-sm-3 col-form-label">Tanggal Terbit</label>
                                <div class="col-sm-9">
                                    <input type="date" class="form-control" id="tgl_terbit" name="tgl_terbit" value="<?php echo $data[0]['tgl_terbit']; ?>" required>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="isbn" class="col-sm-3 col-form-label">ISBN</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" id="isbn" name="isbn" value="<?php echo $data[0]['isbn']; ?>" required>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="bahasa" class="col-sm-3 col-form-label">Bahasa</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" id="bahasa" name="bahasa" value="<?php echo $data[0]['bahasa']; ?>" required>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="penerbit" class="col-sm-3 col-form-label">Penerbit</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" id="penerbit" name="penerbit" value="<?php echo $data[0]['penerbit']; ?>" required>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="berat" class="col-sm-3 col-form-label">Berat</label>
                                <div class="col-sm-9">
                                    <input type="number" class="form-control" id="berat" name="berat" value="<?php echo $data[0]['berat']; ?>" required>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="lebar" class="col-sm-3 col-form-label">Lebar</label>
                                <div class="col-sm-9">
                                    <input type="number" class="form-control" id="lebar" name="lebar" value="<?php echo $data[0]['lebar']; ?>" required>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="panjang" class="col-sm-3 col-form-label">Panjang</label>
                                <div class="col-sm-9">
                                    <input type="number" class="form-control" id="panjang" name="panjang" value="<?php echo $data[0]['panjang']; ?>" required>
                                </div>
                            </div>
                            <div class="form-group row mt-4">
                                <div class="col-sm-12">
                                    <input type="submit" class="btn btn-primary w-100" value="Update">
                                </div>
                            </div>
                        </form>
                    <?php else : ?>
                        <form method="post">
                            <div class="form-group row">
                                <label for="id_product" class="col-sm-3 col-form-label">ID Product</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" id="id_product" name="id_product" required>
                                </div>
                            </div>
                            <div class="form-group row mt-4">
                                <div class="col-sm-12">
                                    <input type="submit" class="btn btn-warning w-100" value="Pilih">
                                </div>
                            </div>
                        </form>
                    <?php endif; ?>
                <?php elseif ($method == "DELETE") :
                ?>
                    <form action="products" method="post">
                        <input type="hidden" name="_method" value="DELETE">
                        <div class="form-group row">
                            <label for="id_product" class="col-sm-3 col-form-label">ID Product</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="id_product" name="id_product" required>
                            </div>
                        </div>
                        <div class="form-group row mt-4">
                            <div class="col-sm-12">
                                <input type="submit" class="btn btn-danger w-100" value="Hapus">
                            </div>
                        </div>
                    </form>
                <?php endif; ?>
            </div>
            <div class=" col-6" style="height: 100%; position: absolute; right: 0; overflow-y: scroll;">
                <div id="json-container"></div>
            </div>
        </div>
    </div>


    <script>
        var data = fetch('products.php')
            .then(response => response.json())
            .then(data => {
                $('#json-container').jsonview(data);
            });
    </script>
</body>

</html>