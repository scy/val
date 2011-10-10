<?php

class IndexController extends ScyMultilang_Controller_Action
{

	public function indexAction() {
		// If no locale is set, redirect to the best match.
		if ($this->getRequest()->getParam('LOCALE') == '') {
			$available = Zend_Registry::get('Zend_Translate')->getList();
			$detected  = new Zend_Locale();
			$switchTo  = $detected->getLanguage();
			if (!isset($available[$switchTo])) {
				// Detected language is not available. Fall back to default.
				$config   = Zend_Registry::get('config');
				$switchTo = $config['language']['default'];
			}
			$this->_helper->getHelper('Redirector')->gotoRoute(array(
				'LOCALE' => $switchTo,
			), 'static');
		}
		// action body
	}

}

