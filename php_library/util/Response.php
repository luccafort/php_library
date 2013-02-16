<?php
/**
 * レスポンス管理
 * @author luccafort
 *
 */
class Util_Response
{
	/**
	 * HTTPヘッダ
	 * @var String
	 */
	const HTTP_VERSION = 'HTTP/1.1';

	/**
	 * リクエスト成功.
	 *
	 * リクエストされた内容が成功
	 *
	 * @var int
	 */
	const SUCCESS = 200;

	/**
	 * 不正リクエスト
	 *
	 * 想定されていないリクエストの場合に使用
	 *
	 * @var int
	 */
	const BAD_REQUEST = 400;

	/**
	 * 認証エラー
	 *
	 * 認証が通らない場合に使用.
	 * クライアント以外のアクセスがなされた場合などを想定.
	 * ※ユーザ認証などとは異なる点に注意.
	 *
	 * @var int
	 */
	const UNAUTHORIZED = 401;

	/**
	 * 実行不可
	 *
	 * メンテナンス等の諸事情によりリクエストを拒否する場合に使用.
	 *
	 * @var int
	 */
	const FOBIDDEN = 403;

	/**
	 * リソースが見つからない
	 *
	 * サーバ上に指定されたリソースが存在しない場合に使用.
	 *
	 * @var int
	 */
	const NOT_FOUND = 404;

	/**
	 * 不明なエラー
	 * @var int
	 */
	const UNKNOWN_ERROR = 500;

	/**
	 * レスポンスヘッダーを返す.
	 * @param int $status
	 * @param String $message
	 * @throws Exception
	 */
	public static function setResponse( $status, $message = '' )
	{
		if( false == Util_Validator::isNumeric( $status ) ){
			throw new Exception( 'status code is not numeric.' );
		}
		switch( $status ){
			case self::SUCCESS:
			case self::BAD_REQUEST:
			case self::UNAUTHORIZED:
			case self::FOBIDDEN:
			case self::NOT_FOUND:
			case self::UNKNOWN_ERROR:
				$value = strval( self::HTTP_VERSION . ' ' . $status . ' ' . $message );
				header( $value );
				break;
			default:
				throw new Exception( 'status code is error. ' );
				break;
		}
	}

}