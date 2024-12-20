<?php 
    session_start();
    include "routes/router.php"; 

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
    <link rel="stylesheet" href="public/assets/styles/global.css">
    <link rel="stylesheet" href="public/assets/styles/sidebar.css">
    <link rel="stylesheet" href="vendor/twbs/bootstrap/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="vendor/twbs/bootstrap-icons/font/bootstrap-icons.css">
</head>
<style>
    * {
        padding: 0;
        margin: 0;
        overflow: hidden;
    }
</style>
<body>
    <div class="container-fluid admin-container p-0">
        <aside style="width: 20%;" >
                <?php require_once 'app/view/components/sidebar.php' ?>
        </aside>
        <main class="mainContainer" style="width: 80%; background-color: #F3F5F9;"> 
            <header class="admin-header">
                <?php require_once 'app/view/components/adminHeader.php' ?>
            </header>
            <section>
                <?php require_once $page; ?>
            </section>
        </main>
    </div>
</body>
    <script src="public/assets/js/event.js"></script>
    <script src="vendor/twbs/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
</html>
