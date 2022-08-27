<fieldset>
    <legend>Informacion general</legend>
    <label for="nombre">Nombre</label>
    <input type="text" id="mombre" name="vendedor[nombre]" value="<?php echo s($vendedor->nombre); ?>" placeholder="Nombre del vendedor">

    <label for="apellido">Apellido</label>
    <input type="text" id="apellido" name="vendedor[apellido]" value="<?php echo s($vendedor->apellido); ?>" placeholder="apellido del vendedor">
    
</fieldset>
<fieldset>

    <label for="telefono">Telefono</label>
    <input type="text" id="telefono" name="vendedor[telefono]" value="<?php echo s($vendedor->telefono); ?>" placeholder="telefono del vendedor">


</fieldset>