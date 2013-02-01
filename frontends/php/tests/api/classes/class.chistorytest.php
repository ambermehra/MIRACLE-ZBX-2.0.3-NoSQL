<?php
require_once dirname(__FILE__).'/../../../include/classes/core/ZBase.php';
require_once dirname(__FILE__).'/../../../include/classes/api/API.php';
require_once dirname(__FILE__).'/../../../include/classes/api/CZBXAPI.php';
require_once dirname(__FILE__).'/../../../include/history-gluon.inc.php';
require_once dirname(__FILE__).'/../../../api/classes/CTriggerGeneral.php';
require_once dirname(__FILE__).'/../../../api/classes/CGraphGeneral.php';
require_once dirname(__FILE__).'/../../../api/classes/CHostGeneral.php';
require_once dirname(__FILE__).'/../../include/class.capitest.php';

class Z extends ZBase {
	public static function getRootDir() {
		return realpath(dirname(__FILE__).'/../../../');
	}
}

class CHistoryTest extends CApiTest {
	public function setUp() {
		parent::setUp();

		$this->setUpTestHost();
		$this->api = API::History();
	}

	public function providerCreateValid() {
	}

	public function providerGet() {
		$data1 = array (
			"history" => 0,
			"itemids" => array("22188"),
			"time_from" => 1351090935,
			"time_till" => 1351090937,
		);

		return array (
			array(
				array(
					"data" => array_merge($data1, array("output" => "extend")),
					"expected" => array(
						array(
							"itemid" => "22188",
							"clock" => "1351090936",
							"value" => "0.16000",
							"ns" => "549216402",
						),
					),
				),
			),
			array(
				array(
					"data" => $data1,
					"expected" => array(
						array(
							"itemid" => "22188",
							"clock" => "1351090936",
						),
					),
				),
			),
			array(
				array(
					"data" => array_merge($data1, array("history" => "1")),
					"expected" => array(),
				),
			),
		);
	}

	public function testCreateValid() {
		$this->markTestIncomplete("History doesn't have create method");
	}

	public function testDelete() {
		$this->markTestIncomplete("History doesn't have delete method");
	}

	private function assertGet($object, $useHistoryGluon) {
		global $HISTORY_DB;
		$use_history_db_saved = $HISTORY_DB['USE'];
		if ($useHistoryGluon) {
			$HISTORY_DB['USE']  = 'yes';
		} else {
			$HISTORY_DB['USE']  = 'no';
		}

		$actual = $this->api->get($object["data"]);
		$this->assertEquals($object["expected"], $actual);

		$HISTORY_DB['USE'] = $use_history_db_saved;
	}

	/**
	 * @dataProvider providerGet
	 */
	public function testGet(array $object) {
		$this->assertGet($object, FALSE);
	}

	/**
	 * @dataProvider providerGet
	 */
	public function testGetHistoryGluon(array $object) {
		$this->assertGet($object, TRUE);
	}
}
?>
