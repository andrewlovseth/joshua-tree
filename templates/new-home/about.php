<?php 

    $about = get_field('about');
    $headline = $about['headline'];
    
?>

<section class="about grid">

    <div class="headline">
        <h1><?php echo $headline; ?></h1>
    </div>
   
</section>