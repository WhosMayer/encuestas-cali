<section class="panel acceso">
    <p class="sobrelinea">Área de trabajo</p>
    <h1>Iniciar sesión</h1>
    <p>Usa tu cuenta del equipo de encuestas.</p>
    <form method="post">
        <input type="hidden" name="csrf" value="<?= e($_SESSION['csrf']) ?>">
        <label>Usuario <input name="usuario" autocomplete="username" required></label>
        <label>Contraseña <input type="password" name="clave" autocomplete="current-password" required></label>
        <button name="accion" value="entrar">Entrar</button>
    </form>
</section>
