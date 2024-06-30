<?php
session_start();

include 'koneksi.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Library - About Us</title>

    <!-- font awesome cdn link  -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <!-- custom css file link  -->
    <link rel="stylesheet" href="css/style.css">
    <link rel="icon" type="image/png" href="images/books.png">

</head>
<body>
    
<?php include 'header.php'; ?>
   
<div class="heading">
    <h3>about us</h3>
</div>

<section class="about2">

    <div class="content">
        <h3>Kenalan yuk dengan pembuat web ini</h3>
        <p>Lorem ipsum, dolor sit amet consectetur adipisicing elit. Atque cumque exercitationem repellendus, amet ullam voluptatibus</p>
    </div>

</section>

<section class="about">
    <div class="flex">
        <div class="member">
            <div class="image">
                <img src="images/author-1.jpg" alt="">
            </div>
            <div class="content">
                <h3>Anggota</h3>
                <ul class="member-list">
                    <li><span class="member-name">Muhammad Yusuf Tri Daryanto</span> <span class="member-id">(L200220140)</span></li>
                </ul>
            </div>
        </div>
        <div class="member">
            <div class="image">
                <img src="images/author-3.jpg" alt="">
            </div>
            <div class="content">
                <h3>Anggota</h3>
                <ul class="member-list">
                    <li><span class="member-name">As'ad Nirot Ahmadi</span> <span class="member-id">(L200220155)</span></li>
                </ul>
            </div>
        </div>
        <div class="member">
            <div class="image">
                <img src="images/author-5.jpg" alt="">
            </div>
            <div class="content">
                <h3>Anggota</h3>
                <ul class="member-list">
                    <li><span class="member-name">Iqbal Firmansyah</span> <span class="member-id">(L200220180)</span></li>
                </ul>
            </div>
        </div>
    </div>
</section>

<?php include 'footer.php'; ?>

<!-- custom js file link  -->
<script src="js/script.js"></script>

</body>
</html>