<main class="contenedor seccion">
    <h1 data-cy="heading-login">Iniciar Sesón</h1>

    <?php
    foreach ($errores as $error) : ?>
        <div data-cy="alerta-login"  class="alerta error"><?php echo $error; ?></div>
    <?php endforeach; ?>
    <form data-cy="formulario-login" action="" class="formulario" method="POST" action="/login">
        <fieldset>
            <legend>Email y password</legend>

            <label for="email">E-mail</label>
            <input type="email" placeholder="Tu Email" name="email" id="email">

            <label for="telefono">Passwprd</label>
            <input type="password" placeholder="Tu password" id="password" name="password">


        </fieldset>
        <input type="submit" value="Iniciar Sesión" class=" boton boton-verde">

    </form>
</main>