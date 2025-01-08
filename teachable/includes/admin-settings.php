<?php
/**
 * Core file.
 * Resist deletion.
 *
 * Admin Settings.
 * The dashboard settings page for this plugin.
 *
 * @package Teachable
 * @version 1.0.0
 */

namespace Teachable;

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

wp_enqueue_style( 'teachable-admin' );
wp_enqueue_script( 'teachable-admin' );

$general_tab_url = admin_settings_tab_url( 'general' );
$how_tab_url     = admin_settings_tab_url( 'how' );
$sync_tab_url    = admin_settings_tab_url( 'sync' );

$page_tab = isset( $_GET['tab'] ) && isset( $_GET['_wpnonce'] ) && wp_verify_nonce( sanitize_text_field( wp_unslash( $_GET['_wpnonce'] ) ), 'teachable_tab_nonce' )
	? sanitize_text_field( wp_unslash( $_GET['tab'] ) )
	: 'general';

$general_settings   = get_option( 'teachable_general_settings', array() );
$school_name        = isset( $general_settings['school_name'] ) ? $general_settings['school_name'] : '';
$sync_time          = isset( $general_settings['sync_time'] ) ? $general_settings['sync_time'] : '2:00 AM';
$last_sync          = isset( $general_settings['last_sync'] ) ? $general_settings['last_sync'] : esc_html__( 'Last known data sync has not been recorded', 'teachable' );
$is_delete_data_set = isset( $general_settings['delete_data'] ) && 1 === $general_settings['delete_data'];

$default_time = '2:00 AM';
$sync_time    = $general_settings['sync_time'] ?? $default_time;

$time_parts  = explode( ' ', $sync_time );
$hour_minute = explode( ':', $time_parts[0] );
$hour        = $hour_minute[0];
$minute      = $hour_minute[1];
$ampm        = $time_parts[1] ?? 'AM';
?>
<div class="teachable-page">
	<header class="header">
		<a href="https://teachable.com/" target="_blank" class="logo">
			<svg width="50" height="51" viewBox="0 0 50 51" fill="none" xmlns="http://www.w3.org/2000/svg" class="icon">
				<rect y="0.186401" width="50" height="50" rx="8" fill="#21CD9C"/>
				<g clip-path="url(#clip0_1327_1184)">
					<mask id="mask0_1327_1184" style="mask-type:luminance" maskUnits="userSpaceOnUse" x="13" y="10" width="24" height="32">
						<path d="M37 10.1864H13V41.1864H37V10.1864Z" fill="white"/>
					</mask>
					<g mask="url(#mask0_1327_1184)">
						<path d="M36.9433 19.3303V24.0605H32.3154V19.3303H36.9433ZM36.9433 36.5038V41.1864H32.3154V36.5038H36.9433Z" fill="#222222"/>
						<path d="M21.6603 10.1864V19.3346H28.1138V22.9766H21.6603V33.9025C21.6603 36.2438 22.9164 37.5444 25.0386 37.5444H28.1138V41.1864H24.6922C20.2744 41.1864 17.4591 38.4982 17.4591 34.0325V22.9766H12.998V19.3346H17.4591V10.1864H21.6603Z" fill="#222222"/>
					</g>
				</g>
				<defs>
					<clipPath id="clip0_1327_1184">
						<rect width="24" height="31" fill="white" transform="translate(13 10.1864)"/>
					</clipPath>
				</defs>
			</svg>


			<svg width="346" height="57" viewBox="0 0 346 57" fill="none" xmlns="http://www.w3.org/2000/svg" class="wordmark">
				<path d="M15.718 0V16.5825H27.4278V23.184H15.718V42.9885C15.718 47.2325 17.9971 49.5901 21.848 49.5901H27.4278V56.1918H21.2192C13.2031 56.1918 8.09475 51.3192 8.09475 43.2244V23.184H0V16.5825H8.09475V0H15.718Z" fill="#21CD9C"/>
				<path d="M67.7447 43.3036C66.3301 51.4768 59.1785 56.821 49.4333 56.821C37.1735 56.821 29.5503 47.1545 29.5503 36.1518C29.5503 25.0707 36.4661 15.9543 48.6476 15.9543C60.9074 15.9543 67.4304 24.6777 67.4304 34.7372C67.4304 35.7589 67.3519 37.0165 67.2734 37.7236H37.0162C37.6449 45.1896 42.5175 50.298 49.4333 50.298C55.2491 50.298 59.0212 47.7832 60.1215 43.3036H67.7447ZM37.252 32.1439H59.7286C59.257 26.0925 55.1704 22.0843 48.6476 22.0843C42.439 22.0843 38.4308 25.5422 37.252 32.1439Z" fill="#21CD9C"/>
				<path d="M106.253 30.6505V56.1923H98.6299V49.7479C96.7437 53.9918 91.7138 56.821 85.7412 56.821C77.6464 56.821 72.3021 51.9484 72.3021 44.8753C72.3021 37.252 78.3538 32.5367 87.7059 32.5367H95.9578C97.7654 32.5367 98.6299 31.5937 98.6299 30.1792C98.6299 25.3851 95.1718 22.0843 89.042 22.0843C83.5407 22.0843 79.5325 25.5422 79.2967 29.5503H72.2236C72.8523 21.7699 79.9254 15.9543 89.2775 15.9543C99.4943 15.9543 106.253 21.8485 106.253 30.6505ZM98.6299 38.8239V37.8809H88.4131C83.2261 37.8809 79.8469 40.5528 79.8469 44.7182C79.8469 48.3333 82.8333 50.7696 87.2343 50.7696C94.4644 50.7696 98.6299 46.1328 98.6299 38.8239Z" fill="#21CD9C"/>
				<path d="M111.597 36.3876C111.597 25.4637 118.749 15.9543 131.244 15.9543C140.518 15.9543 148.534 21.4556 149.634 30.4147H142.011C141.304 25.9352 136.745 22.6344 131.401 22.6344C123.464 22.6344 119.538 28.7643 119.538 36.3876C119.538 44.0108 123.546 50.141 131.401 50.141C136.824 50.141 140.832 47.3116 142.09 42.832H149.634C148.377 51.1624 141.304 56.821 131.244 56.821C118.749 56.821 111.597 47.3116 111.597 36.3876Z" fill="#21CD9C"/>
				<path d="M154.503 0H162.127V23.5769C164.252 18.6258 168.968 15.9537 174.862 15.9537C183.821 15.9537 189.637 22.3981 189.637 31.8288V56.1918H182.014V33.3221C182.014 27.0349 178.32 22.791 172.74 22.791C166.532 22.791 162.13 27.8208 162.13 34.7367V56.1918H154.507L154.503 0Z" fill="#21CD9C"/>
				<path d="M243.628 30.6505V56.1923H236.005V49.7479C234.119 53.9918 229.089 56.821 223.116 56.821C215.021 56.821 209.677 51.9484 209.677 44.8753C209.677 37.252 215.729 32.5367 225.081 32.5367H233.333C235.14 32.5367 236.005 31.5937 236.005 30.1792C236.005 25.3851 232.547 22.0843 226.417 22.0843C220.916 22.0843 216.907 25.5422 216.672 29.5503H209.599C210.227 21.7699 217.3 15.9543 226.652 15.9543C236.865 15.9543 243.628 21.8485 243.628 30.6505ZM236.005 38.8239V37.8809H225.788C220.601 37.8809 217.222 40.5528 217.222 44.7182C217.222 48.3333 220.208 50.7696 224.609 50.7696C231.839 50.7696 236.001 46.1328 236.001 38.8239H236.005Z" fill="#21CD9C"/>
				<path d="M258.085 50.2975V56.1918H250.462V0H258.085V22.3981C260.365 18.5472 265.158 15.9537 270.582 15.9537C282.685 15.9537 289.521 24.5986 289.521 36.387C289.521 48.1755 282.685 56.8205 270.502 56.8205C265.241 56.8205 260.365 54.2269 258.085 50.2975ZM281.82 36.387C281.82 28.1352 276.946 22.6339 269.637 22.6339C262.25 22.6339 257.457 28.1352 257.457 36.387C257.457 44.6389 262.25 50.1402 269.637 50.1402C276.946 50.1402 281.82 44.6389 281.82 36.387Z" fill="#21CD9C"/>
				<path d="M294.712 0H302.334V56.1918H294.712V0Z" fill="#21CD9C"/>
				<path d="M345.944 43.3036C344.531 51.4768 337.38 56.821 327.638 56.821C315.377 56.821 307.753 47.1545 307.753 36.1518C307.753 25.0707 314.67 15.9543 326.853 15.9543C339.108 15.9543 345.632 24.6777 345.632 34.7372C345.632 35.7589 345.552 37.0165 345.474 37.7236H315.217C315.845 45.1896 320.718 50.298 327.632 50.298C333.446 50.298 337.217 47.7832 338.317 43.3036H345.944ZM315.455 32.1439H337.938C337.47 26.0925 333.379 22.0843 326.86 22.0843C320.646 22.0843 316.635 25.5422 315.455 32.1439Z" fill="#21CD9C"/>
				<path d="M203.78 21.0025V29.5688H195.371V21.0025H203.78ZM203.78 47.723V56.191H195.371V47.7033L203.78 47.723Z" fill="#21CD9C"/>
			</svg>
		</a>
	</header>

	<section class="section">
		<nav class="primary-navigation">
		<ul>
				<li class="<?php echo ( 'general' === $page_tab ) ? 'current-menu-item' : ''; ?>">
					<a href="<?php echo esc_url( $general_tab_url ); ?>"><?php esc_html_e( 'General', 'teachable' ); ?></a>
				</li>
				<li class="<?php echo ( 'how' === $page_tab ) ? 'current-menu-item' : ''; ?>">
					<a href="<?php echo esc_url( $how_tab_url ); ?>"><?php esc_html_e( 'How to use', 'teachable' ); ?></a>
				</li>
				<li class="<?php echo ( 'sync' === $page_tab ) ? 'current-menu-item' : ''; ?>">
					<a href="<?php echo esc_url( $sync_tab_url ); ?>"><?php esc_html_e( 'Sync data', 'teachable' ); ?></a>
				</li>
			</ul>
		</nav>
	</section>

	<section class="section">
		<article class="article">
			<?php
			if ( 'general' === $page_tab ) :
				?>

				<div class="main">

					<h1 class="mt-0"><strong><?php esc_html_e( 'General Settings', 'teachable' ); ?></strong></h1>

					<p><strong class="weight-500"><?php esc_html_e( 'Follow the steps below to complete the Teachable plugin setup. If you face any issues in the future, return to this page for troubleshooting and helpful resources.', 'teachable' ); ?></strong></p>

					<div class="spacer-025">&nbsp;</div>

					<h2><?php esc_html_e( '1. Sign in or create a Teachable account', 'teachable' ); ?></h2>

					<p><?php esc_html_e( 'Already have an account? ', 'teachable' ); ?><a href="https://sso.teachable.com/secure/teachable_accounts/integrations/wordpress" target="_blank"><?php esc_html_e( 'Sign in', 'teachable' ); ?></a></p>

					<p><?php esc_html_e( 'Not on Teachable? ', 'teachable' ); ?><a href="https://sso.teachable.com/secure/teachable_accounts/sign_up" target="_blank"><?php esc_html_e( 'Get started for free', 'teachable' ); ?></a></p>

					<div class="spacer-025">&nbsp;</div>

					<h2><?php esc_html_e( '2. Paste WordPress Key', 'teachable' ); ?></h2>

					<p><?php esc_html_e( 'When installing the WordPress app on Teachable, a key will be generated. Please paste this key here and click "Save Changes" to complete the installation process.', 'teachable' ); ?></p>

					<div class="spacer-025">&nbsp;</div>

					<form class="form-teachable" action="" method="post">
						<?php wp_nonce_field( 'teachable-general-settings' ); ?>
						<?php
						$notice = get_transient( 'transient_teachable_general_settings_wp_key' );
						?>
						<?php
						$notice_class = '';
						if ( false !== $notice && 'field-error' === $notice['class'] ) {
							$notice_class = 'field-error';
						}
						$status_class = '';
						if ( ! isset( $general_settings['wp_key'] ) ) {
							$status_class = 'api-required';
						}
						?>
						<input type="password" id="general_settings_wp_key" class="mt-0-important <?php echo esc_attr( $notice_class ); ?> <?php echo esc_attr( $status_class ); ?>" name="teachable_general_settings[wp_key]" value="" placeholder="<?php echo isset( $general_settings['wp_key'] ) ? '********************************' : ''; ?>" required />

						<?php
						if ( false !== $notice ) {
							?>
								<p class="teachable-form-notice <?php echo esc_attr( $notice['class'] ); ?>"><?php echo wp_kses( $notice['message'], teachable_wp_kses() ); ?></p>
							<?php
							delete_transient( 'transient_teachable_general_settings_wp_key' );
						}
						?>


						<span id="general_settings_wp_key_error"><?php esc_html_e( 'Invalid key. Please double-check and ensure it is correct.', 'teachable' ); ?></span>

						<input name="submit_general_settings" class="button button-primary" type="submit" value="<?php esc_attr_e( 'Save Changes', 'teachable' ); ?>" />
					</form>

					<br />

					<label for="school-name"><strong><?php esc_html_e( 'Connected Teachable school', 'teachable' ); ?></strong></label>

					<input type="text" value="<?php echo esc_html( $school_name ); ?>" id="school-name" class="school-name" name="school-name" placeholder="" disabled />

					<p class="small mb-0"><small><?php esc_html_e( 'After the installation process is finished, your school name will appear in this section. If you have multiple schools, please verify that the listed one is the correct choice. If you need to change schools, simply paste a new WordPress key, and then click on "Save Changes."', 'teachable' ); ?></small></p>

				</div>

				<?php
			elseif ( 'how' === $page_tab ) :
				?>

				<div class="main">

					<h1 class="mt-0"><strong><?php esc_html_e( 'How to use plugin', 'teachable' ); ?></strong></h1>

					<p><?php esc_html_e( 'To finalize the installation process and link your Teachable school to WordPress, you will need to follow the steps below:', 'teachable' ); ?></p>

					<ol class="mb-0">
						<li><?php esc_html_e( 'Navigate to your Teachable school', 'teachable' ); ?></li>
						<li><?php esc_html_e( 'Go to Settings > App Hub and look for the WordPress app', 'teachable' ); ?></li>
						<li><?php esc_html_e( 'When you click to install the app, a modal with a WordPress Key will pop up', 'teachable' ); ?></li>
						<li><?php esc_html_e( 'Copy the Key ', 'teachable' ); ?></li>
						<li><?php esc_html_e( 'Come back to the General settings tab and paste it on the WordPress Key field ', 'teachable' ); ?></li>
						<li><?php esc_html_e( 'Click to Save Changes', 'teachable' ); ?></li>
					</ol>

					<p><?php esc_html_e( 'All changes to your Teachable products will automatically sync with WordPress daily. If you wish to see updates sooner, you can manually sync them by clicking "Sync now" in the Sync Data tab.', 'teachable' ); ?></p>

				</div>

				<?php
			elseif ( 'sync' === $page_tab ) :
				?>

				<div class="main">

					<h1 class="mt-0 mb-0"><strong><?php esc_html_e( 'Sync Data', 'teachable' ); ?></strong></h1>

					<div class="spacer-05">&nbsp;</div>

					<h2><?php esc_html_e( 'Data sharing preferences', 'teachable' ); ?></h2>

					<p>
						<strong class="weight-500">
						<?php
							echo esc_html(
								sprintf(
								/* translators: 1: daily sync time */
									__( 'By default, your data is synced daily at %s.', 'teachable' ),
									$sync_time . ' ' . timezone()
								)
							);
						?>
						</strong>
						<br />
						<em>
							<?php
							echo esc_html(
								sprintf(
								/* translators: 1: last updated time */
									__( 'Last updated: %s.', 'teachable' ),
									timezone( $last_sync, 'F jS, Y, g:i A T' )
								)
							);
							?>
						</em>
					</p>

					<p><strong class="weight-500"><?php esc_html_e( 'You can always click "Sync Now" to manually sync the data.', 'teachable' ); ?></strong></p>

					<form class="form-teachable" action="" method="post">
						<?php wp_nonce_field( 'teachable-general-settings' ); ?>
						<input type="hidden" id="general_settings_sync_now" name="teachable_general_settings[sync_now]" value="true" />

						<button type="submit" name="submit_sync_now" class="button button-secondary sync-button"><svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M12 4V1L8 5L12 9V6C15.31 6 18 8.69 18 12C18 13.01 17.75 13.97 17.3 14.8L18.76 16.26C19.54 15.03 20 13.57 20 12C20 7.58 16.42 4 12 4ZM12 18C8.69 18 6 15.31 6 12C6 10.99 6.25 10.03 6.7 9.2L5.24 7.74C4.46 8.97 4 10.43 4 12C4 16.42 7.58 20 12 20V23L16 19L12 15V18Z" fill="#323232"/></svg><?php esc_html_e( 'Sync Now', 'teachable' ); ?></button>

						<?php
						$notice = get_transient( 'transient_teachable_general_settings_sync_now' );
						if ( false !== $notice ) {
							?>
								<p class="teachable-form-notice <?php echo esc_attr( $notice['class'] ); ?>"><?php echo wp_kses( $notice['message'], teachable_wp_kses() ); ?></p>
							<?php
							delete_transient( 'transient_teachable_general_settings_sync_now' );
						}
						?>
					</form>

					<div class="spacer-05">&nbsp;</div>

					<form class="form-teachable" action="" method="post">
						<?php wp_nonce_field( 'teachable-general-settings' ); ?>
						<p class="mb-0"><strong class="weight-500"><?php esc_html_e( 'If you would like to update the daily sync between Teachable and WordPress, pick the time below and click "Save Changes."', 'teachable' ); ?></strong></p>

						<div class="time-field-wrapper">
							<input type="number" id="general_settings_sync_hour" name="teachable_general_settings[sync_time_hour]" min="1" max="12" value="<?php echo esc_attr( $hour ); ?>" /> : <input type="number" id="general_settings_sync_minute" name="teachable_general_settings[sync_time_minute]" min="0" max="59" value="<?php echo esc_attr( $minute ); ?>" step="1" /> <select id="general_settings_sync_ampm" name="teachable_general_settings[sync_time_ampm]">
							<?php
							foreach ( array( 'AM', 'PM' ) as $period ) {
								$selected = ( $ampm === $period ) ? ' selected' : '';
								?>
								<option value="<?php echo esc_html( $period ); ?>"<?php echo esc_html( $selected ); ?>><?php echo esc_html( $period ); ?></option>
								<?php
							}
							?>
							</select>
						</div>

						<p class="w-100 mt--05 mb-0"><small><?php esc_html_e( 'Keep in mind that this is in ', 'teachable' ); ?><?php echo esc_html( timezone() ); ?><?php esc_html_e( ', the timezone set within WordPress.', 'teachable' ); ?></small></p>

						<div class="spacer-05">&nbsp;</div>

						<h2><?php esc_html_e( 'Plugin deletion preferences', 'teachable' ); ?></h2>

						<p class="mt-0 small"><strong><small><?php esc_html_e( 'When you uninstall this plugin, what do you want to do with your stored data?', 'teachable' ); ?></small></strong></p>

						<fieldset class="delete-data-fields">
							<label for="general_settings_keep_data">
								<input type="radio" id="general_settings_keep_data" name="teachable_general_settings[delete_data]" value="0" <?php echo checked( $is_delete_data_set, false, false ); ?> />
								<?php esc_html_e( 'Keep data', 'teachable' ); ?>
							</label>
							<label for="general_settings_delete_data">
								<input type="radio" id="general_settings_delete_data" name="teachable_general_settings[delete_data]" value="1" <?php echo checked( $is_delete_data_set, true, false ); ?> />
									<?php esc_html_e( 'Remove data', 'teachable' ); ?>
							</label>
						</fieldset>

						<div class="spacer-025">&nbsp;</div>

						<input name="submit_sync_data" class="button button-primary" type="submit" value="<?php esc_attr_e( 'Save Changes', 'teachable' ); ?>" />

						<?php
						$notice = get_transient( 'transient_teachable_general_settings_sync_data_form' );
						if ( false !== $notice ) {
							?>
							<p class="teachable-form-notice <?php echo esc_attr( $notice['class'] ); ?>"><?php echo wp_kses( $notice['message'], teachable_wp_kses() ); ?></p>
							<?php
							delete_transient( 'transient_teachable_general_settings_sync_data_form' );
						}
						?>
					</form>

				</div>

				<?php
			endif;
			?>
		</article>
	</section>
	<section class="section">
		<p class="mt-0 mb-0"><small>
		<?php
		printf(
			/* translators: 1: opening <a> tag for the plugin documentation, 2: closing </a> tag */
			esc_html__( 'If you need help setting up this plugin, please refer to the %1$splugin documentation%2$s.', 'teachable' ),
			'<a href="https://support.teachable.com/hc/en-us/articles/25418090816781-Teachable-for-Wordpress" target="_blank">',
			'</a>'
		);
		?>
		</small></p>
	</section>
</div>
