<?php
/**
 * The deactivate feedback model class for ThemeIsle SDK
 *
 * @package     ThemeIsleSDK
 * @subpackage  Feedback
 * @copyright   Copyright (c) 2017, Marius Cristea
 * @license     http://opensource.org/licenses/gpl-3.0.php GNU Public License
 * @since       1.0.0
 */
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
if ( ! class_exists( 'ThemeIsle_SDK_Feedback_Deactivate' ) ) :
	/**
	 * Deactivate feedback model for ThemeIsle SDK.
	 */
	class ThemeIsle_SDK_Feedback_Deactivate extends ThemeIsle_SDK_Feedback {

		/**
		 * @var array $options_plugin The main options list for plugins.
		 */
		private $options_plugin = array(
			'I only needed the plugin for a short period' => array(
				'id' => 1,
			),
			'The plugin broke my site'                    => array(
				'id' => 2,
			),
			'I found a better plugin'                     => array(
				'id'          => 3,
				'type'        => 'text',
				'placeholder' => 'What\'s the plugin\'s name?',
			),
			'The plugin suddenly stopped working'         => array(
				'id' => 4,
			),
			'I no longer need the plugin'                 => array(
				'id'          => 5,
				'type'        => 'textarea',
				'placeholder' => 'If you could improve one thing about our product, what would it be?',
			),
			'It\'s a temporary deactivation. I\'m just debugging an issue.' => array(
				'id' => 6,
			),
		);

		/**
		 * @var array $options_theme The main options list for themes.
		 */
		private $options_theme = array(
			'I don\'t know how to make it look like demo' => array(
				'id' => 7,
			),
			'It lacks options'                            => array(
				'id' => 8,
			),
			'Is not working with a plugin that I need'    => array(
				'id'          => 9,
				'type'        => 'text',
				'placeholder' => 'What is the name of the plugin',
			),
			'I want to try a new design, I don\'t like {theme} style' => array(
				'id' => 10,
			),
		);

		/**
		 * @var array $other The other option
		 */
		private $other = array(
			'Other' => array(
				'id'          => 999,
				'type'        => 'textarea',
				'placeholder' => 'cmon cmon tell us',
			),
		);

		/**
		 * @var string $heading_plugin The heading of the modal
		 */
		private $heading_plugin = 'If you have a moment, please let us know why you are deactivating:';

		/**
		 * @var string $heading_theme The heading of the modal
		 */
		private $heading_theme = 'Looking to change {theme}, what doesn\'t work for you?';

		/**
		 * @var string $button_submit_before The text of the deactivate button before an option is chosen
		 */
		private $button_submit_before = 'Skip &amp; Deactivate';

		/**
		 * @var string $button_submit The text of the deactivate button
		 */
		private $button_submit = 'Submit &amp; Deactivate';

		/**
		 * @var string $button_cancel The text of the cancel button
		 */
		private $button_cancel = 'Cancel';

		/**
		 * @var int how many seconds before the deactivation window is triggered for themes
		 */
		const AUTO_TRIGGER_DEACTIVATE_WINDOW_SECONDS = 3;

		/**
		 * @var int how many days before the deactivation window pops up again for the theme
		 */
		const PAUSE_DEACTIVATE_WINDOW_DAYS = 100;

		/**
		 * ThemeIsle_SDK_Feedback_Deactivate constructor.
		 *
		 * @param ThemeIsle_SDK_Product $product_object The product object.
		 */
		public function __construct( $product_object ) {
			parent::__construct( $product_object );
		}

		/**
		 * Registers the hooks
		 */
		public function setup_hooks_child() {
			global $pagenow;

			if ( ( $this->product->get_type() === 'plugin' && $pagenow === 'plugins.php' ) || ( $this->product->get_type() === 'theme' && $pagenow === 'theme-install.php' ) ) {
				add_action( 'admin_head', array( $this, 'load_resources' ) );
			}
			add_action( 'wp_ajax_' . $this->product->get_key() . __CLASS__, array( $this, 'post_deactivate' ) );
		}

		/**
		 * Loads the additional resources
		 */
		function load_resources() {
			add_thickbox();

			$id = $this->product->get_key() . '_deactivate';

			$this->add_css( $this->product->get_type(), $this->product->get_key() );
			$this->add_js( $this->product->get_type(), $this->product->get_key(), '#TB_inline?' . apply_filters( $this->product->get_key() . '_feedback_deactivate_attributes', 'width=600&height=550' ) . '&inlineId=' . $id );

			echo '<div id="' . $id . '" style="display:none;" class="themeisle-deactivate-box">' . $this->get_html( $this->product->get_type(), $this->product->get_key() ) . '</div>';
		}

		/**
		 * Loads the css
		 *
		 * @param string $type The type of product.
		 * @param string $key The product key.
		 */
		function add_css( $type, $key ) {
			$suffix = 'theme' === $type ? 'theme-install-php' : 'plugins-php';
			?>
			<style type="text/css" id="<?php echo $key; ?>ti-deactivate-css">
				input[name="ti-deactivate-option"] ~ div {
					display: none;
				}

				input[name="ti-deactivate-option"]:checked ~ div {
					display: block;
				}

				body.<?php echo $suffix; ?> .<?php echo $key; ?>-container #TB_window.thickbox-loading:before {
					background: none !important;
				}

				body.<?php echo $suffix; ?> .<?php echo $key; ?>-container #TB_title {
					font-size: 21px;
					padding: 20px 0;
					background-color: #f3f3f3;
				}

				body.<?php echo $suffix; ?> .<?php echo $key; ?>-container div.actions {
					padding: 20px 0;
					background-color: #f3f3f3;
					border-top: 1px solid #dddddd;
				}

				body.<?php echo $suffix; ?> .<?php echo $key; ?>-container input.button.button-primary {
					margin-right: 20px;
				}

				body.<?php echo $suffix; ?> .<?php echo $key; ?>-container input.button {
					margin-right: 20px;
				}

				body.<?php echo $suffix; ?> .<?php echo $key; ?>-container #TB_ajaxWindowTitle {
					text-align: left;
					margin-left: 15px;
				}

				body.<?php echo $suffix; ?> .<?php echo $key; ?>-container div.revive_network-container {
					background-color: #ffffff;
				}

				body.<?php echo $suffix; ?> .<?php echo $key; ?>-container ul.ti-list li {
					font-size: 14px;
				}

				body.<?php echo $suffix; ?> .<?php echo $key; ?>-container ul.ti-list li label {
					margin-left: 10px;
					line-height: 32px;
					font-size: 16px;
				}

				body.<?php echo $suffix; ?> .<?php echo $key; ?>-container #TB_ajaxContent {
					padding: 10px 20px;
				}

				body.<?php echo $suffix; ?> .<?php echo $key; ?>-container li div textarea {
					padding: 10px 15px;
					width: 100%;
				}

				body.<?php echo $suffix; ?> .<?php echo $key; ?>-container ul.ti-list li div {
					margin: 10px 30px;
				}

				.<?php echo $key; ?>-container #TB_title #TB_ajaxWindowTitle {
					display: block;
				}

				body.<?php echo $suffix; ?> .<?php echo $key; ?>-container .actions {

					width: 100%;
					display: block;
					position: absolute;
					left: 0px;
					bottom: 0px;
					text-align: right;
				}

				body.<?php echo $suffix; ?> .<?php echo $key; ?>-container #TB_title {

					height: 33px;
					width: 100%;
					text-align: center;
				}

				.theme-install-php .<?php echo $key; ?>-container #TB_closeWindowButton .tb-close-icon:before {
					font-size: 32px;
				}

				.<?php echo $key; ?>-container #TB_closeWindowButton .tb-close-icon {

					color: #eee;
				}

				.<?php echo $key; ?>-container #TB_closeWindowButton {
					left: auto;
					right: -30px;
					color: #eee;
				}

				body.<?php echo $suffix; ?> .<?php echo $key; ?>-container {

					margin: auto !important;
					height: 550px !important;
					top: 0 !important;
					left: 0 !important;
					bottom: 0 !important;
					right: 0 !important;
				}
			</style>
			<?php
		}

		/**
		 * Loads the js
		 *
		 * @param string $type The type of product.
		 * @param string $key The product key.
		 * @param string $src The url that will hijack the deactivate button url.
		 */
		function add_js( $type, $key, $src ) {
			$heading = 'plugin' === $type ? $this->heading_plugin : str_replace( '{theme}', $this->product->get_name(), $this->heading_theme );
			$heading = apply_filters( $this->product->get_key() . '_feedback_deactivate_heading', $heading );
			?>
			<script type="text/javascript" id="ti-deactivate-js">
				(function ($) {
					$(document).ready(function () {
						var auto_trigger = false;
						var target_element = 'tr[data-plugin^="<?php echo $this->product->get_slug(); ?>/"] span.deactivate a';
						<?php
						if ( 'theme' === $type ) {
						?>
						auto_trigger = true;
						if ($('a.ti-auto-anchor').length == 0) {
							$('body').append($('<a class="ti-auto-anchor" href=""></a>'));
						}
						target_element = 'a.ti-auto-anchor';
						<?php
						}
						?>

						if (auto_trigger) {
							setTimeout(function () {
								$('a.ti-auto-anchor').trigger('click');
							}, <?php echo self::AUTO_TRIGGER_DEACTIVATE_WINDOW_SECONDS * 1000; ?> );
						}
						$( document ).on( 'thickbox:removed', function() {
							$.ajax({
								url: ajaxurl,
								method: 'post',
								data: {
									'action'	: '<?php echo $key . __CLASS__; ?>',
									'nonce'		: '<?php echo wp_create_nonce( (string) __CLASS__ ); ?>',
									'type'		: '<?php echo $type; ?>',
									'key'		: '<?php echo $key; ?>'
								},
							});
						});
						var href = $(target_element).attr('href');
						$('#<?php echo $key; ?>ti-deactivate-no').on('click', function (e) {
							e.preventDefault();
							e.stopPropagation();

							$('body').unbind('thickbox:removed');
							tb_remove();
						});

						$('#<?php echo $key; ?> ul.ti-list label, #<?php echo $key; ?> ul.ti-list input[name="ti-deactivate-option"]').on('click', function (e) {
							$('#<?php echo $key; ?>ti-deactivate-yes').val($('#<?php echo $key; ?>ti-deactivate-yes').attr('data-after-text'));

							var radio = $(this).prop('tagName') === 'LABEL' ? $(this).parent() : $(this);
							if (radio.parent().find('textarea').length > 0 && radio.parent().find('textarea').val().length === 0) {
								$('#<?php echo $key; ?>ti-deactivate-yes').attr('disabled', 'disabled');
								radio.parent().find('textarea').on('keyup', function (ee) {
									if ($(this).val().length === 0) {
										$('#<?php echo $key; ?>ti-deactivate-yes').attr('disabled', 'disabled');
									} else {
										$('#<?php echo $key; ?>ti-deactivate-yes').removeAttr('disabled');
									}
								});
							} else {
								$('#<?php echo $key; ?>ti-deactivate-yes').removeAttr('disabled');
							}
						});

						$('#<?php echo $key; ?>ti-deactivate-yes').attr('data-ti-action', href).on('click', function (e) {
							e.preventDefault();
							e.stopPropagation();
							$.ajax({
								url: ajaxurl,
								method: 'post',
								data: {
									'action'	: '<?php echo $key . __CLASS__; ?>',
									'nonce'		: '<?php echo wp_create_nonce( (string) __CLASS__ ); ?>',
									'id'		: $('#<?php echo $key; ?> input[name="ti-deactivate-option"]:checked').parent().attr('ti-option-id'),
									'msg'		: $('#<?php echo $key; ?> input[name="ti-deactivate-option"]:checked').parent().find('textarea').val(),
									'type'		: '<?php echo $type; ?>',
									'key'		: '<?php echo $key; ?>'
								},
							});
							var redirect = $(this).attr('data-ti-action');
							if (redirect != '') {
								location.href = redirect;
							} else {
								$('body').unbind('thickbox:removed');
								tb_remove();
							}
						});

						$(target_element).attr('name', '<?php echo esc_html( $heading ); ?>').attr('href', '<?php echo $src; ?>').addClass('thickbox');
						var thicbox_timer;
						$(target_element).on('click', function () {
							tiBindThickbox();
						});

						function tiBindThickbox() {
							var thicbox_timer = setTimeout(function () {
								if ($("#<?php echo esc_html( $key ); ?>").is(":visible")) {
									$("body").trigger('thickbox:iframe:loaded');
									$("#TB_window").addClass("<?php echo $key; ?>-container");
									clearTimeout(thicbox_timer);
									$('body').unbind('thickbox:removed');
								} else {
									tiBindThickbox();
								}
							}, 100);
						}
					});
				})(jQuery);
			</script>
			<?php
		}

		/**
		 * Generates the HTML
		 *
		 * @param string $type The type of product.
		 * @param string $key The product key.
		 */
		function get_html( $type, $key ) {
			$options              = 'plugin' === $type ? $this->options_plugin : $this->options_theme;
			$button_submit_before = 'plugin' === $type ? $this->button_submit_before : 'Submit';
			$button_submit        = 'plugin' === $type ? $this->button_submit : 'Submit';
			$options              = $this->randomize_options( apply_filters( $this->product->get_key() . '_feedback_deactivate_options', $options ) );
			$button_submit_before = apply_filters( $this->product->get_key() . '_feedback_deactivate_button_submit_before', $button_submit_before );
			$button_submit        = apply_filters( $this->product->get_key() . '_feedback_deactivate_button_submit', $button_submit );
			$button_cancel        = apply_filters( $this->product->get_key() . '_feedback_deactivate_button_cancel', $this->button_cancel );

			$options += $this->other;

			$list = '';
			foreach ( $options as $title => $attributes ) {
				$id    = $attributes['id'];
				$list .= '<li ti-option-id="' . $id . '"><input type="radio" name="ti-deactivate-option" id="' . $key . $id . '"><label for="' . $key . $id . '">' . str_replace( '{theme}', $this->product->get_name(), $title ) . '</label>';
				if ( array_key_exists( 'type', $attributes ) ) {
					$list       .= '<div>';
					$placeholder = array_key_exists( 'placeholder', $attributes ) ? $attributes['placeholder'] : '';
					switch ( $attributes['type'] ) {
						case 'text':
							$list .= '<textarea style="width: 100%" rows="1" name="comments" placeholder="' . $placeholder . '"></textarea>';
							break;
						case 'textarea':
							$list .= '<textarea style="width: 100%" rows="2" name="comments" placeholder="' . $placeholder . '"></textarea>';
							break;
					}
					$list .= '</div>';
				}
				$list .= '</li>';
			}

			return '<div id="' . $this->product->get_key() . '">'
				   . '<ul class="ti-list">' . $list . '</ul>'
				   . '<div class="actions">'
				   . get_submit_button(
					   $button_submit_before, 'secondary', $this->product->get_key() . 'ti-deactivate-yes', false, array(
						   'data-after-text' => $button_submit,
					   )
				   )
				   . get_submit_button( $button_cancel, 'primary', $this->product->get_key() . 'ti-deactivate-no', false )
				   . '</div></div>';
		}

		/**
		 * Called when the deactivate button is clicked
		 */
		function post_deactivate() {
			check_ajax_referer( (string) __CLASS__, 'nonce' );

			if ( ! empty( $_POST['id'] ) ) {
				$this->call_api(
					array(
						'type'    => 'deactivate',
						'id'      => $_POST['id'],
						'comment' => isset( $_POST['msg'] ) ? $_POST['msg'] : '',
					)
				);
			}

			$this->post_deactivate_or_cancel();
		}

		/**
		 * Called when the deactivate/cancel button is clicked
		 */
		private function post_deactivate_or_cancel() {
			if ( isset( $_POST['type'] ) && isset( $_POST['key'] ) && 'theme' === $_POST['type'] ) {
				set_transient( 'ti_sdk_pause_' . $_POST['key'], true, PAUSE_DEACTIVATE_WINDOW_DAYS * DAY_IN_SECONDS );
			}
		}
	}
endif;
