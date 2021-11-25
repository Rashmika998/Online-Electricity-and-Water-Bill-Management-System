<?php

require_once '../Config.php';

  $Current = mysqli_query($link, "SELECT COUNT(admin_id) FROM admin WHERE type = 'Electricity'");
  $Current_admins = mysqli_fetch_assoc($Current);
  $Current_users = $Current_admins["COUNT(admin_id)"];


  
  $all = mysqli_query($link, "SELECT COUNT(user_id) FROM users");
  $all_use = mysqli_fetch_assoc($all);
  $all_users = $all_use["COUNT(user_id)"];

  
  $Water = mysqli_query($link, "SELECT COUNT(admin_id) FROM admin WHERE type = 'Water'");
  $Water_admins = mysqli_fetch_assoc($Water);
  $Water_users = $Water_admins["COUNT(admin_id)"];
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>OEAWBMS</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <!-- Favicons -->
  <link href="assets/img/favicon.png" rel="icon">
  <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">

  <!-- Google Fonts -->
  <link
    href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Raleway:300,300i,400,400i,500,500i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i"
    rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="assets/vendor/aos/aos.css" rel="stylesheet">
  <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
  <link href="assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
  <link href="assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">

  <!-- Template Main CSS File -->
  <link href="assets/css/style.css" rel="stylesheet">

  <script type="text/javascript" src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit">
  </script>
  <script type="text/javascript">
    function googleTranslateElementInit() {
      new google.translate.TranslateElement({
        includedLanguages: 'en,si,ta',
        layout: google.translate.TranslateElement.InlineLayout.SIMPLE
      }, 'google_translate_element');
    }
  </script>

  <!-- =======================================================
  * Template Name: Appland - v4.3.0
  * Template URL: https://bootstrapmade.com/free-bootstrap-app-landing-page-template/
  * Author: BootstrapMade.com
  * License: https://bootstrapmade.com/license/
  ======================================================== -->
</head>

<body>

  <!-- ======= Header ======= -->
  <header id="header" class="fixed-top  header-transparent ">
    <div class="container d-flex align-items-center justify-content-between">

      <div class="logo">
        <h1><a href="index.html">OEAWBMS</a></h1>
        <!-- Uncomment below if you prefer to use an image logo -->
        <!-- <a href="index.html"><img src="assets/img/logo.png" alt="" class="img-fluid"></a>-->
      </div>

      <nav id="navbar" class="navbar">
        <ul>
          <li><a class="nav-link scrollto active" href="#hero">Home</a></li>
          <li><a class="nav-link scrollto" href="#features">Features</a></li>
          <!-- <li><a class="nav-link scrollto" href="#gallery">Gallery</a></li> -->
          <li><a class="nav-link scrollto" href="#pricing">Stats</a></li>
          <li><a class="nav-link scrollto" href="#contact">Contact</a></li>
          <li><a class="getstarted scrollto" href="#">Language 
            <div id="google_translate_element"></div>
          </a></li>
        </ul>
        <i class="bi bi-list mobile-nav-toggle"></i>
      </nav><!-- .navbar -->

    </div>
  </header><!-- End Header -->

  <!-- ======= Hero Section ======= -->
  <section id="hero" class="d-flex align-items-center">

    <div class="container">
      <div class="row">
        <div
          class="col-lg-6 d-lg-flex flex-lg-column justify-content-center align-items-stretch pt-5 pt-lg-0 order-2 order-lg-1"
          data-aos="fade-up">
          <div>
            <h1>Welcome to OEAWBMS-Online Electricity and Water Bill Management System</h1>
            <h2>OEAWBMS is an online system to manage electricity and water billing for the administrator and customer.
            </h2>
            <a href="../User-Register.php" class="download-btn"><i class="bx bx-plus"></i> User Sign up</a>
            <a href="../User-Login.php" class="download-btn"><i class="bx bx-user"></i> User Log in</a>
          </div>
        </div>
        <div class="col-lg-6 d-lg-flex flex-lg-column align-items-stretch order-1 order-lg-2 hero-img"
          data-aos="fade-up">
          <img src="assets/img/picc.png" class="img-fluid" alt="">
        </div>
      </div>
    </div>

  </section><!-- End Hero -->

  <main id="main">

    <!-- ======= App Features Section ======= -->
    <section id="features" class="features">
      <div class="container">

        <div class="section-title">
          <h2>Features</h2>
          <p>We introduce an online system to manage electrical and water billing for the administrator and customer.
          </p>
        </div>

        <div class="row no-gutters">
          <div class="col-xl-7 d-flex align-items-stretch order-2 order-lg-1">
            <div class="content d-flex flex-column justify-content-center">
              <div class="row">
                <div class="col-md-6 icon-box" data-aos="fade-up">
                  <i class="bx bx-receipt"></i>
                  <h4>Online Bill Management</h4>
                  <p>Paperless bill management system</p>
                </div>
                <div class="col-md-6 icon-box" data-aos="fade-up" data-aos-delay="100">
                  <i class="bx bx-money"></i>
                  <h4>Online Payment Portal</h4>
                  <p>User can pay their bills through online</p>
                </div>
                <div class="col-md-6 icon-box" data-aos="fade-up" data-aos-delay="200">
                  <i class="bx bx-images"></i>
                  <h4>Upload Meter Image</h4>
                  <p>User needs to upload an image of the meter before the deadline</p>
                </div>
                <div class="col-md-6 icon-box" data-aos="fade-up" data-aos-delay="300">
                  <i class="bx bx-chart"></i>
                  <h4>Analyze the Usage</h4>
                  <p>User can analyze the electricity and water usage in past months</p>
                </div>
                <div class="col-md-6 icon-box" data-aos="fade-up" data-aos-delay="400">
                  <i class="bx bx-bell"></i>
                  <h4>Get Updated</h4>
                  <p>User can view the notifications and reminders send by administrators</p>
                </div>
                <div class="col-md-6 icon-box" data-aos="fade-up" data-aos-delay="500">
                  <i class="bx bx-lock"></i>
                  <h4>Privacy</h4>
                  <p>Privacy of all user data will be maintained</p>
                </div>
              </div>
            </div>
          </div>
          <div class="image col-xl-5 d-flex align-items-stretch justify-content-center order-1 order-lg-2"
            data-aos="fade-left" data-aos-delay="100">
            <img src="assets/img/features.svg" class="img-fluid" alt="">
          </div>
        </div>

      </div>
    </section><!-- End App Features Section -->

    <!-- ======= Details Section ======= -->
    <section id="details" class="details">
      <div class="container">

        <div class="row content">
          <div class="col-md-4" data-aos="fade-right">
            <img src="assets/img/details-1.png" class="img-fluid" alt="">
          </div>
          <div class="col-md-8 pt-4" data-aos="fade-up">
            <h3>Administrator Features</h3>
            <p class="fst-italic">
              By using this system, meter reading will be paperless as well as human errors which can be happened when
              updating the bill manually will be avoided.
            </p>
            <ul>
              <li><i class="bi bi-check"></i> Register users for the system.</li>
              <li><i class="bi bi-check"></i> Update bills and payments.</li>
              <li><i class="bi bi-check"></i> Analyze the electricity and water usage for each category.</li>
              <li><i class="bi bi-check"></i> Add, Remove users from the system.</li>
            </ul>
            <p>
              Human error associated with manually operated system, improper bill creation and delay in bill
              availability process
              problems will be solved through this system.
            </p>
          </div>
        </div>

        <div class="row content">
          <div class="col-md-4 order-1 order-md-2" data-aos="fade-left">
            <img src="assets/img/details-4.png" class="img-fluid" alt="">
          </div>
          <div class="col-md-8 pt-5 order-2 order-md-1" data-aos="fade-up">
            <h3>User Manual</h3>
            <p>
              User can first sign in for the system and then they can login to the system.
              User will be directed to the electricity management system page and in there user can switch to water bill
              management page.
            </p>
            <p>
              User has to upload a clear image of the electricity/water meter for the relevant month before the
              deadlines to avoid
              extra charges.
              Then administartors will update the bill fore the specific month and use will be notified once it was
              updated.
              User can pay the payment through online or normal way.
            </p>
            <p>
              Users can get to know about their electricity and water usages relevant to the month so that they can plan
              their power
              and water consumption and delay in payments process problem also will be solved through the system.
            </p>
          </div>
        </div>
      </div>
    </section><!-- End Details Section -->

    <!-- ======= Gallery Section ======= -->
    <!-- <section id="gallery" class="gallery">
      <div class="container" data-aos="fade-up">

        <div class="section-title">
          <h2>Gallery</h2>
          <p>Magnam dolores commodi suscipit. Necessitatibus eius consequatur ex aliquid fuga eum quidem. Sit sint
            consectetur velit. Quisquam quos quisquam cupiditate. Et nemo qui impedit suscipit alias ea. Quia fugiat sit
            in iste officiis commodi quidem hic quas.</p>
        </div>

      </div>

      <div class="container-fluid" data-aos="fade-up">
        <div class="gallery-slider swiper-container">
          <div class="swiper-wrapper">
            <div class="swiper-slide"><a href="assets/img/gallery/gallery-1.png" class="gallery-lightbox"
                data-gall="gallery-carousel"><img src="assets/img/gallery/gallery-1.png" class="img-fluid" alt=""></a>
            </div>
            <div class="swiper-slide"><a href="assets/img/gallery/gallery-2.png" class="gallery-lightbox"
                data-gall="gallery-carousel"><img src="assets/img/gallery/gallery-2.png" class="img-fluid" alt=""></a>
            </div>
            <div class="swiper-slide"><a href="assets/img/gallery/gallery-3.png" class="gallery-lightbox"
                data-gall="gallery-carousel"><img src="assets/img/gallery/gallery-3.png" class="img-fluid" alt=""></a>
            </div>
            <div class="swiper-slide"><a href="assets/img/gallery/gallery-4.png" class="gallery-lightbox"
                data-gall="gallery-carousel"><img src="assets/img/gallery/gallery-4.png" class="img-fluid" alt=""></a>
            </div>
            <div class="swiper-slide"><a href="assets/img/gallery/gallery-5.png" class="gallery-lightbox"
                data-gall="gallery-carousel"><img src="assets/img/gallery/gallery-5.png" class="img-fluid" alt=""></a>
            </div>
            <div class="swiper-slide"><a href="assets/img/gallery/gallery-6.png" class="gallery-lightbox"
                data-gall="gallery-carousel"><img src="assets/img/gallery/gallery-6.png" class="img-fluid" alt=""></a>
            </div>
            <div class="swiper-slide"><a href="assets/img/gallery/gallery-7.png" class="gallery-lightbox"
                data-gall="gallery-carousel"><img src="assets/img/gallery/gallery-7.png" class="img-fluid" alt=""></a>
            </div>
            <div class="swiper-slide"><a href="assets/img/gallery/gallery-8.png" class="gallery-lightbox"
                data-gall="gallery-carousel"><img src="assets/img/gallery/gallery-8.png" class="img-fluid" alt=""></a>
            </div>
            <div class="swiper-slide"><a href="assets/img/gallery/gallery-9.png" class="gallery-lightbox"
                data-gall="gallery-carousel"><img src="assets/img/gallery/gallery-9.png" class="img-fluid" alt=""></a>
            </div>
            <div class="swiper-slide"><a href="assets/img/gallery/gallery-10.png" class="gallery-lightbox"
                data-gall="gallery-carousel"><img src="assets/img/gallery/gallery-10.png" class="img-fluid" alt=""></a>
            </div>
            <div class="swiper-slide"><a href="assets/img/gallery/gallery-11.png" class="gallery-lightbox"
                data-gall="gallery-carousel"><img src="assets/img/gallery/gallery-11.png" class="img-fluid" alt=""></a>
            </div>
            <div class="swiper-slide"><a href="assets/img/gallery/gallery-12.png" class="gallery-lightbox"
                data-gall="gallery-carousel"><img src="assets/img/gallery/gallery-12.png" class="img-fluid" alt=""></a>
            </div>
          </div>
          <div class="swiper-pagination"></div>
        </div>

      </div>
    </section>End Gallery Section -->

    <!-- ======= Pricing Section ======= -->
    <section id="pricing" class="pricing">
      <div class="container" data-aos="fade-up">

        <div class="section-title">
          <h2>Stats</h2>
          <p>Electricity and Water Bill management administrators can log into the systems through below links</p>
        </div>

        <div class="row no-gutters">

          <div class="col-lg-4 box" data-aos="fade-right">
            <h3>Electricity</h3>
            <h4><?php echo $Current_users?> <span>Total officers</span></h4>
            <ul>
              <li><i class="bx bx-check"></i> Register user for Electricity bill management system</li>
              <li><i class="bx bx-check"></i> Update user bills and payments</li>
              <li><i class="bx bx-check"></i> Send reminders for red bills if neccessary</li>
              <li><i class="bx bx-check"></i> Analyze electricity usage for different categories</li>
              <li> Click below button to log in as an administrator</li>
            </ul>
            <a href="../Current-Admin-Login.php" class="get-started-btn">Login</a>
          </div>

          <div class="col-lg-4 box featured" data-aos="fade-up">
            <h3>Users</h3>
            <h4><?php echo $all_users?> <span>Total users</span></h4>
            <ul>
              <li><i class="bx bx-check"></i> Register user for Electricity and Water bill management system</li>
              <li><i class="bx bx-check"></i> Upload the meetr image</li>
              <li><i class="bx bx-check"></i> get updates about bills</li>
              <li><i class="bx bx-check"></i> Pay the amount through online</li>
              <li><i class="bx bx-check"></i> View usage</li>
            </ul>
            <a href="../User-Login.php" class="get-started-btn">Login</a>
          </div>

          <div class="col-lg-4 box" data-aos="fade-left">
            <h3>Water</h3>
            <h4><?php echo $Water_users?> <span>Total officers</span></h4>
            <ul>
              <li><i class="bx bx-check"></i> Register user for Water bill management system</li>
              <li><i class="bx bx-check"></i> Update user bills and payments</li>
              <li><i class="bx bx-check"></i> Send reminders for red bills if neccessary</li>
              <li><i class="bx bx-check"></i> Analyze water usage for different categories</li>
              <li> Click below button to log in as an administrator</li>
            </ul>
            <a href="../Water-Admin-Login.php" class="get-started-btn">Login</a>
          </div>

        </div>

      </div>
    </section><!-- End Pricing Section -->

    <!-- ======= Frequently Asked Questions Section ======= -->
    <!-- <section id="faq" class="faq section-bg">
      <div class="container" data-aos="fade-up">

        <div class="section-title">

          <h2>Frequently Asked Questions</h2>
          <p>Magnam dolores commodi suscipit. Necessitatibus eius consequatur ex aliquid fuga eum quidem. Sit sint
            consectetur velit. Quisquam quos quisquam cupiditate. Et nemo qui impedit suscipit alias ea. Quia fugiat sit
            in iste officiis commodi quidem hic quas.</p>
        </div>

        <div class="accordion-list">
          <ul>
            <li data-aos="fade-up">
              <i class="bx bx-help-circle icon-help"></i> <a data-bs-toggle="collapse" class="collapse"
                data-bs-target="#accordion-list-1">Non consectetur a erat nam at lectus urna duis? <i
                  class="bx bx-chevron-down icon-show"></i><i class="bx bx-chevron-up icon-close"></i></a>
              <div id="accordion-list-1" class="collapse show" data-bs-parent=".accordion-list">
                <p>
                  Feugiat pretium nibh ipsum consequat. Tempus iaculis urna id volutpat lacus laoreet non curabitur
                  gravida. Venenatis lectus magna fringilla urna porttitor rhoncus dolor purus non.
                </p>
              </div>
            </li>

            <li data-aos="fade-up" data-aos-delay="100">
              <i class="bx bx-help-circle icon-help"></i> <a data-bs-toggle="collapse"
                data-bs-target="#accordion-list-2" class="collapsed">Feugiat scelerisque varius morbi enim nunc? <i
                  class="bx bx-chevron-down icon-show"></i><i class="bx bx-chevron-up icon-close"></i></a>
              <div id="accordion-list-2" class="collapse" data-bs-parent=".accordion-list">
                <p>
                  Dolor sit amet consectetur adipiscing elit pellentesque habitant morbi. Id interdum velit laoreet id
                  donec ultrices. Fringilla phasellus faucibus scelerisque eleifend donec pretium. Est pellentesque elit
                  ullamcorper dignissim. Mauris ultrices eros in cursus turpis massa tincidunt dui.
                </p>
              </div>
            </li>

            <li data-aos="fade-up" data-aos-delay="200">
              <i class="bx bx-help-circle icon-help"></i> <a data-bs-toggle="collapse"
                data-bs-target="#accordion-list-3" class="collapsed">Dolor sit amet consectetur adipiscing elit? <i
                  class="bx bx-chevron-down icon-show"></i><i class="bx bx-chevron-up icon-close"></i></a>
              <div id="accordion-list-3" class="collapse" data-bs-parent=".accordion-list">
                <p>
                  Eleifend mi in nulla posuere sollicitudin aliquam ultrices sagittis orci. Faucibus pulvinar elementum
                  integer enim. Sem nulla pharetra diam sit amet nisl suscipit. Rutrum tellus pellentesque eu tincidunt.
                  Lectus urna duis convallis convallis tellus. Urna molestie at elementum eu facilisis sed odio morbi
                  quis
                </p>
              </div>
            </li>

            <li data-aos="fade-up" data-aos-delay="300">
              <i class="bx bx-help-circle icon-help"></i> <a data-bs-toggle="collapse"
                data-bs-target="#accordion-list-4" class="collapsed">Tempus quam pellentesque nec nam aliquam sem et
                tortor consequat? <i class="bx bx-chevron-down icon-show"></i><i
                  class="bx bx-chevron-up icon-close"></i></a>
              <div id="accordion-list-4" class="collapse" data-bs-parent=".accordion-list">
                <p>
                  Molestie a iaculis at erat pellentesque adipiscing commodo. Dignissim suspendisse in est ante in. Nunc
                  vel risus commodo viverra maecenas accumsan. Sit amet nisl suscipit adipiscing bibendum est. Purus
                  gravida quis blandit turpis cursus in.
                </p>
              </div>
            </li>

            <li data-aos="fade-up" data-aos-delay="400">
              <i class="bx bx-help-circle icon-help"></i> <a data-bs-toggle="collapse"
                data-bs-target="#accordion-list-5" class="collapsed">Tortor vitae purus faucibus ornare. Varius vel
                pharetra vel turpis nunc eget lorem dolor? <i class="bx bx-chevron-down icon-show"></i><i
                  class="bx bx-chevron-up icon-close"></i></a>
              <div id="accordion-list-5" class="collapse" data-bs-parent=".accordion-list">
                <p>
                  Laoreet sit amet cursus sit amet dictum sit amet justo. Mauris vitae ultricies leo integer malesuada
                  nunc vel. Tincidunt eget nullam non nisi est sit amet. Turpis nunc eget lorem dolor sed. Ut venenatis
                  tellus in metus vulputate eu scelerisque.
                </p>
              </div>
            </li>

          </ul>
        </div>

      </div>
    </section>End Frequently Asked Questions Section -->

    <!-- ======= Contact Section ======= -->
    <section id="contact" class="contact">
      <div class="container" data-aos="fade-up">

        <div class="section-title">
          <h2>Contact</h2>
          <p>Conatct us for any issue through below ways.</p>
        </div>

        <div class="row">

          <div class="col-lg-6">
            <div class="row">
              <div class="col-lg-6 info">
                <i class="bx bx-map"></i>
                <h4>Address</h4>
                <p>No.21/1 New road,<br>Colombo - 04</p>
              </div>
              <div class="col-lg-6 info">
                <i class="bx bx-phone"></i>
                <h4>Call Us</h4>
                <p>011 2 123 456<br>011 2 456 789</p>
              </div>
              <div class="col-lg-6 info">
                <i class="bx bx-envelope"></i>
                <h4>Email Us</h4>
                <p>ocawbms2021@gmail.com</p>
              </div>
              <div class="col-lg-6 info">
                <i class="bx bx-time-five"></i>
                <h4>Working Hours</h4>
                <p>24 Hour service</p>
              </div>
            </div>
          </div>

          <div class="col-lg-6">
            <form action="forms/contact.php" method="post" role="form" class="php-email-form" data-aos="fade-up">
              <div class="form-group">
                <input placeholder="Your Name" type="text" name="name" class="form-control" id="name" required>
              </div>
              <div class="form-group mt-3">
                <input placeholder="Your Email" type="email" class="form-control" name="email" id="email" required>
              </div>
              <div class="form-group mt-3">
                <input placeholder="Subject" type="text" class="form-control" name="subject" id="subject" required>
              </div>
              <div class="form-group mt-3">
                <textarea placeholder="Message" class="form-control" name="message" rows="5" required></textarea>
              </div>
              <div class="my-3">
                <div class="loading">Loading</div>
                <div class="error-message"></div>
                <div class="sent-message">Your message has been sent. Thank you!</div>
              </div>
              <div class="text-center"><button type="submit">Send Message</button></div>
            </form>
          </div>

        </div>

      </div>
    </section><!-- End Contact Section -->

  </main><!-- End #main -->

  <!-- ======= Footer ======= -->
  <footer id="footer">

    <div class="footer-top">
      <div class="container">
        <div class="row">

          <div class="col-lg-3 col-md-6 footer-contact">
            <h3>Appland</h3>
            <p>
              No.21/1 New road <br>
              Colombo - 04<br><br>
              <strong>Phone:</strong> 011 2 123 456, 011 2 456 789<br>
              <strong>Email:</strong> ocawbms2021@gmail.com<br>
            </p>
          </div>

          <div class="col-lg-3 col-md-6 footer-links">
            <h4>Useful Links</h4>
            <ul>
              <li><i class="bx bx-chevron-right"></i> <a href="#">Home</a></li>
              <li><i class="bx bx-chevron-right"></i> <a href="#">About us</a></li>
              <li><i class="bx bx-chevron-right"></i> <a href="#">Services</a></li>
              <li><i class="bx bx-chevron-right"></i> <a href="#">Terms of service</a></li>
              <li><i class="bx bx-chevron-right"></i> <a href="#">Privacy policy</a></li>
            </ul>
          </div>

          <div class="col-lg-3 col-md-6 footer-links">
            <h4>Our Services</h4>
            <ul>
              <li><i class="bx bx-chevron-right"></i> <a href="#">Electricity Bill Maintainance</a></li>
              <li><i class="bx bx-chevron-right"></i> <a href="#">Water Bill Maintainance</a></li>
              <li><i class="bx bx-chevron-right"></i> <a href="#">View usage</a></li>
              <li><i class="bx bx-chevron-right"></i> <a href="#">Online Payment Portal</a></li>
            </ul>
          </div>

          <div class="col-lg-3 col-md-6 footer-links">
            <h4>Our Social Networks</h4>
            <p>See more of us from social media networks</p>
            <div class="social-links mt-3">
              <a href="#" class="twitter"><i class="bx bxl-twitter"></i></a>
              <a href="#" class="facebook"><i class="bx bxl-facebook"></i></a>
              <a href="#" class="instagram"><i class="bx bxl-instagram"></i></a>
              <a href="#" class="google-plus"><i class="bx bxl-skype"></i></a>
              <a href="#" class="linkedin"><i class="bx bxl-linkedin"></i></a>
            </div>
          </div>

        </div>
      </div>
    </div>

    <div class="container py-4">

      <div class="credits">
        <div class="copyright">
          &copy; Copyright <strong><span>OEAWBMS</span></strong>. All Rights Reserved
        </div>
      </div>
    </div>
  </footer><!-- End Footer -->

  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i
      class="bi bi-arrow-up-short"></i></a>

  <!-- Vendor JS Files -->
  <script src="assets/vendor/aos/aos.js"></script>
  <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="assets/vendor/glightbox/js/glightbox.min.js"></script>
  <script src="assets/vendor/php-email-form/validate.js"></script>
  <script src="assets/vendor/swiper/swiper-bundle.min.js"></script>

  <!-- Template Main JS File -->
  <script src="assets/js/main.js"></script>

</body>

<script>
  $('document').ready(function() {

      $('#google_translate_element').on("click", function() {

          // Change font family and color
          $("iframe").contents().find(
                  ".goog-te-menu2-item div, .goog-te-menu2-item:link div, .goog-te-menu2-item:visited div, .goog-te-menu2-item:active div"
              ) 
          // Change Google's default blue border
          // $("iframe").contents().find('.goog-te-menu2').css('border', '1px solid red');

          // $("iframe").contents().find('.goog-te-menu2').css('background-color', 'red');

          // Change the iframe's box shadow
          // $(".goog-te-menu-frame").css({
          //     '-moz-box-shadow': '0 3px 8px 2px #666666',
          //     '-webkit-box-shadow': '0 3px 8px 2px #666',
          //     'box-shadow': '0 3px 8px 2px #666'
          // });
      });
  });
  </script>

  <style>
  /* OVERRIDE GOOGLE TRANSLATE WIDGET CSS BEGIN */
  div#google_translate_element div.goog-te-gadget-simple {
      border: none;
      background-color: #5777ba;
      /*#e3e3ff*/
  }

  div#google_translate_element div.goog-te-gadget-simple a.goog-te-menu-value:hover {
      text-decoration: none;
  }

  div#google_translate_element div.goog-te-gadget-simple a.goog-te-menu-value span {
      color: white;
  }

  div#google_translate_element div.goog-te-gadget-simple a.goog-te-menu-value span:hover {
      color: white;
  }

  .goog-te-gadget-icon {
      display: none !important;
      /*background: url("url for the icon") 0 0 no-repeat !important;*/
  }

  /* Remove the down arrow */
  /* when dropdown open */
  div#google_translate_element div.goog-te-gadget-simple a.goog-te-menu-value span[style="color: rgb(213, 213, 213);"] {
      display: none;
  }

  /* after clicked/touched */
  div#google_translate_element div.goog-te-gadget-simple a.goog-te-menu-value span[style="color: rgb(118, 118, 118);"] {
      display: none;
  }

  /* on page load (not yet touched or clicked) */
  div#google_translate_element div.goog-te-gadget-simple a.goog-te-menu-value span[style="color: rgb(155, 155, 155);"] {
      display: none;
  }

  /* Remove span with left border line | (next to the arrow) in Chrome & Firefox */
  div#google_translate_element div.goog-te-gadget-simple a.goog-te-menu-value span[style="border-left: 1px solid rgb(187, 187, 187);"] {
      display: none;
  }

  /* Remove span with left border line | (next to the arrow) in Edge & IE11 */
  /* div#google_translate_element div.goog-te-gadget-simple a.goog-te-menu-value span[style="border-left-color: rgb(187, 187, 187); border-left-width: 1px; border-left-style: solid;"] {
      display: none;
  } */

  /* HIDE the google translate toolbar */
  .goog-te-banner-frame.skiptranslate {
      display: none !important;
  }

  body {
      top: 0px !important;
  }

  /* OVERRIDE GOOGLE TRANSLATE WIDGET CSS END */
  </style>

</html>