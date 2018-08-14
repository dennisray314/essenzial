<?php
/**
 * Orders
 *
 * Shows orders on the account page.
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/myaccount/orders.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see 	https://docs.woocommerce.com/document/template-structure/
 * @author  WooThemes
 * @package WooCommerce/Templates
 * @version 2.6.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

do_action( 'woocommerce_before_account_orders', $has_orders ); ?>

<?php do_action( 'woocommerce_before_account_orders_pagination' ); ?>


<?php 

$user_meta=get_userdata(get_current_user_id());
    $user_roles=$user_meta->roles;
    if($user_roles[0] == 'capo_area') {

      $user_id = 'user_'.get_current_user_id();
      $user_capoarea = get_field('codice_capoarea', $user_id);


    } else if ($user_roles[0] == 'evoluter') {
      $user_id = 'user_'.get_current_user_id();
      $user_evoluter = get_field('codice_evoluter', $user_id);
    }

    ?>


<?php 
   $args = array(
    'post_type'       =>'shop_order',
    'post_status'    => 'publish',
    'posts_per_page' =>  -1,
    'order'          => 'DESC',
    'item_meta' =>  array (
    '_sku' => 'ABCD',
    ),              
    'tax_query' => array( 
     array( 'taxonomy' => 'shop_order_status',
         'field' => 'slug',
         'terms' => array (/*'Pending' , 'Failed' , */'Processing' , 'Completed'/*, 'On-Hold' , 'Cancelled' , 'Refunded'*/)
        ) 
      )             
  );
?>   

	<table class="woocommerce-MyAccount-orders shop_table shop_table_responsive my_account_orders account-orders-table">
		<thead>
			<tr>
                    <th ><?php _e('# Ordine', ' '); ?></th>
                    <th ><?php _e('Data', ' '); ?></th>
                    <th ><?php _e('Valore', ' '); ?></th>
                    <th ><?php _e('Nome', ' '); ?></th>
                    <th ><?php _e('E-mail', ' '); ?></th>
                    <th ><?php _e('Stato', ' '); ?></th>
                    <!--<th ><?php /*_e('Capoarea', ' '); */?></th>-->
                <!--<th>Prodotti acquistati</th>-->
                    <!--<th ><?php /*_e('Evoluter', ' '); */?></th>-->
			</tr>
		</thead>

		


		<tbody>
   
                <?php
                $loop = new WP_Query( $args  );
                while ( $loop->have_posts() ) : $loop->the_post(); 
                $order_id = $loop->post->ID; 
                $order = new WC_Order($order_id);
                $capoarea = get_post_meta( $order_id, 'billing_myfield16' );

				$evoluter = get_post_meta( $order_id, 'billing_myfield15' );

                $customer = new WC_Customer($order_id);
                $id_user_order = $order->user_id;
                $user = get_current_user_id();
                $user_evo = 'user_'.get_current_user_id();
                $cod_evo = get_field('codice_evoluter', $user_evo);


				if ( ($user_roles[0] == 'capo_area' && $id_user_order == $user) || ($user_roles[0] == 'capo_area') && ($user_capoarea == $capoarea[0])) :
                ?> 
                <tr class="order">
                     <td>
                     <!-- <a href="<?php echo esc_url( $order->get_view_order_url() ); ?>">  -->

                        <?php
                             //ID - order
                            if ($order->id) : ?><?php echo '#'.$order->id; ?><?php endif;?>
                     <!-- </a> -->
                    </td>


                    <td>
                        <?php echo the_time('d/m/Y'); ?>
                    </td>
                    <td>
                        <?php if ($order->order_total): $preco_format=($order->order_total);?>
                        <?php echo $trata_preco=number_format($preco_format, 2, ",", "."); ?><?php endif; ?> &euro;
                    </td>

                    <td>
                        <?php if ($order->billing_first_name) : ?><?php echo $order->billing_first_name; ?><?php endif; ?>
                        <?php if ($order->billing_last_name) : ?><?php echo $order->billing_last_name; ?><?php endif; ?>
                    </td>

                    <td>
                        <?php if ($order->billing_email) : ?><?php echo $order->billing_email; ?><?php endif; ?>
                    </td>


                    <td>
                        <?php if ($order->status) : ?><?php echo $order->status; ?><?php endif; ?>
                    </td>
                    <!--<td>
                        <?php /*echo $capoarea[0]; */?>
                    </td>-->
                    <!--<td>
                        <?php /*echo $evoluter[0]; */?>
                    </td>-->
                    <!--<td>
                      <?php /*$items = $order->get_items();
                      foreach ($items as $item) {
                        echo '<br>';
                        echo $item['name'].' '.$item['item_meta']['_qty'][0];
                      
                      }
                      */?>
                    </td>-->

               </tr> 
           <?php elseif (($user_roles[0] == 'evoluter') && (($id_user_order == $user))) : ?>

				<tr class="order">
                     <td>
                     <!-- <a href="<?php echo esc_url( $order->get_view_order_url() ); ?>"> -->
                        <?php
                             //ID - order
                            if ($order->id) : ?><?php echo '#'.$order->id; ?><?php endif;?>
                     <!-- </a> -->
                    </td>


                    <td>
                        <?php echo the_time('d/m/Y'); ?>
                    </td>
                    <td>
                        <?php if ($order->order_total): $preco_format=($order->order_total);?>
                        <?php echo $trata_preco=number_format($preco_format, 2, ",", "."); ?><?php endif; ?> &euro;
                    </td>

                    <td>
                        <?php if ($order->billing_first_name) : ?><?php echo $order->billing_first_name; ?><?php endif; ?>
                        <?php if ($order->billing_last_name) : ?><?php echo $order->billing_last_name; ?><?php endif; ?>
                    </td>

                    <td>
                        <?php if ($order->billing_email) : ?><?php echo $order->billing_email; ?><?php endif; ?>
                    </td>


                    <td>
                        <?php if ($order->status) : ?><?php echo $order->status; ?><?php endif; ?>
                    </td>
                    <td>
                        <?php echo $capoarea[0]; ?>
                    </td>
                    <td>
                        <?php echo $evoluter[0]; ?>
                    </td>

               </tr> 
           			
               	<?php endif; // $capoarea ?>
                   <?php endwhile; ?>
                   <?php wp_reset_query(); ?> 
            </tbody>
        </table>












	<?php if ( 1 < $customer_orders->max_num_pages ) : ?>
		<div class="woocommerce-Pagination">
			<?php if ( 1 !== $current_page ) : ?>
				<a class="woocommerce-Button woocommerce-Button--previous button" href="<?php echo esc_url( wc_get_endpoint_url( 'orders', $current_page - 1 ) ); ?>"><?php _e( 'Previous', 'woocommerce' ); ?></a>
			<?php endif; ?>

			<?php if ( $current_page !== intval( $customer_orders->max_num_pages ) ) : ?>
				<a class="woocommerce-Button woocommerce-Button--next button" href="<?php echo esc_url( wc_get_endpoint_url( 'orders', $current_page + 1 ) ); ?>"><?php _e( 'Next', 'woocommerce' ); ?></a>
			<?php endif; ?>
		</div>
	<?php endif; ?>



<?php do_action( 'woocommerce_after_account_orders', $has_orders ); ?>
