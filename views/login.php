<form method="POST">
    <?php if (!empty($aviso)):?>
        <div class="alert alert-danger fade in">
            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
            <?php echo $aviso; ?></div>
    <?php endif; ?>
    <h1>Página de Login</h1>
    E-mail:<br/>
    <input type="email" name="email" /><br/><br/>
    Senha:<br/>
    <input type="password" name="senha" /><br/><br/>
    <input type="submit" value="Login" />
</form>

