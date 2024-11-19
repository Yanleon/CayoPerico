<?php
include 'conexion.php'; // 
include_once "Admin/encabezado.php";


$sql = "SELECT nombre, descripcion, precio, imagen FROM productos";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Catálogo</title>
    <link rel="stylesheet" href="Estilos/Estilosindex/bootstrap.min.css">
    <link rel="stylesheet" href="Estilos/Estilosindex/4.css" type="text/css">
    <link rel="stylesheet" href="Estilos/cssProductos.css">
    <link rel="stylesheet" href="Estilos/estilos2.css">
    <link rel="stylesheet" href="Estilos/Estilosindex/2.css">
    <link rel="stylesheet" href="Estilos/Estilosindex/3.css">
    <link rel="preload" href="https://fonts.googleapis.com/css2?family=Golos+Text:wght@400;700&display=swap&display=swap" as="style" onload="this.onload=null;this.rel='stylesheet'">  <noscript>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Golos+Text:wght@400;700&display=swap&display=swap"></noscript>
	<link rel="icon" type="image/x-icon" href="../media/favi.webp">

</head>
<body>
<section data-bs-version="5.1" class="menu menu2 cid-uuwjTVxyDp" once="menu" id="menu-5-uuwjTVxyDp">
	

	<nav class="navbar navbar-dropdown navbar-fixed-top navbar-expand-lg">
		<div class="container">
			<div class="navbar-brand">
				<span class="navbar-logo">
					<a href="index.html">
						<img src="media/LOGO.jpg" alt="" style="height: 4.3rem;">
					</a>
				</span>
				<span class="navbar-caption-wrap"><a class="navbar-caption text-black display-4" href="#">Cayo Perico</a></span>
			</div>
			<button class="navbar-toggler" type="button" data-toggle="collapse" data-bs-toggle="collapse" data-target="#navbarSupportedContent" data-bs-target="#navbarSupportedContent" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
				<div class="hamburger">
					<span></span>
					<span></span>
					<span></span>
					<span></span>
				</div>
			</button>
			<div class="collapse navbar-collapse" id="navbarSupportedContent">
				<ul class="navbar-nav nav-dropdown" data-app-modern-menu="true">
					<li class="nav-item">
						<a class="nav-link link text-black display-4" href="index.html">Inicio</a>
					</li>
					<li class="nav-item">
						<a class="nav-link link text-black display-4" href="discord.html" aria-expanded="false">Contacto</a>
					</li>
				</ul>
				
				<div class="navbar-buttons mbr-section-btn">
					<a class="btn btn-primary display-4" href="Login.html">Inicia sesión</a>
				</div>
			</div>
		</div>
	</nav>
</section>
<br> 
<br> 
<br> 
<br> 
<br> 
    <div class="container">
        <h1>Catálogo Disponible</h1>
        <div class="product-grid">
            <?php
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo '<div class="product-card">
                            
                            <h3>' . htmlspecialchars($row['nombre']) . '</h3>
                            <p>' . htmlspecialchars($row['descripcion']) . '</p>
                            <p>Precio: $' . htmlspecialchars($row['precio']) . '</p>
                          </div>';
                }
            } else {
                echo '<p>No hay productos disponibles.</p>';
            }
            ?>
        </div>
    </div>
</body>
</html>

