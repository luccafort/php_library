<?php
/**
 * リクエストパラメータを管理
 *
 * @author tkonishi
 *
 */
class Util_Request
{
	/**
	 * GET値
	 * @var String
	 */
	const MODE_GET    = '_get';

	/**
	 * POST値
	 * @var String
	 */
	const MODE_POST   = '_post';

	/**
	 * COOKIE値
	 * @var String
	 */
	const MODE_COOKIE = '_cookie';
	/**
	 *
	 * 取得したリクエストパラメータを格納する
	 * @var unknown_type
	 */
	private $_param = array();

	/**
	 *
	 * コンストラクタ.
	 */
	public function __construct()
	{
		if( isset( $_REQUEST ) && count( $_REQUEST ) > 0 ){
			//GET/POST/COOKIEのリクエスト値を取得
			$this->_param = $_REQUEST;
		}
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
	public static function get( $position = null )
	{
		$result = array();
		if( Util_Validator::isEmpty( $position ) ){
			$result = $this->_param;
		} else if( Util_Validator::isArray( $position ) == false ){
			//取得するメソッドの指定があれば対象のメソッド内から探査.
			if( strlen( $this->_param[ $position ] ) > 0 ){
				$result = $this->_param[ $position ];
			}
		}
		return $result;
	}

	/**
	 * 配列のエスケープ処理
	 * <pre>
	 * htmlspecialchars()にてエスケープ処理を実装.
	 * </pre>
	 * @param array $param
	 * @param boolean $isEmpty
	 * @return array $result
	 */
	public static function escape( array $param, $isEmpty = false ){
		$result = array();
		if( Util_Validator::isArray( $param, $isEmpty ) ){
			foreach( $param as $key => $value ){
				if( Util_Validator::isArray( $value ) ){
					$result[ $key ] = self::escape( $value );
				} else {
					$result[ $key ] = htmlspecialchars( trim( $value ), ENT_QUOTES );
				}
			}
		}
		return $result;
	}

}