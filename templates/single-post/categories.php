<?php 

$categories = get_the_category();

if($categories): ?>
    <div class="categories module">
        <h4>Categories</h4>

        <?php foreach($categories as $category): ?>
            <?php if($category->name != 'Default'): ?>
                <p><a href="<?php echo get_category_link($category->term_id); ?>"><?php echo $category->name; ?></a></p>
            <?php endif; ?>
        <?php endforeach; ?>
    </div>
<?php endif; ?>