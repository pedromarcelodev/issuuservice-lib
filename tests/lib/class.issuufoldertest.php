<?php

class IssuuFolderTest extends PHPUnit_Framework_TestCase
{
	private static $instance;

	private static $params = array(
		'action' => 'issuu.folder.add',
		'folderName' => 'Unit Test',
		'folderDescription' => 'Pedro Marcelo de Sá Alves Folder',
	);

	private static $signature;

	public static function setUpBeforeClass()
	{
		self::$instance = new IssuuFolder('jil7ll5cg2cwm93kg6xlsc1x9apdeyh7', '8agoiu10igdyw7azj9b8rvi0otyja6gj');
		$params = array_merge(array('apiKey' => 'jil7ll5cg2cwm93kg6xlsc1x9apdeyh7'), self::$params);
		ksort($params);
		$params = strtr(urldecode(http_build_query($params)), array('&' => '', '=' => ''));
		self::$signature = md5('8agoiu10igdyw7azj9b8rvi0otyja6gj' . $params);
	}

	public function testHasClass()
	{
		$this->assertTrue(class_exists('IssuuFolder'));
	}

	public function testSetParamsAndThrowException()
	{
		try {
			self::$instance->setParams(array('action' => 'issuu.folders.list'));
			$this->assertTrue(true);
		} catch (Exception $e) {
			$this->fail("Parâmetros não aceitos");
		}

		try {
			self::$instance->setParams(array());
			self::$instance->setParams('');
			self::$instance->setParams(true);
			self::$instance->setParams(1);
			self::$instance->setParams(0.6);
			self::$instance->setParams(new stdClass());
			$this->fail("Parâmetros inválidos aceitos");
		} catch (Exception $e) {
			$this->assertTrue(true);
		}
	}

	public function testCalculateSignature()
	{
		try {
			self::$instance->setParams(self::$params);
			$this->assertEquals(self::$signature, self::$instance->getSignature());
		} catch (Exception $e) {
			$this->fail("Parâmetros não aceitos");
		}
	}

	public function testParseJsonObjectValues()
	{
		$obj = new stdClass();
		$obj->attr1 = 'string';
		$obj->attr2 = '3';
		$obj->attr3 = 'true';
		$obj->attr4 = '3.5';
		$obj->attr5 = array();

		$this->assertTrue(is_string(
			self::$instance->validFieldJson($obj, 'attr1', 0)
		));
		$this->assertTrue(is_int(
			self::$instance->validFieldJson($obj, 'attr2', 1)
		));
		$this->assertTrue(is_bool(
			self::$instance->validFieldJson($obj, 'attr3', 2)
		));
		$this->assertTrue(is_float(
			self::$instance->validFieldJson($obj, 'attr4', 3)
		));
		$this->assertTrue(is_array(
			self::$instance->validFieldJson($obj, 'attr5', -1)
		));
		$this->assertEquals('', self::$instance->validFieldJson($obj, 'attr6'));
	}

	public function testParseXmlObjectValues()
	{
		$obj = array(
			'attr1' => 'string',
			'attr2' => '3',
			'attr3' => 'true',
			'attr4' => '3.5',
			'attr5' => array(),
		);

		$this->assertTrue(is_string(
			self::$instance->validFieldXML($obj, 'attr1', 0)
		));
		$this->assertTrue(is_int(
			self::$instance->validFieldXML($obj, 'attr2', 1)
		));
		$this->assertTrue(is_bool(
			self::$instance->validFieldXML($obj, 'attr3', 2)
		));
		$this->assertTrue(is_float(
			self::$instance->validFieldXML($obj, 'attr4', 3)
		));
		$this->assertTrue(is_array(
			self::$instance->validFieldXML($obj, 'attr5', -1)
		));
		$this->assertEquals('', self::$instance->validFieldXML($obj, 'attr6'));
	}

	public function testIssuuListFolders()
	{
		$response = self::$instance->issuuList();
		$this->assertEquals('ok', $response['stat']);
	}

	public function testErrorCodes()
	{

		$invalidInstance = new IssuuFolder('jil7ll5cg2cwm93kg6xlsc1x9apdeyhb', 'apisecret');
		$response = $invalidInstance->issuuList();
		$this->assertTrue(
			$response['stat'] == 'fail' && $response['code'] == '010'
		);

		$params = array();
		$response = self::$instance->add($params);
		$this->assertTrue(
			$response['stat'] == 'fail' && $response['code'] == '200' && $response['field'] == 'folderName'
		);

		$invalidInstance = new IssuuFolder('abz', 'apisecret');
		$response = $invalidInstance->issuuList();
		$this->assertTrue(
			$response['stat'] == 'fail' && $response['code'] == '201' && $response['field'] == 'apiKey'
		);

		/**
		*	Same folder name for differents folders is accepted
		*/
		// $params['folderName'] = 'Unit Test';
		// $response = self::$instance->add($params);
		// $this->assertTrue(
		// 	$response['stat'] == 'fail' && $response['code'] == '261'
		// );
	}

	public function testAddUpdateAndDeleteFolder()
	{
		
	}
}