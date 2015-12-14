<?php

class IssuuDocumentUploadTest extends PHPUnit_Extensions_SeleniumTestCase
{
	protected $captureScreenshotOnFailure = TRUE;
    protected $screenshotPath = ISSUU_SERVICE_LIBRARY_DIR . '/tests/screenshots';
    protected $screenshotUrl = 'http://localhost/issuuservice-lib/tests/pages/screenshots';

	public function setUp()
	{
		$this->setBrowser('firefox');
		$this->setHost('localhost');
		$this->setPort(4444);
		$this->setBrowserUrl('http://localhost/issuuservice-lib/tests/pages/form.php');
	}

	public function testUploadFile()
	{
		$this->open('http://localhost/issuuservice-lib/tests/pages/form.php');
		// $this->attachFile('file', 'http://localhost/issuuservice-lib/tests/assets/test.pdf');
		$this->focus('id=issuuDocumentUpload');
		$this->click('id=issuuDocumentUpload');
		// $this->typeKeys('id=issuuDocumentUpload', ISSUU_SERVICE_LIBRARY_DIR . '/tests/assets/test.pdf');
		// $this->attachFile('id=issuuDocumentUpload', 'file://' . ISSUU_SERVICE_LIBRARY_DIR . '/tests/assets/test.pdf');
		$this->attachFile('id=issuuDocumentUpload', 'http://localhost/issuuservice-lib/tests/assets/test.pdf');
		$this->submit('id=formUpload');
		$this->pause(14000);
		// $this->assertBodyText('okok');
		$this->assertEquals('okok', $this->getTitle());
	}
}