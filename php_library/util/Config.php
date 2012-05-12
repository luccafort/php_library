<?php
/**
 * Configファイル管理クラス.
 * 
 * DB情報や各種定数データを管理する際に使用.
 * 
 */
class Util_Config extends Util_Singleton
{
	private $_param;
	private static $_path;
	private static $instance = null;
	
	/**
	 * 
	 * コンストラクタ
	 * 
	 * インスタンス取得のため private 修飾子にて定義.
 	 */
	private function __construct()
	{
		self::$_path = '';
		$this->_param = array();
	}
	
	/**
	 * 
	 * デストラクタ.
	 */
	private function __destruct()
	{
		//インスタンスが生成済みなら破棄.
		if( false == Util_Validator::isEmpty( self::$instance ) ){
			self::$instance = null;
		}
	}
	
	/**
	 * 
	 * インスタンス取得
	 * @param String $path
	 * @param bool $enable
	 * @return Util_Config
	 */
	public static function getInstance( $path = '')
	{
		if( Util_Validator::isEmpty( self::$instance ) ){
			self::$instance = new Util_Config();
		}
		return $this;
	}
	
	/**
	 * 
	 * インスタンスの破棄.
	 */
	public static function closeInstance()
	{
		$this->_param = array();
		self::$_path = '';
		$this->__destruct();
	}
	
	/**
	 * 
	 * iniファイル情報を解析.
	 * 
	 * @throws Exception
	 */
	public function parse()
	{
		if( Util_Validator::isEmpty( self::$_path ) != true ){
			$this->_params = parse_ini_file( self::$_path, true );
			if( $this->_params === false ){
				//INIファイルのデータ取得に失敗.
				throw new Exception( 'parse_ini_file() failed, function is returned false. ' );
			} else if( Util_Validator::isEmpty( $this->_params ) ){
				//INIファイル内のデータが空
				throw new Exception( ' ini data is empty ' );
			}
		}
	}
	
	/**
	 * 
	 * 指定されたファイルパスを設定.
	 * 
	 * 成功すれば true を、失敗すれば false を返す.
	 * parseEnable が true だった場合は
	 * 指定されたiniファイルを解析した連想配列が返る.
	 * 
	 * @param String $path
	 * @param bool $parseEnable
	 * @return mixed
	 * 
	 */
	public function setFile( $path, $parseEnable = false )
	{
		$result = false;
		if( false == Util_Validator::isEmpty( $path )
		&&  Util_Validator::isString( $path ) ){
			$this->_setPath( $path );
			//パースした結果を返す必要か判定
			if( $parseEnable !== false ){
				$result = $this->parse();
			} else {
				$result = true;
			}
		}
		return $result;
	}
	
	/**
	 * 
	 * ファイルパスを設定.
	 * @param String $path
	 */
	private function _setPath( $path )
	{
		if( Util_Validator::isFileExist( $path ) ){
			self::$_path = $path;
		}
	}
	
	/**
	 * 
	 * ファイルパスを取得.
	 * @return String
	 */
	private function _getPath()
	{
		return self::$_path;
	}
	
}