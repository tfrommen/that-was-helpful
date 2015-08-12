<?php # -*- coding: utf-8 -*-

namespace tf\ThatWasHelpful\Views;

use tf\ThatWasHelpful\Models;
use tf\ThatWasHelpful\Models\SettingsPage as Model;

/**
 * Class SettingsPage
 *
 * @package tf\ThatWasHelpful\Views
 */
class SettingsPage {

	/**
	 * @var Model
	 */
	private $model;

	/**
	 * @var string
	 */
	private $title;

	/**
	 * Constructor. Set up the properties.
	 *
	 * @param Model $model Model.
	 */
	public function __construct( Model $model ) {

		$this->model = $model;

		$this->title = esc_html_x( 'That Was Helpful', 'Settings page title', 'that-was-helpful' );
	}

	/**
	 * Add the settings page to the Settings menu.
	 *
	 * @wp-hook admin_menu
	 *
	 * @return void
	 */
	public function add() {

		$menu_title = esc_html_x( 'That Was Helpful', 'Menu item title', 'that-was-helpful' );
		add_options_page(
			$this->title,
			$menu_title,
			$this->model->get_capability(),
			$this->model->get_slug(),
			array( $this, 'render' )
		);
	}

	/**
	 * Render the HTML.
	 *
	 * @return void
	 */
	public function render() {

		$option_name = Models\Option::get_name();

		$option = Models\Option::get();
		?>
		<div class="wrap">
			<h2>
				<?php echo $this->title; ?>
			</h2>

			<form action="<?php echo admin_url( 'options.php' ); ?>" method="post">
				<?php settings_fields( $option_name ); ?>

				<table class="form-table">
					<tbody>
					<tr>
						<th scope="row">
							<?php esc_html_e( 'Automatic Appending', 'that-was-helpful' ); ?>
						</th>
						<td>
							<fieldset>
								<?php
								$id = 'append-to-content';
								$name = 'append_to_content';
								?>
								<label for="<?php echo $id; ?>">
									<input name="<?php echo "{$option_name}[{$name}]"; ?>" type="checkbox" value="1"
										id="<?php echo $id; ?>" <?php checked( ! empty( $option[ $name ] ) ); ?>>
									<?php
									$string = esc_html_x(
										'Automatically append to content with priority %s',
										'%s = Priority input element', 'that-was-helpful'
									);

									$id .= '-priority';
									$name .= '_priority';
									$value = isset( $option[ $name ] ) ? (int) $option[ $name ] : 10;
									$input = '</label>'
										. '<label for="' . $id . '">'
										. '<input name="' . "{$option_name}[{$name}]" . '" type="number" step="1"
											value="' . $value . '" id="' . $id . '" class="small-text">';

									printf( $string, $input );
									?>
								</label>
								<br>
								<?php
								$id = 'append-to-excerpt';
								$name = 'append_to_excerpt';
								?>
								<label for="<?php echo $id; ?>">
									<input name="<?php echo "{$option_name}[{$name}]"; ?>" type="checkbox" value="1"
										id="<?php echo $id; ?>" <?php checked( ! empty( $option[ $name ] ) ); ?>>
									<?php
									$string = esc_html_x(
										'Automatically append to excerpt with priority %s',
										'%s = Priority input element', 'that-was-helpful'
									);

									$id .= '-priority';
									$name .= '_priority';
									$value = isset( $option[ $name ] ) ? (int) $option[ $name ] : 10;
									$input = '</label>'
										. '<label for="' . $id . '">'
										. '<input name="' . "{$option_name}[{$name}]" . '" type="number" step="1"
											value="' . $value . '" id="' . $id . '" class="small-text">';

									printf( $string, $input );
									?>
								</label>
							</fieldset>
						</td>
					</tr>
					</tbody>
				</table>

				<?php submit_button(); ?>
			</form>
		</div>
	<?php
	}

}
