<fieldset>
    <legend>Informacion general</legend>
    <label for="titulo">Titulo</label>
    <input type="text" id="titulo" name="propiedad[titulo]" value="<?php echo s($propiedad->titulo); ?>" placeholder="Titulo de la propiedad">
    <label for="precio">Precio</label>
    <input type="text" id="precio" name="propiedad[precio]" value="<?php echo s($propiedad->precio); ?>" placeholder="Precio de la propiedad">
    <label for="imagen">Imagen:</label>
    <input type="file" id="imagen<" accept="image/jpeg, image/png" name="propiedad[imagen]">
    <?php if ($propiedad->imagen) : ?>

        <img src="/imagenes/<?php echo $propiedad->imagen; ?>" alt="" class=imagen-small>
    <?php endif; ?>
    <label for="descripcion">Descripción</label>
    <textarea id="descripcion" name="propiedad[descripcion]"><?php echo s($propiedad->descripcion); ?></textarea>
</fieldset>
<fieldset>
    <legend>Informacion de la propiedad</legend>
    <label for="habitaciones">Habitaciones</label>
    <input type="number" id="habitaciones" name="propiedad[habitaciones]" value="<?php echo s($propiedad->habitaciones); ?>" placeholder="EJ: 3 " min="1" max="9">
    <label for="wc">Baños</label>
    <input type="number" id="=" wc" name="propiedad[wc]" value="<?php echo s($propiedad->wc); ?>" placeholder="EJ: 3 " min="1" max="9">
    <label for="estacionamiento">Estacionamiento</label>
    <input type="number" id="=" estacionamiento" name="propiedad[estacionamiento]" value="<?php echo s($propiedad->estacionamiento); ?>" placeholder="EJ: 3 " min="1" max="9">
</fieldset>
<fieldset>
    <legend>Vendedor</legend>
    <label for="vendedor">Vendedor</label>
    <select name="propiedad[vendedores_id]" id="vendedor">
        <option value="" selected> ---- Seleccione vendedores ----</option>
        <?php foreach ($vendedores as $vendedor) : ?>
            <option <?php echo $propiedad->vendedores_id === $vendedor->id ? 'selected' : ''; ?>
             value="<?php echo s($vendedor->id) ?>"> <?php echo s($vendedor->nombre) . ' ' . s($vendedor->apellido) ?>
            <?php endforeach; ?>
    </select>
</fieldset>
