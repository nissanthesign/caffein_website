<?php

$db_name = 'mysql:host=localhost;dbname=coffee_db';
$username = 'root';  // No password
$password = '';  // Empty string

$conn = new PDO($db_name, $username, $password);

if (isset($_POST['send'])) {

   $name = $_POST['name'];
   $name = filter_var($name);
   $number = $_POST['number'];
   $number = filter_var($number);
   $guests = $_POST['guests'];
   $guests = filter_var($guests);

   $select_contact = $conn->prepare("SELECT * FROM `coffee_form` WHERE name = ? AND number = ? AND guests = ?");
   $select_contact->execute([$name, $number, $guests]);

   if ($select_contact->rowCount() > 0) {
      $message[] = 'message sent already!';
   } else {
      $insert_contact = $conn->prepare("INSERT INTO `coffee_form`(name, number, guests) VALUES(?,?,?)");
      $insert_contact->execute([$name, $number, $guests]);
      $message[] = 'message sent successfully!';
   }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Caffeine</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- custom css file link  -->
   
   <link rel="stylesheet" href="css/style.css">


</head>

<body>

   <?php
   if (isset($message)) {
      foreach ($message as $message) {
         echo '
            <div class="message" style="
               position: sticky;
               top: 0;
               z-index: 1100;
               background: var(--main-color);
               padding: 2rem;
               display: flex;
               align-items: center;
               justify-content: space-between;
               gap: 1.5rem;
               max-width: 1200px;
               margin: 0 auto;">
               <span style="color: var(--white);
               font-size: 2rem;">' . $message . '</span>

               <i class="fas fa-times" style="font-size: 2.5rem;
               color: var(--white);
               cursor: pointer;" onclick="this.parentElement.remove();"></i>
            </div>
            ';
      }
   }
   ?>

   <!-- header section starts  -->

   <header class="header">

      <section class="flex">

         <a href="#home" class="logo"><img src="images/logo.png" alt=""></a>

         <nav class="navbar">
            <a href="#home">home</a>
            <a href="#about">about</a>
            <a href="#menu">menu</a>
            <a href="#gallery">gallery</a>
            <a href="#team">team</a>
            <a href="#contact">contact</a>
            <a href="admin.php" class="btn admin-btn">Admin Panel</a>

         </nav>

         <div id="menu-btn" class="fas fa-bars"></div>

      </section>

   </header>

   <!-- header section ends -->

   <!-- home section starts  -->

   <div class="home-bg">

      <section class="home" id="home">

         <div class="content">
            <h3>Caffe!n</h3>
            <p>Lorem ipsum dolor sit amet consectetur, adipisicing elit. Ut officia, accusantium mollitia laudantium dolorum dolore.</p>
            <a href="#about" class="btn">about us</a>
         </div>

      </section>

   </div>

   <!-- home section ends -->

   <!-- about section starts  -->

   <section class="about" id="about">

      <div class="image">
         <img src="images/about-img.svg" alt="">
      </div>

      <div class="content">
         <h3>A cup of coffee can complete your day</h3>
         <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Veniam suscipit sunt repellendus, dolorum recusandae placeat quae. Iste eaque aspernatur, animi deleniti voluptas, sunt molestias eveniet sint consectetur facere a ex.</p>
         <a href="#menu" class="btn">our menu</a>
      </div>

   </section>

   <!-- about section ends -->

   <!-- facility section starts  -->

   <section class="facility">

      <div class="heading">
         <img src="images/heading-img.png" alt="">
         <h3>our facility</h3>
      </div>

      <div class="box-container">

         <div class="box">
            <img src="images/icon-1.png" alt="">
            <h3>varieties of coffees</h3>
            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Saepe, adipisci!</p>
         </div>

         <div class="box">
            <img src="images/icon-2.png" alt="">
            <h3>coffee beans</h3>
            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Saepe, adipisci!</p>
         </div>

         <div class="box">
            <img src="images/icon-3.png" alt="">
            <h3>breakfast and sweets</h3>
            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Saepe, adipisci!</p>
         </div>

         <div class="box">
            <img src="images/icon-4.png" alt="">
            <h3>read to go coffee</h3>
            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Saepe, adipisci!</p>
         </div>

      </div>

   </section>

   <!-- facility section ends -->

   <!-- menu section starts  -->

   <section class="menu" id="menu">

      <div class="heading">
         <img src="images/heading-img.png" alt="">
         <h3>popular menu</h3>
      </div>

      <div class="box-container">

         <div class="box">
            <img src="images/menu-1.png" alt="">
            <h3>love you coffee</h3>
         </div>

         <div class="box">
            <img src="images/menu-2.png" alt="">
            <h3>Cappuccino</h3>
         </div>

         <div class="box">
            <img src="images/menu-3.png" alt="">
            <h3>Mocha coffee</h3>
         </div>

         <div class="box">
            <img src="images/menu-4.png" alt="">
            <h3>Frappuccino</h3>
         </div>

         <div class="box">
            <img src="images/menu-5.png" alt="">
            <h3>black coffee</h3>
         </div>

         <div class="box">
            <img src="images/menu-6.png" alt="">
            <h3>love heart coffee</h3>
         </div>

      </div>

   </section>

   <!-- menu section ends -->

   <!-- gallery section starts  -->

   <section class="gallery" id="gallery">

      <div class="heading">
         <img src="images/heading-img.png" alt="">
         <h3>our gallery</h3>
      </div>

      <div class="box-container">
         <img src="images/gallery-1.webp" alt="">
         <img src="images/gallery-2.webp" alt="">
         <img src="images/gallery-3.webp" alt="">
         <img src="images/gallery-4.webp" alt="">
         <img src="images/gallery-5.webp" alt="">
         <img src="images/gallery-6.webp" alt="">
      </div>

   </section>

   <!-- gallery section ends -->

   <!-- team section starts  -->

   <section class="team" id="team">

      <div class="heading">
         <img src="images/heading-img.png" alt="">
         <h3>our team</h3>
      </div>

      <div class="box-container">

         <div class="box">
            <img src="images/our-team-1.jpg" alt="">
            <h3>Nishan</h3>
         </div>
         <div class="box">
            <img src="images/our-team-2.jpg" alt="">
            <h3>Akhi</h3>
         </div>
         <div class="box">
            <img src="images/our-team-3.jpg" alt="">
            <h3>Jerin</h3>
         </div>
         <div class="box">
            <img src="images/our-team-4.jpg" alt="">
            <h3>Akash</h3>
         </div>

      </div>

   </section>

   <!-- team section ends -->

   <!-- contact section starts  -->

   <section class="contact" id="contact">

      <div class="heading">
         <img src="images/heading-img.png" alt="">
         <h3>contact us</h3>
      </div>

      <div class="row">

         <div class="image">
            <img src="images/contact-img.svg" alt="">
         </div>

         <form action="" method="POST">
            <h3>book a table</h3>
            <input type="text" name="name" method="POST" required class="box" maxlength="20" placeholder="enter your name">
            <input type="number" name="number" method="POST" required class="box" maxlength="20" placeholder="enter your number" min="0" max="9999999999" onkeypress="if(this.value.length == 10) return false">
            <input type="number" name="guests" method="POST" required class="box" maxlength="20" placeholder="how many guests" min="0" max="99" onkeypress="if(this.value.length == 2) return false">
            <input type="submit" name="send" value="send message" class="btn">
         </form>

      </div>

   </section>

   <!-- contact section ends -->

   <!-- footer section starts  -->

   <section class="footer">

      <div class="box-container">

         <div class="box">
            <i class="fas fa-envelope"></i>
            <h3>our email</h3>
            <p>fbknissan@gmail.com</p>
            <p>peakashdo@gmail.com</p>
         </div>

         <div class="box">
            <i class="fas fa-clock"></i>
            <h3>opening hours</h3>
            <p>07:00am to 09:00pm</p>
         </div>

         <div class="box">
            <i class="fas fa-map-marker-alt"></i>
            <h3>shop location</h3>
            <p>Mirpur-1, Dhaka, Bangladesh</p>
         </div>

         <div class="box">
            <i class="fas fa-phone"></i>
            <h3>our number</h3>
            <p>01961100661</p>
            <p>01814588428</p>
         </div>

      </div>

      <div class="credit"> &copy; copyright @ <?= date('Y'); ?> by <span>NISHAN</span> | all rights reserved! </div>

   </section>

   <!-- footer section ends -->



   <!-- custom js file link  -->
   <script src="js/script.js"></script>

</body>

</html>