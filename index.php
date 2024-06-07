<?php
session_start();

?>
<!DOCTYPE html>
<html>

<head>
    <title>FITNESSFUSIONLAB</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- <link rel="stylesheet" href="css/animate.css"> -->
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <style>
        .wow:first-child {
            visibility: hidden;
        }
    </style>

</head>

<body>

    <!-- Start Header  -->
    <header>
        <div class="container">
            <div class="logo">
                <a href="">Fitness <span>Club</span></a>
            </div>
            <a href="javascript:void(0)" class="ham-burger">
                <span></span>
                <span></span>
            </a>
            <div class="nav">
                <ul>
                    <li><a href="#home">Home</a></li>
                    <li><a href="#exercise">Exercise</a></li>
                    <li><a href="#gallery">Gallery</a></li>
                    <li><a href="#contact">Contact</a></li>
                    <?php
                    if (isset($_SESSION['user_name'])) {
                    ?>
                        <li><a href="logout.php">Logout</a></li>
                    <?php
                    } else {
                    ?>
                        <li><a href="login.php">Login</a></li>
                    <?php
                    }
                    ?>
                </ul>
            </div>
        </div>
    </header>
    <!-- End Header  -->

    <!-- Start Home -->
    <section class="home wow flash" id="home">
        <div class="container">
            <h1 class="wow slideInLeft" data-wow-delay="1s">It's <span>gym</span> time. Let's go</h1>
            <h1 class="wow slideInRight" data-wow-delay="1s">We are ready to <span>fit you</span></h1>
        </div>

    </section>
    <!-- End Home -->


    <!-- Start About -->
    <section class="about" id="exercise">
        <div class="container">
            <h2>Choose Your Level</h2>
            <p class="title-p">Selecting your fitness level is crucial for getting the most out of your workout routine. Whether you're just starting, have some experience, or are looking to challenge yourself with advanced exercises, we have tailored programs to suit your needs. Choose from Beginner, Intermediate, or Advanced to see exercises specifically designed to match your fitness level and help you achieve your goals safely and effectively.</p>
            <div class="content">
                <div class="box wow bounceInUp">
                    <a href="muscle_group.php?level=1">
                        <div class="inner">
                            <div class="img">
                                <img src="images/about3.jpg" alt="about" />
                            </div>
                            <div class="text">
                                <h4>Beginner</h4>
                                <p>Perfect for those new to fitness or returning after a long break, the Beginner Level focuses on foundational exercises that build strength, improve flexibility, and enhance overall fitness. Start here to learn proper form, develop a routine, and set the stage for more advanced workouts.<br><br></p>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="box wow bounceInUp" data-wow-delay="0.2s">
                    <a href="muscle_group.php?level=2">
                        <div class="inner">
                            <div class="img">
                                <img src="images/about1.jpg" alt="about" />
                            </div>
                            <div class="text">
                                <h4>Intermediate</h4>
                                <p>Ideal for those with a solid fitness foundation, the Intermediate Level introduces more challenging exercises to help you continue building strength, endurance, and flexibility. This level focuses on increasing intensity and variety, pushing your limits, and preparing you for advanced workouts.</p>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="box wow bounceInUp" data-wow-delay="0.4s">
                    <a href="muscle_group.php?level=3">
                        <div class="inner">
                            <div class="img">
                                <img src="images/about2.jpg" alt="about" />
                            </div>
                            <div class="text">
                                <h4>Advanced</h4>
                                <p>Designed for experienced fitness enthusiasts, the Advanced Level offers high-intensity exercises that challenge your strength, endurance, and agility. This level incorporates complex movements and rigorous routines to help you reach peak physical performance and achieve your highest fitness goals.</p>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </section>
    <!-- End About -->

    <!-- Start Gallery -->
    <section class="gallery" id="gallery">
        <h2>Workout Gallery</h2>
        <div class="content">
            <div class="box wow slideInLeft">
                <img src="images/gallery1.jpg" alt="gallery" />
            </div>
            <div class="box wow slideInRight">
                <img src="images/gallery2.jpg" alt="gallery" />
            </div>
            <div class="box wow slideInLeft">
                <img src="images/gallery3.jpg" alt="gallery" />
            </div>
            <div class="box wow slideInRight">
                <img src="images/gallery4.jpg" alt="gallery" />
            </div>
        </div>
    </section>
    <!-- End Gallery -->

    <!-- Start Price -->
    <!-- <section class="price-package" id="price">
  	 <div class="container">
  	 	  <h2>Choose Your Package</h2>
  	 	  <p class="title-p">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, </p>
  	 	  <div class="content">
  	 	  	  <div class="box wow bounceInUp">
  	 	  	  	  <div class="inner">
  	 	  	  	  	   <div class="price-tag">
  	 	  	  	  	   	  $59/Month
  	 	  	  	  	   </div>
  	 	  	  	  	   <div class="img">
  	 	  	  	  	   	 <img src="images/price1.jpg" alt="price" />
  	 	  	  	  	   </div>
  	 	  	  	  	   <div class="text">
  	 	  	  	  	   	  <h3>Body Building Training</h3>
  	 	  	  	  	   	  <p>Get Free WiFi</p>
  	 	  	  	  	   	  <p>Month to Month</p>
  	 	  	  	  	   	  <p>No Time Restrictions</p>
  	 	  	  	  	   	  <p>Gym and Cardio</p>
  	 	  	  	  	   	  <p>Service Locker Rooms</p>
  	 	  	  	  	   	  <a href="" class="btn">Join Now</a>
  	 	  	  	  	   </div>
  	 	  	  	  </div>
  	 	  	  </div>
  	 	  	  <div class="box wow bounceInUp" data-wow-delay="0.2s">
  	 	  	  	  <div class="inner">
  	 	  	  	  	   <div class="price-tag">
  	 	  	  	  	   	  $69/Month
  	 	  	  	  	   </div>
  	 	  	  	  	   <div class="img">
  	 	  	  	  	   	 <img src="images/price2.jpg" alt="price" />
  	 	  	  	  	   </div>
  	 	  	  	  	   <div class="text">
  	 	  	  	  	   	  <h3>Body Building Training</h3>
  	 	  	  	  	   	  <p>Get Free WiFi</p>
  	 	  	  	  	   	  <p>Month to Month</p>
  	 	  	  	  	   	  <p>No Time Restrictions</p>
  	 	  	  	  	   	  <p>Gym and Cardio</p>
  	 	  	  	  	   	  <p>Service Locker Rooms</p>
  	 	  	  	  	   	  <a href="" class="btn">Join Now</a>
  	 	  	  	  	   </div>
  	 	  	  	  </div>
  	 	  	  </div>
  	 	  	  <div class="box wow bounceInUp" data-wow-delay="0.4s">
  	 	  	  	  <div class="inner">
  	 	  	  	  	   <div class="price-tag">
  	 	  	  	  	   	  $99/Month
  	 	  	  	  	   </div>
  	 	  	  	  	   <div class="img">
  	 	  	  	  	   	 <img src="images/price3.jpg" alt="price" />
  	 	  	  	  	   </div>
  	 	  	  	  	   <div class="text">
  	 	  	  	  	   	  <h3>Body Building Training</h3>
  	 	  	  	  	   	  <p>Get Free WiFi</p>
  	 	  	  	  	   	  <p>Month to Month</p>
  	 	  	  	  	   	  <p>No Time Restrictions</p>
  	 	  	  	  	   	  <p>Gym and Cardio</p>
  	 	  	  	  	   	  <p>Service Locker Rooms</p>
  	 	  	  	  	   	  <a href="" class="btn">Join Now</a>
  	 	  	  	  	   </div>
  	 	  	  	  </div>
  	 	  	  </div>
  	 	  </div>
  	 </div>
  </section> -->
    <!-- End Price -->
    <section class="contactus-container" id="contact">
        <div>
            <h2>CONTACT US</h2>
            <div class="img-container-bx">
                <img src="images/103101538.png" alt="">
            </div>
            <form action="contactusAction.php" method="post">
                <div class="input-container">
                    <label for="">Name:</label>
                    <div>
                        <input type="text" placeholder="First" name="firstname" required>
                        <input type="text" placeholder="Last" name="lastname" required>
                    </div>
                </div>
                <div class="input-container">
                    <label for="">Phone Number:</label>
                    <div>
                        <input type="text" placeholder="#### #### ##" name="number" required>
                    </div>
                </div>
                <div class="input-container">
                    <label for="">Email Address:</label>
                    <div>
                        <input type="email" name="email" required>
                    </div>
                </div>
                <div class="input-container">
                    <label for="">Message:</label>
                    <div>
                        <textarea name="message" required></textarea>
                    </div>
                </div>
                <div class="submit-button-container">
                    <button type="submit">SUBMIT</button>
                </div>
            </form>

        </div>
    </section>


    <!-- jquery -->

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script>
        $(document).ready(function() {

            $(".ham-burger, .nav ul li a").click(function() {

                $(".nav").toggleClass("open")

                $(".ham-burger").toggleClass("active");
            })
            $(".accordian-container").click(function() {
                $(".accordian-container").children(".body").slideUp();
                $(".accordian-container").removeClass("active")
                $(".accordian-container").children(".head").children("span").removeClass("fa-angle-down").addClass("fa-angle-up")
                $(this).children(".body").slideDown();
                $(this).addClass("active")
                $(this).children(".head").children("span").removeClass("fa-angle-up").addClass("fa-angle-down")
            })

            $(".nav ul li a, .go-down").click(function(event) {
                if (this.hash !== "") {

                    event.preventDefault();

                    var hash = this.hash;

                    $('html,body').animate({
                        scrollTop: $(hash).offset().top
                    }, 800, function() {
                        window.location.hash = hash;
                    });

                    // add active class in navigation
                    $(".nav ul li a").removeClass("active")
                    $(this).addClass("active")
                }
            })
        })
    </script>
    <script src="js/wow.min.js"></script>
    <script>
        wow = new WOW({
            animateClass: 'animated',
            offset: 0,
        });
        wow.init();
    </script>
</body>

</html>