<?php  global $config; ?>

<h1>Seus Pedidos</h1>
<a class="logout" href="/login/logout">Logout</a>

<table border="0" align="left" width="100%">
    <tr>
        <th>Nº do Pedido</th>
        <th>Valor Pago</th>
        <th>Forma de Pgto</th>
        <th>Status do Pgto</th>
        <th>Ações</th>
    </tr>
    <?php foreach($pedidos as $pedido):?>
    <tr>
        <td><?php echo $pedido['id']; ?></td>
        <td><?php echo "R$ ".$pedido['valor']; ?></td>
        <td><?php echo $pedido['forma_pg']; ?></td>
        <td><?php echo $config['status_pg'][$pedido['status_pg']]; ?></td> 
        <td><a  href="/pedidos/ver/<?php echo $pedido['id']; ?>">Detalhes</a></td>
    </tr>
    <?php endforeach; ?>
</table>
