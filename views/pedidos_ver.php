<?php global $config; ?>
<h1>Meu Pedido</h1>
<table border="0" align="left" width="100%">
    <tr>
        <th>Nº do Pedido</th>
        <th>Valor Pago</th>
        <th>Forma de Pgto</th>
        <th>Status do Pgto</th>
    </tr>
    <tr>
        <td><?php echo $pedido['id']; ?></td>
        <td><?php echo "R$ ".$pedido['valor']; ?></td>
        <td><?php echo $pedido['forma_pg']; ?></td>
        <td><?php echo $config['status_pg'][$pedido['status_pg']]; ?></td> 
    </tr>
</table>
<hr>
<?php foreach($pedido['produtos'] as $prod): ?>
<div class="pedido_produto">
    <img src="/assets/images/<?php echo $prod['imagem']; ?>" border="0" width="90" height="90" />
    <?php echo utf8_encode($prod['nome']); ?>
    R$<?php echo $prod['preco']; ?>
    Quantidade:<?php echo $prod['quantidade']; ?>
</div>
<?php endforeach;  ?>
<div class="limpa"></div>


