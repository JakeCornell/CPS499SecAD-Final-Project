<?php
   
  require 'mysql.php';
?>
<html>
  <head>
    <link rel="stylesheet" id="base" href="css/default.css" type="text/css" media="screen" />

    <title><?php echo (isset($site)) ? h($site) :"My Blog" ; ?></title>
  </head>
  <body>
    
  <div id="header">

      <h1>My Blog</h1>

    <div id="menu">
      <ul>  
        <li class="active">
            <a href="index.php"> Home  |</a> 
        </li>
 
        <li>
          <a href="admin.php">Admin</a>
        </li>
        </ul>
      </div>
    </div> 

  </div>


<?php
	show_posts();
?>


