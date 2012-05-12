<?php
/**
 * Singletonクラス.
 */
abstract class Util_Singleton
{
	/**
	 * 
	 * インスタンスを格納
	 * @var Util_Singleton
	 */
	private static $instance;
	
	/**
	 * 
	 * コンストラクタ.
	 * 
	 * Singletonデザインを実装するために private にて実装.
	 */
	abstract private function __construct();
	
	/**
	 * 
	 * デストラクタ.
	 * 
	 * Singletonデザインを実装するために private にて実装.
	 */
	abstract private function __destruct();
	
	/**
	 * 
	 * インスタンスを生成/取得.
	 */
	abstract public static function getInstance();
	
	/**
	 * 
	 * インスタンスを破棄.
	 */
	abstract public static function closeInstance();
	
}