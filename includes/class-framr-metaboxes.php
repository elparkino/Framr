<?php
/**
 * Frame Post Type
 *
 * @package   Team_Post_Type
 * @license   GPL-2.0+
 */

/**
 * Register metaboxes.
 *
 * @package Team_Post_Type
 */
class Frame_Post_Type_Metaboxes {

	public function init() {
		add_action( 'add_meta_boxes', array( $this, 'frame_meta_boxes' ) );
		add_action( 'save_post', array( $this, 'save_meta_boxes' ),  10, 2 );
	}

	/**
	 * Register the metaboxes to be used for the frame post type
	 *
	 * @since 0.1.0
	 */
	public function frame_meta_boxes() {
		add_meta_box(
			'frame_fields',
			'Frame Fields',
			array( $this, 'render_meta_boxes' ),
			'frame',
			'normal',
			'high'
		);
	}

   /**
	* The HTML for the fields
	*
	* @since 0.1.0
	*/
	function render_meta_boxes( $post ) {

		$meta = get_post_custom( $post->ID );
		$title = ! isset( $meta['frame_price'][0] ) ? '' : $meta['frame_price'][0];

		wp_nonce_field( basename( __FILE__ ), 'frame_fields' ); ?>

		<table class="form-table">

			<tr>
				<td class="frame_meta_box_td" colspan="2">
					<label for="frame_price"><?php _e( 'Price per foot', 'frame-post-type' ); ?>
					</label>
				</td>
				<td colspan="4">
					<input type="text" name="frame_price" class="regular-text" value="<?php echo $title; ?>">
					<p class="description"><?php _e( 'E.g. $1.25 for the gilded frame', 'frame-post-type' ); ?></p>
				</td>
			</tr>
		</table>

	<?php }

   /**
	* Save metaboxes
	*
	* @since 0.1.0
	*/
	function save_meta_boxes( $post_id ) {

		global $post;

		// Verify nonce
		if ( !isset( $_POST['frame_fields'] ) || !wp_verify_nonce( $_POST['frame_fields'], basename(__FILE__) ) ) {
			return $post_id;
		}

		// Check Autosave
		if ( (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) || ( defined('DOING_AJAX') && DOING_AJAX) || isset($_REQUEST['bulk_edit']) ) {
			return $post_id;
		}

		// Don't save if only a revision
		if ( isset( $post->post_type ) && $post->post_type == 'revision' ) {
			return $post_id;
		}

		// Check permissions
		if ( !current_user_can( 'edit_post', $post->ID ) ) {
			return $post_id;
		}

		$meta['frame_price'] = ( isset( $_POST['frame_price'] ) ? esc_textarea( $_POST['frame_price'] ) : '' );

                
		foreach ( $meta as $key => $value ) {
			update_post_meta( $post->ID, $key, $value );
		}
	}

}