<?php

class IssuuServiceConsoleListener
{
	public function __construct()
	{
		IssuuServiceConsoleEventManager::attach('issuu.documents.list', array($this, 'issuuDocumentsList'), 600);
		IssuuServiceConsoleEventManager::attach('issuu.documents.list', array($this, 'issuuDocumentsList2'), 600);
		IssuuServiceConsoleEventManager::attach('issuu.documents.list', array($this, 'issuuDocumentsList3'), 600);
	}

	public function issuuDocumentsList(IssuuServiceConsoleEvent $event)
	{
		return array('Olá mundo', $event->getName());
	}

	public function issuuDocumentsList2()
	{
		throw new Exception("Testing trigger until");
	}

	public function issuuDocumentsList3()
	{
		return array('After Exception');
	}
}