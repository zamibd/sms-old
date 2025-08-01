<?php
if (file_exists(__DIR__ . "/config.php")) {
    if (file_exists(__DIR__ . "/upgrade.php")) {
        header("location:upgrade.php");
        exit();
    }

    require_once __DIR__ . "/includes/session.php";
    date_default_timezone_set(TIMEZONE);

    if (file_exists(__DIR__ . "/install/index.php")) {
        if (!rmdir_recursive("install")) {
            $error = "Could not remove install directory.";
        }
    }

    if (isset($_SESSION["userID"])) {
        header("location:dashboard.php");
        exit();
    }
} else {
    header("location:install/index.php");
    exit();
}

$title = "Sign In";
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=5" />
    <meta name="theme-color" content="#111827" />
    <link rel="manifest" href="/manifest.json">
    <title><?= $title ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/toastr@2.1.4/build/toastr.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/toastr@2.1.4/build/toastr.min.css" rel="stylesheet" />
    <style>
        body {
            background-color: #f8fafc;
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            font-family: sans-serif;
        }
        @media (prefers-color-scheme: dark) {
            body {
                background-color: #111827;
                color: #e5e7eb;
            }
            .form-control {
                background-color: #1f2937;
                color: #e5e7eb;
                border-color: #374151;
            }
        }
    </style>
</head>
<body>
<div class="w-full max-w-sm p-4 border rounded shadow-sm bg-white dark:bg-gray-900 dark:text-white">
    <?php if (isset($error)) { ?>
        <div class="alert alert-danger"><?= $error ?></div>
    <?php } ?>
    <form id="loginForm" method="post">
        <h2 class="text-center mb-4"><?= $title ?></h2>
        <div class="mb-3">
            <input type="email" name="email" class="form-control" placeholder="Email" required />
        </div>
        <div class="mb-3">
            <input type="password" name="password" class="form-control" placeholder="Password" required />
        </div>
        <div class="d-flex justify-content-between mb-3">
            <a href="reset-password.php" class="small">Forgot password?</a>
        </div>
        <button type="submit" id="signInButton" class="btn btn-primary w-100">Sign In</button>
    </form>
</div>

<script>
    $(function () {
        const loginForm = $('#loginForm');
        const signInButton = $('#signInButton');
        loginForm.submit(function (event) {
            event.preventDefault();
            signInButton.prop('disabled', true);
            toastr.options = { positionClass: "toast-top-center" };
            $.post("ajax/login-form.php", loginForm.serialize())
                .done(function () {
                    window.location.href = "dashboard.php";
                })
                .fail(function (xhr) {
                    toastr.error(xhr.responseText || "Login failed");
                    loginForm[0].reset();
                })
                .always(function () {
                    signInButton.prop('disabled', false);
                });
        });
    });
</script>
</body>
</html>
