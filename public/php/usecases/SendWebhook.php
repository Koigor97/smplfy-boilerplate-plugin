<?php

namespace SMPLFY\boilerplate;


// Using the Core plugin helper class.
use SmplfyCore\WpHttpAPIHelper;

class SendWebhook
{
    public function execute( array $data ): \WP_Error|array
    {

        $webhook_url = 'https://webhook.site/8bda6ada-87fb-44d9-a8ca-f87e591eeecc';

        // Prepare the arguments
        $args = array(
            'body' => json_encode( $data ),
            'headers' => array(
                'Content-Type' => 'application/json; charset=utf-8',
            )
        );

        //Send the request using the Core Helper.
        return WpHttpAPIHelper::send_remote_post($webhook_url, $args);

    }
}