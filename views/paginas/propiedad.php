<main class="contenedor seccion contenido-centrado">
        
            <h2><?php echo $propiedad->titulo; ?></h2>
    
            
                        <img loading="lazy" src="/imagenes/<?php echo $propiedad->imagen;?>" alt="anucio" type="image/webp">
                     
    
                        <div class="resumen-propiedad">
                            <p class="precio">$<?php echo $propiedad->precio; ?></p>
    
                            <ul class="iconos-caracteristicas">
                                <li>
                                    <img class="icono" loading="lazy" src="build/img/icono_wc.svg" alt="icono wc">
                                    <p><?php echo $propiedad->banos; ?></p>
                                </li>
    
                                <li>
                                    <img class="icono" loading="lazy" src="build/img/icono_estacionamiento.svg" alt="icono estacionamiento">
                                    <p><?php echo $propiedad->estacionamiento; ?></p>
                                </li>
    
                                <li>
                                    <img class="icono" loading="lazy" src="build/img/icono_dormitorio.svg" alt="icono dormitorio">
                                    <p><?php echo $propiedad->habitaciones; ?></p>
                                </li>
    
                            </ul>

                            <?php echo $propiedad->descripcion; ?>
                        
                        </div>
    
                           


    </main>
