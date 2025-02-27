<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">


   
<meta name="description" content="Agnibina: A leading coaching center for university admissions, dedicated to guiding students toward academic success.">
<meta name="keywords" content="Agnibina, University Admission Coaching, Bangladesh, Exam Preparation, Counseling, Education">
<meta name="author" content="Md. Tajul Islam">
<meta property="og:title" content="Agnibina Coaching Center">
<meta property="og:description" content="Join Agnibina Coaching Center to achieve your university admission goals. Expert coaching and guidance await you.">
<meta property="og:image" content="images/logo1.png">
<meta property="og:url" content="https://www.agnibina.org">


<meta property="og:author" content="https://www.facebook.com/md.tajul.islam.60918">


    <link rel="icon" href="logo1.png" type="image/png">

    <title>Agnibina</title>

    
    <script>
  document.addEventListener('contextmenu', (event) => event.preventDefault());

  
</script>


    <style>
      
        body, html {
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
            height: 100%;
            display: flex;
            overflow-x: hidden; 
            flex-direction: column;
        }

       
        .slides {
            display: none;
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

      
        @media (max-width: 767px) {
            .slides {
                object-position: center center;  
            }
        }

      
        .active {
            display: block;
        }

     
        footer {
            background: linear-gradient(135deg, #34495e, #2c3e50);
            color: #ecf0f1;
            padding: 40px 20px;
            font-family: 'Roboto', sans-serif;
        }

        .footer-container {
            display: flex;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 20px;
            margin-bottom: 20px;
        }

        /* Footer Section Styling */
        .footer-section {
            flex: 1;
            min-width: 250px;
            max-width: 300px;
            text-align: center;
        }

        .footer-section h5 {
            font-size: 24px;
            margin-bottom: 15px;
            color: #f1c40f;
            text-transform: uppercase;
            text-align: center;
            border-bottom: 3px solid #f1c40f;
            display: inline-block;
            padding-bottom: 5px;
            margin-bottom: 20px;
        }

        .footer-section p {
            font-size: 14px;
            line-height: 1.8;
            margin-bottom: 10px;
        }

        .footer-section a {
            color: #1abc9c;
            text-decoration: none;
        }

        .footer-section a:hover {
            text-decoration: underline;
        }

        .footer-section i {
            margin-right: 10px;
        }

     
        .social-icons {
            display: flex;
            justify-content: center;
            gap: 15px;
        }

        .social-icons a {
            font-size: 22px;
            padding: 10px;
            border-radius: 50%;
            color: #ecf0f1;
            transition: background-color 0.3s, transform 0.3s;
        }

        .social-icons .facebook {
            background-color: #3b5998;
        }

        .social-icons .twitter {
            background-color: #1da1f2;
        }

        .social-icons .instagram {
            background-color: #e4405f;
        }

        .social-icons a:hover {
            transform: scale(1.1);
            opacity: 0.9;
        }

       
        .footer-bottom {
            text-align: center;
            border-top: 1px solid #7f8c8d;
            padding-top: 20px;
            font-size: 14px;
        }

        .footer-bottom a {
            color: #f1c40f;
            font-weight: bold;
            text-decoration: none;
        }

        .footer-bottom a:hover {
            text-decoration: underline;
        }

.whatsapp-icon {
    position: fixed;
    bottom: 20px;
    left: 20px;
    background-color: #25d366;
    padding: 8px;
    border-radius: 50%;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.3);
    z-index: 100;
    animation: pulse 4s ease-in-out infinite; /* Only size change animation */
}


@keyframes pulse {
    0% {
        transform: scale(1); 
    }
    25% {
        transform: scale(1.5); 
    }
    50% {
        transform: scale(1); 
    }
    75% {
        transform: scale(1.5);
    }
    100% {
        transform: scale(1); 
    }
}

.whatsapp-icon img {
    width: 35px; 
    height: auto;
}

        
        
        @media (max-width: 768px) {
            .footer-container {
                flex-direction: column; 
                align-items: center;   
                text-align: center;   
            }
            .footer-section {
                max-width: 100%;
            }
        }

    </style>
</head>
<body>
   
    <?php include('main.php'); ?>

    <!-- Slideshow Section -->
    <div class="slideshow">
        <img class="slides active" src="photo/slide1.jpg" alt="Photo 1">
        <img class="slides" src="photo/slide2.jpg" alt="Photo 2">
        <img class="slides" src="photo/slide3.jpg" alt="Photo 3">
    </div>

    <!-- Slideshow Script -->
    <script>
        let slideIndex = 0;
        const slides = document.querySelectorAll('.slides');

        function showSlides() {
            slides.forEach(slide => slide.classList.remove('active'));
            slideIndex = (slideIndex + 1) % slides.length;
            slides[slideIndex].classList.add('active');
        }

        setInterval(showSlides, 5000); 
    </script>

   
    <footer>
    <div class="footer-container">
        
        <div class="footer-section">
            <h5>Contact Us</h5>
            <p>
                <i class="fas fa-map-marker-alt" style="color: #e74c3c;"></i> Trishal, Mymensingh, Bangladesh
            </p>
            <p>
                <i class="fas fa-phone-alt" style="color: #27ae60;"></i> 
                <a href="tel:01853991419">01781072096</a>
            </p>
            <p>
                <i class="fas fa-envelope" style="color: #3498db;"></i> 
                <a href="mailto:tajul.cse.jkkniu@gmail.com">agnibina.uac@gmail.com</a>
            </p>
        </div>

        <!-- About Us Section -->
        <div class="footer-section">
    <h5>About Us</h5>
    <p>
        We are a Agnibina university admission coaching center, dedicated to helping students achieve their academic dreams. Our mission is to guide students through the university admission process, providing expert coaching, personalized counseling, and the necessary resources to succeed in exams. We strive to create an environment where students can excel academically and gain admission to top universities with confidence.
    </p>
</div>


        <!-- Social Media Section -->
        <div class="footer-section">
            <h5>Follow Us</h5>
            <div class="social-icons">
                <a href="https://www.facebook.com/home.php" target="_blank" class="facebook">
                    <i class="fab fa-facebook"></i>
                </a>
                <a href="https://twitter.com/home" target="_blank" class="twitter">
                    <i class="fab fa-twitter"></i>
                </a>
                <a href="https://www.instagram.com/" target="_blank" class="instagram">
                    <i class="fab fa-instagram"></i>
                </a>
            </div>
        </div>
    </div>

    <!-- Footer Bottom -->
    <div class="footer-bottom">
        <p>
            Developed by <a href="https://web.facebook.com/profile.php?id=100030474022734" target="_blank"><strong>Md. Tajul Islam</strong></a>
        </p>
        <p>&copy; 2024 Agnibina. All rights reserved.</p>
    </div>
</footer>



<!--Start of Tawk.to Script-->
<script type="text/javascript">
var Tawk_API=Tawk_API||{}, Tawk_LoadStart=new Date();
(function(){
var s1=document.createElement("script"),s0=document.getElementsByTagName("script")[0];
s1.async=true;
s1.src='https://embed.tawk.to/674b42124304e3196aeae005/1iduvk6aa';
s1.charset='UTF-8';
s1.setAttribute('crossorigin','*');
s0.parentNode.insertBefore(s1,s0);
})();
</script>
<!--End of Tawk.to Script-->




<!-- WhatsApp Icon -->
<a href="https://wa.me/8801781072096?text=Hello%20I%20need%20assistance%20from%20Aginibina." target="_blank" class="whatsapp-icon">
    <img src="https://upload.wikimedia.org/wikipedia/commons/6/6b/WhatsApp.svg" alt="WhatsApp">
</a>
</body>
</html>
