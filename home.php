<?php
if (isset($_POST["donar"])) {
    $res = $_POST["donar"];
    if ($res == true) {
        header("location:DonarFolder/home.php");
        exit();
    } else {
        echo "error";
    }
}
if (isset($_POST["hospital"])) {
    $res = $_POST["hospital"];
    if ($res == true) {
        header("location:HospitalFolder/home.php");
        exit();
    } else {
        echo "error";
    }
}

if (isset($_POST["admin"])) {
    $res = $_POST["admin"];
    if ($res == true) {
        header("location:AdminFolder/home.php");
        exit();
    } else {
        echo "error";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home Page</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="bootstrap.css">

    <style>
        body {
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        main {
            flex: 1;
        }

        footer {
            background-color: #343a40;
            color: white;
            text-align: center;
            padding: 1rem;
        }

        .role-selection .btn {
            padding: 0.75rem 2rem; /* Reduces vertical padding slightly */
            width: 70%; /* Keeps the button narrower */
            margin: 0 auto 1.25rem; /* Centers the button and adjusts spacing below */
            font-size: 1.1rem; /* Slightly reduces text size for better fit */
            border-radius: 8px; /* Optional: adds rounded corners for aesthetics */
        }
    </style>
</head>
<body>
<?php include 'navbar.php'; ?>

<main>
    <section class="bg-light py-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-12 col-sm-10 col-md-8 col-lg-6 col-xl-5">
                    <div class="card border-light shadow-sm rounded-4">
                        <div class="card-body p-4">
                            <!-- Logo -->
                            <div class="text-center mb-4">
                                <a href="#!">
                                    <img src="./assets/img/bsb-logo.svg" alt="Blood Donation Logo" width="175" height="57">
                                </a>
                            </div>

                            <!-- Title -->
                            <h2 class="fs-5 fw-normal text-center text-secondary mb-4">Select your role</h2>

                            <!-- Form -->
                            <form action="<?php $_PHP_SELF ?>" method="POST">
                                <div class="d-grid gap-3 role-selection">
                                    <!-- Admin Button -->
                                    <button class="btn btn-danger" type="submit" name="admin" value="admin">Admin</button>

                                    <!-- Hospital Button -->
                                    <button class="btn btn-danger" type="submit" name="hospital" value="hospital">Hospital</button>

                                    <!-- Donor Button -->
                                    <button class="btn btn-danger" type="submit" name="donar" value="donar">Donar</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>

<?php include 'footer.php'; ?>
</body>
</html>
