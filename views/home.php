<body class="home">
    <?php 
    foreach ($produtos as $produto): ?> 
    <a href="/produto/ver/<?php echo $produto['id'] ?>">
        <div class="produto">
            <img src="/assets/images/<?php echo $produto['imagem'] ?>" width="170" height="200" border="0" />
        <strong><?php echo $produto['nome'] ?></strong><br/>
        <?php echo ("R$ ".$produto['preco']); ?>
        </div>
    </a>
    <?php endforeach; ?>
</body>