<html>
    <head>
        <meta charset="UTF-8" />
        <link rel="stylesheet" type="text/css" href="/assets/css/bootstrap.min.css">
        <link rel="stylesheet" type="text/css" href="/assets/css/bootstrap.min.css">
        <link rel="stylesheet" href="/assets/css/style.css"/>
        <script type="text/javascript" src="/assets/js/jquery-3.1.1.min.js"></script>
        <script type="text/javascript" src="/assets/js/bootstrap.min.js"></script>
        <script type="text/javascript" src="/assets/js/angular.min.js"></script>
        <script type="text/javascript" src="/assets/js/script.js"></script>
        <!--<link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" />-->
        <!--<script type="text/javascript" src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>-->
      <title>Loja Virtual</title>  
    </head>
    <body>
        <div class="topo">
            <img src="/assets/images/banner.png" border="0" width="100%" height="100" />
        </div>
        <div class="menu">
            <div class="menuint">
                <ul>
                    <a href="/"><li>Home</li></a>
                    <a href="/empresa"><li>Empresa</li></a>
                    <?php foreach ($menu as $menuitem):  ?>
                    <a href="/categoria/ver/<?php echo($menuitem['id']); ?>"><li><?php echo utf8_encode($menuitem['titulo']); ?></li></a>
                    <?php endforeach; ?>
                    <a href="/contato"><li>Contato</li></a>
                    <a href="/pedidos"><li>Pedidos</li></a>
                </ul>
                <a href="/carrinho">
                <div class="carrinho">
                    Carrinho:<br/>
                    <?php echo (isset($_SESSION['carrinho']))?count($_SESSION['carrinho']):"0"; ?> Itens
                </div>
                </a>
            </div>
        </div>
        <div class="container">
            <?php $this->loadViewInTemplate($viewName, $viewData); ?> 
        </div>
        <div class="rodape"></div>   
             
    </body>
</html>