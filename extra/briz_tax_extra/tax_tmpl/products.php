<section id="products" class="<?php echo $class ?>">

<?php

echo '<br />term id - '   . $term_id;
echo '<br />term path - ' . $term_data[ 'tmpl_path' ];
echo '<br />taxonomy - '  . $term_data[ 'taxonomy' ];
echo '<br />operator - '  . $operator;
echo '<br />children - '  . gettype( $children );
echo '<br />limit - '     . $limit;
echo '<br />offset - '    . $offset;
echo '<br />orderby - '   . $orderby;
echo '<br />order - '     . $order;
echo '<br />meta key - '  . $meta_key;

?>

</section>
