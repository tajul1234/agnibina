<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Clickable Cards Layout</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .small-card {
            max-width: 300px;
            margin: 0 auto;
            background-color: #f0f0f0; /* Gray background for the cards */
            text-decoration: none; /* Remove underline from links */
            color: inherit; /* Inherit text color from the card */
            transition: background-color 0.3s ease, transform 0.3s ease; /* Smooth transition for hover effect */
        }

        .small-card:hover {
            background-color: #4CAF50; /* Green color on hover */
            transform: translateY(-5px); /* Slight lift effect on hover */
        }

        .card-img-top {
            height: 150px;
            object-fit: cover;
        }

        .card-body {
            text-align: center;
            padding: 10px;
        }

        .card-title {
            font-size: 1rem;
        }

        .card-text {
            font-size: 0.9rem;
        }

        .container {
            max-width: 900px;
        }

        /* Centering card at the top */
        .top-card {
            margin: 20px auto;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <!-- Top Centered Card -->
        <div class="top-card">
            <a href="allmember.php" class="card small-card">
                <img src="all.png" class="card-img-top" alt="Top Card Image">
                <div class="card-body">
                    <h6 class="card-title">ALL MEMBER</h6>
                    <p class="card-text">This card is centered at the top of the page.</p>
                </div>
            </a>
        </div>

        <div class="row row-cols-1 row-cols-md-3 g-3">
            <!-- Repeat this card block for each card -->
            <div class="col">
                <a href="https://example.com" class="card small-card h-100">
                    <img src="https://via.placeholder.com/150" class="card-img-top" alt="Image 1">
                    <div class="card-body">
                        <h6 class="card-title">Card Title 1</h6>
                        <p class="card-text">This is a brief description for card 1.</p>
                    </div>
                </a>
            </div>
            <div class="col">
                <a href="https://example.com" class="card small-card h-100">
                    <img src="https://via.placeholder.com/150" class="card-img-top" alt="Image 2">
                    <div class="card-body">
                        <h6 class="card-title">Card Title 2</h6>
                        <p class="card-text">This is a brief description for card 2.</p>
                    </div>
                </a>
            </div>
            <div class="col">
                <a href="kola.php" class="card small-card h-100">
                    <img src="kola.png" class="card-img-top" alt="Image 3">
                    <div class="card-body">
                        <h6 class="card-title">Kola</h6>
                        <p class="card-text">This is a brief description for card 3.</p>
                    </div>
                </a>
            </div>
            <div class="col">
                <a href="bba.php" class="card small-card h-100">
                    <img src="bba.png" class="card-img-top" alt="Image 4">
                    <div class="card-body">
                        <h6 class="card-title">BBA</h6>
                        <p class="card-text">This is a brief description for card 4.</p>
                    </div>
                </a>
            </div>
            <div class="col">
                <a href="https://example.com" class="card small-card h-100">
                    <img src="https://via.placeholder.com/150" class="card-img-top" alt="Image 5">
                    <div class="card-body">
                        <h6 class="card-title">Card Title 5</h6>
                        <p class="card-text">This is a brief description for card 5.</p>
                    </div>
                </a>
            </div>
            <div class="col">
                <a href="https://example.com" class="card small-card h-100">
                    <img src="https://via.placeholder.com/150" class="card-img-top" alt="Image 6">
                    <div class="card-body">
                        <h6 class="card-title">Card Title 6</h6>
                        <p class="card-text">This is a brief description for card 6.</p>
                    </div>
                </a>
            </div>
            <div class="col">
                <a href="https://example.com" class="card small-card h-100">
                    <img src="https://via.placeholder.com/150" class="card-img-top" alt="Image 7">
                    <div class="card-body">
                        <h6 class="card-title">Card Title 7</h6>
                        <p class="card-text">This is a brief description for card 7.</p>
                    </div>
                </a>
            </div>
            <div class="col">
                <a href="https://example.com" class="card small-card h-100">
                    <img src="https://via.placeholder.com/150" class="card-img-top" alt="Image 8">
                    <div class="card-body">
                        <h6 class="card-title">Card Title 8</h6>
                        <p class="card-text">This is a brief description for card 8.</p>
                    </div>
                </a>
            </div>
            <div class="col">
                <a href="science/scienceall.php" class="card small-card h-100">
                    <img src="#" class="card-img-top" alt="Image 4">
                    <div class="card-body">
                        <h6 class="card-title">Science</h6>
                        <p class="card-text">This is a brief description for card 4.</p>
                    </div>
                </a>
            </div>
            <div class="col">
                <a href="arts/arts.php" class="card small-card h-100">
                    <img src="https://via.placeholder.com/150" class="card-img-top" alt="Image 5">
                    <div class="card-body">
                        <h6 class="card-title">Arts</h6>
                        <p class="card-text">This is a brief description for card 5.</p>
                    </div>
                </a>
            </div>
            <div class="col">
                <a href="law/law.php" class="card small-card h-100">
                    <img src="https://via.placeholder.com/150" class="card-img-top" alt="Image 6">
                    <div class="card-body">
                        <h6 class="card-title">Law</h6>
                        <p class="card-text">This is a brief description for card 6.</p>
                    </div>
                </a>
            </div>
            <div class="col">
                <a href="sudii/sudi.php" class="card small-card h-100">
                    <img src="https://via.placeholder.com/150" class="card-img-top" alt="Image 9">
                    <div class="card-body">
                        <h4 class="card-title">ALL interest</h4>
                        <p class="card-text">This is a card of All interest</p>
                    </div>
                </a>
            </div>

            
            
        </div>

        <!-- Bottom Centered Card -->
        <div class="top-card mt-3">
            <a href="former.php" class="card small-card">
                <img src="savak.png" class="card-img-top" alt="Bottom Card Image">
                <div class="card-body">
                    <h3 class="card-title">The Former</h3>
                    
                </div>
            </a>
        </div>
        
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
