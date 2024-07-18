<!DOCTYPE html>
<html lang="es">
<head>
    <?php require_once('./html/head.php'); ?>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- Puedes mantener los estilos y scripts necesarios para el menú y otras funcionalidades -->
    <style>
        /* Estilos adicionales que puedas necesitar */
    </style>
</head>
<body>
    <div class="container-xxl position-relative bg-white d-flex p-0">
        <!-- Spinner Start -->
        <div id="spinner" class="show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
            <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status">
                <span class="sr-only">Cargando...</span>
            </div>
        </div>
        <!-- Spinner End -->

        <!-- Sidebar Start -->
        <?php require_once('./html/menu.php'); ?>
        <!-- Sidebar End -->

        <!-- Content Start -->
        <div class="content">
            <!-- Navbar Start -->
            <?php require_once('./html/header.php'); ?>
            <!-- Navbar End -->

            <!-- Aquí puedes incluir otros contenidos que necesites mostrar -->

            <!-- JavaScript Libraries -->
            <?php require_once('./html/scripts.php'); ?>
            <!-- También puedes incluir tus propios scripts personalizados -->
            <script src="./dashboard.js"></script>
            <script>
                // Aquí puedes incluir tus funciones JavaScript necesarias
                $(document).ready(function() {
                    // Ejemplo de función JavaScript
                    console.log('Documento cargado.');
                });
            </script>
        </div>
        <!-- Fin Content End -->
    </div>
</body>
</html>
