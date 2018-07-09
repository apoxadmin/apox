<?php
get_header();

remove_action( 'woocommerce_before_shop_loop_item', 'woocommerce_template_loop_product_link_open', 10 );
remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_product_link_close', 5 );

remove_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_show_product_loop_sale_flash', 10);
remove_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_thumbnail', 10);

remove_action( 'woocommerce_shop_loop_item_title', 'woocommerce_template_loop_product_title', 10 );

remove_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_price', 10 );
remove_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_rating', 5 );
remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_product_link_close', 5 );
remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 10 );

//remove_action( 'woocommerce_before_single_product_summary', 'woocommerce_show_product_sale_flash', 10 );
//add_action( 'peony_show_product_sale_flash', 'woocommerce_show_product_sale_flash', 10 );

add_action( 'woocommerce_before_shop_loop_item', 'peony_before_shop_loop_item', 10 );
add_action( 'woocommerce_after_shop_loop_item', 'peony_after_shop_loop_item', 5 );

add_action( 'woocommerce_before_shop_loop_item_title', 'peony_before_shop_loop_item_title', 10);

add_action( 'woocommerce_shop_loop_item_title', 'peony_template_loop_product_title', 10 );

add_action( 'peony_template_loop_add_to_cart', 'woocommerce_template_loop_add_to_cart', 10 );


add_filter( 'woocommerce_product_add_to_cart_text', 'peony_product_single_add_to_cart_text', 100 );


add_action( 'peony_template_loop_price', 'woocommerce_template_loop_price', 10 );
add_action( 'peony_template_loop_rating', 'woocommerce_template_loop_rating', 5 );


function peony_before_shop_loop_item() 
{
    $return = '<div class="product-inner">';
    echo $return;
}
	
function peony_after_shop_loop_item()
{
    $return = '</div>';
    echo $return;
}
	
function peony_product_single_add_to_cart_text()
{
    return '<i class="fa fa-shopping-cart"></i><i class="fa fa-check"></i>';
}

function peony_wcwl_add_wishlist_on_loop()
{
    echo do_shortcode('[yith_wcwl_add_to_wishlist]');
}
	
if (defined('YITH_WCWL')) {
    add_action( 'peony_add_to_wishlist', 'peony_wcwl_add_wishlist_on_loop', 15 );
}

function peony_before_shop_loop_item_title()
{
    global $post, $product, $woocommerce, $wishlists;

	$id               = get_the_ID();
	$size             = 'shop_catalog';
	$gallery          = get_post_meta($id, '_product_image_gallery', true);
	$attachment_image = '';

	if (!empty($gallery)) {
		$gallery          = explode( ',', $gallery );
		$first_image_id   = $gallery[0];
		$attachment_image = wp_get_attachment_image( $first_image_id, $size, false, array( 'class' => 'hover-image' ) );
	}

	if (has_post_thumbnail()) {
		$thumb = get_the_post_thumbnail(get_the_ID(), "shop_catalog"); 

		$product_image = '<div class="product-image-front">
							  '.$thumb.'
						  </div>
						  <div class="product-image-back">
							  '.$attachment_image.'
						  </div>';
	} else {
		$product_image = '<img src="'. woocommerce_placeholder_img_src() .'" alt="Placeholder" width="'.$placeholder_width.'" height="'.$placeholder_height.'" />';
	}
	
	$onsale = '';
	if ($product->is_on_sale()) : 
		$onsale = apply_filters( 'woocommerce_sale_flash', '<span class="onsale">' . __( 'Sale!', 'peony' ) . '</span>', $post, $product ); 
	endif; 

    $add_to_cart_link_class =  implode( ' ', array_filter( array(
					//	'product_type_' . $product->product_type,
						$product->is_purchasable() && $product->is_in_stock() ? 'add_to_cart_button' : '',
						$product->supports( 'ajax_add_to_cart' ) ? 'ajax_add_to_cart' : ''
				) ) );
	echo  $onsale.'<div class="product-image">
					  '.$product_image.'
					  <a href="javascript:;" class="product-image-overlay">
					  </a>
					  <div class="product-image-action">
						  <ul>
							  <li>
								  <a href="' . get_the_permalink() . '" class="woocommerce-LoopProduct-link"><i class="fa fa-eye"></i></a>
							  </li>
							  <li>';
							  do_action( 'peony_template_loop_add_to_cart',array('class'=>$add_to_cart_link_class) );
								  
	echo '</li>
							  <li>';
								  
                        do_action( 'peony_add_to_wishlist' );

	echo '</li>
						  </ul>
					  </div>
				  </div>';
}
	
function peony_template_loop_product_title()
{
    echo '<div class="product-info">
                <a href="' . get_the_permalink() . '">      
                    <h3 class="entry-title">'.get_the_title().'</h3>
                    <div class="clearfix">
                        <div class="pull-left">';
                            
                            
                            do_action( 'peony_template_loop_price' );
                            
    echo '</div>
                        <div class="pull-right">';
                            
                            do_action( 'peony_template_loop_rating' );
                            
    echo '</div>
                    </div>
                </a>
            </div>';
                                                

    
}
?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
<?php peony_make_page_title_bar(WOOCOMMERCE_TITLE_BAR); ?>
<div class="post-wrap">
<div class="container">
<div class="page-inner row no-aside">
<div class="col-main">
	<section class="page-main" role="main" id="content">
	<div class="page-content">
	<?php woocommerce_content(); ?>
	</div>
</div>
</div>
</div>
</div>
</div>
</article>
<?php
get_footer();