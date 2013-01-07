<?php /**
 * @package Simple Resources Plugin
 * @version 0.6
 */
/*
Plugin Name: Simple Resources Plugin
Plugin URI: http://freedomonlineservices.net
Description: Adds a resources post type and simple php calls to display them.
Author: Rob Kay
Version: 0.6
Author URI: http://freedomonlineservices.net
*/

    add_action( 'wp_enqueue_scripts', 'prefix_add_my_stylesheet' );
    function prefix_add_my_stylesheet() {
        // Respects SSL, Style.css is relative to the current file
        wp_register_style( 'resources-style', plugins_url('resources-styles.css', __FILE__) );
        wp_enqueue_style( 'resources-style' );
    }

// Portfolio post type

function post_type_resources() {
// Creates Resources post type
register_post_type('resource', array(
'label' => 'Resources',
'public' => true,
'show_ui' => true,
'capability_type' => 'post',
'hierarchical' => false,
'rewrite' => array('slug' => 'resources/%restype%'),
'query_var' => true,
'supports' => array('title', 'editor', 'excerpt', 'thumbnail', 'comments','custom-fields'),
) );

register_taxonomy(
'restype',
'resource',
array('label' => 'Types', 'rewrite' => array('slug' => 'resources','with_front' => FALSE), 
'hierarchical' => true)
);

}

add_action('init', 'post_type_resources');

add_filter('post_link', 'restype_permalink', 10, 3);
add_filter('post_type_link', 'restype_permalink', 10, 3);

function restype_permalink($permalink, $post_id, $leavename) {
if (strpos($permalink, '%restype%') === FALSE) return $permalink;

// Get post
$post = get_post($post_id);
if (!$post) return $permalink;

// Get taxonomy terms
$terms = wp_get_object_terms($post->ID, 'restype');
if (!is_wp_error($terms) && !empty($terms) && is_object($terms[0])) $taxonomy_slug = $terms[0]->slug;
else $taxonomy_slug = 'unclassified';

return str_replace('%restype%', $taxonomy_slug, $permalink);
}

function resource_bar($allornothing = '')
{
$thisterm = get_term_by( 'slug', get_query_var( 'term' ), get_query_var( 'taxonomy' ) );

echo '<div class="breadcrumb breadcrumbs">Browse: <a href="'.get_bloginfo('url').'">Home</a> / <a href="'.get_bloginfo('url').'/Resources">Resources</a> / ';
if($allornothing=='all')
echo 'All';
else
echo '<a href="'.get_bloginfo('url').'/resources/">All</a>';

$shelves = get_terms('restype', 'orderby=name&fields=all&parent=0');
foreach($shelves as $child) :
if($child->slug==$thisterm->slug)
{
echo "&nbsp;|&nbsp;".$thisterm->name;
}
else
echo "&nbsp;|&nbsp;".'<a href="'.get_bloginfo('url').'/resources/'.$child->slug.'/">'.$child->name.'</a>';
endforeach;
echo "</div>";
}

function getresources()
{
?>
<div class="resource"><table>

<tr>
<td width="170px">
<?php the_post_thumbnail('thumbnail') ?>
</td>
<td>
<strong style="margin: 0px; padding: 0px;"><?php the_title(); ?></strong>
<?php the_excerpt(); ?>
<a href="<?php the_permalink(); ?>">Read More</a>
</td>
</tr>
</table></div>
<?php }

function get_tax_resources() {
	?><div class="resources"><?php
	resource_bar('');
$child = get_term_by( 'slug', get_query_var( 'term' ), get_query_var( 'taxonomy' ) );

query_posts( array('post_type' => 'resource', 'orderby' => 'date',
				'order' => 'ASC',
				'restype' => $child->slug));
if ( have_posts() ) while ( have_posts() ) : the_post();
getresources();
endwhile;
?></div><?php
}

function get_all_resources() {?>
<div class="resources"><?php
	resource_bar('all');

if ( have_posts() ) : while ( have_posts() ) : the_post();
the_content();
endwhile;
endif;

$allterm = get_term_by( 'slug', 'all', 'restype' );
$child_terms = get_terms('restype', 'orderby=name&fields=all&parent=0&exclude='.$allterm->term_id);
foreach($child_terms as $child) :

echo '<h3>';
echo $child->name.'<br />';
echo '</h3>';

query_posts( array('post_type' => 'resource', 'orderby' => 'date',
				'order' => 'ASC',
				'restype' => $child->slug));
if ( have_posts() ) while ( have_posts() ) : the_post();

getresources();

endwhile;
	?>
<br />
<?php
endforeach;
	?> </div> <?php
}

?>
