<?php 
	include("bd/bd.php");
	session_start();
	if(!isset($_SESSION['usuario'])){
		header("Location:./index.php");
	}else if($_SESSION['tipo'] == 1){
		header("Location:./admin/index.php");
	}
	//seleccionar registros de productos
	$sentencia=$conexion->prepare("SELECT * FROM tbl_productos;");
	$sentencia->execute();
	$lista_productos=$sentencia->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8" />
		<meta http-equiv="X-UA-Compatible" content="IE=edge" />
		<meta
			name="viewport"
			content="width=device-width, initial-scale=1.0"
		/>
		<title>Tienda</title>
		<link rel="stylesheet" href="styles.css" />
	</head>
	<body>
		<header>
			<h1>Tienda</h1>
			<nav>
				<ul>
					<li><a href="#">Inicio</a></li>
					<li><a href="webdav.php">Mis pedidos</a></li>					
					<li><a href="acerca.php">Acerca de</a></li>
					<li><a href="cerrar.php">Cerrar sesion</a></li>
				</ul>
        	</nav>
			<div class="container-icon">
				<div class="container-cart-icon">
					<svg
						xmlns="http://www.w3.org/2000/svg"
						fill="none"
						viewBox="0 0 24 24"
						stroke-width="1.5"
						stroke="currentColor"
						class="icon-cart" > <!--Clase de la imagen -->
						<path
							stroke-linecap="round"
							stroke-linejoin="round"
							d="M15.75 10.5V6a3.75 3.75 0 10-7.5 0v4.5m11.356-1.993l1.263 12c.07.665-.45 1.243-1.119 1.243H4.25a1.125 1.125 0 01-1.12-1.243l1.264-12A1.125 1.125 0 015.513 7.5h12.974c.576 0 1.059.435 1.119 1.007zM8.625 10.5a.375.375 0 11-.75 0 .375.375 0 01.75 0zm7.5 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z"
						/>
					</svg>
					<div class="count-products">
						<span id="contador-productos">0</span>
					</div>
				</div>
				<div class="container-cart-products hidden-cart">
					<div class="row-product hidden">
						<div class="cart-product">
							<svg
								xmlns="http://www.w3.org/2000/svg"
								fill="none"
								viewBox="0 0 24 24"
								stroke-width="1.5"
								stroke="currentColor"
								class="icon-close"><!--Clase de la imagen -->
								<path
									stroke-linecap="round"
									stroke-linejoin="round"
									d="M6 18L18 6M6 6l12 12"
								/>
							</svg>
						</div>
					</div>

					<div class="cart-total hidden">
						<h3>Total:</h3>
						<span class="total-pagar">$</span>
					</div>
					<p class="cart-empty">El carrito está vacío</p>
					<!-- Botón de pago -->
    				<a class="btn-pagar">Hacer el pedido</a>
				</div>
			</div>
		</header>
		<div class="container-items">
			<?php foreach ($lista_productos as $registro) { ?>
				<div class="item">
					<figure>
						<img src="<?php echo $registro["imagen"] ?>" alt="producto" />
					</figure>
					<div class="info-product">
						<h2><?php echo $registro["nombre"] ?></h2>
						<p class="price">$<?php echo $registro["precio"] ?></p>
						<button class="btn-add-cart">Añadir al carrito</button>
					</div>
				</div>
			<?php } ?>
		</div>
		<script src="index.js"></script>
	</body>
</html>
