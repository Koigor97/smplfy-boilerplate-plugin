<?php
/**
 * Adapter for handling Gravity Forms events
 */

namespace SMPLFY\boilerplate;
class GravityFormsAdapter {

	private SendWebhook $send_webhook;

	public function __construct( SendWebhook $send_webhook ) {
		$this->send_webhook = $send_webhook;

		$this->register_hooks();
	}

    /**
     * Process the form data and send to the use case
     * * @param array $entry The Entry Object
     * @param array $form The Form Object
     */
	public function process_submission(array $entry, array $form): void
    {

        // Prepare the data
        $data_to_send = array();

        if (isset($form['fields'])) {
            foreach ($form['fields'] as $field) {
                $label = $field->label;
                // Using rgar to safely det the value
                $value = rgar($entry, (string) $field->id);
                $data_to_send[$label] = $value;
            }
        }

        // Useful metadata
        $data_to_send['form_title'] = $form['form_title'] ?? 'Unknown Form';
        $data_to_send['entry_id'] = $entry['id'] ?? 0;

        $this->send_webhook->execute($data_to_send);


	}


	/**
	 * Register gravity forms hooks to handle custom logic
	 */
	public function register_hooks(): void
    {
        // Hook into Gravity Forms after submission.
        // Points to the 'process_submission' method in THIS class.
        add_action('gform_after_submission', [$this, 'process_submission'], 10, 2);
	}
}