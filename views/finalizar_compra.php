<script type="text/javascript">
    preencheUF();
</script>
<h1>Finalizar Compra</h1>
<?php if (!empty($erro)): ?>
    <h3><?php echo $erro; ?></h3>
<?php endif; ?>
<form method="POST" id="form" onsubmit="return pagar()"><!--Evitar o envio da primeira vez -->
    <fieldset>
        <legend>Informações do Usuário</legend>
        
        <input type="text" name="nome" placeholder="Nome" size="50"  autofocus ><br/><br/>
        
        <input type="email" name="email" placeholder="E-mail" size="50" ><br/><br/>
        
        <input type="password" name="senha" placeholder="Senha" ><br/><br/>
     
        <input type="text" name="ddd" placeholder="DDD" maxlength="2" size="1">&nbsp;<input type="text" name="telefone" placeholder="Telefone" id="telefone" maxlength="9" size="7"><br/><br/>
    </fieldset><br/>
    
    <fieldset>
        <legend>Informações de Endereço</legend>
        <input type="text" name="endereco[cep]" id="cep" placeholder="CEP" onkeyup="getCep()" maxlength="8" size="6" /><br/><br/>

        <input type="text" name="endereco[logradouro]" id="logradouro" placeholder="Logradouro" size="50"/>
 
        <input type="text" name="endereco[numero]" id="numero" placeholder="Número" size="6" /><br/><br/>
 
        <input type="text" name="endereco[complemento]" placeholder="Complemento" size="50" /><br/><br/>
    
        <input type="text" name="endereco[bairro]" id="bairro" placeholder="Bairro" size="50" /><br/><br/>
        
        <input type="text" name="endereco[cidade]" id="localidade" placeholder="Cidade" size="50" />
        
        <select name="endereco[estado]" id="uf" >
            <option value="SP">SP</option>>
        </select>
        
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
                
                <input type="text" name="c_titular" placeholder="Titular do Cartão" /><br/><br/>
                
                <input type="text" name="c_cpf" placeholder="CPF do Titular" /><br/><br/>
                
                <input type="text" name="cartao" placeholder="Número do Cartão" id="cartao" /><br/><br/>
                
                <input type="text" name="cvv" placeholder="cvv" id="cvv" maxlength="4" /><br/><br/>
                
                <input type="text" name="validade" placeholder="Validade" id="validade" />
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