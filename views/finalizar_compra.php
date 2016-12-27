<form method="POST">
    <fieldset>
        <legend>Informações do Usuário:</legend>
        Nome:<br/>
        <input type="text" name="nome" /><br/><br/>
        E-mail:<br/>
        <input type="email" name="email" /><br/><br/>
        Senha:<br/>
        <input type="password" name="senha" /><br/><br/>
        
    </fieldset>
    <br/>
    <fieldset>
        <legend>Informações do Endereço:</legend>
        <textarea name="textarea"></textarea>
    </fieldset>
    <br/>
    <fieldset>
        <legend>Resumo da Compra:</legend>
        Total a Pagar: <?php echo $total; ?>
    </fieldset>
    <br/>
    <fieldset>
        <legend>Informações do Pagamento:</legend>
        <?php foreach ($pagamentos as $pg): ?> 
        <input type="radio" name="pg" value="<?php echo $pg['id']; ?>"><?php echo utf8_encode($pg['nome']); ?><br/><br/>
        <?php endforeach; ?>
    </fieldset>
    <input type="submit" value="Efetuar Pagamento" />
</form>