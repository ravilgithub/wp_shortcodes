<section id="about" class="<?php echo $class ?>">

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


$args = [
	'tax_query' => [
		[
			'taxonomy'         => $term_data[ 'taxonomy' ],
			'terms'            => $term_id,
			'operator'         => $operator,
			'include_children' => $children
		]
	],
	'posts_per_page' => $limit,
	'orderby'       => $orderby,
	'order'         => $order
];

$query = new WP_Query( $args );


Bri_Shortcodes\Helper::debug( $query );


if ( $query->have_posts() ) :
	while ( $query->have_posts() ) :
		$query->the_post();
 		the_title();
 		the_permalink();
	endwhile; 
	wp_reset_postdata();
endif;

?>

</section>
