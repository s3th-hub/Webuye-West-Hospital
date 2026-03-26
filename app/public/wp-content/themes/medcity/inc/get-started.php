<?php
if ( ! class_exists( 'CMS_PORTAL' ) ) {
	// disable SSL verify
	add_filter( 'https_local_ssl_verify', '__return_false' );
	add_filter( 'https_ssl_verify', '__return_false' );

	// Welcome page
	add_action( 'admin_menu', 'medcity_add_welcome_page' );
	function medcity_add_welcome_page() {
		$current_theme = wp_get_theme();
		if ( is_child_theme() ) {
			$current_theme = $current_theme->parent();
		}
		add_submenu_page( 'themes.php', esc_html__( 'About', 'medcity' ) . ' ' . $current_theme->get( 'Name' ), esc_html__( 'About', 'medcity' ) . ' ' . $current_theme->get( 'Name' ), 'manage_options', "{$current_theme->get('TextDomain')}-welcome", 'medcity_welcome_page' );
	}

	function medcity_welcome_page() {
		$current_theme = wp_get_theme();
		if ( is_child_theme() ) {
			$current_theme = $current_theme->parent();
		}
		$theme_name    = $current_theme->get( 'Name' );
		$theme_version = $current_theme->get( 'Version' );
		$cms_portal    = get_plugins( '/cms-portal' );
		?>
        <div class="welcome-page">
            <div class="welcome-page-inner">
                <div class="welcome-page-content">
                    <div class="welcome-page-title">
                                <span>
                                    <?php esc_html_e( 'Welcome to', 'medcity' ) ?>
                                </span>
                        <span>
                                    <?php echo esc_html( $theme_name . ' v' . $theme_version ); ?>
                                </span>
                    </div>
                    <div class="welcome-page-description">
                                <span>
                                    <?php esc_html_e( 'In order to continue, please install and activate', 'medcity' ) ?>
                                </span>
                        <span class="font-weight-bold font-italic">
                                    <?php echo esc_html( 'CMS Portal Plugin' ) ?>
                                </span>
                    </div>
                    <div class="welcome-page-actions">
						<?php if ( $cms_portal && count( $cms_portal ) > 0 ): ?>
                            <button type="button" id="btn-cms-get-started"
                                    class="button button-primary btn-activate"><?php esc_html_e( 'Activate', 'medcity' ) ?></button>
						<?php else: ?>
                            <button type="button" id="btn-cms-get-started"
                                    class="button button-primary btn-install"><?php esc_html_e( 'Install', 'medcity' ) ?></button>
						<?php endif; ?>
                        <p id="cms-alert" style="display: none; color: red;"></p>
                    </div>
                    <div class="welcome-page-note font-italic">
                        <span style="color: red;">*</span>
                        <span>
                                    <?php esc_html_e( "CMS Portal Plugin will allow you to update theme, install required plugins", 'medcity' ) ?>
                                </span>
                    </div>
                </div>
            </div>
        </div>
		<?php
	}
	add_action( 'admin_notices', 'medcity_admin_notice_get_started' );
	if ( ! function_exists( 'medcity_admin_notice_get_started' ) ) {
		function medcity_admin_notice_get_started() {
			$current_theme = wp_get_theme();
			if ( is_child_theme() ) {
				$current_theme = $current_theme->parent();
			}
			$screen = get_current_screen();
			if ( $screen->parent_file == $current_theme->get( 'TextDomain' ) . '-welcome' || $screen->parent_file == 'themes.php' ) {
				return;
			}

			$theme_name       = $current_theme->get( 'Name' );
			$theme_desc       = $current_theme->get( 'Description' );
			$theme_author     = $current_theme->get( 'Author' );
			$theme_theme_uri  = $current_theme->get( 'ThemeURI' );
			$theme_author_uri = $current_theme->get( 'AuthorURI' );
			$theme_screenshot = $current_theme->get_screenshot();
			$theme_logo       = get_template_directory_uri() . '/assets/images/logo/logo.png';
			$cms_portal       = get_plugins( '/cms-portal' );
			?>
            <div class="gt-notice notice is-dismissible">
                <div class="gt-notice-inner">
                    <div class="gt-notice-logo">
                        <img src="<?php echo esc_attr( $theme_logo ) ?>" alt="<?php echo esc_attr( $theme_name ) ?>"
                             style="max-width: 200px;">
                    </div>
                    <div class="gt-notice-body">
                        <span class="gt-theme-author">
                            <?php echo esc_html__( 'By', 'medcity' ) ?>
                            <a href="<?php echo esc_attr( $theme_author_uri ); ?>"><?php echo esc_html( $theme_author ); ?></a>
                        </span>
                        <hr class="gt-divide">
                        <div class="gt-theme-description">
							<?php echo esc_html( $theme_desc ); ?>
                        </div>
                        <hr class="gt-divide">
                        <div class="gt-notice-actions">
                            <div class="gt-notice-actions-description">
                                <span>
                                    <?php esc_html_e( 'In order to continue, please install and activate', 'medcity' ) ?>
                                </span>
                                <span class="font-weight-bold font-italic">
                                    <?php echo esc_html( 'CMS Portal Plugin' ) ?>
                                </span>
                            </div>
							<?php if ( $cms_portal && count( $cms_portal ) > 0 ): ?>
                                <button type="button" id="btn-cms-get-started"
                                        class="button button-primary btn-activate"><?php esc_html_e( 'Activate', 'medcity' ) ?></button>
							<?php else: ?>
                                <button type="button" id="btn-cms-get-started"
                                        class="button button-primary btn-install"><?php esc_html_e( 'Install', 'medcity' ) ?></button>
							<?php endif; ?>
                            <span id="cms-alert" style="display: none; color: red; margin-left: 15px;"></span>
                            <div class="gt-notice-actions-note font-italic">
                                <span style="color: red;">*</span>
                                <span>
                                    <?php esc_html_e( "CMS Portal Plugin will allow you to update theme, install required plugins", 'medcity' ) ?>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
			<?php
		}
	}

	add_action( 'wp_ajax_get_started', 'medcity_get_started' );
	add_action( 'wp_ajax_nopriv_get_started', 'medcity_get_started' );
	if ( ! function_exists( 'medcity_get_started' ) ) {
		function medcity_get_started() {
			try {
				if ( isset( $_POST["activate"] ) && ! empty( $_POST["activate"] ) ) {
					$result                 = [
						'stt'  => false,
						'msg'  => esc_html__( 'Plugin CMS Portal have not installed yet!', 'medcity' ),
						'data' => [],
					];
					$installed_plugins_data = get_plugins();
					foreach ( $installed_plugins_data as $installed_plugin_file => $installed_plugin_data ) {
						$_installed_plugin_file = explode( '/', $installed_plugin_file );
						if ( $_installed_plugin_file[0] == 'cms-portal' ) {
							$is_installed = true;
							// null|WP_Error Null on success, WP_Error on invalid file.
							$active_result = activate_plugin( $installed_plugin_file );

							if ( ! is_null( $active_result ) ) {
								$result = [
									'stt'  => false,
									'msg'  => esc_html__( 'Fail to activate plugin CMS Portal!', 'medcity' ),
									'data' => [],
								];
							} else {
								$current_theme = wp_get_theme();
								if ( is_child_theme() ) {
									$current_theme = $current_theme->parent();
								}

								$result = [
									'stt'  => true,
									'msg'  => esc_html__( 'Successfully!', 'medcity' ),
									'data' => [
										'redirect_url' => admin_url( 'admin.php?page=' . $current_theme->get( 'TextDomain' ) )
									],
								];
							}
						}
					}
				} else {
					if ( ! isset( $_POST["download_link"] ) || empty( $_POST["download_link"] ) ) {
						throw new Exception( __( 'Something went wrong!', 'medcity' ) );
					}

					$is_installed           = false;
					$installed_plugins_data = get_plugins();
					foreach ( $installed_plugins_data as $installed_plugin_file => $installed_plugin_data ) {
						$_installed_plugin_file = explode( '/', $installed_plugin_file );
						if ( $_installed_plugin_file[0] == 'cms-portal' ) {
							$is_installed = true;
							// null|WP_Error Null on success, WP_Error on invalid file.
							$active_result = activate_plugin( $installed_plugin_file );

							if ( ! is_null( $active_result ) ) {
								$result = [
									'stt'  => false,
									'msg'  => esc_html__( 'Fail to activate plugin!', 'medcity' ),
									'data' => [],
								];
							} else {
								$current_theme = wp_get_theme();
								if ( is_child_theme() ) {
									$current_theme = $current_theme->parent();
								}

								$result = [
									'stt'  => true,
									'msg'  => esc_html__( 'Successfully!', 'medcity' ),
									'data' => [
										'redirect_url' => admin_url( 'admin.php?page=' . $current_theme->get( 'TextDomain' ) )
									],
								];
							}
						}
					}

					if ( ! $is_installed ) {
						require_once ABSPATH . 'wp-admin/includes/class-wp-upgrader.php';
						include_once ABSPATH . 'wp-admin/includes/plugin-install.php';

						$skin           = new WP_Ajax_Upgrader_Skin();
						$upgrader       = new Plugin_Upgrader( $skin );
						$install_result = $upgrader->install( $_POST["download_link"] );

						if ( ! $install_result ) {
							$result = [
								'stt'  => false,
								'msg'  => __( 'Fail to install plugin!', 'medcity' ),
								'data' => [],
							];
						} else {
							$installed_plugins_data = get_plugins();
							foreach ( $installed_plugins_data as $installed_plugin_file => $installed_plugin_data ) {
								$_installed_plugin_file = explode( '/', $installed_plugin_file );
								if ( $_installed_plugin_file[0] == 'cms-portal' ) {
									// null|WP_Error Null on success, WP_Error on invalid file.
									$active_result = activate_plugin( $installed_plugin_file );

									if ( ! is_null( $active_result ) ) {
										$result = [
											'stt'  => false,
											'msg'  => esc_html__( 'Fail to activate plugin!', 'medcity' ),
											'data' => [],
										];
									} else {
										$current_theme = wp_get_theme();
										if ( is_child_theme() ) {
											$current_theme = $current_theme->parent();
										}

										$result = [
											'stt'  => true,
											'msg'  => esc_html__( 'Successfully!', 'medcity' ),
											'data' => [
												'redirect_url' => admin_url( 'admin.php?page=' . $current_theme->get( 'TextDomain' ) )
											],
										];
									}
								}
							}
						}
					}
				}
			} catch ( Exception $e ) {
				$result = [
					'stt'  => false,
					'msg'  => $e->getMessage(),
					'data' => '',
				];
			}

			wp_send_json( $result );
			die();
		}
	}
}

add_action( 'after_switch_theme', 'medcity_redirect_to_welcome_page' );
function medcity_redirect_to_welcome_page() {
	$current_theme = wp_get_theme();
	if ( is_child_theme() ) {
		$current_theme = $current_theme->parent();
	}

	if ( class_exists( 'CMS_PORTAL' ) ) {
		wp_safe_redirect( admin_url( "themes.php?page={$current_theme->get('TextDomain')}" ) );
	} else {
		wp_safe_redirect( admin_url( "themes.php?page={$current_theme->get('TextDomain')}-welcome" ) );
	}
}

?>