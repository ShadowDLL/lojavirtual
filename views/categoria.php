<h2><?php echo utf8_encode($categoria); ?></h2>
<?php 
foreach ($produtos['produto'] as $produto): ?> 
<a href="/produto/ver/<?php echo $produto['id'] ?>">
    <div class="produto">
        <img src="/assets/images/<?php echo $produto['imagem'] ?>" width="170" height="200" border="0" />
    <strong><?php echo utf8_encode($produto['nome']); ?></strong><br/>
    <?php echo ("R$ ".$produto['preco']); ?>
    </div>
</a>
<?php endforeach; ?>
