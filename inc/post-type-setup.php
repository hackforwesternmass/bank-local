<?php
/**
 * Create the Custom Post Type "Sections" with meta for points & design
 * Remove Posts from the menu (because we aren't using them)
 * Note: We're leaving pages for informational purposes.
 * @todo: Remove the "View post" link from success message
 * @todo: Add icon to sections
 */

class CPT_Sections {
	/**
	 * Singleton
	 */
	private static $__instance = null;

	/**
	 * Class variables
	 */
	private $post_type = 'bl-section';
	
	/**
	 * Silence is golden
	 */
	private function __construct() {}

	/**
	 * Implement singleton
	 *
	 * @uses self::setup
	 * @return self
	 */
	public static function get_instance() {
		if ( ! is_a( self::$__instance, __CLASS__ ) ) {
			self::$__instance = new self;
			self::$__instance->setup();
		}

		return self::$__instance;
	}

	/**
	 * Register actions and filters.
	 *
	 * @uses add_action
	 * @uses add_filter
	 */
	private function setup() {
		add_action( 'init', array( $this, 'create_post_type' ) );
		add_action( 'admin_menu', array( $this, 'remove_menus' ) );

		add_action( 'admin_enqueue_scripts', array( $this, 'admin_enqueue_scripts' ) );

		add_filter( 'post_updated_messages', array( $this, 'post_updated_messages' ) );
		add_filter( 'enter_title_here', array( $this, 'enter_title_here' ), 10, 2 );
		add_action( 'edit_form_after_title', array( $this, 'edit_form_after_title' ) );

		add_action( 'save_post', array( $this, 'save_points' ), 10, 2 );
	}
	
	/**
	 * Enqueue scripts and styles
	 */
	public function admin_enqueue_scripts() {
		$screen = get_current_screen();
		if ( 'post' !== $screen->base || $this->post_type !== $screen->post_type )
			return;

		wp_enqueue_script( 'bl-admin', get_template_directory_uri().'/assets/js/admin.js', array( 'jquery', 'jquery-ui-sortable' ) );
		wp_enqueue_style( 'bl-admin', get_template_directory_uri().'/assets/admin.css' );
	}
	
	/**
	 * Create the CPT
	 * @uses register_post_type
	 */
	public function create_post_type() {
		register_post_type( $this->post_type, array(
			'label'			=> 'Sections',
			'labels'		=> array(
				'name'			=> 'Sections',
				'singular_name'	=> 'Section',
				'add_new'		=> 'Add Section',
				'add_new_item'	=> 'Add New Section',
				'edit_item'		=> 'Edit Section',
				'new_item'		=> 'New Section',
				'search_items'	=> 'Search Section',
				'not_found'		=> 'No section found',
				'not_found_in_trash' => 'No section found in Trash'
			),
			'public'		=> true,
			'show_in_menu'	=> true,
			'supports'		=> array( 'title', 'editor' ),
			'rewrite'		=> false,
			'show_in_nav_menus'	=> false,
		));
	}
	
	function remove_menus() {
		global $menu;
		$restricted = array( __( 'Posts' ) );
		end( $menu );
	
		while ( prev( $menu ) ) {
			$value = explode( ' ', $menu[ key( $menu ) ][0] );
	
			if ( ( $value[0] != NULL ) && in_array(  $value[0], $restricted ) ) {
				unset( $menu[ key( $menu ) ] );
			}
		}
	}
	
	/**
	 * Customize updated messages based on post type
	 * @param  array $messages Post updated messages
	 * @return array           Potentially altered updated messages
	 */
	public function post_updated_messages( $messages ) {
		global $post;

		$messages[$this->post_type] = array(
			0  => '', // Unused. Messages start at index 1.
			1  => sprintf( 'Section updated.' ),
			2  => 'Custom field updated.',
			3  => 'Custom field deleted.',
			4  => 'Section updated.',
			5  => isset( $_GET['revision'] ) ? sprintf( 'Section restored to revision from %s', wp_post_revision_title( (int) $_GET['revision'], false ) ) : false,
			6  => sprintf( 'Section published.' ),
			7  => 'Section saved.',
			8  => sprintf( 'Section submitted.' ),
			9  => sprintf( 'Section scheduled for: <strong>%1$s</strong>.', date_i18n( 'M j, Y @ G:i', strtotime( $post->post_date ) ) ),
			10 => sprintf( 'Section draft updated.' ),
		);

		return $messages;
	}

	/**
	 * Relabel the title input placeholder
	 * @param  string $placeholder Placeholder text
	 * @param  object $post        Current post object
	 * @return string              Potentially altered placeholder text
	 */
	public function enter_title_here( $placeholder, $post ) {
		if ( $this->post_type == get_post_type( $post ) )
			$placeholder = 'Section title (internal only?)';

		return $placeholder;
	}
	
	/**
	 * Save the history field
	 * @param  int    $post_id Current post ID
	 * @param  object $post    Current post object
	 * @return void
	 */
	public function save_points( $post_id, $post ) {
		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE )
			return;

		if ( ! current_user_can( 'edit_post', $post_id ) )
			return;

		if ( ! isset( $_POST['_points_nonce'] ) || ! wp_verify_nonce( $_POST['_points_nonce'], 'bl-section-points-save' ) )
			return;

		if ( empty( $_POST['points'] ) )
			return;
		
		// Update post meta for details
		$new = array();

		$points = $_POST['points'];

		foreach ( $points as $point ) {
			$data = array();

			foreach ( array( 'title','text' ) as $key ) {
				if ( ! empty( $point[$key] ) )
					if ( 'text' == $key )
						$data[$key] = wp_kses( $point[$key] );
					else
						$data[$key] = sanitize_text_field( $point[$key] );
			}

			if ( ! empty( $data) )
				$new[] = $data;
		}

		if ( ! empty ( $new ) )
			update_post_meta( $post_id, 'section_points', $new );
		else
			delete_post_meta( $post_id, 'section_points' );
	}

	
	/**
	 * Display things under the editor on the edit screen
	 * @return void
	 */
	public function edit_form_after_title() {
		if ( $this->post_type == get_post_type() ) {
			wp_nonce_field( 'bl-section-points-save', '_points_nonce' ); ?>

<h3 class="pull-up">Points</h3>
<p class="description">Enter up to 3 points to make in this section</p>
<?php $rows = get_post_meta( get_the_ID(), 'section_points', true ); ?>
<table class="widefat">
	<thead>
		<tr>
			<th width="30"><img src="<?php echo get_stylesheet_directory_uri(); ?>/images/move.png" alt="Move" title="Move" /></th>
			<th>Text</th>
			<th width="55">Remove</th>
		</tr>
	</thead>
	<tfoot>
		<tr>
			<th colspan="3">
				<a class="button add-row" href="#" <?php if ( count( $rows ) >= 3 ) echo 'disabled="disabled"'; ?>>+ Add row</a>
			</th>
		</tr>
	</tfoot>
	<tbody class="sortable">
		<?php
			if ( ! empty( $rows ) ) {
				foreach( $rows as $id => $item ) {
					$this->item_row_html( $id, $item );
				}
			} else {
				$this->item_row_html( 0 );
			}
		?>
	</tbody>
</table>

<script type="text/template" id="tmpl-new-row">
	<?php $this->item_row_html( '<%=i%>', array() ); ?>
</script>

<h3>Citations</h3>

<?php	}
	}
	
	/**
	 * Gets the HTML for the table row of an investment round item
	 * @param  string $id     ID to be used for input name array keys.
	 *                        Defaults to {$id} for easy replacement (JS)
	 * @param  array  $values Array of values (optional)
	 * @return string
	 */
	private function item_row_html( $id = '<%=i%>', $values = array() ) {
		?>
		<tr class="item" data-i="<?php echo $id; ?>">
			<td class="move">
				<img src="<?php echo get_stylesheet_directory_uri(); ?>/images/drag-handle.png" alt="Drag to move" title="Drag to move" />
			</td>
			<?php
			$title = '';
			$text = '';
			if ( isset( $values['title'] ) )
				$title = ( is_numeric( $id ) )? esc_attr( $values['title'] ): $values['title'];
			if ( isset( $values['text'] ) )
				$text = ( is_numeric( $id ) )? esc_attr( $values['text'] ): $values['text'];
			?>
			<td>
				<input type="text" placeholder="Title" name="points[<?php echo $id; ?>][title]" class="widefat" value="<?php echo $title; ?>" />
				<textarea placeholder="2-4 sentences making this point." name="points[<?php echo $id; ?>][text]" class="widefat"><?php echo $text; ?></textarea>
			</td>
			<td>
				<p>
					<a href="#" class="remove">Remove</a>
				</p>
			</td>
		</tr>
		<?php
	}


}
CPT_Sections::get_instance();