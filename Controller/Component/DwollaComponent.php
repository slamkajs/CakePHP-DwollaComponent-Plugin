<?php
/**
 * StripeComponent
 *
 * A component that handles payment processing using Stripe.
 *
 * PHP version 5
 *
 * @package		StripeComponent
 * @author		Gregory Gaskill <gregory@chronon.com>
 * @license		MIT License (http://www.opensource.org/licenses/mit-license.php)
 * @link		https://github.com/chronon/CakePHP-StripeComponent-Plugin
 */

App::uses('Component', 'Controller');

/**
 * StripeComponent
 *
 * @package		StripeComponent
 */
class StripeComponent extends Component {

/**
 * Default Stripe mode to use: Test or Live
 *
 * @var string
 * @access public
 */
	public $mode = 'Test';

/**
 * Default currency to use for the transaction
 *
 * @var string
 * @access public
 */
	public $currency = 'usd';

/**
 * Default mapping of fields to be returned: local_field => stripe_field
 *
 * @var array
 * @access public
 */
	public $fields = array('dwolla_id' => 'id');

/**
 * Controller startup. Loads the Stripe API library and sets options from
 * APP/Config/bootstrap.php.
 *
 * @param Controller $controller Instantiating controller
 * @return void
 * @throws CakeException
 */
	public function startup(Controller $controller) {
		$this->Controller = $controller;

		// load the stripe vendor class IF it hasn't been autoloaded (composer)
		App::import('Vendor', 'Dwolla.Dwolla', array(
			'file' => 'Dwolla' . DS . 'lib' . DS . 'dwolla.php')
		);
		if (!class_exists('Dwolla')) {
			throw new CakeException('Dwolla API Libaray is missing or could not be loaded.');
		}

		// if mode is set in bootstrap.php, use it. otherwise, Test.
		$mode = Configure::read('Dwolla.mode');
		if ($mode) {
			$this->mode = $mode;
		}

		// field map for charge response, or use default (set above)
		$fields = Configure::read('Dwolla.fields');
		if ($fields) {
			$this->fields = $fields;
		}
	}

}