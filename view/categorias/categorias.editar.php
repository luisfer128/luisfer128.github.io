<!-- incluimos Encabezado -->
<?php require_once HEADER; ?>

<div class="container">
    <h2><?php echo $titulo ?></h2>
    <div class="card card-body">

        <form action="index.php?c=categorias&f=editar" method="POST" name="formCatNuevo" id="formCatNuevo">

            <input type="hidden" name="id" id="id" value="<?php echo $categoria['cat_id']; ?>" />
            <div class="form-row">
                <div class="form-group col-sm-6">
                    <label for="nombre">Nombre</label>
                    <input type="text" name="nombre" id="nombre" value="<?php echo $categoria['cat_nombre']; ?>" class="form-control" placeholder="Nombre de la categoría" required>
                </div>

                <div class="form-group col-sm-6">
                    <label for="descripcion">Descripción</label>
                    <textarea name="descripcion" id="descripcion" class="form-control" 
                    placeholder="Descripción de la categoría" required>
                    <?php echo $categoria['cat_descripcion']; ?>
                    </textarea>
                </div>

                <div class="form-group col-sm-12">
                    <label for="estado">Estado</label>
                    <select id="estado" name="estado" class="form-control" required>
                        <option value="1" <?php if ($categoria['cat_estado'] == '1') echo 'selected'; ?>>Activo</option>
                        <option value="0" <?php if ($categoria['cat_estado'] == '0') echo 'selected'; ?>>Inactivo</option>
                    </select>
                </div>

                <div class="form-group mx-auto">
                    <button type="submit" class="btn btn-primary" onclick="return confirm('¿Estás seguro de modificar la categoría?')">Guardar</button>
                    <a href="index.php?c=categorias&f=index" class="btn btn-primary">Cancelar</a>
                </div>
            </div>
        </form>

    </div>
</div>

<!-- incluimos pie de pagina -->
<?php require_once FOOTER; ?>
