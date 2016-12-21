<html>
    <head>
      <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
      <link rel="stylesheet" href="<?php echo BASE_URL; ?>/assets/css/style.css"/>
      <script type="text/javascript" src="<?php echo BASE_URL; ?>/assets/js/jquery-3.1.1.min.js"></script>
      <script type="text/javascript" src="<?php echo BASE_URL; ?>/assets/js/bootstrap.min.js"></script>
      <script type="text/javascript" src="<?php echo BASE_URL; ?>/assets/js/angular.min.js"></script>
      <script type="text/javascript" src="<?php echo BASE_URL; ?>/assets/js/script.js"></script>
      <!--<link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" />-->
      <!--<script type="text/javascript" src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>-->
      <title>Titulo do Site</title>  
    </head>
    <body>
        <div class="container">      
            <?php $this->loadViewInTemplate($viewName, $viewData); ?>
        </div>    
    </body>
</html>