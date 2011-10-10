<?php

class StaticController extends ScyMultilang_Controller_Action {

	protected function scriptParam($params, $name, $default) {
		if (isset($params[$name])) {
			return preg_replace('/[^a-zA-Z0-9-]/', '', $params[$name]);
		} else {
			return $default;
		}
	}

	protected function scriptParams($params, $parts) {
		$arr = array();
		foreach ($parts as $name => $default) {
			$r = $this->scriptParam($params, $name, $default);
			if ($r !== null) {
				$arr[] = $r;
			}
		}
		return $arr;
	}

	public function staticAction() {
		// Get some tools.
		$request = $this->getRequest();
		$viewrenderer = $this->_helper->getHelper('viewRenderer');
		// Find out which script should be displayed.
		$params = $request->getParams();
		$script = implode('/', $this->scriptParams($params, array(
			'lv1' => 'index',
			'lv2' => 'index',
			'lv3' => null,
		))) . '-' . $params['LOCALE'];
		$this->_helper->viewRenderer($script);
	}

}
