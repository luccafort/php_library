<?php
/**
 * ディスパッチ
 */
class Util_Dispatcher
{
	const REQUEST_NAME = 'action';
	private static $_params = array();
	private $_controller = null;

	/**
	 * 実行処理を割り当てる.
	 */
	public function display()
	{
		//生成対象取得.
		$getParams = preg_replace( '/?$', '', $_GET[ self::REQUEST_NAME ] );
		if( false == Util_Validator::isEmpty( $getParams ) ){
			self::$_params = explode( '/', $getParams );
		}

		$controllerName = 'index';
		if( count( self::$_params ) > 0 ){
			//一番目のパラメータが生成対象のコントローラー名.
			$controllerName = self::$_params[ 0 ];
		}
		self::getInstance( $controllerName );
		if( Util_Validator::isEmpty( $this->_controller ) ){
			Util_Response::sendStatusCode( Util_Response::NOT_FOUND, 'NOT FOUND.' );
		}
	}

	/**
	 * 生成対象となるクラスのインスタンスを取得する.
	 */
	abstract protected static function getInstance( $controllerName );
}