<?php
/**
 * Class Checkout_Page_Settings
 *
 * Configure the plugin settings page.
 */
class Checkout_Page_Settings {

	/**
	 * Capability required by the user to access the My Plugin menu entry.
	 *
	 * @var string $capability
	 */
	private $capability = 'manage_options';

	/**
	 * Array of fields that should be displayed in the settings page.
	 *
	 * @var array $fields
	 */
	private $fields = [
		[
			'id' => 'active',
			'label' => 'Active',
			'description' => '',
			'type' => 'checkbox',
		],
		[
			'id' => 'banner-background-color',
			'label' => 'Banner Background Color',
			'description' => '',
			'type' => 'color',
		],
		[
			'id' => 'active-step-color',
			'label' => 'Active Step Color',
			'description' => '',
			'type' => 'color',
		],
		[
			'id' => 'buttons-font-size',
			'label' => 'Buttons font size',
			'description' => '',
			'type' => 'number',
		],
		[
			'id' => 'buttons-text-color',
			'label' => 'Buttons text color',
			'description' => '',
			'type' => 'color',
		],
        [
			'id' => 'buttons-background-color',
			'label' => 'Buttons background color',
			'description' => '',
			'type' => 'color',
		],
		[
			'id' => 'buttons-padding',
			'label' => 'Buttons border padding',
			'description' => '',
			'type' => 'number',
		],
		[
			'id' => 'buttons-border',
			'label' => 'Border on buttons',
			'description' => '',
			'type' => 'checkbox',
		],
		[
			'id' => 'buttons-border-color',
			'label' => 'Buttons border color',
			'description' => '',
			'type' => 'color',
		],
		[
			'id' => 'buttons-border-size',
			'label' => 'Buttons border size',
			'description' => '',
			'type' => 'number',
		],
		[
			'id' => 'buttons-border-radius',
			'label' => 'Buttons border radius',
			'description' => '',
			'type' => 'number',
		],
	];

	/**
	 * The Plugin Settings constructor.
	 */
	function run() {
		add_action( 'admin_init', [$this, 'settings_init'] );
		add_action( 'admin_menu', [$this, 'options_page'] );
        add_action('wp_head', [$this, 'addCustomStyles']);
	}

	/**
	 * Register the settings and all fields.
	 */
	function settings_init() : void {

		// Register a new setting this page.
		register_setting( 'checkout-page-settings', 'wporg_options' );


		// Register a new section.
		add_settings_section(
			'checkout-page-settings-section',
			__( '', 'checkout-page-settings' ),
			[$this, 'render_section'],
			'checkout-page-settings'
		);


		/* Register All The Fields. */
		foreach( $this->fields as $field ) {
			// Register a new field in the main section.
			add_settings_field(
				$field['id'], /* ID for the field. Only used internally. To set the HTML ID attribute, use $args['label_for']. */
				__( $field['label'], 'checkout-page-settings' ), /* Label for the field. */
				[$this, 'render_field'], /* The name of the callback function. */
				'checkout-page-settings', /* The menu page on which to display this field. */
				'checkout-page-settings-section', /* The section of the settings page in which to show the box. */
				[
					'label_for' => $field['id'], /* The ID of the field. */
					'class' => 'wporg_row', /* The class of the field. */
					'field' => $field, /* Custom data for the field. */
				]
			);
		}
	}

	/**
	 * Add a subpage to the WordPress Settings menu.
	 */
	function options_page() : void {
		add_menu_page(
			'Settings', /* Page Title */
			'Checkout Page', /* Menu Title */
			$this->capability, /* Capability */
			'checkout-page-settings', /* Menu Slug */
			[$this, 'render_options_page'], /* Callback */
			'dashicons-performance', /* Icon */
			'80', /* Position */
		);
	}

	/**
	 * Render the settings page.
	 */
	function render_options_page() : void {

		// check user capabilities
		if ( ! current_user_can( $this->capability ) ) {
			return;
		}

		// add error/update messages

		// check if the user have submitted the settings
		// WordPress will add the "settings-updated" $_GET parameter to the url
		if ( isset( $_GET['settings-updated'] ) ) {
			// add settings saved message with the class of "updated"
			add_settings_error( 'wporg_messages', 'wporg_message', __( 'Settings Saved', 'checkout-page-settings' ), 'updated' );
		}

		// show error/update messages
		settings_errors( 'wporg_messages' );
		?>
		<div class="wrap">
			<h1><?php echo esc_html( get_admin_page_title() ); ?></h1>
			<h2 class="description"></h2>
			<form action="options.php" method="post">
				<?php
				/* output security fields for the registered setting "wporg" */
				settings_fields( 'checkout-page-settings' );
				/* output setting sections and their fields */
				/* (sections are registered for "wporg", each field is registered to a specific section) */
				do_settings_sections( 'checkout-page-settings' );
				/* output save settings button */
				submit_button( 'Save Settings' );
				?>
			</form>
		</div>
		<?php
	}

	/**
	 * Render a settings field.
	 *
	 * @param array $args Args to configure the field.
	 */
	function render_field( array $args ) : void {

		$field = $args['field'];

		// Get the value of the setting we've registered with register_setting()
		$options = get_option( 'wporg_options' );

		switch ( $field['type'] ) {

			case "text": {
				?>
				<input
					type="text"
					id="<?php echo esc_attr( $field['id'] ); ?>"
					name="wporg_options[<?php echo esc_attr( $field['id'] ); ?>]"
					value="<?php echo isset( $options[ $field['id'] ] ) ? esc_attr( $options[ $field['id'] ] ) : ''; ?>"
				>
				<p class="description">
					<?php esc_html_e( $field['description'], 'checkout-page-settings' ); ?>
				</p>
				<?php
				break;
			}

			case "checkbox": {
				?>
				<input
					type="checkbox"
					id="<?php echo esc_attr( $field['id'] ); ?>"
					name="wporg_options[<?php echo esc_attr( $field['id'] ); ?>]"
					value="1"
					<?php echo isset( $options[ $field['id'] ] ) ? ( checked( $options[ $field['id'] ], 1, false ) ) : ( '' ); ?>
				>
				<p class="description">
					<?php esc_html_e( $field['description'], 'checkout-page-settings' ); ?>
				</p>
				<?php
				break;
			}

			case "textarea": {
				?>
				<textarea
					id="<?php echo esc_attr( $field['id'] ); ?>"
					name="wporg_options[<?php echo esc_attr( $field['id'] ); ?>]"
				><?php echo isset( $options[ $field['id'] ] ) ? esc_attr( $options[ $field['id'] ] ) : ''; ?></textarea>
				<p class="description">
					<?php esc_html_e( $field['description'], 'checkout-page-settings' ); ?>
				</p>
				<?php
				break;
			}

			case "select": {
				?>
				<select
					id="<?php echo esc_attr( $field['id'] ); ?>"
					name="wporg_options[<?php echo esc_attr( $field['id'] ); ?>]"
				>
					<?php foreach( $field['options'] as $key => $option ) { ?>
						<option value="<?php echo $key; ?>" 
							<?php echo isset( $options[ $field['id'] ] ) ? ( selected( $options[ $field['id'] ], $key, false ) ) : ( '' ); ?>
						>
							<?php echo $option; ?>
						</option>
					<?php } ?>
				</select>
				<p class="description">
					<?php esc_html_e( $field['description'], 'checkout-page-settings' ); ?>
				</p>
				<?php
				break;
			}

			case "password": {
				?>
				<input
					type="password"
					id="<?php echo esc_attr( $field['id'] ); ?>"
					name="wporg_options[<?php echo esc_attr( $field['id'] ); ?>]"
					value="<?php echo isset( $options[ $field['id'] ] ) ? esc_attr( $options[ $field['id'] ] ) : ''; ?>"
				>
				<p class="description">
					<?php esc_html_e( $field['description'], 'checkout-page-settings' ); ?>
				</p>
				<?php
				break;
			}

			case "wysiwyg": {
				wp_editor(
					isset( $options[ $field['id'] ] ) ? $options[ $field['id'] ] : '',
					$field['id'],
					array(
						'textarea_name' => 'wporg_options[' . $field['id'] . ']',
						'textarea_rows' => 5,
					)
				);
				break;
			}

			case "email": {
				?>
				<input
					type="email"
					id="<?php echo esc_attr( $field['id'] ); ?>"
					name="wporg_options[<?php echo esc_attr( $field['id'] ); ?>]"
					value="<?php echo isset( $options[ $field['id'] ] ) ? esc_attr( $options[ $field['id'] ] ) : ''; ?>"
				>
				<p class="description">
					<?php esc_html_e( $field['description'], 'checkout-page-settings' ); ?>
				</p>
				<?php
				break;
			}

			case "url": {
				?>
				<input
					type="url"
					id="<?php echo esc_attr( $field['id'] ); ?>"
					name="wporg_options[<?php echo esc_attr( $field['id'] ); ?>]"
					value="<?php echo isset( $options[ $field['id'] ] ) ? esc_attr( $options[ $field['id'] ] ) : ''; ?>"
				>
				<p class="description">
					<?php esc_html_e( $field['description'], 'checkout-page-settings' ); ?>
				</p>
				<?php
				break;
			}

			case "color": {
				?>
				<input
					type="color"
					id="<?php echo esc_attr( $field['id'] ); ?>"
					name="wporg_options[<?php echo esc_attr( $field['id'] ); ?>]"
					value="<?php echo isset( $options[ $field['id'] ] ) ? esc_attr( $options[ $field['id'] ] ) : ''; ?>"
				>
				<p class="description">
					<?php esc_html_e( $field['description'], 'checkout-page-settings' ); ?>
				</p>
				<?php
				break;
			}

			case "date": {
				?>
				<input
					type="date"
					id="<?php echo esc_attr( $field['id'] ); ?>"
					name="wporg_options[<?php echo esc_attr( $field['id'] ); ?>]"
					value="<?php echo isset( $options[ $field['id'] ] ) ? esc_attr( $options[ $field['id'] ] ) : ''; ?>"
				>
				<p class="description">
					<?php esc_html_e( $field['description'], 'checkout-page-settings' ); ?>
				</p>
				<?php
				break;
			}
			case "number": {
				?>
				<input
					type="number"
					id="<?php echo esc_attr( $field['id'] ); ?>"
					name="wporg_options[<?php echo esc_attr( $field['id'] ); ?>]"
					value="<?php echo isset( $options[ $field['id'] ] ) ? esc_attr( $options[ $field['id'] ] ) : ''; ?>"
				>
				<p class="description">
					<?php esc_html_e( $field['description'], 'checkout-page-settings' ); ?>
				</p>
				<?php
				break;
			}

		}
	}


	/**
	 * Render a section on a page, with an ID and a text label.
	 *
	 * @since 1.0.0
	 *
	 * @param array $args {
	 *     An array of parameters for the section.
	 *
	 *     @type string $id The ID of the section.
	 * }
	 */
	function render_section( array $args ) : void {
		?>
		<p id="<?php echo esc_attr( $args['id'] ); ?>"><?php esc_html_e( '', 'checkout-page-settings' ); ?></p>
		<?php
	}

    function addCustomStyles(){
        $options = get_option( 'wporg_options' );
        $bannerColor = $options['banner-background-color'];
        $currentStepColor = $options['active-step-color'];
        $buttonsBackgroundColor = $options['buttons-background-color'];
		$buttonsFontSize = $options['buttons-font-size'];
        $buttonsTextColor = $options['buttons-text-color'];
		$buttonsBorderColor = $options['buttons-border-color'];
		$buttonsBorderSize = $options['buttons-border-size'];
		$buttonsPadding = $options['buttons-padding'];
		$buttonsBorderRadius = $options['buttons-border-radius'];
		
        $active = "";
        if(!isset($options['active'])){
            $active = "#custom-checkout-page-section-button-containers-container{display:none !important}";
        }
		$border = "border:none !important";
        if(isset($options['active'])){
			if($buttonsBorderSize){
				$border = "border:solid " . $buttonsBorderSize . "px";
			}else{
				$border = "border:solid 1px";
			}
            
        }
        $custom_css = "" . $active . "
        #custom-checkout-page-section-button-containers-container {
                background-color: {$bannerColor} !important;
        }
        .custom-checkout-page-section-button-container.current{
            background-color: {$currentStepColor} !important;
        }
        .custom-checkout-page-section-change-button-neighbour{
			font-size:" . $buttonsFontSize . "px;
            background-color: {$buttonsBackgroundColor} !important;
            color: {$buttonsTextColor} !important;
			" . $border . ";
			border-color: " . $buttonsBorderColor . ";
			padding:" . $buttonsPadding . "px;
			border-radius:" . $buttonsBorderRadius . "px;
        }";
        
        echo "<style>" . $custom_css . "</style>";
    }
}