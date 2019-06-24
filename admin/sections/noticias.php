<?php
require '../libraries/data-noticias.php';

$noticias = traerProducto($db);
?>
<div id="main-panel">
    <h1>Administración de Noticias</h1>
    
    <?php
    if(isset($_SESSION['mensaje'])):
        $mensaje = $_SESSION['mensaje'];
        unset($_SESSION['mensaje']);
    ?>
    <div class="alerta"><?= $mensaje;?></div>
    <?php
    endif;
    ?>
    
    <a href="index.php?s=nueva-noticia">Crear nueva noticia</a>
    
    <table class="panel-table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Título</th>
                <th>Autor</th>
                <th>Fecha</th>
                <th>Sinopsis</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
        <?php
        foreach($noticias as $noticia):
        ?>
            <tr>
                <td><?= $noticia['id_noticia'];?></td>
                <td><?= $noticia['titulo'];?></td>
                <td><?= $noticia['id_usuario'];?></td>
                <td><?= $noticia['fecha_publicacion'];?></td>
                <td><?= $noticia['sinopsis'];?></td>
                <td>
                    <a href="index.php?s=editar-noticia&id=<?= $noticia['id_noticia'];?>">Editar</a>
                    <a href="acciones/eliminar-noticia.php?id=<?= $noticia['id_noticia'];?>" class="registro-eliminar" data-titulo="<?= $noticia['titulo'];?>">Eliminar</a>
                </td>
            </tr>
        <?php
        endforeach;
        ?>
        </tbody>
    </table>
</div>

<script>
    // Primero que nada, antes de hacer cualquier tipo
    // de manipulación del DOM, debemos esperar a que
    // cargue por completo.
    // Para esto, tenemos el evento DOMContentLoaded del
    // objeto window.
    // Asignamos un "event listener" (escuchador de 
    // eventos).
    window.addEventListener('DOMContentLoaded', function() {
        // Lo que esté acá adentro, se ejecuta cuando
        // el DOM cargue.
        var linksEliminar = document.querySelectorAll('.registro-eliminar');
        
//        console.log(linksEliminar);
        
        for(var i = 0; i < linksEliminar.length; i++) {
            linksEliminar[i].addEventListener('click', function(ev) {
                // Leemos el atributo data-titulo.
//                var titulo = this.getAttribute('data-titulo');
                var titulo = this.dataset.titulo;
                
                // El parámetro de la función (el nombre
                // es arbitrario) recibe automáticamente
                // un objeto Event de JS.
                // Objeto desde el cual podemos manipular
                // el evento u obtener información.
                var confirmado = confirm('¿Estás seguro que querés eliminar la noticia "' + titulo + '"?');
                
                if(!confirmado) {
                    // preventDefault() cancela el
                    // comportamiento nativo (default)
                    // del evento.
                    ev.preventDefault();
                }
            });
        }
    });
</script>





