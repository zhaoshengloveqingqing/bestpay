<?php namespace Pinet\BestPay\Commands; in_array(__FILE__, get_included_files()) or exit("No direct script access allowed");

use Clips\Command;

/**
 * @author Jack
 * @date Mon Jun  8 17:45:35 2015
 * @Clips\Model("place")
 */
class PlaceCommand extends Command {
	public function execute($args) {
		$csv = \Clips\try_path('tests/data/places.csv');
		$f = fopen($csv, 'r');
		while($data = fgetcsv($f)) {
			$this->place->insert(array(
				'id' => $data[0],
				'parent_id' => $data[1],
				'name' => $data[2],
				'type' => $data[3]
			));
		}
		$this->output('done');
	}
}
