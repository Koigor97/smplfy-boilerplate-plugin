<?php
namespace SMPLFY\boilerplate;

class TaskSetup {

    /**
     * 1. Register "Task" CPT and "Status" Taxonomy
     * (Logic migrated from post-type-task.php)
     */
    public function register_tasks(): void
    {

        // Register "Status" Taxonomy
        $taxonomy_labels = array(
            'name'          => 'Statuses',
            'singular_name' => 'Status',
            'menu_name'     => 'Status',
        );

        $taxonomy_args = array(
            'labels'            => $taxonomy_labels,
            'public'            => false,
            'publicly_queryable' => false,
            'show_ui'           => true,
            'show_in_menu'      => false,
            'hierarchical'      => true,
            'show_in_rest'      => true,
            'show_admin_column' => true,
            'query_var'         => false,
            'rewrite'           => false,
        );
        register_taxonomy('stm_task_status', array('stm_task'), $taxonomy_args);

        // Register "Task" Post Type
        $cpt_labels = array(
            'name'               => 'Tasks',
            'singular_name'      => 'Task',
            'add_new_item'       => 'Add New Task',
            'edit_item'          => 'Edit Task',
            'new_item'           => 'New Task',
            'view_item'          => 'View Task',
            'search_items'       => 'Search Tasks',
            'not_found'          => 'No Tasks found',
        );

        $cpt_args = array(
            'labels'              => $cpt_labels,
            'public'              => false,
            'publicly_queryable'  => false,
            'has_archive'         => false,
            'show_ui'             => true,
            'show_in_menu'        => false,
            'supports'            => array('title', 'editor'),
            'hierarchical'        => false,
            'menu_position'       => 21,
            'menu_icon'           => 'dashicons-pressthis',
            'show_in_rest'        => true,
            'exclude_from_search' => true,
            'taxonomies'          => array('stm_task_status'),
            'rewrite'             => false,
            'query_var'           => false,
        );
        register_post_type('stm_task', $cpt_args);
    }

    /**
     * 2. Login Page Customizations
     * (Logic migrated from admin-login-mods.php)
     */
    public function enqueue_login_styles(): void
    {
        // Point to 'public/css/admin-login.css'
        // We go up two levels from 'public/php/usecases' to 'public'
        $css_url = SMPLFY_NAME_PLUGIN_URL . 'public/css/admin-login.css';
        wp_enqueue_style('simplify-login-styles', $css_url);
    }

    public function login_logo_url(): string
    {
        return 'https://simplifybiz.com/';
    }

    public function login_logo_title(): string
    {
        return 'Sign In - Access your internship sandbox';
    }

    public function login_custom_message(): string
    {
        return '
            <div class="stm-login-header">
                <h2 class="stm-login-title">Interns Sign In</h2>
                <p class="stm-login-subtitle">Access your Internship WordPress Sandbox.</p>
            </div>
        ';
    }

    /**
     * 3. Admin Menu & Pages
     * (Logic migrated from admin-menu.php)
     */
    public function add_admin_menu(): void
    {

        $icon_url = SMPLFY_NAME_PLUGIN_URL . 'public/images/stm-icon-1.svg';

        // Parent Menu
        add_menu_page(
            'Task Manager',
            'Task Manager',
            'manage_options',
            'stm-task-manager',
            [ $this, 'render_kanban_page' ],
            $icon_url,
            20
        );

        // Submenu 1: Kanban Board
        add_submenu_page(
            'stm-task-manager',
            'Kanban Board',
            'Kanban Board',
            'manage_options',
            'stm_task_manager',
            [ $this, 'render_kanban_page' ]
        );

        // Submenu 2: Add New Task
        add_submenu_page(
            'stm-task-manager',
            'Add New Task',
            'Add New Task',
            'manage_options',
            'post-new.php?post_type=stm_task'
        );

        // Submenu 3: Task Statuses
        add_submenu_page(
            'stm-task-manager',
            'Task Statuses',
            'Task Statuses',
            'manage_options',
            'edit.php?taxonomy=stm_task_status&post_type=stm_task'
        );

        // Submenu 4: Settings
        add_submenu_page(
            'stm-task-manager',
            'Task Manager Settings',
            'Settings',
            'manage_options',
            'stm_task_manager-settings',
            [ $this, 'render_settings_page' ]
        );
    }

    public function enqueue_admin_styles(): void
    {
        $css_url = SMPLFY_NAME_PLUGIN_URL . 'public/css/admin-kanban.css';
        wp_enqueue_style('simplify-kanban-styles', $css_url);
    }

    /**
     * Page Render Methods
     */
    public function render_kanban_page(): void
    {

        $view_path = SMPLFY_NAME_PLUGIN_URL . 'public/views/kanban-board-page.php';

        if ( file_exists( $view_path ) ) {
            require_once $view_path;
        } else {
            echo '<h1>Kanban Board</h1><p>Please move your view file to public/views/kanban-board-page.php</p>';
        }
    }

    public function render_settings_page() {
        ?>
        <div class="wrap">
            <h1>Task Manager Settings</h1>
            <p>This page will hold the settings, using the Options API</p>
        </div>
        <?php
    }

    /**
     * 4. Redirect after save
     */
    public function redirect_after_saving_task($location, $post_id) {
        $post = get_post($post_id);

        if ($post && 'stm_task' === $post->post_type) {
            $location = admin_url('admin.php?page=stm_task_manager');
        }

        return $location;
    }

}