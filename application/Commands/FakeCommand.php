<?php namespace Pinet\BestPay\Commands; in_array(__FILE__, get_included_files()) or exit("No direct script access allowed");

use Clips\Command;

/**
 * @Clips\Context(key = 'test_data', value = 'fake')
 * @Clips\Object("testData")
 * @Clips\Library("csv")
 * @Clips\Model("tag")
 */
class FakeCommand extends Command {
	public function execute($args) {
		$tags = $this->csv->read("src://tests/data/tag.csv");
		foreach($tags as $tag){
			$this->tag->insert($tag);
		}
		echo "Done!";
	}
}
