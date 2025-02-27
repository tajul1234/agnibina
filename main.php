<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AGNIBINA</title>
    
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
        
        .tt {
            background-color: #006482;
            padding: 1.5px;
        }
        .ww:hover {
            text-decoration: underline;
            background-color: #4A4A4A;
        }

.logo-container {
    display: flex;
    justify-content: center;
    align-items: center;
    margin: 0 auto;
    position: relative;
    margin-left: 10px;
    overflow: hidden;
    width: 120px; 
    height: 120px;
    border-radius: 50%; 
    box-shadow: 0 0 30px rgba(255, 215, 0, 0.8), 
                0 0 60px rgba(255, 215, 0, 0.6), 
                0 0 90px rgba(255, 215, 0, 0.4); 
}


.logo {
    width: 100%;
    height: 100%;
    object-fit: cover; 
    border-radius: 50%;
    position: relative;
}


.logo-container::after {
    content: '';
    position: absolute;
    bottom: -10px; 
    left: 50%;
    transform: translateX(-50%);
    width: 60%;
    height: 10px;
    background: rgba(255, 215, 0, 0.8);
    border-radius: 50%; 
    box-shadow: 0 0 20px rgba(255, 215, 0, 0.6);
}


@media screen and (max-width: 768px) {
    .logo-container {
        width: 120px; 
        height: 120px;
        border-radius: 0%; 
        box-shadow: none; 
        margin: 0; 
    }

    .logo {
        width: 100%; 
        height: 100%; 
        object-fit: contain; 
    }

    
    .logo-container::after {
        bottom: -5px; 
        width: 50%;
        height: 5px;
        background: rgba(255, 215, 0, 0.8);
        box-shadow: 0 0 10px rgba(255, 215, 0, 0.6);
    }
}



        
        .ful {
            background-color: #F9F4F4;
        }
        .foot {
            background-color: #4A4A4A;
            color: aliceblue;
        }
        .cc {
    font-family: 'Cinzel', serif; 
    font-size: 200px;
    font-weight: bold;
    text-align: center;
    text-transform: uppercase;
    background: linear-gradient(90deg,#FFFFFF,#FF0000,#DE3163,#702963, #ff3cac, #784ba0, #2b86c5, #43cea2, #ff7e5f, #feb47b, #ff3cac);
    background-size: 800% 800%; 
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    animation: colorFlow 5s infinite linear;
    letter-spacing: 8px;
    margin: 20px;
    position: relative;
    right: -30px
}

@keyframes colorFlow {
    0% {
        background-position: 0% 50%;
    }
    50% {
        background-position: 100% 50%;
    }
    100% {
        background-position: 0% 50%;
    }
}


@media (max-width: 600px) {
    .cc {
        font-size: 120px; 
        letter-spacing: 3px;
        right: 0; 
    }
}



        @media all and (min-width: 1200px) {
            .navbar .nav-item .dropdown-menu {
                display: none;
            }
            .navbar .nav-item:hover .dropdown-menu {
                display: block;
            }
            .navbar .nav-item .dropdown-menu {
                margin-top: 0;
            }
        }
        .group {
            position: relative;
            height: 30px;
            overflow: hidden;
            color: #fff;
            background-color: #2F3851;
            border-top: 1px solid darkturquoise;
        }
        .group .text {
            position: absolute;
            margin: 5px 0;
            padding: 2;
            width: max-content;
            animation: my-animation 10s linear infinite;
        }
        .s:hover {
            color: green;
        }

        /* New styles for active link */
        .nav-link.active {
            text-decoration: underline;
        }

        /* Mobile friendly styles */
        @media (max-width: 576px) {
            .navbar-brand {
                display: flex;
                justify-content: center;
                align-items: center;
                flex-direction: column;
                text-align: center;
                width: 100%;
            }
            .navbar-brand img {
                width: 50px;
                margin-bottom: 5px;
            }
            .navbar-brand h1, .navbar-brand h5 {
                font-size: 1.2rem;
                margin: 0;
                color: #fff;
                text-align: center;
            }
            .navbar .nav-item {
                text-align: center;
            }
        }

        /* Laptop styles */
        @media (min-width: 577px) {
            .navbar-brand {
                display: flex;
                align-items: center;
            }
            .navbar-brand h1, .navbar-brand h5 {
                font-size: 1rem;
                margin: 0;
                color: #fff;
                text-align: left;
            }
        }

        
    </style>
</head>
<body>
    <header>
        <nav class="navbar navbar-expand-sm tt">
            <a href="#" class="navbar-brand">
            <div class="logo-container">
    <img src="/saad/logo1.png" alt="Logo" class="logo">
</div>
                <div class="d-none d-sm-block">
                <h1 class="fs-0 text-danger cc" style="font-size: 22px;">AGNIBINA ADMISSION COACHING</h1>

                   
                </div>
                <div class="d-sm-none text-center">
                <h1 class="fs-0 text-danger cc" style="color: black;">AGNIBINA ADMISSION COACHING</h1>
                   
                </div>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"> <a class="nav-link text-white fs-5 ww" href="/saad/index.php"><i class="fa-solid fa-house-chimney p-2"></i><strong>Home</strong></a></li>
                    <li class="nav-item"><a class="nav-link text-white fs-5 ww" href="#"><i class="fa-solid fa-address-card p-2"></i>About</a></li>
                    <li class="nav-item"> <a class="nav-link text-white fs-5 ww" href="/saad/Exam/login_system/login.php"><i class="fa-brands fa-teamspeak p-2"></i>Online Exam</a></li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle text-white fs-5 ww" href="#" data-bs-toggle="dropdown"><i class="fa-solid fa-right-to-bracket p-2"></i> Login</a>
                        <ul class="dropdown-menu bg-success">
                            <li><a class="dropdown-item text-white ww m-2" href="/saad/admin/protect.php"><b>1.Admin</b></a></li>
                            <li><a class="dropdown-item text-white ww m-2" href="/saad/member/membersecure.php"><b>2.Login</b></a></li>
                            <li><a class="dropdown-item text-white ww m-2" href="/saad/Exam/Admin_panel/coaching_secure.php"><b>3. Admin Coaching</b></a></li>
                        </ul>
                    </li>
                    <li class="nav-item"><a class="nav-link text-white fs-5 ww" href="admin/patient/messageindex.php"><i class="fa-regular fa-id-card p-2"></i>Contacts</a></li>
                </ul>
            </div>
        </nav>
    </header>   

    <main>
        <div class="group">
            <p class="text">অগ্নিবীণা বিশ্ববিদ্যালয় ভর্তি কোচিং এ আপনাকে স্বাগতম, ত্রিশাল-শাখা,ময়মনসিংহ</p>
        </div>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous"></script>
    <script>
        var style = document.createElement('style');
        var position = 'right';
        style.innerHTML = `
        @keyframes my-animation {
            0% { ${position}: -${document.querySelector('.text').offsetWidth + 8}px; }
            100% { ${position}: 100%; }
        }`;
        document.head.append(style);
    </script>
</body>
</html>
