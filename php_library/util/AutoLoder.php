<?php
/**
 * AutoLoderクラス.
 * 
 * TODO:SymphonyやZendのように最終的にはロード済みのクラスをキャッシュするように修正が必要か。
 * 小さなプログラムを書く際にキャッシュされても面倒なので
 * キャッシュする際にはフラグ管理的なものを用意し、判定するようにするか
 * もしくはキャッシュを任意的に排除する処理が必要になる。
 * 
 */
class Util_Autoloader
{
	//プロジェクト固有のルートパス.
	const PROJECT_ROOT_PATH = '/www/hogehoge/';
	
	/**
	 * 
	 * 本クラスのクラス名.
	 * 
	 * spl_autoload_register()にて本クラスを
	 * __autoload の実装として登録するのに必要
	 * ※プロジェクト毎にパスが変わり得るのでクラス定数として定義
	 * 
	 * @var String
	 */
	const CLASS_NAME = 'Util_Autoloader';
	
	public static function autoloder( $className )
	{
		$result = false;
		$file = '';
		$directory = self::_getDirectory();
		$extension = self::_getExtension();
		if( false == self::_isExist( $className ) ){
			foreach( $directory as $dir ){
				if( strlen( $file ) > 0 ){
					//すでにファイルパスが指定されていれば処理を抜ける.
					break;
				}
				foreach( $extension as $ext ){
					$tempfile = $dir . $className . $ext;
					//ファイルが存在し、かつ通常ファイル
					if( file_exists(  $tempfile )
					&&  is_file( $tempfile ) ){
						$file = $tempfile;
						break;
					}
				}
			}
		}
		if( strlen( $file ) ){
			require $file;
			if( function_exists( '__autoload' ) ){
				//すでに定義済みのautoloadが存在する場合はこちらを優先するよう書き換える.
				spl_autoload_register( '__autoload', true );
			}
			//autoload に登録、結果を格納.
			$result = spl_autoload_register( array( self::CLASS_NAME, 'autoload' ) );
		}
		return $result;
	}
	
	/**
	 * 
	 * 
	 */
	private static function _getDirectory()
	{
		$dir = array();
		//TODO:指定階層以下のディレクトリ情報を取得したほうが汎用的.
		//でも今はめんどうなので固定で値を保持しますよっと。
		$dir = array(
			self::PROJECT_ROOT_PATH,
			self::PROJECT_ROOT_PATH . 'controller/',
			self::PROJECT_ROOT_PATH . 'dao/',
			self::PROJECT_ROOT_PATH . 'util/',
		);
		return $dir;
	}
	
	private static function _getExtension()
	{
		//TODO:可能ならiniファイルとかにクラスファイルの拡張子を格納して
		//iniファイル情報を取得とかのほうがソース変更しなくて済むので楽か？
		//ただ今はめんどうなのでスルー
		$extension = array(
			'.php',
			'.class.php',
			'.inc',
			'.lib',
			'.mod',
			'.cls.php'
		);
		return $extension;
	}
	
	/**
	 * 
	 * すでに存在しているか判定.
	 * @param unknown_type $className
	 */
	private static function _isExist( $className )
	{
		$result = false;
		if( class_exists( $className, false )
		||  interface_exists( $className, false ) ){
			$result = true;
		}
		return $result;
	}
	
}