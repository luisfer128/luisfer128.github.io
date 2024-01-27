<?php require_once HEADER; ?>

<div class="container">
<h2> <?php echo $titulo?></h2>
    <div class="row">
        <div class="col-sm-6">
            <form action="index.php?c=categorias&f=buscar" method="POST">
                <input type="text" name="b" id="busqueda" placeholder="Buscar categoria..."/>
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-search"></i> Buscar
                </button>
            </form>       
        </div>
        <div class="col-sm-6 d-flex flex-column align-items-end">
            <a href="index.php?c=categorias&f=ver_nuevo"> 
                <button type="button" class="btn btn-primary">
                    <i class="fas fa-plus"></i> Agregar Categoria
                </button>
            </a>
        </div>
    </div>
    <div class="table-responsive mt-2">
        <table class="table table-striped table-bordered">
            <thead class="thead-dark">
            <th>Código</th>
            <th>Nombre</th>
            <th>Categoría</th>
            <th>Estado</th>
            <th>Fecha Actualizacion</th>
            <th>Acciones</th>
            </thead>
            <tbody class="tabladatos">
                <?php 
                
                foreach ($resultado ?? array() as $fila) {
                  ?>
                <tr>
                    <td><?php echo $fila->cat_id; ?></td>
                    <td><?php echo $fila->cat_nombre; ?></td>
                    <td><?php echo $fila->cat_descripcion; ?></td>
                    <td><?php echo $fila->cat_estado; ?></td>
                    <td><?php echo $fila->cat_fechaActualizacion; ?></td>
                    <td>
                    <a class="btn btn-primary" href="index.php?c=categorias&f=ver_edicion&id=
                        <?php echo $fila->cat_id; ?>">
                        <i class="fas fa-edit"></i> Editar
                    </a>
                    <a class="btn btn-danger" 
                        onclick="if(!confirm('¿Estás seguro de eliminar esta categoría?')) return false;" 
                        href="index.php?c=categorias&f=eliminar&id=
                        <?php echo $fila->cat_id; ?>">
                        <i class="fas fa-trash-alt"></i> Eliminar
                    </a>
                    </td>
                </tr>
                <?php  }?>
            </tbody>
        </table>
    </div>
</div>

<?php  require_once FOOTER ?>