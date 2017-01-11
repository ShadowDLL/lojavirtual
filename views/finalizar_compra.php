<h1>Finalizar Compra</h1>
<form method="POST" id="form">
    <fieldset>
        <legend>Informações do Usuário</legend>
        Nome:<br/>
        <input type="text" name="nome" autofocus ><br/><br/>
        
        E-mail:<br/>
        <input type="email" name="email" ><br/><br/>
        
        Senha:<br/>
        <input type="password" name="senha" ><br/><br/>
        
        Telefone:<br/>
        <input type="text" name="ddd" maxlength="2" size="1"><input type="text" name="telefone" ><br/><br/>
    </fieldset><br/>
    
    <fieldset>
        <legend>Informações de Endereço</legend>
        CEP:<br/>
        <input type="text" name="endereco[cep]" /><br/><br/>
        
        Logradouro:<br/>
        <input type="text" name="endereco[logradouro]" /><br/><br/>
        
        Número:<br/>
        <input type="text" name="endereco[numero]" /><br/><br/>
        
        Complemento:<br/>
        <input type="text" name="endereco[complemento]" /><br/><br/>
        
        Bairro:<br/>
        <input type="text" name="endereco[bairro]" /><br/><br/>
        
        Cidade:<br/>
        <input type="text" name="endereco[cidade]" /><br/><br/>
        
        Estado:<br/>
        <input type="text" name="endereco[estado]" /><br/><br/>
    </fieldset><br/>
    
    <fieldset>
        <legend>Resumo da Compra</legend>
        Total a Pagar: R$ <?php echo $total; ?>
    </fieldset><br/>
    
    <fieldset>
        <legend>Informações de Pagamento</legend>
        <select name="pg_form" id="pg_form" onchange="selectPg()">
            <option value=""></option>
            <option value="CREDIT_CARD">Cartão de Crédito</option>
            <option value="BOLETO">Boleto</option>
            <option value="BALANCE">Saldo Pagseguro</option>
        </select>
        <div id="cc" style="display: none;">
            Qual a bandeira  do seu cartão?<br/>
            <div id="bandeiras" ></div>
            <br/>
            <div id="cardinfo" style="display: none;">
                Parcelamento:<br/>
                <select name="parc" id="parc"></select><br/><br/>
                
                Titular do Cartão:<br/>
                <input type="text" name="c_titular" /><br/><br/>
                
                CPF do Titular:<br/>
                <input type="text" name="c_cpf" /><br/><br/>
                
                Número do Cartão:<br/>
                <input type="text" name="cartao" id="cartao" /><br/><br/>
                
                Dígito:<br/>
                <input type="text" name="cvv" id="cvv" maxlength="4" /><br/><br/>
                
                Validade:<br/>
                <input type="text" name="validade" id="validade" />
            </div>
        </div>
    </fieldset><br/>
    
    <input type="submit" value="Efetuar Pagamento" />
    
    <input type="hidden" name="bandeira" id="bandeira" />
    <input type="hidden" name="ctoken" id="ctoken" />
    <input type="hidden" name="shash" id="shash" />
    <input type="hidden" name="sessionId" value="<?php echo $sessionId; ?>"/>
</form>

<script type="text/javascript" 
        src="https://stc.sandbox.pagseguro.uol.com.br/pagseguro/api/v2/checkout/pagseguro.directpayment.js"> 
</script>

<script type="text/javascript">
     var sessionId = '<?php echo $sessionId; ?>';
     var valor = '<?php echo $total; ?>';
     var formOk = false;
</script>

<script type="text/javascript" src="/assets/js/ckt.js"></script>














































<!--<form method="POST">
    <h1>Finalizar Compra</h1>
    
    <?php// if (!empty($aviso)): ?>
        <div class="erro"><?php //echo $aviso; ?></div>
    <?php// endif; ?> 
    
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
        <textarea name="endereco"></textarea>
    </fieldset>
    <br/>
    <fieldset>
        <legend>Resumo da Compra:</legend>
        Total a Pagar: <?php// echo $total; ?>
    </fieldset>
    <br/>
    <fieldset>
        <legend>Informações do Pagamento:</legend>
        <?php //foreach ($pagamentos as $pg): ?> 
        <input type="radio" name="pg" value="<?php //echo $pg['id']; ?>"><?php //echo utf8_encode($pg['nome']); ?><br/><br/>
        <?php //endforeach; ?>
    </fieldset>
    <input type="submit" value="Efetuar Pagamento" />
</form>