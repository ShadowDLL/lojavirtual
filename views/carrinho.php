<h1>Carrinho de Compras</h1>
<table align="left" border="0" width="100%">
    <tr>
        <th>Imagem</th>
        <th>Nome do Produto</th>
        <th>Valor</th>
        <th>Ações</th>
    </tr>
    <?php $subtotal = 0; ?>
    <?php if (isset($carrinho)) :?>
        <?php foreach($carrinho as $item): ?>
        <tr>

            <td><img src="/assets/images/<?php echo($item['imagem']);  ?>" border="0" width="60"></td>
            <td><?php echo(utf8_encode($item['nome']));  ?></td>
            <td><?php echo($item['preco']);  ?></td>
            <td>
                <a href="/carrinho/del/<?php echo $item['id']; ?>">Remover</a>
            </td>
        </tr>
        <?php $subtotal += $item['preco']; ?>
        <?php endforeach; ?>
        <tr>
            <td colspan="2" align="right">Sub-total:R$ &nbsp </td>
            <td align="left"><?php echo($subtotal);?></td>
            <td>
                <a href="carrinho/finalizar">Finalizar Compra</a>
            </td>
        </tr>
    <?php endif; ?>
    
</table>


