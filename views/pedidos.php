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
        <td><?php 
            switch ($pedido['forma_pg']) {
                case '1':
                    echo "Cortesia";
                    break;
                case '2':
                    echo "Pagseguro";
                    break;
                case '3':
                    echo "Paypal";
                    break;
                case '4':
                    echo "Boleto";
                    break;
                case '5':
                    echo "MoIP";
                    break;
            }?></td>
        <td><?php 
            switch ($pedido['status_pg']) {
                case '1':
                    echo "Aguardando Aprovação";
                    break;
                case '2':
                    echo "Aprovado";
                    break;
                case '3':
                    echo "Cancelado";
                    break;
            }?></td>
        
    </tr>
    <?php endforeach; ?>
</table>
