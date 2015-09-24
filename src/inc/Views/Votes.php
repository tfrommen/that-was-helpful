<?php # -*- coding: utf-8 -*-

namespace tfrommen\ThatWasHelpful\Views;

use tfrommen\ThatWasHelpful\Models\Nonce as NonceModel;
use tfrommen\ThatWasHelpful\Models\Post as PostModel;
use tfrommen\ThatWasHelpful\Models\State as StateModel;

/**
 * Votes view.
 *
 * @package tfrommen\ThatWasHelpful\Views
 */
class Votes {

	/**
	 * @var NonceModel
	 */
	private $nonce;

	/**
	 * @var PostModel
	 */
	private $post;

	/**
	 * @var StateModel
	 */
	private $state;

	/**
	 * Constructor. Sets up class variables.
	 *
	 * @param StateModel $state State model.
	 * @param PostModel  $post  Post model.
	 * @param NonceModel $nonce Nonce model.
	 */
	public function __construct( StateModel $state, PostModel $post, NonceModel $nonce ) {

		$this->state = $state;

		$this->post = $post;

		$this->nonce = $nonce;
	}

	/**
	 * Appends the rendered HTML to the given output.
	 *
	 * @wp-hook the_content
	 * @wp-hook the_excerpt
	 *
	 * @param string $output Output.
	 *
	 * @return string
	 */
	public function append( $output ) {

		ob_start();
		$this->render();

		return $output . ob_get_clean();
	}

	/**
	 * Renders the HTML.
	 *
	 * @wp-hook that_was_helpful
	 *
	 * @param int $post_id Optional. Post ID. Defaults to 0.
	 *
	 * @return void
	 */
	public function render( $post_id = 0 ) {

		if ( ! $post_id ) {
			$post_id = get_the_ID();
			if ( ! $post_id ) {
				return;
			}
		}

		$this->post->set_post_id( $post_id );

		$this->state->set_active();

		$data = $this->post->get_data();
		?>
		<div class="that-was-helpful that-was-helpful--<?php echo $post_id; ?>">
			<?php if ( is_user_logged_in() ) : ?>
				<form action="" method="POST" class="that-was-helpful__form">
					<?php $this->nonce->print_field(); ?>
					<input type="hidden" name="vote_post" value="<?php echo $post_id; ?>">
					<?php
					$class = 'that-was-helpful__submit button';

					if ( $data->vote ) {
						$class .= ' active';
						$title = $data->titles[ 'active' ];
					} else {
						$title = $data->titles[ 'vote' ];
					}
					?>
					<input type="submit" name="vote"
						value="<?php echo esc_attr_x( 'That was helpful', 'Vote button text', 'that-was-helpful' ); ?>"
						class="<?php echo $class; ?>" title="<?php echo $title; ?>">
				</form>
			<?php endif; ?>
			<span class="that-was-helpful__votes">
				<?php
				$string = _nx(
					'%d visitor found that helpful.',
					'%d visitors found that helpful.',
					$data->votes,
					'Vote description',
					'that-was-helpful'
				);
				$string = esc_html( $string );
				printf( $string, $data->votes );
				?>
			</span>
		</div>
		<?php
	}

}
