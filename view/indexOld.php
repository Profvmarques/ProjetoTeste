<?php
session_start();
$_SESSION = array();
session_destroy();
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ouvidoria</title>
    <!-- Core CSS - Include with every page -->
    <link href="../css/bootstrap.min.css" rel="stylesheet">
    <link href="../font-awesome/css/font-awesome.css" rel="stylesheet">
    <!-- SB Admin CSS - Include with every page -->
    <link href="../css/sb-admin.css" rel="stylesheet">
<style type="text/css">
    body
        {
            background-image: url("../imagens/FundoOuvidoria3.jpg");
            background-repeat: no-repeat;
            background-position: center center;
            background-attachment: fixed;
            -webkit-background-size: cover;
            -moz-background-size: cover;
            -o-background-size: cover;
            background-size: cover;
        }

    h1
        {
            /*text-shadow: 3px 3px 3px #737373;*/
            text-shadow: 2px 2px 2px #FFFFFF;


        }

    #painelLogin
        {
            opacity: 0.6;
            -webkit-transition: opacity 0.2s ease-in-out;
            -moz-transition: opacity 0.2s ease-in-out;
            -o-transition: opacity 0.2s ease-in-out;
            transition: opacity 0.2s ease-in-out;
            -webkit-box-shadow: 5px 5px 5px 5px rgba(0,0,0,0.3);
            box-shadow: 5px 5px 5px 5px rgba(0,0,0,0.3);
            
        }

    #painelLogin:hover
    {
        opacity: 1;
        
    }
    h5
    {
        position: fixed;
        left: 20px;
        bottom: 10px;
    }

</style>

</head>
<body>


    <div class="container">

        <div class="row">
            
            <h1 class="text-center" id=""><strong>Sistema de Ouvidoria</strong></h1>

            <form method='post' action='../controle/login.php'>
              <div class="col-md-4 col-md-offset-4">
                 
                  <div class="login-panel panel panel-default" id="painelLogin">
                      <div class="panel-heading">
                          <h3 class="panel-title">Efetuar Login</h3>
                      </div>

                      <div class="panel-body">
                          <form role="form">
                              <div class="alert alert-success alert-dismissable hide" id="success">
                                  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                              </div>
                              <div class="alert alert-info alert-dismissable hide" id="info">
                                  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                              </div>
                              <div class="alert alert-warning alert-dismissable hide" id="erro">
                                  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                              </div>
                              <fieldset>
                                  <div class="form-group">
                                      <input class="form-control" id="login" placeholder="Login" name="login" type="text" autofocus>
                                  </div>
                                  <div class="form-group">
                                      <input class="form-control" id="senha" placeholder="Senha" name="senha" type="password" value="">
                                  </div>
                              <!--
                                  <div class="checkbox">
                                      <label>
                                          <input name="remember" type="checkbox" value="Remember Me">Remember Me
                                      </label>
                                  </div>
                              -->
                                  <!-- Change this to a button or input when using this as a form -->
                                  <button type="submit" class="btn btn-lg btn-success btn-block" id="btnLogin">Login</button>
                              </fieldset>
                          </form>
                      </div>
                  </div>
              </div>
            </form>
            
        </div>
            <div id="img">
                 <div id="imgfaetec"></div>
                 <div id="imgdgi"></div>
                 <div id="imgouvidoria"></div>
            </div>
            
    </div>
    <!-- Core Scripts - Include with every page -->
    <script src="js/jquery-1.10.2.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/plugins/metisMenu/jquery.metisMenu.js"></script>

    <!-- SB Admin Scripts - Include with every page -->

</body>
</html>
