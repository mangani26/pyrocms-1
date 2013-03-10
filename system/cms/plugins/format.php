<?php defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Format Plugin
 *
 * Various text formatting functions.
 *
 * @author  PyroCMS Dev Team
 * @package PyroCMS\Core\Plugins
 */
class Plugin_format extends Plugin
{
	public $version = '1.0.0';

	public $name = array(
		'en' => 'Format',
	);

	public $description = array(
		'en' => 'Format strings, including Markdown and Textile.',
		'el' => 'Μορφοποίηση κειμενοσειρών, συμπεριλαμβανομένων των Markdown και Textile.',
		'fr' => 'Formatter des chaînes de caractères, incluant Markdown et Textile.',
		'it' => 'Formatta le stringhe, incluse Markdown e Textitle',
	);

	/**
	 * Returns a PluginDoc array that PyroCMS uses
	 * to build the reference in the admin panel
	 *
	 * All options are listed here but refer
	 * to the Format plugin for a larger example
	 *
	 * @return array
	 */
	public function _self_doc()
	{
		$info = array(
			'markdown' => array(
				'description' => array(
					'en' => 'Send some content through the Markdown processor.'
				),
				'single' => false,
				'double' => true,
				'variables' => '',
				'attributes' => array(),
			),

			'textile' => array(
				'description' => array(
					'en' => 'Send some content through the Textile processor.'
				),
				'single' => false,
				'double' => true,
				'variables' => '',
				'attributes' => array(),
			),

			'url_title' => array(
				'description' => array(
					'en' => 'A Plugin shortcut to the CodeIgniter url_title() function.'
				),
				'single' => true,
				'double' => false,
				'variables' => '',
				'attributes' => array(
					'string' => array(
						'type' => 'text',
						'required' => true,
					),
					'separator' => array(
						'type' => 'text',
						'default' => 'dash',
						'required' => false,
					),
					'lowercase' => array(
						'type' => 'bool',
						'flags' => 'true|false',
						'default' => 'false',
						'required' => false,
					),
				),
			),
		);

		return $info;
	}

	/**
	 * Markdown
	 *
	 * Takes content and formats it with the Markdown Library.
	 *
	 * Usage:
	 * {{ format:markdown }}
	 *   Formatted **text**
	 * {{ /format:markdown }}
	 *
	 * Outputs: <p>Formatted <strong>text</strong></p>
	 *
	 * @return string The HTML generated by the Markdown Library.
	 */
	public function markdown()
	{
		$this->load->helper('markdown');

		$content = $this->attribute('content', $this->content());

		return parse_markdown(trim($content));
	}

	/**
	 * URL Title
	 *
	 * Converts a string using the `url_title()` URL Helper function
	 *
	 * Usage:
	 * {{ format:url_title string="Introducing New Administrators" separator="dash" lowercase="true" }}
	 *
	 * Outputs: "introducing-new-administrators"
	 *
	 * @return string Formatted with the `url_title` helper function
	 */
	public function url_title()
	{
		$this->load->helper('url');

		$attrs = $this->attributes();

		// fix 'true' or 'false' to real bools.
		if (count($attrs) > 2) {
			$bool = array_slice($attrs, 2);
			array_splice($attrs, 2, 1, array_map('str_to_bool', $bool));
		}

		return call_user_func_array('url_title', $attrs);
	}

}

/* EOF */
