<?php

    require_once("services/dbcon.php");
    $consulta = "show tables";
    $dbc = conectar();
    if ($dbc === null) {
        die("No se pudo establecer la conexión con la base de datos.");
    }
    
    $query = $dbc->prepare("SELECT * FROM productos");

    try{
    $res=$query->execute();
    }
    catch(PDOException $e){
        
    }
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="./assets/img/logo_inicio.png" type="image/x-icon">
    <link rel="stylesheet" href="../assets/plugins/fontawesome/js/all.min.js">
    <link rel="stylesheet" href="../assets/css/style-cart.css">
    <title>Tienda - Dogtores</title>
</head>
<body>
    <header class="header">
        <div class="header-content container">
            <nav class="navigation">
                <a href="./IndexVeterinaria.html">
                    <p class="logotipo">Nuestros<span>Productos - ᶦⁿᶦᶜᶦᵒ</span></p>
                </a>
                
                <div class="btn-cart">
                    <button type="button"><i class="fa-solid fa-cart-shopping icon-cart"></i></button>  
                    <span id="cartCount"></span>

                    <div class="cart">
                        <div class="cart-responsive">
                            <table>
                                <thead>
                                    <tr>
                                        <th>Imagen</th>
                                        <th>Descripcion</th>
                                        <th>Precio</th>
                                        <th>Cantidad</th>
                                        <th>Accion</th>
                                    </tr>
                                </thead>
                                <tbody id="contentProducts">
                                    
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan="5" class="total">
                                            <h4 class="heading-total">Total: <span id="total"></span></h4>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="5">
                                            <button type="button" id="emptyCart">Vaciar Carrito</button>
                                        </td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>

                </div> 

                

            </nav>
        </div>

        <form class="form-header">
        </form>
    </header>

    <section class="banner">
        <div class="banner-grid container">
            <div class="banner-item">
                <i class="fa-regular fa-lightbulb icon-banner"></i>
                <h3>Buenas ideas, buenos productos!</h3>
            </div>
            <div class="banner-item">
                <i class="fa-solid fa-bullseye icon-banner"></i>
                <h3>Todos nuestros productos aqui!</h3>
            </div>
            <div class="banner-item">
                <i class="fa-regular fa-clock icon-banner"></i>
                <h3>Piensa inteligente, todo lo que necesites esta aqui!</h3>
            </div>
        </div>
    </section>

    <main>
        <section class="products" id="listProducts">
            <h2>Productos</h2>
            <div class="products-grid container">
                <div class="product">
                    <img src="../assets/img/products/croq_perro.png" alt="image product">
                    <div class="product-info">
                        <h4>Croquetas Premium Para Perro</h4>
                        <p class="product-text">Alimento con nutrientes suficientes para tener una mascota fuerte y sana.</p>
                        
                        <i class="fa-solid fa-star icon-star"></i>
                        <i class="fa-solid fa-star icon-star"></i>
                        <i class="fa-solid fa-star icon-star"></i>
                        <i class="fa-solid fa-star icon-star"></i>
                        <i class="fa-solid fa-star icon-star"></i>

                        <div class="price">
                            <span>$300.00 MXN</span>
                            <p id="currentPrice">$250.00 MXN</p>
                        </div>
                        <button class="btn-add" type="button" data-id="1" data-nombre="Croquetas Premium Para Perro" data-precio="250" data-img="../assets/img/products/croq_perro.png">Agregar al Carrito</button>
                    </div>
                </div>
                <div class="product">
                    <img src="../assets/img/products/croq_gato.png" alt="image product">
                    <div class="product-info">
                        <h4>Croquetas Premium Para Gato</h4>
                        <p class="product-text">Alimento con nutrientes suficientes para tener una mascota fuerte y sana.</p>
                
                        <i class="fa-solid fa-star icon-star"></i>
                        <i class="fa-solid fa-star icon-star"></i>
                        <i class="fa-solid fa-star icon-star"></i>
                        <i class="fa-solid fa-star icon-star"></i>
                        <i class="fa-solid fa-star icon-star"></i>
                
                        <div class="price">
                            <span>$300.00 MXN</span>
                            <p id="currentPrice">$250.00 MXN</p>
                        </div>
                        <button class="btn-add" type="button" data-id="2" data-nombre="Croquetas Premium Para Gato" data-precio="250" data-img="../assets/img/products/croq_gato.png">Agregar al Carrito</button>
                    </div>
                </div>
                <div class="product">
                    <img src="../assets/img/products/shampoo_prod.png" alt="image product">
                    <div class="product-info">
                        <h4>Shampoo Premium Para Mascotas</h4>
                        <p class="product-text">Shampoo loquido para Mascotas.</p>
                
                        <i class="fa-solid fa-star icon-star"></i>
                        <i class="fa-solid fa-star icon-star"></i>
                        <i class="fa-solid fa-star icon-star"></i>
                        <i class="fa-solid fa-star icon-star"></i>
                        <i class="fa-solid fa-star icon-star"></i>
                
                        <div class="price">
                            <span>$150.00 MXN</span>
                            <p id="currentPrice">$110.00 MXN</p>
                        </div>
                        <button class="btn-add" type="button" data-id="3" data-nombre="Shampoo Para Mascotas" data-precio="110" data-img="../assets/img/products/shampoo_prod.png"> Agregar al Carrito</button>
                    </div>
                </div>
                <div class="product">
                    <img src="../assets/img/products/cepillo.png" alt="image product">
                    <div class="product-info">
                        <h4>Cepillo Premium Para Mascotas</h4>
                        <p class="product-text">Cepillo para limpiar y bañar a tus Mascotas.</p>
                
                        <i class="fa-solid fa-star icon-star"></i>
                        <i class="fa-solid fa-star icon-star"></i>
                        <i class="fa-solid fa-star icon-star"></i>
                        <i class="fa-solid fa-star icon-star"></i>
                        <i class="fa-solid fa-star icon-star"></i>
                
                        <div class="price">
                            <span>$120.00 MXN</span>
                            <p id="currentPrice">$90.00 MXN</p>
                        </div>
                        <button class="btn-add" type="button" data-id="4" data-nombre="Cepillo Para Mascotas" data-precio="90" data-img="../assets/img/products/cepillo.png">Agregar al Carrito</button>
                    </div>
                </div>
                <div class="product">
                    <img src="../assets/img/products/repelente.png" alt="image product">
                    <div class="product-info">
                        <h4>Repelente Premium Para Mascotas</h4>
                        <p class="product-text">Repelente para mascotas, evita esos insectos.</p>
                
                        <i class="fa-solid fa-star icon-star"></i>
                        <i class="fa-solid fa-star icon-star"></i>
                        <i class="fa-solid fa-star icon-star"></i>
                        <i class="fa-solid fa-star icon-star"></i>
                        <i class="fa-solid fa-star icon-star"></i>
                
                        <div class="price">
                            <span>$160.00 MXN</span>
                            <p id="currentPrice">$140.00 MXN</p>
                        </div>
                        <button class="btn-add" type="button" data-id="5" data-nombre="Repelente Para Mascotas" data-precio="140" data-img="../assets/img/products/repelente.png">Agregar al Carrito</button>
                    </div>
                </div>
                <div class="product">
                    <img src="../assets/img/products/arromatizante.png" alt="image product">
                    <div class="product-info">
                        <h4>Perfume Premium Para Mascotas</h4>
                        <p class="product-text">Para que tus mascotas tengan un aroma dulce.</p>
                
                        <i class="fa-solid fa-star icon-star"></i>
                        <i class="fa-solid fa-star icon-star"></i>
                        <i class="fa-solid fa-star icon-star"></i>
                        <i class="fa-solid fa-star icon-star"></i>
                        <i class="fa-solid fa-star icon-star"></i>
                
                        <div class="price">
                            <span>$90.00 MXN</span>
                            <p id="currentPrice">$60.00 MXN</p>
                        </div>
                        <button class="btn-add" type="button" data-id="6" data-nombre="Perfume Para Mascotas" data-precio="60" data-img="../assets/img/products/arromatizante.png">Agregar al Carrito</button>
                    </div>
                </div>
                <div class="product">
                    <img src="../assets/img/products/casa_mascotas.png" alt="image product">
                    <div class="product-info">
                        <h4>Casa de madera para Perros Chica</h4>
                        <p class="product-text">Una linda casa para que tus Perros pasen el tiempo como familia.</p>
                
                        <i class="fa-solid fa-star icon-star"></i>
                        <i class="fa-solid fa-star icon-star"></i>
                        <i class="fa-solid fa-star icon-star"></i>
                        <i class="fa-solid fa-star icon-star"></i>
                        <i class="fa-solid fa-star icon-star"></i>
                
                        <div class="price">
                            <span>$1500.00 MXN</span>
                            <p id="currentPrice">$999.00 MXN</p>
                        </div>
                        <button class="btn-add" type="button" data-id="7" data-nombre="Casa para Perros" data-precio="999" data-img="./assets/img/products/casa_mascotas.png">Agregar al Carrito</button>
                    </div>
                </div>
                <div class="product">
                    <img src="../assets/img/products/casa_gatos.png" alt="image product">
                    <div class="product-info">
                        <h4>Casa de madera para Gatos Mediana</h4>
                        <p class="product-text">Linda casa para que tus Gatos pasen el tiempo.</p>
                
                        <i class="fa-solid fa-star icon-star"></i>
                        <i class="fa-solid fa-star icon-star"></i>
                        <i class="fa-solid fa-star icon-star"></i>
                        <i class="fa-solid fa-star icon-star"></i>
                        <i class="fa-solid fa-star icon-star"></i>
                
                        <div class="price">
                            <span>$1600.00 MXN</span>
                            <p id="currentPrice">$1199.00 MXN</p>
                        </div>
                        <button class="btn-add" type="button" data-id="8" data-nombre="Casa para Gatos" data-precio="1199" data-img="../assets/img/products/casa_gatos.png">Agregar al Carrito</button>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <footer class="footer">
        <div class="container">
            <p>&copy;2025 Dogtores. Derechos reservados a el equipo</p>
        </div>
    </footer>

    <script src="../assets/plugins/fontawesome/js/all.min.js"></script>
    <script src="../assets/js/app.js"></script>
</body>
</html>