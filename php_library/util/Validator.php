<?php
/**
 * 
 * バリデーション管理
 * @author tkonishi
 *
 */
class Util_Validator
{
	/**
	 * 
	 * 配列判定.
	 * @param array $value
	 * @param bool $isEmpty
	 */
	public static function isArray( $value, $isEmpty = false )
	{
		$result = false;
		if( is_array( $value ) ){
			if( $isEmpty === true ){
				$result = self::isEmpty( $value );
			} else {
				$result = true;
			}
		}
		return $result;
	}
	
	/**
	 * 
	 * 空判定.
	 * @param mixed $value
	 */
	public static function isEmpty( $value )
	{
		$result = true;
		if( is_array( $value ) ){
			if( count( $value ) > 0 ){
				$result = false;
			}
		} else {
			if( is_string( $value ) || is_int( $value ) ){
				if( '' !== $value
				&&  null !== $value
				&&  false !== $value ){
					$result = false;
				}
			}
		}
		return $result;
	}
	
	/**
	 * 
	 * 文字列長判定.
	 * 
	 * 数値、もしくは文字列のみそのLength長を調べ結果を返す.
	 * 
	 * @param mixed $value
	 */
	public function isLength( $value )
	{
		$result = false;
		if( false == self::isEmpty( $value ) ){
			if( is_int( $value ) || is_string( $value ) ){
				$result = strlen( $value );
			}
		}
		return $result;
	}
	
	/**
	 * 
	 * Boolean型判定.
	 * @param boolean $value
	 */
	public static function isBoolean( $value )
	{
		return is_bool( $value );
	}
	
	/**
	 * 
	 * 文字列判定.
	 * @param unknown_type $value
	 */
	public static function isString( $value )
	{
		$result = false;
		if( is_string( $value ) || is_int( $value ) ){
			$result = true;
		}
		return $result;
	}
	
	/**
	 * 
	 * マルチバイト文字判定
	 * @param String $value
	 * @param String $encoding
	 */
	public static function isMbString( $value, $encoding = 'UTF-8' )
	{
		$result = false;
		if( self::isString( $value ) || self::isNumeric( $value ) ){
			if( mb_strlen( $value, $encoding ) > 0 ){
				$result = true;
			}
		}
		return $result;
	}
	
	/**
	 * 
	 * 数値判定.
	 * 
	 * 16進数文字列や指数文字列も false として返却
	 * 
	 * @param unknown_type $value
	 */
	public static function isNumeric( $value )
	{
		$result = false;
		if( is_int( $value ) || is_string( $value ) ){
			if( ctype_digit( strval( $value ) ) ){
				$result = true;
			}
		}
		return $result;
	}
	
	/**
	 * 
	 * ファイルパスの存在有無判定.
	 * @param String $path
	 */
	public static function isFileExist( $path )
	{
		return file_exists( $path );
	}
	
}