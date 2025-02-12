<?php // @codingStandardsIgnoreLine
/**
 * Ask for a review class
 *
 * @package ultraDevsSL
 * @since 1.0.0
 */

namespace ultraDevs\SL;

use ultraDevs\SL\Helper;

/**
 * Ask for a review class
 *
 * @package ultraDevsSL
 * @since 2.0.3
 */
class Review {

	/**
	 * Plugin slug
	 *
	 * @var string
	 */
	public $slug = 'sticky-list';

	/**
	 * Constructor
	 */
	public function __construct() {}

	/**
	 * Register.
	 *
	 * @return void
	 */
	public function register() {
		add_action( 'admin_init', array( $this, 'action' ) );
		add_action( 'admin_notices', array( $this, 'review_notice' ) );
	}

	/**
	 * Action
	 *
	 * @return void
	 */
	public function action() {
		if ( isset( $_GET['sticky_list_admin_action'] ) && isset( $_GET['_nonce'] ) ) {

			$action = sanitize_text_field( wp_unslash( $_GET['sticky_list_admin_action'] ) );

			if ( wp_verify_nonce( sanitize_text_field( wp_unslash( $_GET['_nonce'] ) ), 'sticky_list_admin_action_nonce' ) ) { // @codingStandardsIgnoreLine.
				switch ( $action ) {
					case 'review_already_did':
						Helper::update_option( 'sticky_list_review_already_did', 'yes' );
						break;
					case 'review_later':
						Helper::update_option( 'sticky_list_review_later_time', current_time( 'timestamp' ) ); // phpcs:ignore
						break;
				}
			}

			// Remove action & nonce arg and redirect.
			wp_safe_redirect( esc_url_raw( remove_query_arg( array( 'sticky_list_admin_action', '_nonce' ) ) ) );
		}
	}

	/**
	 * Review Notice.
	 *
	 * @return void
	 */
	public function review_notice() {

		// Check if already did.
		if ( 'yes' === Helper::get_option( 'sticky_list_review_already_did' ) ) {
			return;
		}

		$install_date     = Helper::get_option( 'sticky_list_installed_datetime' );
		$maybe_later_date = Helper::get_option( 'sticky_list_review_later_time' );

		if ( ! empty( $maybe_later_date ) ) {

			$maybe_later_days = Helper::time_to_days( $maybe_later_date );

			if ( $maybe_later_days < 3 ) {
				return;
			}
		} elseif ( ! empty( $install_date ) ) {
				$installed_days = Helper::time_to_days( $install_date );
			if ( $installed_days < 3 ) {
				return;
			}
		}

		$nonce = wp_create_nonce( 'sticky_list_admin_action_nonce' );

		$review_url = 'https://wordpress.org/support/plugin/' . $this->slug . '/reviews/?filter=5#new-post';

		$review_later_link       = add_query_arg(
			array(
				'sticky_list_admin_action' => 'review_later',
				'_nonce'                   => $nonce,
			)
		);
		$review_already_did_link = add_query_arg(
			array(
				'sticky_list_admin_action' => 'review_already_did',
				'_nonce'                   => $nonce,
			)
		);

		$notice_msg = sprintf(
			// translators: %1$s Plugin Name.
			__( 'Hey, we noticed you have been using %1$s for more than 3 days now - that\'s awesome! <br> Could you please do us a BIG favor and give it a rating on WordPress.org to help us do more great work and boost our motivation?', 'sticky-list' ),
			'<strong>' . STICKY_LIST_NAME . '</strong>'
		);
		?>
		<style>
			.ud-review-notice {
				border-left-color: #5820e5;
			}
			.ud-review-notice p {
				color: #555;
				font-size: 14px;
				line-height: 22px;
			}
			.ud-review-notice p a {
				color: #5820e5;
			}
			.ud-review-notice__btns {
				display: flex;
				margin: 15px 0;
			}
			.ud-review-notice__btn {
				text-decoration: none;
				padding: 5px 10px;
				background: #f7f7f7;
				margin-right: 5px;
				border-radius: 5px;
				color: #5820e5;
			}
			.ud-review-notice__btn:hover {
				color: #f30d55;
			}
			.ud-review-notice__btn span {
				margin-right: 3px;
			}
		</style>
		<div class="ud-review-notice notice notice-info is-dismissible">
			<p>
				<?php
					echo wp_kses(
						$notice_msg,
						array(
							'strong' => array(),
							'br'     => array(),
						)
					);
				?>
			</p>
			<p>
				<strong>Mahbub Hasan Imon</strong>
				<br>
				Founder & CEO, <a href="https://ultradevs.com/" target="_blank">ultraDevs</a>
			</p>
			<div class="ud-review-notice__btns">
					<a href="<?php echo esc_url( $review_url ); ?>" target="_blank" class="ud-review-notice__btn">
						<span class="dashicons dashicons-welcome-write-blog"></span>
						<?php echo esc_html__( 'Yes, you deserve it', 'sticky-list' ); ?>
					</a>
					<a href="<?php echo esc_url( $review_later_link ); ?>" class="ud-review-notice__btn">
						<span class="dashicons dashicons-calendar"></span>
						<?php echo esc_html__( 'No, maybe later', 'sticky-list' ); ?>
					</a>
					<a href="<?php echo esc_url( $review_already_did_link ); ?>" class="ud-review-notice__btn">
						<span class="dashicons dashicons-smiley"></span>
						<?php echo esc_html__( 'I already did', 'sticky-list' ); ?>
					</a>
			</div>
		</div>
		<?php
	}
}
