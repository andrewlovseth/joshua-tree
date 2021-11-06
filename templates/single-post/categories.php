<?php 

$categories = get_the_category();

$delete_item = 1;
if (($key = array_search($delete_item, $categories)) !== false) {
    unset($categories[$key]);
}

if($categories): ?>
    <div class="categories module">
        <h4>Categories</h4>

        <?php foreach($categories as $category): ?>
            <p><a href="<?php echo get_category_link($category->term_id); ?>"><?php echo $category->name; ?></a></p>
        <?php endforeach; ?>
    </div>
<?php endif; ?>