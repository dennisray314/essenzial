<?php
ob_clean();
ob_start();

/**
 * INCLUDES
 */
include( get_stylesheet_directory() . '/helper-functions.php' );
include( get_stylesheet_directory() . '/codice-fiscale-class.php' );
include( get_stylesheet_directory() . '/googletag-functions.php' );
include( get_stylesheet_directory() . '/essenzial-admin-page-class.php' );
//include( get_stylesheet_directory() . '/natale-functions-class.php' );


function write_log($txt){
	
	$logfile = fopen( "essenzial-debug.log", "a");
	$message = date('m.d.Y H:i:s') . ' - ' . $txt . PHP_EOL;
	return fwrite($logfile,  $message );
}

add_filter( 'x_enqueue_parent_stylesheet', '__return_true' );

function inserisci_scripts() {
    wp_enqueue_style( 'spectral', 'https://fonts.googleapis.com/css?family=Spectral' );
    wp_enqueue_script('sconti2x1', get_stylesheet_directory_uri() . '/sconti2x1.js', array('jquery'), true );
    
}

add_action( 'wp_enqueue_scripts', 'inserisci_scripts' );


if( is_admin() ) {
    $essenzial_settings_page = new EssenzialPage();
}


function payment_gateway_disable_contrassegno( $available_gateways ) {
    global $woocommerce;
    $items = $woocommerce->cart->get_cart();

    foreach($items as $item => $values) {
        $_product = $values['data'];
        $sku = $values['data']->get_sku();
        $check = strstr(strtolower($sku), 'orig');


        if ( isset( $available_gateways['cod'] ) && ($check !== FALSE) ) {
            unset( $available_gateways['cod'] );
            break;
        }
    }
    return $available_gateways;

}
add_filter( 'woocommerce_available_payment_gateways', 'payment_gateway_disable_contrassegno' );








function custom_override_checkout_fields( $fields ) {

    $fields['billing']['billing_address_1']['class'] = array('form-row-first address-field');

    script_togli_campi_evoluter();

    unset($fields['billing']['billing_company']);
    unset($fields['shipping']['shipping_company']);
    unset($fields['billing']['billing_address_2']);
    // Our hooked in function - $fields is passed via the filter!


    return $fields;

}

add_filter('woocommerce_checkout_fields','custom_override_checkout_fields');

add_action('woocommerce_checkout_process', 'my_custom_checkout_field_process');

add_action( 'woocommerce_checkout_update_order_meta', 'my_custom_checkout_field_update_order_meta' );

function my_custom_checkout_field_update_order_meta( $order_id ) {


    $user_id = 'user_'.get_current_user_id();
    $user_capoarea = get_field('capoarea', $user_id);
    $evo_id = get_field('codice_evoluter', $user_id);

    $user_meta=get_userdata(get_current_user_id());
    $user_roles=$user_meta->roles;

    if($user_roles[0] == 'capo_area') {


        if ( ! empty( $_POST['billing_myfield15'] ) ) {
            update_post_meta( $order_id, 'billing_myfield15', sanitize_text_field( $_POST['billing_myfield15'] ) );
        } /*else {
            update_post_meta( $order_id, 'billing_myfield15', sanitize_text_field( $_POST['billing_myfield15'] ) );
        }*/

        update_post_meta( $order_id, 'billing_myfield16', get_field('codice_capoarea', $user_id) );

        /*if ( ! empty( $_POST['billing_myfield16'] ) ) {
            update_post_meta( $order_id, 'billing_myfield16', sanitize_text_field( $_POST['billing_myfield16'] ) );
        } else {
            update_post_meta( $order_id, 'billing_myfield16', sanitize_text_field( $_POST['billing_myfield16'] )  );
        }*/

    } elseif ($user_roles[0] == 'evoluter') {

        update_post_meta( $order_id, 'billing_myfield15', $evo_id );
        update_post_meta( $order_id, 'billing_myfield16', $user_capoarea );

        /*if ( ! empty( $_POST['billing_myfield15'] ) ) {
            update_post_meta( $order_id, 'billing_myfield15', $evo_id );
        } else {
            update_post_meta( $order_id, 'billing_myfield15', $evo_id );
        }

        if ( ! empty( $_POST['billing_myfield16'] ) ) {
            update_post_meta( $order_id, 'billing_myfield16', $user_capoarea );
        } else {
            update_post_meta( $order_id, 'billing_myfield16', $user_capoarea  );
        }*/

    }

    if ( ! empty( $_POST['codice_fiscale'] ) ) {
        update_post_meta( $order_id, 'codice_fiscale', sanitize_text_field( $_POST['codice_fiscale'] ) );
    } 
    elseif (!empty($_POST['billing_myfield11'])) {
    	update_post_meta( $order_id, 'codice_fiscale', sanitize_text_field( $_POST['billing_myfield11'] ) );
    }
    else {
        //update_post_meta( $order_id, 'codice_fiscale', sanitize_text_field( 'TGNBRB70A65L833N' ) );

        $cf = new CF();
        $nome = sanitize_text_field( $_POST['billing_first_name'] );
        $cognome = sanitize_text_field( $_POST['billing_last_name'] );
        $data = '09/'.rand(1,12).'/'.rand(1920,2000);
        $sesso = 'F';
        $comune = 'Viareggio'; //L833

        $codiceFiscale = $cf->calcola($nome, $cognome, $data, $sesso, $comune);
        if ($codiceFiscale==false) $codiceFiscale = get_option('essenzial_options')['codiceFiscale'];

        update_post_meta( $order_id, 'codice_fiscale', $codiceFiscale );
    }
}


/**
 * Display field value on the order edit page
 */
add_action( 'woocommerce_admin_order_data_after_billing_address', 'my_custom_checkout_field_display_admin_order_meta', 10, 1 );

function my_custom_checkout_field_display_admin_order_meta($order){
    echo "<p><strong>Data di Nascita:</strong> " . get_post_meta( $order->id, 'data', true ) . "</p><br>";
    echo "<p><strong>Codice Fiscale:</strong> " . get_post_meta( $order->id, 'codice_fiscale', true ) . "</p><br>";
    echo "<p><strong>Num. Civico:</strong> " . get_post_meta( $order->id, 'numero_civico', true ) . "</p><br>";
    echo "<p><strong>Evoluter:</strong> " . get_post_meta( $order->id, 'billing_myfield15', true ) . "</p><br>";
    echo "<p><strong>Capoarea:</strong> " . get_post_meta( $order->id, 'billing_myfield16', true ) . "</p><br>";
}

// MINIMUM ORDER

add_action( 'woocommerce_checkout_process', 'wc_minimum_order_amount' );
add_action( 'woocommerce_before_cart' , 'wc_minimum_order_amount' );

function wc_minimum_order_amount() {
    // Set this variable to specify a minimum order value
    $minimum = 10;

    if ( WC()->cart->total < $minimum ) {

        if( is_cart() ) {

            wc_print_notice(
                sprintf( 'Devi raggiungere un minimo di ordine di 8,90 €' ,
                    wc_price( $minimum ),
                    wc_price( WC()->cart->total )
                ), 'error'
            );

        } else {

            wc_add_notice(
                sprintf( 'Devi raggiungere un minimo di ordine di 8,90 €' ,
                    wc_price( $minimum ),
                    wc_price( WC()->cart->total )
                ), 'error'
            );

        }
    }

}
//Add sidebar to single product
// =============================================================================

if ( ! function_exists( 'x_get_content_layout' ) ) :
    function x_get_content_layout() {

        $stack          = x_get_stack();
        $content_layout = x_get_option('x_layout_content', 'content-sidebar' );

        if ( $content_layout != 'full-width' ) {
            if ( is_home() ) {
                $opt    = x_get_option( 'x_blog_layout', 'sidebar' );
                $layout = ( $opt == 'sidebar' ) ? $content_layout : $opt;
            } elseif ( is_singular( 'post' ) ) {
                $meta   = get_post_meta( get_the_ID(), '_x_post_layout', true );
                $layout = ( $meta == 'on' ) ? 'full-width' : $content_layout;
            } elseif ( x_is_portfolio_item() ) {
                $layout = 'full-width';
            } elseif ( x_is_portfolio() ) {
                $meta   = get_post_meta( get_the_ID(), '_x_portfolio_layout', true );
                $layout = ( $meta == 'sidebar' ) ? $content_layout : $meta;
            } elseif ( is_page_template( 'template-layout-content-sidebar.php' ) ) {
                $layout = 'content-sidebar';
            } elseif ( is_page_template( 'template-layout-sidebar-content.php' ) ) {
                $layout = 'sidebar-content';
            } elseif ( is_page_template( 'template-layout-full-width.php' ) ) {
                $layout = 'full-width';
            } elseif ( is_archive() ) {
                if ( x_is_shop() || x_is_product_category() || x_is_product_tag() || x_is_product() ) {
                    $opt    = x_get_option( 'x_woocommerce_shop_layout_content','sidebar' );
                    $layout = ( $opt == 'sidebar' ) ? $content_layout : $opt;
                } else {
                    $opt    = x_get_option( 'x_archive_layout', 'sidebar' );
                    $layout = ( $opt == 'sidebar' ) ? $content_layout : $opt;
                }
            } elseif ( x_is_buddypress() ) {
                $opt    = x_get_option( 'x_buddypress_layout_content', 'sidebar' );
                $layout = ( $opt == 'sidebar' ) ? $content_layout : $opt;
            } elseif ( is_404() ) {
                $layout = 'full-width';
            } else {
                $layout = $content_layout;
            }
        } else {
            $layout = $content_layout;
        }

        return $layout;

    }
endif;

// Add custom sidebar to product page//
//===================================================
add_filter( 'ups_sidebar', 'product_sidebar_2', 9999 );

function product_sidebar_2 ( $default_sidebar ) {
    if ( x_is_product() ) return 'ups-sidebar-left-sidebar'; //Must match the ID of your target sidebar
    return $default_sidebar;
}



function user_register_pre_save( $post_id ) {
    // check if this is to be a new post
    if( $post_id != 'new' ) {
        return $post_id;
    }

    $userdata = array(
        'ID'        => $user_id,
        'user_login'    => $_POST['acf']['user'],
        'user_pass'     => $_POST['acf']['password'],
        'user_email'    => $_POST['acf']['email'],
        'first_name'    => $_POST['acf']['nome'],
        'last_name'     => $_POST['acf']['cognome'],
        'display_name'  => $_POST['acf']['field_567a4d0a839b3'] . ' ' . $_POST['acf']['field_567a4d10839b4'],
        'role'      => $_POST['acf']['evoluter']
    );

//register user
    $user_id = wp_insert_user($userdata);

    return $post_id;
}

add_filter('acf/pre_save_post' , 'user_register_pre_save');





function script_togli_campi_evoluter() { ?>
    <script>
        jQuery(document).ready(function(){
            jQuery('p#billing_myfield15_field label').css('display', 'none');
            jQuery('p#billing_myfield16_field label').css('display', 'none');
            jQuery('input#billing_myfield15').attr("type", "hidden");
            jQuery('input#billing_myfield16').attr("type", "hidden");
        });

    </script>
<?php }

add_action( 'woocommerce_before_checkout_form', 'my_checkout_script' );

function my_checkout_script() {

}


add_filter("woocommerce_before_checkout_form", "order_fields");

function order_fields($checkout) {
    $user_meta=get_userdata(get_current_user_id());
    $user_roles=$user_meta->roles;

    $user_id = 'user_'.get_current_user_id();
    $user_capoarea = get_field('codice_capoarea', $user_id);

    $args = array(
        'blog_id'      => $GLOBALS['blog_id'],
        'role'         => 'evoluter'
    );
    $users = get_users( $args );

    if($user_roles[0] == 'capo_area') {
        ?>

        <form action="" method="GET">
            <label for="evoluter" class="evoluter">Selezione Evoluter</label>
            <select name="evoluter">
                <option value="-1" selected disabled>Seleziona un evoluter</option>
                <?php
                foreach ($users as $user) {
                    $id = 'user_'.$user->ID;
                    $cod_capo = get_field('capoarea', $id);
                    $cod_evo = get_field('codice_evoluter', $id);
                    $user_id = 'user_'.get_current_user_id();
                    $user_capoarea = get_field('codice_capoarea', $user_id);

                    if ($user_capoarea == $cod_capo) {
                        $selected = $_GET['evoluter'] == $user->ID ? 'selected' : '';
                        echo '<option '.$selected.' value="'.$user->ID.'">'.$user->first_name.' '.$user->last_name.'</option>';
                    }
                } ?>
            </select>
            <input type="submit" value="Seleziona">
        </form>

        <?php
        $id_evoluter = $_GET['evoluter'];
        $post_id = get_the_ID();
        $id_evo = 'user_'.$id_evoluter;
        $cod_evo_selected = get_field('codice_evoluter', $id_evo);
        echo $cod_evo_selected;

        
        
        if ($_GET['evoluter']) {
            ?>

            <script>
                jQuery(document).ready(function(){
                    jQuery('input#billing_first_name').val('<?php echo get_user_meta($id_evoluter, 'first_name')[0]; ?>');
                    jQuery('input#billing_last_name').val('<?php echo get_user_meta($id_evoluter, 'billing_last_name')[0]; ?>');
                    jQuery('input#billing_address_1').val('<?php echo get_user_meta($id_evoluter, 'billing_address_1')[0]; ?>');
                    jQuery('input#billing_myfield6').val('<?php echo get_user_meta($id_evoluter, 'billing_myfield6')[0]; ?>');
                    jQuery('input#billing_city').val('<?php echo get_user_meta($id_evoluter, 'billing_city')[0]; ?>');
                    jQuery('input#billing_postcode').val('<?php echo get_user_meta($id_evoluter, 'billing_postcode')[0]; ?>');
                    jQuery('input#billing_email').val('<?php echo get_user_meta($id_evoluter, 'billing_email')[0]; ?>');
                    jQuery('input#billing_phone').val('<?php echo get_user_meta($id_evoluter, 'billing_phone')[0]; ?>');
                    jQuery('input#billing_myfield11').val('<?php echo get_user_meta($id_evoluter, 'billing_myfield11')[0]; ?>');
                    jQuery('input#billing_myfield15').val('<?php echo $cod_evo_selected; ?>');
                    jQuery('input#billing_myfield16').val('<?php echo get_user_meta($id_evoluter, 'capoarea')[0]; ?>');
                });

            </script>
            <?php
        }
    }


    return $checkout;

}

/*
 * 
 *  NOTE DI PROFUMO DISATTIVATE 17/07/2017
 */
//add_action( 'woocommerce_after_add_to_cart_button', 'add_content_after_addtocart_button_func' );

function add_content_after_addtocart_button_func() {

    ?>
    <p>
    <?php
// check if the repeater field has rows of data
    if( have_rows('note_testa') ):
        ?>
        <p>Note di Testa:
            <?php
            // loop through the rows of data
            while ( have_rows('note_testa') ) : the_row();
                // display a sub field value
                $image_testa = get_sub_field('immagine_nota_testa');
                ?>
                <img style="width: 30px margin-left: 3px;" width="30" src="<?php echo $image_testa['url']; ?>" title="<?php echo $image_testa['title'] ?>" alt="<?php echo $image_testa['alt'] ?>" />
                <?php
            endwhile;
            ?>
        </p>
        <?php
    endif;


// check if the repeater field has rows of data
    if( have_rows('note_cuore') ):
        ?>
        <p>Note di Cuore:
            <?php
            // loop through the rows of data
            while ( have_rows('note_cuore') ) : the_row();
                // display a sub field value
                $image_cuore = get_sub_field('immagine_nota_cuore');
                ?>
                <img style="width: 30px margin-left: 3px;" width="30" src="<?php echo $image_cuore['url']; ?>" title="<?php echo $image_cuore['title'] ?>" alt="<?php echo $image_cuore['alt'] ?>" />
                <?php
            endwhile;
            ?>
        </p>
        <?php
    endif;


// check if the repeater field has rows of data
    if( have_rows('note_fondo') ):
        ?>
        <p>Note di Fondo:
            <?php
            // loop through the rows of data
            while ( have_rows('note_fondo') ) : the_row();
                // display a sub field value
                $image_fondo = get_sub_field('immagine_nota_fondo');
                ?>
                <img style="width: 30px margin-left: 3px;" width="30" src="<?php echo $image_fondo['url']; ?>" title="<?php echo $image_fondo['title'] ?>" alt="<?php echo $image_fondo['alt'] ?>" />
                <?php
            endwhile;
            ?>
        </p>
        <?php
    endif;
    ?>
    </p>
    <?php

}

/*
 // define the woocommerce_view_order callback
 function action_woocommerce_view_order( $wccs_file_uploader_front_end ) {
 
 };
 
 // add the action
 add_action( 'woocommerce_view_order', 'action_woocommerce_view_order', 1, 1 );
 */


/**
 * WOOCOMMERCE 3 NUOVA IMPLEMENTAZIONE
 */
/** commentato da roberto 32/08*/
//add_action( 'woocommerce_before_calculate_totals', 'add_custom_price');
function add_custom_price( $cart_object) {
    
    if ( is_admin() && !defined( 'DOING_AJAX' ) )
        return;
        
        foreach ( $cart_object->cart_contents as $key => $value ) {
            
            $_product = wc_get_product($value['product_id']);
            
            if (isset( $value['variation_id']) &&  $value['variation_id'] != 0) {
                $product_variation = new WC_Product_Variation($value['variation_id']);
                //$variation_price = $product_variation->price;
                $variation_price = $product_variation->get_price();
                
                
                //i prodotti originali non sono scontati:
                //var_dump ($variation_price) ;
                $price = isOriginalSKU( $product_variation->get_sku()) ? $variation_price : return_custom_price( $variation_price, $_product);
            } else {
                $price = $_product->get_price();
            }
            
            $value['data']->set_price( $price );
            
        }
}

//add_filter('woocommerce_available_variation','return_custom_available_variation', 10,3);

function return_custom_available_variation( $variation_get_max_purchase_quantity, $instance, $variation ){
    global $product;
    
    
    $sku = $variation_get_max_purchase_quantity['sku'];
    
    if ( !isOriginalSKU($sku) ){
        $prezzo = return_custom_price( $variation_get_max_purchase_quantity["display_price"], $product );
        $html_price = sprintf ( '<span class="price"><span class="woocommerce-Price-amount amount">%s<span class="woocommerce-Price-currencySymbol">€</span></span></span>',
            number_format ( $prezzo, '2', ',' , '.') );
        
        $variation_get_max_purchase_quantity["display_price"] = $prezzo;
        $variation_get_max_purchase_quantity["display_regular_price"]= $prezzo;
        $variation_get_max_purchase_quantity["price_html"] = $html_price;
    }
    
    
    return $variation_get_max_purchase_quantity;
}



/**Modificato da roberto 23/08 */
//add_filter('woocommerce_product_get_price', 'return_custom_price', 10,2);

function return_custom_price($price, $product) {
    global  $woocommerce;
    // Grab the product id

    //$post_id = $product->id;
    //Inserito nel caso che il prezzo sia non percentuale, ma particolare per l'evoluter 
    if ( !is_null( $product ) ){
        $prezzo_evoluter = $product->get_attribute( 'prezzo_evoluter' );
        
        if (!empty($prezzo_evoluter) && ( isCurrentUserEvoluter()|| isCurrentUserCapoArea())  ) {
            return $prezzo_evoluter;
        }
    }
//Fine prezzo particolare per evoluter

    if (isset($_GET['evoluter'])) {
        $user_meta=get_userdata($_GET['evoluter']);
        
        
    } else {
        $user_meta=get_userdata(get_current_user_id());
    }

    $id = $user_meta->ID;
    $id_user = 'user_'.$id;
    $sconto = get_field('sconto', $id_user);
    $totale_carrello = WC()->cart->cart_contents_total;
    //print_r($totale_carrello);

    //lo sconto è derivato dal campo sconto dell'evoluter, ma ora lo calcolo con il plugin quindi lo metto a 0
    $sconto = 100 - $sconto;
    
    if (($sconto==0) || (!$sconto)) {
        $sconto = 100;
    }

    if ( !is_null ($product) ){
        
        $sku = $product->get_sku();
        
        if ( isOriginalSKU($sku) ) {
            $sconto = 100;
            
        }
    }
   //Senza sconto equivale allo sconto=100
    //$sconto = 100; 
    $sconto = $sconto / 100;

    // If the IP detection is enabled look for the correct price
    $new_price = round ( $price * $sconto, 2 );

    return $new_price;
}

// Modifica prezzi variabili
//add_filter( 'woocommerce_variable_price_html', 'wc_wc20_variation_price_format', 10, 2 );
function wc_wc20_variation_price_format( $price, $product ) {
    
    $id = get_current_user_id();
    $id_user = 'user_'. $id;
    

    $sconto = get_field('sconto', $id_user);
   //Azzero lo sconto  non prendo quello dell'evoluter ma lo metto senza sconto
      //$sconto = 100 - $sconto;
   //$sconto = 100;
    if (($sconto==0) || (!$sconto)) {
        $sconto = 100;
    }

    if (isOriginalSKU($sku)) {
        $sconto=100;
    }
    $sconto = $sconto / 100;

    $min_price = $product->get_variation_price( 'min', true );
    $min_price = $min_price * $sconto;
    $price = sprintf( __( 'A partire da: %1$s', 'woocommerce' ), wc_price( $min_price ) );
    return $price;
}


function wc_ninja_change_flat_rates_cost( $rates, $package ) {
    $user_meta=get_userdata(get_current_user_id());
    $user_roles=$user_meta->roles;
    // Make sure flat rate is available
    if ( isset( $rates['flat_rate:7'] ) ) {
    	
    	//write_log('flat_rate:7 is set');
    	
        // Current value of the shopping cart
        $cart_subtotal = WC()->cart->subtotal;
        //write_log(sprintf( 'subtotal %s',$cart_subtotal));
        
        if ( $cart_subtotal >= 30 && !in_array('evoluter', $user_roles) && !in_array('capo_area', $user_roles) ) {
        	
        	//write_log('entrato in if');
        	//write_log(sprintf( 'user_role %s',$user_roles[0]) );
            // Set the cost to $0
            $rates['flat_rate:7']->cost = 0;
        } 
        elseif  ($cart_subtotal >= 200)  {
        	
        	//write_log('entrato in elseif');
            // Set the cost to $0^
            $rates['flat_rate:7']->cost = 0;
       }
	 else {
	 	//write_log('entrato in else');
            $rates['flat_rate:7']->cost = 6.90;
        }

        //write_log(sprintf( 'rata: %s', $rates['flat_rate:7']->cost) );
    }

    return $rates;
}

//add_filter( 'woocommerce_package_rates', 'wc_ninja_change_flat_rates_cost', 10, 2 );


function add_this_script_footer(){
    $user_meta=get_userdata(get_current_user_id());
    $user_roles=$user_meta->roles;
    if ($user_roles[0] == 'evoluter') {
        ?>
        <script>
            jQuery('a.promozioni').css('display','none');
        </script>
    <?php }
    global $woocommerce;

    if ( isset( $_POST['login'] ) ) {
        $woocommerce->cart->empty_cart();
    }
}



/**
 * @param $codiceCapoarea stringa che identifica il capoarea
 * @return array   tutti gli id degli evoluter associati al codice capoarea
 */
function getCapoareaEvoluters($codiceCapoarea){
    global $wpdb;
    $query = "SELECT pm.user_id FROM wp_usermeta as pm join wp_users as u ON pm.user_id = u.id WHERE pm.meta_key='capoarea' AND pm.meta_value='".$codiceCapoarea."'";
    $result = $wpdb->get_results( $query, ARRAY_A );
    $evoluters_ids = array();
    foreach ( $result as $row){
        array_push($evoluters_ids,$row['user_id']);
    }
    return $evoluters_ids;
}

/**
 * @param $evoluters_ids  id degli evoluters
 * @param $month   mese (1-12) intervallo | null   (se null restituisce tutti gli ordini senza intervallo di tempo)
 * @return mixed   ordini degli evoluters
 */
function getEvolutersOrders($evoluters_ids,$month){

    $args = array(
        'numberposts' => -1,
        'meta_key'    => '_customer_user',
        'meta_value'  => $evoluters_ids,
        'post_type'   => 'shop_order',
        'post_status' => 'wc-completed', //array_keys( wc_get_order_statuses() )
        'fields' => 'ids'
    );

    if (!is_null($month)) {
        $args['date_query'] = array(
            array(
                'after'     => array(
                    'year'  => date("Y"),
                    'month' => $month
                ),
                'before'    => array(
                    'year'  => date("Y"),
                    'month' => $month
                ),
                'inclusive' => true,
            ),
        );
    }
    return get_posts( $args );
}



/**
 * @param $evoluter_orders
 * @return int|string  restituisce il 10% sulla somma degli ordini al netto senza contrasseno e spese di spedizione
 */
function getCapoareaProfits($evoluter_orders){
    $profits = 0;
    foreach ($evoluter_orders as $id) {
        $order = wc_get_order( $id );
        $payment_gateway = wc_get_payment_gateway_by_order( $order );

        $partial = $order->get_total() - $order->get_total_tax() - $order->get_total_shipping() - $order->get_shipping_tax();

        if ($payment_gateway->title=="Contrassegno") {
            $contrassegno = $payment_gateway->settings["extra_charges"];
            $partial = $partial - $contrassegno;
        }

        $partial = togliIVA($partial,22);
        $profits = $profits + $partial;
    }

    $profits = number_format((float) calcolaPercentuale($profits,10),wc_get_price_decimals(), '.', '');
    return $profits;

}

function myAccountOrderCapoArea(){
    if (is_wc_endpoint_url('orders') && isCurrentUserCapoarea()) {
        $codiceCapoarea =  get_user_meta(get_current_user_id(),'codice_capoarea');
        if (!empty($codiceCapoarea)){

            $evoluters_ids = getCapoareaEvoluters($codiceCapoarea[0]);
            //aggiungo il capoarea nella lista id:
            array_push($evoluters_ids,get_current_user_id());

            $ordiniInizio = getEvolutersOrders($evoluters_ids);
            $ordiniMeseAttuale = getEvolutersOrders($evoluters_ids,date("n"));
            $ordiniMesePrecedente =getEvolutersOrders($evoluters_ids,date("n")-1);

            $profittiInizio = getCapoareaProfits($ordiniInizio);
            $profittiMeseAttuale = getCapoareaProfits($ordiniMeseAttuale);
            $profittiMesePrecedente = getCapoareaProfits($ordiniMesePrecedente);


            echo '<h6>Profitti per <b>'.wp_get_current_user()->display_name.'</b></h6><table id="profitti_capoarea"><tr>';
            echo '<th class="this_month">questo mese ('.date("M").'), '.sizeof($ordiniMeseAttuale).' ordini</th>';
            echo '<th class="prev_month">mese scorso ('.date("M",strtotime('last month')).'), '.sizeof($ordiniMesePrecedente).' ordini</th>';
            echo '<th class="all_profits">dall\'inizio</th>';
            echo '</tr>';
            echo '<tr><td>'.$profittiMeseAttuale.' &euro;</td><td>'.$profittiMesePrecedente.' &euro;</td><td>'.$profittiInizio.' &euro;</td></tr>';
            echo '</table>';
        }
    }




}

function myAccountDashboardCapoArea(){

    if (isCurrentUserCapoarea()) {
        $codiceCapoarea =  get_user_meta(get_current_user_id(),'codice_capoarea');
        if (!empty($codiceCapoarea)){
            $evoluters_ids = getCapoareaEvoluters($codiceCapoarea[0]);
            echo '<h2>LE TUE EVOLUTER</h2><div id="myAccountEvolutersTableContainer"><table> <th>Nome</th><th>Cognome</th><th>Email</th><th>Telefono</th>';

            foreach ($evoluters_ids as $evoluterId){
                $user = get_userdata( $evoluterId);
                echo '<tr><td>'.$user->first_name.'</td>';
                echo '<td>'. $user->last_name.'</td>';
                echo '<td>'. $user->user_email.'</td>';
                echo '<td>'.get_usermeta($evoluterId,'billing_phone').'</td></tr>';
            }
            echo '</div></table>';
        }

    }
}

// define the woocommerce_my_account_my_orders_query callback
function filter_woocommerce_my_account_my_orders_query( $args ) {
    // make filter magic happen here...

    myAccountOrderCapoArea();

    return $args;


};

// add the filter
//add_filter( 'woocommerce_my_account_my_orders_query', 'filter_woocommerce_my_account_my_orders_query', 10, 1 );
//add_filter('woocommerce_after_my_account', 'myAccountDashboardCapoArea',10,1);



function customJs(){?>

    <script>
        var year  = new Date().getFullYear();
        var yearRange = "1912:" + year;
        jQuery(document).ready(function($) {

            if ($.datepicker){
                $.datepicker.setDefaults({
                    changeMonth: true,
                    changeYear: true,
                    minDate: new Date(1912, 1 - 1, 1),
                    yearRange:  yearRange
                });

            }



            $('#order_comments_field').insertAfter("#billing_myfield14_field");
        });
    </script>

    <?php
}

add_action('wp_footer','customJs');

/* BLOCCO PROMOZIONI IN CORSO PER EVOLUTER E CAPOAREA */

function blockPromotions(){
    global $post;
    $post_id = $post->ID;

    global $wp_query;
    $post_id = $wp_query->get_queried_object_id();


    if ($post_id == 1138 && ( isCurrentUserCapoarea()|| isCurrentUserEvoluter())){
        wp_redirect( 'http://www.levoluzionedelprofumo.com/', 302 );
        exit();
    }
}

function afterSidebarJS(){
    if (isCurrentUserCapoarea()|| isCurrentUserEvoluter()) { ?>
        <script>
            jQuery(document).ready(function($) {
                $('.x-sidebar #text-2').remove();
            });
        </script>
        <?php
    }

}

add_action('wp_head','blockPromotions');
add_action('get_sidebar','afterSidebarJS');

/***************************************************/

function isMobileDevice(){
	if(isset($_SERVER['HTTP_USER_AGENT']) and !empty($_SERVER['HTTP_USER_AGENT'])){
		$user_ag = $_SERVER['HTTP_USER_AGENT'];
		if(preg_match('/(Mobile|Android|Tablet|GoBrowser|[0-9]x[0-9]*|uZardWeb\/|Mini|Doris\/|Skyfire\/|iPhone|Fennec\/|Maemo|Iris\/|CLDC\-|Mobi\/)/uis',$user_ag)){
			return true;
		}else{
			return false;
		};
	}else{
		return false;
	};
};

function isIOS(){
	return (strstr($_SERVER['HTTP_USER_AGENT'],'iPhone') || strstr($_SERVER['HTTP_USER_AGENT'],'iPad'));
}

////////////////////////////////////////////////////////////////////////////////////////////

add_action('wp_head','updateAllProductStockQty');

function updateProductStockQty($product_id,$quantity){
	global $woocommerce;
	$prodotto = wc_get_product($product_id);
	//var_dump($prodotto);
	$new_quantity=wc_update_product_stock($prodotto, $quantity);

}

function updateAllProductStockQty(){
	if (isset($_GET['updatestock'])) {
		
		$args     = array( 
				'post_type' => 'product',  
				'fields' => 'ids',
				'posts_per_page'=>-1 
		);
		$quantity = $_GET['updatestock'];
		$products = get_posts( $args );
		
		
		foreach ($products as $prodotto_id){
			updateProductStockQty($prodotto_id,$quantity);
			$handle=new WC_Product_Variable($prodotto_id);
			$variations=$handle->get_children();
			foreach ($variations as $value) {
				$single_variation = new WC_Product_Variation($value);
				update_post_meta($value, '_stock', $quantity );		
			}
		}

	}
}


if ( !function_exists('essenzial_read_more_btn_description')) :
function essenzial_read_more_btn_description(){
	echo sprintf( '
			<div id="detail_read_more">
				<span class="piu">
					Leggi di più&nbsp;
					<i class="x-icon x-icon-angle-down" data-x-icon="" aria-hidden="true"></i>
				</span>
				<span class="meno">
					Chiudi&nbsp;
					<i class="x-icon x-icon-angle-up" data-x-icon="" aria-hidden="true"></i>
				</span>
			</div>
			<script>
				jQuery(document).ready(function($){
					$("#detail_read_more").toggle(function(){
						$(".x-tab-pane.description_pane").animate({height: $(".x-tab-pane.description_pane").get(0).scrollHeight}, 700 );
						$("#detail_read_more .piu").hide();
						$("#detail_read_more .meno").show();
					},function(){
						$(".x-tab-pane.description_pane").animate({height: 300}, 800 );
						$("#detail_read_more .meno").hide();
						$("#detail_read_more .piu").show();
					});
				});
			</script>
			'
			
			);
}
endif;



function is_original_present() {
    global $woocommerce;
    $items = $woocommerce->cart->get_cart();

    foreach($items as $item => $values) {
        $_product = $values['data'];
        $sku = $values['data']->get_sku();
        $check = strstr(strtolower($sku), 'orig');
        if(check){
          return true;
       }
    }
    return false;

}

//add_filter('woocommerce_coupon_get_discount_amount', 'woocommerce_coupon_get_discount_amount', 10, 5 );
	function woocommerce_coupon_get_discount_amount( $discount, $discounting_amount, $cart_item, $single, $coupon ) {
		if ($coupon->type == 'percent_product' || $coupon->type == 'percent') {
			global $woocommerce;
			$cart_total = 0;
		
			foreach ( $woocommerce->cart->get_cart() as $cart_item_key => $cart_item ) {

			 $variable_product1= new WC_Product_Variation( $cart_item["variation_id"] );

			 $cart_total += $variable_product1 ->price * $cart_item['quantity'];
			} 
			if (!is_original_present()){
				$discount = round( ( $cart_total / 100 ) * $coupon->amount, $woocommerce->cart->dp );
				return $discount;
			}else{
				return 0;
			}
		}
		return $discount;
	}





add_action( 'wp_ajax_update_sconto_user_meta', 'update_sconto_user_meta' );
add_action( 'wp_ajax_nopriv_update_sconto_user_meta', 'update_sconto_user_meta' );

function update_sconto_user_meta() {
    
    $nuovo_valore = $_POST['radiovalue'];
    $user_id = get_current_user_id();
    update_user_meta( $user_id,  'sconto_2x1', $nuovo_valore );
    
    echo $nuovo_valore;
    die();
    
}







