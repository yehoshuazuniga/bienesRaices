<main class="contenedor seccion">
    <h1>Administrador de bienes raices</h1>
    <?php
    if ($resultado) {
        $mensaje = muestaNotificaion(intval($resultado));
        if ($mensaje) {
    ?>
            <p class="alerta exito"><?php echo s($mensaje); ?></p>
    <?php }
    }
    ?>
    <a href="propiedades/crear" class="boton boton-verde"> Nueva propiedad</a>
    <a href="vendedores/crear" class="boton boton-amarillo"> Nuevo vendedor</a>
    <h2>Propiedades</h2>
    <table class="propiedades">
        <thead>
            <tr>
                <th>ID</th>
                <th>Titulo</th>
                <th>Imagen</th>
                <th>Precio</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <!-- Resultados de la consulta bbdd -->
            <?php foreach ($propiedades as $propiedad) : ?>
                <tr>
                    <td> <?php echo $propiedad->id; ?> </td>
                    <td><?php echo $propiedad->titulo; ?></td>
                    <td><img src="<?php echo '/imagenes/' . $propiedad->imagen; ?>" alt="" class="imagen-tabla"></td>
                    <td> $<?php echo $propiedad->precio; ?></td>
                    <td>
                        <form method="POST" class="w-100" action="propiedades/eliminar">
                            <input type="submit" value="Eliminar" class="boton-rojo-block">
                            <input type="hidden" name="id" value="<?php echo $propiedad->id; ?>">
                            <input type="hidden" name="tipo" value="propiedad">
                        </form>
                        <a href="propiedades/actualizar?id=<?php echo $propiedad->id; ?>" class="boton-verde-block">Actualizar</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <h2>Vendedores</h2>
    <table class="propiedades">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Telefono</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <!-- Resultados de la consulta bbdd -->
            <?php foreach ($vendedores as $vendedor) : ?>
                <tr>
                    <td> <?php echo $vendedor->id; ?> </td>
                    <td><?php echo $vendedor->nombre; ?></td>
                    <td> $<?php echo $vendedor->telefono; ?></td>
                    <td>
                        <form method="POST" class="w-100" action="vendedores/eliminar">
                            <input type="submit" value="Eliminar" class="boton-rojo-block">
                            <input type="hidden" name="id" value="<?php echo $vendedor->id; ?>">
                            <input type="hidden" name="tipo" value="vendedor">
                        </form>
                        <a href="vendedores/actualizar?id=<?php echo $vendedor->id; ?>" class="boton-verde-block">Actualizar</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</main>