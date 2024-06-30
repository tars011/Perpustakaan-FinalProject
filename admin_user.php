<?php
session_start();

include 'koneksi.php';

// jika belum login maka diarahkan ke halaman login
if( !isset($_SESSION["login"]) ) {
    header("Location: login.php");
    exit;
}

// Handle delete action
if (isset($_GET['delete'])) {
    $delete_id = $_GET['delete'];
    mysqli_query($conn, "DELETE FROM `user` WHERE id_user = '$delete_id'") or die('Query failed');
    header('Location: admin_user.php');
    exit;
}

// Handle update action
if (isset($_POST['update_user'])) {
    $update_id = $_POST['id_user'];
    $username = $_POST['username'];
    $nama = $_POST['nama'];
    $email = $_POST['email'];
    $no_telepon = $_POST['no_telepon'];

    mysqli_query($conn, "UPDATE `user` SET username = '$username', nama = '$nama', email = '$email', no_telepon = '$no_telepon' WHERE id_user = '$update_id'") or die('Query failed');
    header('Location: admin_user.php');
    exit;
}

// Fetch user data if update is requested
if (isset($_GET['update'])) {
    $update_id = $_GET['update'];
    $update_query = mysqli_query($conn, "SELECT * FROM `user` WHERE id_user = '$update_id'") or die('Query failed');
    if (mysqli_num_rows($update_query) > 0) {
        $user_data = mysqli_fetch_assoc($update_query);
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Users</title>

   <!-- Font Awesome CDN link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

   <!-- Custom admin CSS file link  -->
   <link rel="stylesheet" href="css/style_admin.css">

   <style>
      .user {
         padding: 2rem;
      }

      .user .box-container {
         display: flex;
         flex-wrap: wrap;
         gap: 2rem;
         justify-content: center;
      }

      .user .box {
         background: #fff;
         border-radius: .5rem;
         box-shadow: 0 5px 15px rgba(0,0,0,.1);
         padding: 2rem;
         text-align: center;
         width: 300px;
      }

      .user .box p {
         margin-bottom: 1rem;
         font-size: 1.6rem;
         color: #333;
      }

      .user .box .delete-btn,
      .user .box .update-btn {
         display: block;
         width: 100%;
         margin-top: 1rem;
         background: var(--red);
         color: #fff;
         padding: 1rem;
         font-size: 1.6rem;
         border-radius: .5rem;
         cursor: pointer;
         text-align: center;
      }

      .user .box .update-btn {
         background: var(--orange);
      }

      .user .box .delete-btn:hover,
      .user .box .update-btn:hover {
         background: var(--black);
      }

      .update-form {
         display: flex;
         flex-direction: column;
         gap: 1rem;
         margin: 2rem auto;
         padding: 2rem;
         background: #fff;
         border-radius: .5rem;
         box-shadow: 0 5px 15px rgba(0,0,0,.1);
         max-width: 400px;
      }

      .update-form input,
      .update-form select {
         width: 100%;
         padding: 1rem;
         font-size: 1.6rem;
         border: 1px solid #ccc;
         border-radius: .5rem;
      }

      .update-form .btn {
         background: var(--orange);
         color: #fff;
         border: none;
         padding: 1rem;
         font-size: 1.6rem;
         border-radius: .5rem;
         cursor: pointer;
      }

      .update-form .btn:hover {
         background: var(--black);
      }
      p{
         align-items: start;
      }
   </style>
</head>
<body>
   
<?php include 'admin_header.php'; ?>

<section class="user">

   <h1 class="title">User Accounts</h1>

   <div class="box-container">
      <?php
         $select_user = mysqli_query($conn, "SELECT * FROM user LIMIT 18446744073709551615 OFFSET 1") or die('Query failed');
         while($fetch_user = mysqli_fetch_assoc($select_user)){
      ?>
      <div class="box">
         <p> User ID : <span><?php echo $fetch_user['id_user']; ?></span> </p>
         <p> Username : <span><?php echo $fetch_user['username']; ?></span> </p>
         <p> Name : <span><?php echo $fetch_user['nama']; ?></span> </p>
         <p> Email : <span><?php echo $fetch_user['email']; ?></span> </p>
         <p> Phone Number : <span><?php echo $fetch_user['no_telepon']; ?></span> </p>
         <a href="admin_user.php?update=<?php echo $fetch_user['id_user']; ?>" class="update-btn">Update User</a>
         <a href="admin_user.php?delete=<?php echo $fetch_user['id_user']; ?>" onclick="return confirm('Delete this user?');" class="delete-btn">Delete User</a>
      </div>
      <?php
         };
      ?>
   </div>
   <?php if 
   (isset($user_data)) { ?>
   <form action="admin_user.php" method="post" class="update-form">
      <input type="hidden" name="id_user" value="<?php echo $user_data['id_user']; ?>">
      <p> Username: <input type="text" name="username" value="<?php echo $user_data['username']; ?>" required> </p>
      <p> Name: <input type="text" name="nama" value="<?php echo $user_data['nama']; ?>" required> </p>
      <p> Email: <input type="email" name="email" value="<?php echo $user_data['email']; ?>" required> </p>
      <p> Phone Number: <input type="text" name="no_telepon" value="<?php echo $user_data['no_telepon']; ?>" required> </p>
      <input type="submit" name="update_user" value="Update User" class="btn">
   </form>
   <?php } ?>

</section>

<!-- Custom admin JS file link -->
<script src="js/admin_script.js"></script>

</body>
</html>
