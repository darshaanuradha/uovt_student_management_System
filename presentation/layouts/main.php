<?php require '../presentation/partials/header.php'; ?>
<body class="bg-emerald-50 font-sans flex h-screen overflow-hidden">
    <?php require '../presentation/partials/sidebar.php'; ?>
    <main class="flex-1 overflow-x-hidden overflow-y-auto bg-emerald-50/50 p-8">
        <?php require $content; ?>  
    </main>
</body>
<?php require '../presentation/partials/footer.php'; ?>