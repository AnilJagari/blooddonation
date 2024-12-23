<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home Page</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <!-- Include Navbar -->
    <?php include 'navbar.php'; ?>

    <!-- Main Content Section -->
    <main>
        <section class="bg-light py-3 py-md-5">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-12 col-sm-10 col-md-8 col-lg-6 col-xl-5 col-xxl-4">
                        <div class="card border border-light-subtle rounded-3 shadow-sm">
                            <div class="card-body p-3 p-md-4 p-xl-5">
                                <div class="text-center mb-3">
                                    <a href="#!">
                                        <img src="./assets/img/bsb-logo.svg" alt="Blood Donation Logo" width="175" height="57">
                                    </a>
                                </div>
                                <h2 class="fs-6 fw-normal text-center text-secondary mb-4">Select a Button</h2>
                                <form action="<?php $_PHP_SELF ?>" method="POST">
                                    <div class="text-center mb-3">
                                        <div class="col-10">
                                            <div class="d-grid my-3">
                                                <button class="btn btn-danger" type="submit" name="admin" value="admin">Admin</button>
                                            </div>
                                        </div>
                                        <div class="col-10">
                                            <div class="d-grid my-3">
                                                <button class="btn btn-danger" type="submit" name="hospital" value="hospital">Hospital</button>
                                            </div>
                                        </div>
                                        <div class="col-10">
                                            <div class="d-grid my-3">
                                                <button class="btn btn-danger" type="submit" name="donar" value="donar">Donor</button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <!-- Include Footer -->
    <?php include 'footer.php'; ?>
</body>
</html>