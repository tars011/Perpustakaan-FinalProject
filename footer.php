<section class="footer">
   <?php
   $current_page = basename($_SERVER['PHP_SELF']);
   if ($current_page == 'index.php') {
   ?>
   <div class="box-container">
      
      <div class="box" id="box1">
         <h3>quick links</h3>
         <a href="index.php">Home</a>
         <a href="books.php">Books</a>
         <a href="loans.php">Orders</a>
         <a href="about.php">About Us</a>
      </div>

      <div class="box" id="box2">
         <h3>contact info</h3>
         <p> <i class="fas fa-envelope"></i> l200220140@student.ums.ac.id </p>
         <p> <i class="fas fa-envelope"></i> l200220155@student.ums.ac.id </p>
         <p> <i class="fas fa-envelope"></i> l200220180@student.ums.ac.id </p>
         <p> <i class="fas fa-map-marker-alt"></i> Surakarta, Central Java, Indonesia </p>
      </div>

   </div>
   <?php } ?>

   <p class="credit"> Copyright &copy;    <?php echo date('Y'); ?> | All rights reserved.</p>

</section>