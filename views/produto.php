<div class="produto_foto">
    <img  src="/assets/images/<?php echo $produto['imagem'];  ?>" border="0" width="300" height="300" />
</div>
<div class="produto_info">
    <h2><?php echo utf8_encode($produto['nome']);  ?></h2> 
    <?php echo utf8_encode($produto['descricao']);  ?>
    <h3>Preço: R$ <?php echo $produto['preco'];  ?></h3>
    <a href="/carrinho/add/<?php echo $produto['id']; ?>">Adicionar ao carrinho</a>
</div>
<div class="limpa"></div>

