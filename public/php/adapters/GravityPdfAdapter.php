<?php

namespace SMPLFY\boilerplate;

class GravityPdfAdapter
{
    public function __construct() {
        // This filter allows devs to register a new folder for PDF templates
        add_filter( 'gravitypdf_template_paths', [ $this, 'add_custom_template_path' ] );
    }

    /**
     * Add the plugin's 'public/pdf' folder to Gravity PDF's search list.
     */
    public function add_custom_template_path( $file_paths ) {

        // Define the path to the new pdf folder
        // using the constant defined in the main plugin file.
        $my_custom_path = SMPLFY_NAME_PLUGIN_DIR . 'public/pdf/';

        // Add it to the array of paths Gravity PDF checks
        $file_paths[] = $my_custom_path;

        return $file_paths;
    }
}