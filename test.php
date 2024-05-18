<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['username'])) {
    // Redirect to the login page if not logged in
    header("Location: login.html");
    exit();
}

if (isset($_GET['signup_success']) && $_GET['signup_success'] === 'true') {
    // Set a flag to show the SweetAlert
    $showSweetAlert = true;
} else {
    // Set the flag to false if not showing SweetAlert
    $showSweetAlert = false;
}

// Database connection details
$servername = "localhost";
$username = "root"; // default username for XAMPP
$password = "";     // default password for XAMPP
$dbname = "Movie"; // Change this to your database name

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    // Set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}

// Fetch all movie details from the database
$sql = "SELECT * FROM movies";
$stmt = $conn->prepare($sql);
$stmt->execute();
$movies = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Close the connection
$conn = null;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Movies List</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Lemon&family=Libre+Baskerville:wght@400;700&family=Montserrat:wght@200;300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css">
    <link rel="stylesheet" href="../css/swiper-bundle.min.css">
    <link rel="stylesheet" href="../css/style.css">
    <!-- Include SweetAlert2 CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@10/dist/sweetalert2.min.css">
    <style>
        body {
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            margin: 0;
        }

        .container {
            flex: 1;
            display: flex;
            flex-direction: column;
        }

        .movies-list {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            margin-bottom: 20px;
        }

        .movie-card {
            position: relative;
            width: 200px;
            height: 300px;
            background-color: #101116;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease;
            display: flex;
            flex-direction: column;
            margin: 10px;
        }

        .movie-image {
            width: 100%;
            height: 50%;
            object-fit: cover;
        }

        .movie-card-content {
            padding: 10px;
            background-color: rgba(0, 0, 0, 0.6);
            color: #fff;
            flex-grow: 1;
        }

        .movie-card-title {
            font-size: 1rem;
            font-weight: bold;
            color: #fff;
        }

        .movie-card-description {
            font-size: 0.8rem;
        }

        footer {
            background-color: #1e1e1e;
            color: white;
            padding: 20px 0;
            text-align: center;
        }

        .footer-social i {
            margin: 0 10px;
        }
    </style>
</head>
<body>
    <div class="container">
        <header class="header">
            <div class="logo">
                <h1>movie</h1>
            </div>
            <nav class="navBar">
                <div class="open-btn" id="open">
                    <i class="fa-solid fa-bars"></i>
                </div>
                <div class="nav-items">
                    <ul class="list">
                        <li><a href="index.php">Home</a></li>
                        <li><a href="#">Movies</a></li>
                        <li><a href="#">TV Series</a></li>
                        <li><a href="#">Animated Movies</a></li>
                        <li><a href="#">My List</a></li>
                        <div class="close-btn" id="close">
                            <i class="fa-solid fa-xmark"></i>
                        </div>
                    </ul>
                    <ul class="user">
                        <div class="search" id="search">
                            <ul>
                                <li><input type="text"></li>
                            </ul>
                        </div>
                        <li id="search-icon"><i class="fa-solid fa-magnifying-glass"></i></li>
                        <li><i class="fa-solid fa-bell"></i></li>
                        <li id="user-icon"><i class="fa-solid fa-user"></i></li>
                        <div class="menu" id="menu">
                            <ul>
                                <li><a href="../php/Logout.php">Logout</a></li>
                                <li><a href="settings.php">Settings</a></li>
                            </ul>
                        </div>
                    </ul>
                </div>
            </nav>
        </header>

        <!-- SweetAlert Popup Trigger -->
        <?php if ($showSweetAlert): ?>
        <div id="signup-success-alert" class="hidden">
            <script>
                document.addEventListener("DOMContentLoaded", function() {
                    Swal.fire({
                        icon: "success",
                        title: "Signup successful!",
                        showConfirmButton: false,
                        timer: 2000
                    });
                });
            </script>
        </div>
        <?php endif; ?>

        <div class="movies-list">
            <?php
            if ($movies) {
                foreach ($movies as $movie) {
                    $pic_path = $movie["pic"];
                    echo '<div class="movie-card">';
                    echo '<iframe src="' . $pic_path . '" frameborder="0" class="movie-image"></iframe>';
                    echo '<div class="movie-card-content">';
                    echo '<h2 class="movie-card-title">' . $movie["Name"] . '</h2>';
                    echo '<p class="movie-card-description">' . $movie["Desc"] . '</p>';
                    echo '</div></div>';
                }
            } else {
                echo "No movies found";
            }
            ?>
        </div>
    </div>

    <footer class="footer">
        <div>
            <h4>Movies</h4>
            <h4>TV Series</h4>
            <h4>Animated Movies</h4>
        </div>
        <div>
            <h4>Privacy Policy</h4>
            <h4>Cookie Policy</h4>
            <h4>Terms of Use</h4>
        </div>
        <div>
            <h4>Help Center</h4>
            <h4>Support</h4>
            <h4>FAQ</h4>
        </div>
        <div>
            <h4>Follow Us</h4>
            <div class="footer-social">
                <i class="fa-brands fa-instagram"></i>
                <i class="fa-brands fa-facebook-f"></i>
                <i class="fa-brands fa-twitter"></i>
            </div>
        </div>
    </footer>

    <!-- Include jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.3.slim.min.js" integrity="sha256-ZwqZIVdD3iXNyGHbSYdsmWP//UBokj2FHAxKuSBKDSo=" crossorigin="anonymous"></script>
    <!-- Include SweetAlert2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <!-- Include OwlCarousel JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>
    <!-- Include Swiper JS -->
    <script src="../js/swiper-bundle.min.js"></script>
    <!-- Include your custom JS -->
    <script src="../js/main.js"></script>

    <!-- Show SweetAlert Popup -->
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            var signupSuccessAlert = document.getElementById("signup-success-alert");
            if (signupSuccessAlert) {
                signupSuccessAlert.classList.remove("hidden");
            }
        });
    </script>
</body>
</html>
