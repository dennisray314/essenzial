<?php

// =============================================================================
// PAGE.PHP
// -----------------------------------------------------------------------------
// Handles output of individual pages.
//
// Content is output based on which Stack has been selected in the Customizer.
// To view and/or edit the markup of your Stack's pages, first go to "views"
// inside the "framework" subdirectory. Once inside, find your Stack's folder
// and look for a file called "wp-page.php," where you'll be able to find the
// appropriate output.
// =============================================================================


$user = array(
            'login'    => empty( $_POST['login'] ) ? $login : sanitize_text_field( $_POST['login'] ),

            'first_name'    => empty($_POST['first_name']) ? '' : $_POST['first_name'],
            'last_name'    => empty($_POST['last_name']) ? '' : $_POST['last_name'],

            'email'    => empty( $_POST['email'] ) ? $email : sanitize_text_field( $_POST['email'] ),

            'street'    => empty( $_POST['street'] ) ? '' : $_POST['street'],
            'housenumber'    => empty( $_POST['housenumber'] ) ? '' : $_POST['housenumber'],
            'city'    => empty( $_POST['city'] ) ? '' : $_POST['city'],
            'zipcode'    => empty( $_POST['zipcode'] ) ? '' : $_POST['zipcode'],
            'phone'    => empty( $_POST['phone'] ) ? '' : $_POST['phone'],
            'capoarea'    => empty( $_POST['capoarea'] ) ? '' : $_POST['capoarea'],
            'codice_evoluter'    => empty( $_POST['codice_evoluter'] ) ? '' : $_POST['codice_evoluter'],
            'password' => empty( $_POST['password'] ) ? '' : ( $_POST['password'] )
        );

$userdata = array(
                        'user_login' => $user['login'],
                        'user_pass' => $user['password'],
                        'first_name' => $user['first_name'],
                        'last_name' => $user['last_name'],
                        'user_nicename' => $user['login'],
                        'user_email' => $user['email'],
                        'user_registered' => date_default_timezone_get(),
                        'role'  => 'evoluter',
                        'display_name' => $user['login']
                        // 'street' => $user['street'],
                        // 'housenumber' => $user['housenumber'],
                        // 'city' => $user['city'],
                        // 'zipcode' => $user['zipcode'],
                        // 'phone' => $user['phone']
                    );

            $user_id = wp_insert_user( $userdata );


if (get_user_meta($userID, 'shipping_address_1', true)){
      update_user_meta( $user_id, 'shipping_address_1', $_POST['street'], true );
      update_user_meta( $user_id, 'billing_address_1', $_POST['street'], true );
      update_user_meta( $user_id, 'billing_first_name', $_POST['first_name'], true );
      update_user_meta( $user_id, 'shipping_first_name', $_POST['first_name'], true );
      update_user_meta( $user_id, 'billing_last_name', $_POST['last_name'], true );
      update_user_meta( $user_id, 'shipping_last_name', $_POST['last_name'], true );
}else{
      add_user_meta( $user_id, 'shipping_address_1', $_POST['street'], false );
      add_user_meta( $user_id, 'billing_address_1', $_POST['street'], true );
      add_user_meta( $user_id, 'billing_first_name', $_POST['first_name'], true );
      add_user_meta( $user_id, 'shipping_first_name', $_POST['first_name'], true );
      add_user_meta( $user_id, 'billing_last_name', $_POST['last_name'], true );
      add_user_meta( $user_id, 'shipping_last_name', $_POST['last_name'], true );
}

if (get_user_meta($userID, 'billing_city', true)){
      update_user_meta( $user_id, 'billing_city', $_POST['city'], true );
      update_user_meta( $user_id, 'shipping_city', $_POST['city'], true );
}else{
      add_user_meta( $user_id, 'billing_city', $_POST['city'], false );
      add_user_meta( $user_id, 'shipping_city', $_POST['city'], false );
}
if (get_user_meta($userID, 'billing_postcode', true)){
      update_user_meta( $user_id, 'billing_postcode', $_POST['zipcode'], true );
      update_user_meta( $user_id, 'shipping_postcode', $_POST['zipcode'], true );
}else{
      add_user_meta( $user_id, 'billing_postcode', $_POST['zipcode'], false );
      add_user_meta( $user_id, 'shipping_postcode', $_POST['zipcode'], false );
}
if (get_user_meta($userID, 'billing_phone', true)){
      update_user_meta( $user_id, 'billing_phone', $_POST['phone'], true );
      update_user_meta( $user_id, 'shipping_phone', $_POST['phone'], true );
}else{
      add_user_meta( $user_id, 'billing_phone', $_POST['phone'], false );
      add_user_meta( $user_id, 'shipping_phone', $_POST['phone'], false );
}
if (get_user_meta($userID, 'billing_myfield6', true)){
      update_user_meta( $user_id, 'billing_myfield6', $_POST['myfield6'], true );
      update_user_meta( $user_id, 'shipping_myfield6', $_POST['myfield6'], true );
}else{
      add_user_meta( $user_id, 'billing_myfield6', $_POST['myfield6'], false );
      add_user_meta( $user_id, 'shipping_myfield6', $_POST['myfield6'], false );
}

      update_user_meta( $user_id, 'capoarea', $_POST['capoarea']);
      update_user_meta( $user_id, 'codice_evoluter', $_POST['codice_evoluter']);
      update_user_meta( $user_id, 'numero_civico', $_POST['housenumber']);




?>


<?php get_header(); ?>

<style type="text/css">

  .larg-50 {
    width: 48%;
    float: left;
    margin-left: 10px;
  }
  .input-larg-100 {
    width: 100%;
  }
  .clear {
    clear: both;
  }
  .success-message {
    margin-left: 40px;
    margin-right: 40px;
    margin-bottom: 20px;
    padding: 10px;
    border: 1px solid #00673A;
    background: #8EC549;

  }
  .error-message {
    margin-left: 40px;
    margin-right: 40px;
    margin-bottom: 20px;
    padding: 10px;
    border: 1px solid red;
    background: #F17542;
  }
</style>

  <div class="x-main full" role="main">

    <?php while ( have_posts() ) : the_post(); ?>
      <?php x_get_view( 'icon', 'content', 'page' ); ?>

<?php if ( ! is_wp_error( $user_id ) ) { ?>
<div class="success-message">
    <p>Utente creato correttamente. <a href="/wp-login.php">Vai alla pagina di login</a> per entrare e iniziare a fare ordini</p>
</div>
<?php } elseif ((!empty($_POST['login']))) { ?>
<div class="error-message">
    <p>Si è verificato un errore nella registrazione, prova e rifarla di nuovo. </p>
</div>
<?php } ?>


<form method="POST" action="">
<div class="form-wrapper" style="margin-left: 40px; margin-right: 40px;">
                    <?php
                    wp_nonce_field( 'facebook-nonce', 'facebook_security' );
                    wp_nonce_field( 'register_submit', 'security' );
                    ?>
                    <div class="ajax-login-register-status-container">
                        <div class="ajax-login-register-msg-target"></div>
                    </div>
                    <div class="larg-50"><label><?php _e('User Name'); ?></label><input class="input-larg-100" type="text" required name="login"  /></div>
                    <div class="larg-50"><label><?php _e('Password'); ?></label><input class="input-larg-100" type="password" required name="password" /></div>
                    <div class="clear"></div>

                    <div class="larg-50"><label><?php _e('Nome'); ?></label><input class="input-larg-100" type="text" required name="first_name" class="first_name" /></div>
                    <div class="larg-50"><label><?php _e('Cognome'); ?></label><input class="input-larg-100" type="text" required name="last_name" class="last_name" /></div>
                    <div class="clear"></div>

                    <div class="larg-50"><label><?php _e('Email'); ?></label><input class="input-larg-100" type="text" required name="email" class="user_email ajax-login-register-validate-email" /></div>
                    <div class="larg-50"><label><?php _e('Indirizzo'); ?></label><input class="input-larg-100" type="text" required name="street" class="street" /></div>
                    <div class="clear"></div>

                    <div class="larg-50"><label><?php _e('Numero Civico'); ?></label><input class="input-larg-100" type="number" required name="myfield6" class="housenumber" /></div>
                    <div class="larg-50"><label><?php _e('Città'); ?></label><input class="input-larg-100" type="text" required name="city" class="city" /></div>
                    <div class="clear"></div>

                    <div class="larg-50"><label><?php _e('CAP'); ?></label><input class="input-larg-100" type="number" required name="zipcode" class="zipcode" /></div>
                    <div class="larg-50"><label><?php _e('Telefono'); ?></label><input class="input-larg-100" type="number" required name="phone" class="phone" /></div>
                    <div class="clear"></div>

                    <div class="larg-50"><label><?php _e('Codice Evoluter'); ?></label><input class="input-larg-100" type="text" required name="codice_evoluter" class="codice_capoarea" /></div>
                    <div class="larg-50"><label><?php _e('Capoarea'); ?></label><input class="input-larg-100" type="text" required name="capoarea" class="capoarea" /></div>
                    <div class="clear"></div>

   


                    <div class="button-container">
                        <input class="register_button green" type="submit" value="<?php _e('Registra','ajax_login_register'); ?>" accesskey="p" name="register" />
                    </div>
                </div>
  </form>



<?php x_get_view( 'global', '_comments-template' ); ?>
    <?php endwhile; ?>

  </div>

  <?php get_sidebar(); ?>
<?php get_footer(); ?>