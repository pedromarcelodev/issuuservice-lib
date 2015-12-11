<?php

class IssuuServiceConsoleListener
{
	public function __construct()
	{
		// Document
		IssuuServiceConsoleEventManager::attach('issuu.documents.list', array($this, 'issuuDocumentsList'), 600);
		IssuuServiceConsoleEventManager::attach('issuu.document.upload', array($this, 'issuuDocumentUpload'), 600);
		IssuuServiceConsoleEventManager::attach(
			'issuu.document.url_upload',
			array($this, 'issuuDocumentUrlUpload'),
			600
		);
		IssuuServiceConsoleEventManager::attach('issuu.document.update', array($this, 'issuuDocumentUpdate'), 600);
		IssuuServiceConsoleEventManager::attach('issuu.document.delete', array($this, 'issuuDocumentDelete'), 600);
		// Folder
		IssuuServiceConsoleEventManager::attach('issuu.folders.list', array($this, 'issuuFoldersList'), 600);
		IssuuServiceConsoleEventManager::attach('issuu.folder.add', array($this, 'issuuFolderAdd'), 600);
		IssuuServiceConsoleEventManager::attach('issuu.folder.update', array($this, 'issuuFolderUpdate'), 600);
		IssuuServiceConsoleEventManager::attach('issuu.folder.delete', array($this, 'issuuFolderDelete'), 600);
		// Bookmark
		IssuuServiceConsoleEventManager::attach('issuu.bookmarks.list', array($this, 'issuuBookmarksList'), 600);
		IssuuServiceConsoleEventManager::attach('issuu.bookmark.add', array($this, 'issuuBookmarkAdd'), 600);
		IssuuServiceConsoleEventManager::attach('issuu.bookmark.delete', array($this, 'issuuBookmarkDelete'), 600);
		// Document Embed
		IssuuServiceConsoleEventManager::attach(
			'issuu.document_embeds.list',
			array($this, 'issuuDocumentEmbedsList'),
			600
		);
		IssuuServiceConsoleEventManager::attach('issuu.document_embed.add', array($this, 'issuuDocumentEmbedAdd'), 600);
		IssuuServiceConsoleEventManager::attach(
			'issuu.document_embed.get_html_code',
			array($this, 'issuuDocumentEmbedGetHtmlCode'),
			600
		);
		IssuuServiceConsoleEventManager::attach(
			'issuu.document_embed.update',
			array($this, 'issuuDocumentEmbedUpdate'),
			600
		);
		IssuuServiceConsoleEventManager::attach(
			'issuu.document_embed.delete',
			array($this, 'issuuDocumentEmbedDelete'),
			600
		);
	}

	/*
	*	Document
	*/

	public function issuuDocumentsList(IssuuServiceConsoleEvent $event)
	{
		$eventName = $event->getName();
		$type = $event->getParam('type');
		$apiKey = $event->getParam('apiKey');
		$apiSecret = $event->getParam('apiSecret');
		$params = $this->getIssuuParams($event->getParams());
		IssuuServiceConsoleEventManager::trigger(
			$eventName . '.pre',
			$event->getTarget(),
			$event->getParams()
		);
		$instance = new IssuuDocument($apiKey, $apiSecret);

		if ($type == 'calculate-signature')
		{
			$instance->setParams($params);
			$response = $instance->getSignature();
		}
		else if ($type == 'send-request')
		{
			$response = $instance->issuuList($params);
		}
		IssuuServiceConsoleEventManager::trigger(
			$eventName . '.pos',
			$event->getTarget(),
			array_merge($event->getParams(), array('response' => $response))
		);
		return $response;
	}

	public function issuuDocumentUpload(IssuuServiceConsoleEvent $event)
	{
		$eventName = $event->getName();
		$type = $event->getParam('type');
		$apiKey = $event->getParam('apiKey');
		$apiSecret = $event->getParam('apiSecret');
		$params = $this->getIssuuParams($event->getParams());
		IssuuServiceConsoleEventManager::trigger(
			$eventName . '.pre',
			$event->getTarget(),
			$event->getParams()
		);
		$instance = new IssuuDocument($apiKey, $apiSecret);

		if ($type == 'calculate-signature')
		{
			$instance->setParams($params);
			$response = $instance->getSignature();
		}
		else if ($type == 'send-request')
		{
			$response = $instance->upload($params);
		}
		IssuuServiceConsoleEventManager::trigger(
			$eventName . '.pos',
			$event->getTarget(),
			array_merge($event->getParams(), array('response' => $response))
		);
		return $response;
	}

	public function issuuDocumentUrlUpload(IssuuServiceConsoleEvent $event)
	{
		$eventName = $event->getName();
		$type = $event->getParam('type');
		$apiKey = $event->getParam('apiKey');
		$apiSecret = $event->getParam('apiSecret');
		$params = $this->getIssuuParams($event->getParams());
		IssuuServiceConsoleEventManager::trigger(
			$eventName . '.pre',
			$event->getTarget(),
			$event->getParams()
		);
		$instance = new IssuuDocument($apiKey, $apiSecret);

		if ($type == 'calculate-signature')
		{
			$instance->setParams($params);
			$response = $instance->getSignature();
		}
		else if ($type == 'send-request')
		{
			$response = $instance->urlUpload($params);
		}
		IssuuServiceConsoleEventManager::trigger(
			$eventName . '.pos',
			$event->getTarget(),
			array_merge($event->getParams(), array('response' => $response))
		);
		return $response;
	}

	public function issuuDocumentUpdate(IssuuServiceConsoleEvent $event)
	{
		$eventName = $event->getName();
		$type = $event->getParam('type');
		$apiKey = $event->getParam('apiKey');
		$apiSecret = $event->getParam('apiSecret');
		$params = $this->getIssuuParams($event->getParams());
		IssuuServiceConsoleEventManager::trigger(
			$eventName . '.pre',
			$event->getTarget(),
			$event->getParams()
		);
		$instance = new IssuuDocument($apiKey, $apiSecret);

		if ($type == 'calculate-signature')
		{
			$instance->setParams($params);
			$response = $instance->getSignature();
		}
		else if ($type == 'send-request')
		{
			$response = $instance->update($params);
		}
		IssuuServiceConsoleEventManager::trigger(
			$eventName . '.pos',
			$event->getTarget(),
			array_merge($event->getParams(), array('response' => $response))
		);
		return $response;
	}

	public function issuuDocumentDelete(IssuuServiceConsoleEvent $event)
	{
		$eventName = $event->getName();
		$type = $event->getParam('type');
		$apiKey = $event->getParam('apiKey');
		$apiSecret = $event->getParam('apiSecret');
		$params = $this->getIssuuParams($event->getParams());
		IssuuServiceConsoleEventManager::trigger(
			$eventName . '.pre',
			$event->getTarget(),
			$event->getParams()
		);
		$instance = new IssuuDocument($apiKey, $apiSecret);

		if ($type == 'calculate-signature')
		{
			$instance->setParams($params);
			$response = $instance->getSignature();
		}
		else if ($type == 'send-request')
		{
			$response = $instance->delete($params);
		}
		IssuuServiceConsoleEventManager::trigger(
			$eventName . '.pos',
			$event->getTarget(),
			array_merge($event->getParams(), array('response' => $response))
		);
		return $response;
	}

	/*
	*	Folder
	*/

	public function issuuFoldersList(IssuuServiceConsoleEvent $event)
	{
		$eventName = $event->getName();
		$type = $event->getParam('type');
		$apiKey = $event->getParam('apiKey');
		$apiSecret = $event->getParam('apiSecret');
		$params = $this->getIssuuParams($event->getParams());
		IssuuServiceConsoleEventManager::trigger(
			$eventName . '.pre',
			$event->getTarget(),
			$event->getParams()
		);
		$instance = new IssuuFolder($apiKey, $apiSecret);

		if ($type == 'calculate-signature')
		{
			$instance->setParams($params);
			$response = $instance->getSignature();
		}
		else if ($type == 'send-request')
		{
			$response = $instance->issuuList($params);
		}
		IssuuServiceConsoleEventManager::trigger(
			$eventName . '.pos',
			$event->getTarget(),
			array_merge($event->getParams(), array('response' => $response))
		);
		return $response;
	}

	public function issuuFolderAdd(IssuuServiceConsoleEvent $event)
	{
		$eventName = $event->getName();
		$type = $event->getParam('type');
		$apiKey = $event->getParam('apiKey');
		$apiSecret = $event->getParam('apiSecret');
		$params = $this->getIssuuParams($event->getParams());
		IssuuServiceConsoleEventManager::trigger(
			$eventName . '.pre',
			$event->getTarget(),
			$event->getParams()
		);
		$instance = new IssuuFolder($apiKey, $apiSecret);

		if ($type == 'calculate-signature')
		{
			$instance->setParams($params);
			$response = $instance->getSignature();
		}
		else if ($type == 'send-request')
		{
			$response = $instance->add($params);
		}
		IssuuServiceConsoleEventManager::trigger(
			$eventName . '.pos',
			$event->getTarget(),
			array_merge($event->getParams(), array('response' => $response))
		);
		return $response;
	}

	public function issuuFolderUpdate(IssuuServiceConsoleEvent $event)
	{
		$eventName = $event->getName();
		$type = $event->getParam('type');
		$apiKey = $event->getParam('apiKey');
		$apiSecret = $event->getParam('apiSecret');
		$params = $this->getIssuuParams($event->getParams());
		IssuuServiceConsoleEventManager::trigger(
			$eventName . '.pre',
			$event->getTarget(),
			$event->getParams()
		);
		$instance = new IssuuFolder($apiKey, $apiSecret);

		if ($type == 'calculate-signature')
		{
			$instance->setParams($params);
			$response = $instance->getSignature();
		}
		else if ($type == 'send-request')
		{
			$response = $instance->update($params);
		}
		IssuuServiceConsoleEventManager::trigger(
			$eventName . '.pos',
			$event->getTarget(),
			array_merge($event->getParams(), array('response' => $response))
		);
		return $response;
	}

	public function issuuFolderDelete(IssuuServiceConsoleEvent $event)
	{
		$eventName = $event->getName();
		$type = $event->getParam('type');
		$apiKey = $event->getParam('apiKey');
		$apiSecret = $event->getParam('apiSecret');
		$params = $this->getIssuuParams($event->getParams());
		IssuuServiceConsoleEventManager::trigger(
			$eventName . '.pre',
			$event->getTarget(),
			$event->getParams()
		);
		$instance = new IssuuFolder($apiKey, $apiSecret);

		if ($type == 'calculate-signature')
		{
			$instance->setParams($params);
			$response = $instance->getSignature();
		}
		else if ($type == 'send-request')
		{
			$response = $instance->delete($params);
		}
		IssuuServiceConsoleEventManager::trigger(
			$eventName . '.pos',
			$event->getTarget(),
			array_merge($event->getParams(), array('response' => $response))
		);
		return $response;
	}

	/*
	*	Bookmark
	*/

	public function issuuBookmarksList(IssuuServiceConsoleEvent $event)
	{
		$eventName = $event->getName();
		$type = $event->getParam('type');
		$apiKey = $event->getParam('apiKey');
		$apiSecret = $event->getParam('apiSecret');
		$params = $this->getIssuuParams($event->getParams());
		IssuuServiceConsoleEventManager::trigger(
			$eventName . '.pre',
			$event->getTarget(),
			$event->getParams()
		);
		$instance = new IssuuBookmark($apiKey, $apiSecret);

		if ($type == 'calculate-signature')
		{
			$instance->setParams($params);
			$response = $instance->getSignature();
		}
		else if ($type == 'send-request')
		{
			$response = $instance->issuuList($params);
		}
		IssuuServiceConsoleEventManager::trigger(
			$eventName . '.pos',
			$event->getTarget(),
			array_merge($event->getParams(), array('response' => $response))
		);
		return $response;
	}

	public function issuuBookmarkAdd(IssuuServiceConsoleEvent $event)
	{
		$eventName = $event->getName();
		$type = $event->getParam('type');
		$apiKey = $event->getParam('apiKey');
		$apiSecret = $event->getParam('apiSecret');
		$params = $this->getIssuuParams($event->getParams());
		IssuuServiceConsoleEventManager::trigger(
			$eventName . '.pre',
			$event->getTarget(),
			$event->getParams()
		);
		$instance = new IssuuBookmark($apiKey, $apiSecret);

		if ($type == 'calculate-signature')
		{
			$instance->setParams($params);
			$response = $instance->getSignature();
		}
		else if ($type == 'send-request')
		{
			$response = $instance->add($params);
		}
		IssuuServiceConsoleEventManager::trigger(
			$eventName . '.pos',
			$event->getTarget(),
			array_merge($event->getParams(), array('response' => $response))
		);
		return $response;
	}

	public function issuuBookmarkDelete(IssuuServiceConsoleEvent $event)
	{
		$eventName = $event->getName();
		$type = $event->getParam('type');
		$apiKey = $event->getParam('apiKey');
		$apiSecret = $event->getParam('apiSecret');
		$params = $this->getIssuuParams($event->getParams());
		IssuuServiceConsoleEventManager::trigger(
			$eventName . '.pre',
			$event->getTarget(),
			$event->getParams()
		);
		$instance = new IssuuBookmark($apiKey, $apiSecret);

		if ($type == 'calculate-signature')
		{
			$instance->setParams($params);
			$response = $instance->getSignature();
		}
		else if ($type == 'send-request')
		{
			$response = $instance->delete($params);
		}
		IssuuServiceConsoleEventManager::trigger(
			$eventName . '.pos',
			$event->getTarget(),
			array_merge($event->getParams(), array('response' => $response))
		);
		return $response;
	}

	/*
	*	Document Embed
	*/

	public function issuuDocumentEmbedsList(IssuuServiceConsoleEvent $event)
	{
		$eventName = $event->getName();
		$type = $event->getParam('type');
		$apiKey = $event->getParam('apiKey');
		$apiSecret = $event->getParam('apiSecret');
		$params = $this->getIssuuParams($event->getParams());
		IssuuServiceConsoleEventManager::trigger(
			$eventName . '.pre',
			$event->getTarget(),
			$event->getParams()
		);
		$instance = new IssuuDocumentEmbed($apiKey, $apiSecret);

		if ($type == 'calculate-signature')
		{
			$instance->setParams($params);
			$response = $instance->getSignature();
		}
		else if ($type == 'send-request')
		{
			$response = $instance->issuuList($params);
		}
		IssuuServiceConsoleEventManager::trigger(
			$eventName . '.pos',
			$event->getTarget(),
			array_merge($event->getParams(), array('response' => $response))
		);
		return $response;
	}

	public function issuuDocumentEmbedAdd(IssuuServiceConsoleEvent $event)
	{
		$eventName = $event->getName();
		$type = $event->getParam('type');
		$apiKey = $event->getParam('apiKey');
		$apiSecret = $event->getParam('apiSecret');
		$params = $this->getIssuuParams($event->getParams());
		IssuuServiceConsoleEventManager::trigger(
			$eventName . '.pre',
			$event->getTarget(),
			$event->getParams()
		);
		$instance = new IssuuDocumentEmbed($apiKey, $apiSecret);

		if ($type == 'calculate-signature')
		{
			$instance->setParams($params);
			$response = $instance->getSignature();
		}
		else if ($type == 'send-request')
		{
			$response = $instance->add($params);
		}
		IssuuServiceConsoleEventManager::trigger(
			$eventName . '.pos',
			$event->getTarget(),
			array_merge($event->getParams(), array('response' => $response))
		);
		return $response;
	}

	public function issuuDocumentEmbedGetHtmlCode(IssuuServiceConsoleEvent $event)
	{
		$eventName = $event->getName();
		$type = $event->getParam('type');
		$apiKey = $event->getParam('apiKey');
		$apiSecret = $event->getParam('apiSecret');
		$params = $this->getIssuuParams($event->getParams());
		IssuuServiceConsoleEventManager::trigger(
			$eventName . '.pre',
			$event->getTarget(),
			$event->getParams()
		);
		$instance = new IssuuDocumentEmbed($apiKey, $apiSecret);

		if ($type == 'calculate-signature')
		{
			$instance->setParams($params);
			$response = $instance->getSignature();
		}
		else if ($type == 'send-request')
		{
			$response = $instance->getHtmlCode($params);
		}
		IssuuServiceConsoleEventManager::trigger(
			$eventName . '.pos',
			$event->getTarget(),
			array_merge($event->getParams(), array('response' => $response))
		);
		return $response;
	}

	public function issuuDocumentEmbedUpdate(IssuuServiceConsoleEvent $event)
	{
		$eventName = $event->getName();
		$type = $event->getParam('type');
		$apiKey = $event->getParam('apiKey');
		$apiSecret = $event->getParam('apiSecret');
		$params = $this->getIssuuParams($event->getParams());
		IssuuServiceConsoleEventManager::trigger(
			$eventName . '.pre',
			$event->getTarget(),
			$event->getParams()
		);
		$instance = new IssuuDocumentEmbed($apiKey, $apiSecret);

		if ($type == 'calculate-signature')
		{
			$instance->setParams($params);
			$response = $instance->getSignature();
		}
		else if ($type == 'send-request')
		{
			$response = $instance->update($params);
		}
		IssuuServiceConsoleEventManager::trigger(
			$eventName . '.pos',
			$event->getTarget(),
			array_merge($event->getParams(), array('response' => $response))
		);
		return $response;
	}

	public function issuuDocumentEmbedDelete(IssuuServiceConsoleEvent $event)
	{
		$eventName = $event->getName();
		$type = $event->getParam('type');
		$apiKey = $event->getParam('apiKey');
		$apiSecret = $event->getParam('apiSecret');
		$params = $this->getIssuuParams($event->getParams());
		IssuuServiceConsoleEventManager::trigger(
			$eventName . '.pre',
			$event->getTarget(),
			$event->getParams()
		);
		$instance = new IssuuDocumentEmbed($apiKey, $apiSecret);

		if ($type == 'calculate-signature')
		{
			$instance->setParams($params);
			$response = $instance->getSignature();
		}
		else if ($type == 'send-request')
		{
			$response = $instance->delete($params);
		}
		IssuuServiceConsoleEventManager::trigger(
			$eventName . '.pos',
			$event->getTarget(),
			array_merge($event->getParams(), array('response' => $response))
		);
		return $response;
	}

	private function getIssuuParams(array $params)
	{
		$notValids = array('type', 'apiKey', 'apiSecret');
		$newParams = array();
		foreach ($params as $key => $value) {
			if (!in_array($key, $notValids))
			{
				$newParams[$key] = $value;
			}
		}
		return $newParams;
	}
}