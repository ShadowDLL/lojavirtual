<h1>Contato</h1>
<form method="POST" class="contato">
    <?php if (isset($msg)): ?>
    <div class="aviso"><?php echo $msg; ?></div>
    <?php endif; ?>
    Seu nome:<br/>
    <input type="text" name="nome" autofocus /><br/><br/>
    
    Seu e-mail:<br/>
    <input type="email" name="email" /><br/><br/>
    
    Mensagem:<br/>
    <textarea name="msg"></textarea><br/><br/>
    
    <input type="submit" value="Enviar Mensagem" />
</form>