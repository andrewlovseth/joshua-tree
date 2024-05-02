<?php 

    $leaders = get_field('leaders'); 

    if( $leaders ):
    
?>

    <section class="market-info grid">
        <div class="market-leaders">
            <div class="section-header">
                <h3 class="section-headline">Connect with our team</h3>
            </div>
            
            <div class="leader-grid">

                <?php foreach( $leaders as $leader ): ?>

                    <?php
                        $args = [ 'leader' => $leader ];
                        get_template_part('templates/single-market/market-leader', null, $args);
                    ?>

                <?php endforeach; ?>
                
            </div>            
        </div>
    </section>

<?php endif; ?>