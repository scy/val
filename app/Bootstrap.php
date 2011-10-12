<?php

class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{

	protected function _initAutoloading() {
		new Zend_Loader_Autoloader_Resource(array(
			'basePath'      => APPLICATION_PATH . '/../lib/ScyMultilang',
			'namespace'     => 'ScyMultilang',
			'resourceTypes' => array(
				'controller' => array(
					'path'      => 'controllers/',
					'namespace' => 'Controller',
				),
			),
		));
	}

	protected function _initConfig() {
		$config = $this->getOptions();
		Zend_Registry::set('config', $config);
		return $config;
	}

	protected function _initDoctype() {
		$this->bootstrap('view');
		$view = $this->getResource('view');
		$view->doctype('XHTML5');
	}

	protected function _initTranslate() {
		$config = Zend_Registry::get('config');
		$translate = new Zend_Translate(array(
			'adapter'        => 'array',
			'content'        => APPLICATION_PATH . '/locale/text',
			'scan'           => Zend_Translate::LOCALE_FILENAME,
			'route'          => array('fr' => 'de'),
			'disableNotices' => isset($config['language']['disableNotices'])
			                  ? $config['language']['disableNotices']
			                  : true,
		));
		Zend_Registry::set('Zend_Translate', $translate);
	}

	protected function _initRoutes() {
		$routes = array(
			'root' => array('', array(
				'LOCALE'     => '',
				'controller' => 'index',
				'action'     => 'index',
			)),
			'static' => array(':LOCALE/:@lv1/:@lv2/:@lv3', array(
				'controller' => 'static',
				'action'     => 'static',
				'lv1'        => null,
				'lv2'        => null,
				'lv3'        => null,
			)),
		);
		$this->bootstrap('FrontController');
		$fc = $this->getResource('FrontController');
		$router = $fc->getRouter();
		$router->removeDefaultRoutes();
		foreach ($routes as $name => $route) {
			$router->addRoute($name, new ScyMultilang_Controller_Router_Route(
				$route[0], $route[1]
			));
		}
		$translator = new Zend_Translate(array(
			'adapter'        => 'array',
			'content'        => APPLICATION_PATH . '/locale/url',
			'scan'           => Zend_Translate::LOCALE_FILENAME,
			'disableNotices' => isset($config['language']['disableNotices'])
			                  ? $config['language']['disableNotices']
			                  : true,
		));
		ScyMultilang_Controller_Router_Route::setDefaultTranslator($translator);
	}

	protected function _initViewVariables() {
		$view = $this->getResource('view');
		$view->Zend_Registry = Zend_Registry::get('Zend_Translate');
	}

	protected function _initViewRendererHelper() {
		// Make view renderer available as getHelper('view') in controllers.
		Zend_Controller_Action_HelperBroker::addHelper(new Zend_Controller_Action_Helper_ViewRenderer());
	}

}

// Define a shortcut __ function.
function __($key) {
	$translate = Zend_Registry::get('Zend_Translate');
	return $translate->translate($key);
}
