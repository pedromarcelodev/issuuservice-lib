<?php

class IssuuDocumentEmbedTest extends PHPUnit_Framework_TestCase
{
	private static $instance;

	private static $params = array(
		'action' => 'issuu.document_embed.add',
		'documentId' => '150909220128-e98a2d90e33c403c80250d17063a865a',
		'readerStartPage' => 1,
		'width' => 525,
		'height' => 300,
	);

	private static $signature;

	public static function setUpBeforeClass()
	{
		sleep(3);
		self::$instance = new IssuuDocumentEmbed($_POST['apikey'], $_POST['apisecret']);
		$params = array_merge(array('apiKey' => $_POST['apikey']), self::$params);
		ksort($params);
		$params = strtr(urldecode(http_build_query($params)), array('&' => '', '=' => ''));
		self::$signature = md5($_POST['apisecret'] . $params);
	}

	public static function setUpAfterClass()
	{
		self::$instance = null;
	}

	public function testHasClass()
	{
		$this->assertTrue(class_exists('IssuuDocumentEmbed'));
	}

	public function testSetParamsAndThrowException()
	{
		try {
			self::$instance->setParams(array('action' => 'issuu.document_embeds.list'));
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
		sleep(1);
		$invalidInstance = new IssuuDocumentEmbed('jil7ll5cg2cwm93kg6xlsc1x9apdeyhb', 'apisecret');
		$response = $invalidInstance->issuuList();
		$this->assertTrue(
			$response['stat'] == 'fail' && $response['code'] == '010'
		);
		sleep(1);
		$params = array();
		$response = self::$instance->add($params);
		$this->assertTrue(
			$response['stat'] == 'fail' && $response['code'] == '200' && $response['field'] == 'documentId'
		);
		sleep(1);
		$invalidInstance = new IssuuDocumentEmbed('abz', 'apisecret');
		$response = $invalidInstance->issuuList();
		$this->assertTrue(
			$response['stat'] == 'fail' && $response['code'] == '201' && $response['field'] == 'apiKey'
		);
	}

	public function testGetHtmlCode()
	{
		sleep(1);
		$response = self::$instance->issuuList();

		if ($response['stat'] == 'ok')
		{
			sleep(1);
			$embed = $response['documentEmbed'][0];
			$response = self::$instance->getHtmlCode(array(
				'embedId' => $embed->id
			));
			$this->assertTrue(is_string($response));
		}
		else
		{
			$this->fail("Nenhum embed listado");
		}
	}

	public function testAddUpdateAndDeleteDocumentEmbed()
	{
		sleep(1);
		$issuuDocument = new IssuuDocument($_POST['apikey'], $_POST['apisecret']);
		$documents = $issuuDocument->issuuList();

		if ($documents['stat'] == 'ok' && !empty($documents['document']))
		{
			sleep(1);
			$documentId = $documents['document'][0]->documentId;
			$response = self::$instance->add(array(
				'documentId' => '150909220128-e98a2d90e33c403c80250d17063a865a',
				'readerStartPage' => 1,
				'width' => 500,
				'height' => 300,
			));
			$this->assertEquals('ok', $response['stat']);
			$embedId = $response['documentEmbed']->id;
			$response = self::$instance->update(array(
				'embedId' => $embedId,
				'width' => 600,
			));
			$this->assertEquals('ok', $response['stat']);
			$response = self::$instance->delete(array(
				'embedId' => $embedId
			));
			$this->assertEquals('ok', $response['stat']);
		}
		else
		{
			$this->fail("Nenhum documento listado");
		}
	}
}