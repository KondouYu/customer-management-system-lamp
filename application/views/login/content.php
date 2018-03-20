<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <?php
        $rr = rand(1, 4);
        if($rr == 1) $random = "assets/css/login.css";
        if($rr == 2) $random = "assets/css/login_2.css";
        if($rr == 3) $random = "assets/css/login_3.css";
        if($rr == 4) $random = "assets/css/login_4.css";
        ?>
        <!-- Custom CSS -->
        <?php echo link_tag('assets/css/login_3.css'); ?>
        <!-- Animate.css -->
        <?php echo link_tag("assets/css/animate.css"); ?>
    </head>

    <body>
       <form method="POST" action="/">
        <div id="input-window">
            <img src="assets/img/default-avatar.png" />
            <?php
            if(isset($_SESSION['login'])) {
            header("Location: /dashboard");
        } else {
            if (isset($_POST['submit'])) {
                //username and password sent from Form
                $username = trim($_POST['login']);
                $password = trim($_POST['password']);
                
                if ($username == '')
                    echo '<div class="alert alert-danger alert-dismissible fade in animated shake" role="alert">
  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
  <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span><strong> Błąd!</strong> Login nie może być pusty.</div>';
                
                if ($password == '')
                    echo '<div class="alert alert-danger alert-dismissible fade in animated shake" role="alert">
  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
  <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span><strong> Błąd!</strong> Hasło nie może być puste.</div>';
                
                    $query = $this->db->query("SELECT * FROM  konta WHERE login = '$username'");
                    $result = $query->row_array();
                    if ($query->num_rows() > 0 && md5($password) == $result['haslo']){
                        $sessions = array(
                            'login' => $result['login']
                        );
                        $this->session->set_userdata($sessions);
                        header('Location: /dashboard');
                        exit;
                    } else {
                        echo '<div class="alert alert-danger alert-dismissible fade in animated shake" role="alert">
  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
  <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span><strong> Błąd!</strong> Zły login lub hasło.</div>';
                    }
            }
            }
            ?>
            <input type="text" id="login" name="login" placeholder="LOGIN" required/>
            <input type="password" id="password" name="password" placeholder="••••••••••" required/>
            <input type="submit" name="submit" id="submit" value="ZALOGUJ" />
        </div>
        </form>