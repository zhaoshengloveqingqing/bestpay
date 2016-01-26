<?php namespace Pinet\BestPay\Commands; in_array(__FILE__, get_included_files()) or exit("No direct script access allowed");

use Clips\Command;

/**
 * @Clips\Context(key = 'test_data', value = 'tag')
 * @Clips\Object("testData")
 */
class TagCommand extends Command {
	public function execute($args) {
		echo "Done!";
	}
}
