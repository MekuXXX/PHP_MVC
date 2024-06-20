<?php 
  use App\Core\Application;
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"
        integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
    input {
        border: 1px solid;
        border-radius: 0.25rem;
        padding: 0.75rem 0.5rem;
    }
    </style>
    <title>PHP MVC</title>
</head>

<body class="min-h-screen flex flex-col justify-between max-w-[90%] mx-auto lg:max-w-[70%]">
    <header class="flex justify-between items-center py-6">
        <h1 class="text-3xl font-extrabold">
            PHP MVC
        </h1>
        <div class="flex gap-4">
            <a href="/">Home</a>
            <a href="/contact">Contact</a>
        </div>
        <div class="flex gap-4">
            <a href="/register">Register</a>
            <a href="/login">Login</a>
        </div>
    </header>

    <div class="flex-1">
        <?php if (Application::$app->session->getFlash('success')): ?>
        <div class="text-red-600 text-sm bg-gray-200">
            <?php echo Application::$app->session->getFlash('success');?>
        </div>
        <?php endif ?>
        {{ content }}
    </div>

    <footer>
        <p class="text-center">Copyright</p>
    </footer>
</body>

</html>