<?php
/**
 * リクエストパラメータを管理
 * 
 * @author tkonishi
 *
 */
class Util_Request
{
	const REQUEST_TYPE_NONE = null;
	
	/**
	 * GET値用のキー
	 * 
	 * @var String
	 */
	const REQUEST_TYPE_GET = '_get';
	
	/**
	 * 
	 * POST値用のキー
	 * @var String
	 */
	const REQUEST_TYPE_POST = '_post';
	
	/**
	 * 
	 * Session値用のキー
	 * @var String
	 */
	const REQUEST_TYPE_SESSION = '_session';
	
	/**
	 * 
	 * Memcache値用のキー
	 * @var String
	 */
	const REQUEST_TYPE_CACHE = '_cache';
	
	/**
	 * 
	 * サーバー変数値用のキー
	 * @var unknown_type
	 */
	const REQUEST_TYPE_SERVER = '_sever';
	
	/**
	 * 
	 * 取得したリクエストパラメータを格納する
	 * @var unknown_type
	 */
	private $_param = array();
	
	private $_method;
	
	/**
	 * 
	 * コンストラクタ.
	 */
	public function __construct()
	{
		if( isset( $_GET ) && count( $_GET ) > 0 ){
			$this->_param[ self::REQUEST_TYPE_GET ] = $_GET;
		}
		if( isset( $_POST ) && count( $_POST ) > 0 ){
			$this->_param[ self::REQUEST_TYPE_POST ] = $_POST;
		}
		if( isset( $_SESSEION ) && count( $_SESSION ) > 0 ){
			$this->_param[ self::REQUEST_TYPE_SESSION ] = $_SESSION;
		}
		if( isset( $_SERVER ) && count( $_SERVER ) > 0 ){
			$this->_param[ self::REQUEST_TYPE_SERVER ] = $_SERVER;
		}
		//TODO:Memecacheはクラス自体まだ生成してないので保留

		
	}
	
	/**
	 * 
	 * デストラクタ.
	 */
	public function __destruct()
	{
		$this->_param = array();
	}
	
	/**
	 * 
	 * リクエストパラメータ取得.
	 * @param mixed $position
	 */
	public function get( $position = null )
	{
		$result = array();
		if( Util_Validator::isEmpty( $position ) ){
			$result = $this->_param;
		} else if( false == Util_Validator::isArray( $position ) ){
			//取得するメソッドの指定があれば対象のメソッド内から探査.
			if( $this->_method !== self::REQUEST_TYPE_NONE ){
				$array = $this->_param[ $this->_method ];
			} else {
				//指定がないので
				$array = $this->_param;
			}
			foreach( $array as $key => $value ){
				if( Util_Validator::isArray( $value ) ){
					$result = $this->_get( $position, $value );
				} else {
					if( $key === $position ){
						$result = $value;
					}
				}
			}
		}
		return $result;
	}
	
	/**
	 * なんちゃって再帰的処理.
	 * 
	 * @param mixed $position
	 * @param array $array
	 */
	private function _get( $position, array $array )
	{
		$result = false;
		if( false == Util_Validator::isArray( $position ) ){
			foreach( $array as $key => $value ){
				if( $position === $key ){
					$result = $value;
				}
			}
		}
		return $result;
	}
	
	/**
	 * 
	 * 取得対象のメソッドを指定.
	 * @param String $method
	 */
	public function setMethodEnable( $method )
	{
		if( false == Util_Validator::isArray( $method ) ){
			switch( $method ){
				case self::REQUEST_TYPE_NONE:
				case self::REQUEST_TYPE_GET:
				case self::REQUEST_TYPE_POST:
				case self::REQUEST_TYPE_SERVER:
				case self::REQUEST_TYPE_SESSION:
				case self::REQUEST_TYPE_CACHE:
					$this->_method = $method;
					break;
				default :
					break;
			}
		}
	}
	
	/**
	 * 
	 * 意図的にUtil_Requestを破棄したい場合に使用.
	 */
	public function close()
	{
		self::__destruct();
		//TODO:自身にnullを代入することが出来るのか、またそのことによりクラスインスタンスを破棄出来るのか
		$this = null;
	}
	
}