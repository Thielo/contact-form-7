<?php
/**
** A base module for [button]
**/

/* Shortcode handler */

add_action( 'wpcf7_init', 'wpcf7_add_shortcode_button' );

function wpcf7_add_shortcode_button() {
  wpcf7_add_shortcode( 'button', 'wpcf7_button_shortcode_handler' );
}

function wpcf7_button_shortcode_handler( $tag ) {
  $tag = new WPCF7_Shortcode( $tag );

  $class = wpcf7_form_controls_class( $tag->type );

  $atts = array();

  $atts['class'] = $tag->get_class_option( $class );
  $atts['id'] = $tag->get_id_option();
  $atts['tabindex'] = $tag->get_option( 'tabindex', 'int', true );

  $value = isset( $tag->values[0] ) ? $tag->values[0] : '';

  if ( empty( $value ) )
    $value = __( 'Send', 'contact-form-7' );

  $atts['type'] = 'submit';

  $atts = wpcf7_format_atts( $atts );

  $html = sprintf( '<button %1$s>%2$s</button>', $atts, $value );

  return $html;
}


/* Tag generator */

if ( is_admin() ) {
  add_action( 'admin_init', 'wpcf7_add_tag_generator_button', 55 );
}

function wpcf7_add_tag_generator_button() {
  $tag_generator = WPCF7_TagGenerator::get_instance();
  $tag_generator->add( 'button', __( 'button', 'contact-form-7' ),
    'wpcf7_tag_generator_button', array( 'nameless' => 1 ) );
}

function wpcf7_tag_generator_button( $contact_form, $args = '' ) {
  $args = wp_parse_args( $args, array() );

  $description = __( "Generate a form-tag for a button. For more details, see %s.", 'contact-form-7' );

  $desc_link = wpcf7_link( __( 'http://contactform7.com/button/', 'contact-form-7' ), __( 'Button', 'contact-form-7' ) );

?>
<div class="control-box">
<fieldset>
<legend><?php echo sprintf( esc_html( $description ), $desc_link ); ?></legend>

<table class="form-table">
<tbody>
  <tr>
  <th scope="row"><label for="<?php echo esc_attr( $args['content'] . '-values' ); ?>"><?php echo esc_html( __( 'Label', 'contact-form-7' ) ); ?></label></th>
  <td><input type="text" name="values" class="oneline" id="<?php echo esc_attr( $args['content'] . '-values' ); ?>" /></td>
  </tr>

  <tr>
  <th scope="row"><label for="<?php echo esc_attr( $args['content'] . '-id' ); ?>"><?php echo esc_html( __( 'Id attribute', 'contact-form-7' ) ); ?></label></th>
  <td><input type="text" name="id" class="idvalue oneline option" id="<?php echo esc_attr( $args['content'] . '-id' ); ?>" /></td>
  </tr>

  <tr>
  <th scope="row"><label for="<?php echo esc_attr( $args['content'] . '-class' ); ?>"><?php echo esc_html( __( 'Class attribute', 'contact-form-7' ) ); ?></label></th>
  <td><input type="text" name="class" class="classvalue oneline option" id="<?php echo esc_attr( $args['content'] . '-class' ); ?>" /></td>
  </tr>

</tbody>
</table>
</fieldset>
</div>

<div class="insert-box">
  <input type="text" name="button" class="tag code" readonly="readonly" onfocus="this.select()" />

  <div class="submitbox">
  <input type="button" class="button button-primary insert-tag" value="<?php echo esc_attr( __( 'Insert Tag', 'contact-form-7' ) ); ?>" />
  </div>
</div>
<?php
}
