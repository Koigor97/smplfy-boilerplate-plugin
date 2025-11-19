<?php

namespace SMPLFY\boilerplate;

class WordpressAdapter {
	private WPHeartbeatExample $wpHeartbeatExample;
    private TaskSetup $taskSetup;

	public function __construct( WPHeartbeatExample $wpHeartbeatExample, TaskSetup $taskSetup ) {
		$this->wpHeartbeatExample = $wpHeartbeatExample;
        $this->taskSetup = $taskSetup;

		$this->register_hooks();
		$this->register_filters();
	}

	/**
	 * Register Wordpress hooks to handle custom logic
	 *
	 * @return void
	 */
	public function register_hooks(): void
    {
        // 1. CPT & Taxonomy
        add_action( 'init', [ $this->taskSetup, 'register_tasks' ] );

        // 2. Login Page
        add_action( 'login_enqueue_scripts', [ $this->taskSetup, 'enqueue_login_styles' ] );

        // 3. Admin Menu & Enqueue
        add_action( 'admin_menu', [ $this->taskSetup, 'add_admin_menu' ] );
        add_action( 'admin_enqueue_scripts', [ $this->taskSetup, 'enqueue_admin_styles' ] );

	}

	/**
	 * Register Wordpress filters to handle custom logic
	 *
	 * @return void
	 */
	public function register_filters(): void
    {
		add_filter( 'heartbeat_received', [ $this->wpHeartbeatExample, 'receive_heartbeat' ], 10, 2 );

        // Login Filters
        add_filter( 'login_headerurl', [ $this->taskSetup, 'login_logo_url' ] );
        add_filter( 'login_headertext', [ $this->taskSetup, 'login_logo_title' ] );
        add_filter( 'login_message', [ $this->taskSetup, 'login_custom_message' ] );

        // Redirect Filter
        add_filter( 'redirect_post_location', [ $this->taskSetup, 'redirect_after_saving_task' ], 10, 2 );
	}
}