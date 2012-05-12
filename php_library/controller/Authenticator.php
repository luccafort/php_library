<?php
/**
 * 
 * 認証コントローラー
 * @author tkonishi
 *
 */
class Controller_Authenticator
{
	const PROTOCOL_HTTP = 'HTTP/1.1';
	const PROTOCOL_HTTPS = 'HTTPS/1.1';
	
	/**
	 * 認証処理
	 * 
	 * @var int
	 */
	const AUTH_STATE_NONE = 0;
	
	/**
	 * 
	 * リクエストパラメータを格納.
	 * @var Util_Request
	 */
	private $_request = null;
	
	/**
	 * 
	 * DBクラス.
	 * @var Util_Db
	 */
	private $_db = null;
	
	public function __construct()
	{
		$this->_request = new Util_Request();
		
		//TODO:DBに接続する必要がある場合はDBクラスを生成したほうがよい？
	}
	
	public function __destruct()
	{
		if( $this->_request instanceof Util_Request ){
			$this->_request->close();
		}
	}
	
	/**
	 * 
	 * 認証実行.
	 * @param int $state
	 */
	public function execute( $state )
	{
		switch( $state ){
		case self::AUTH_STATE_NONE:
			break;
		default :
			//TODO:エラー処理、もしくは共通処理.
			break;
		}
	}
	
}