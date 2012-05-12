<?php
class Util_Response
{
	const HTTP_VERSION = 'HTTP/1.1';

	/**
	 * 処理中.
	 *
	 * リクエストされた処理の実行時間が長時間かかると想定される場合に使用
	 * クライアントがタイムアウトエラーになってしまわないようにするためのコード
	 *
	 * @var int
	 */
	const PROCESSING = 102;

	/**
	 * リクエスト成功.
	 *
	 * リクエストされた内容が成功
	 *
	 * @var int
	 */
	const SUCCESS = 200;

	/**
	 * 生成成功.
	 *
	 * リソースが生成された場合などに使用
	 *
	 * @var int
	 */
	const CREATED = 201;

	/**
	 * リクエスト受容.
	 *
	 * リクエストの受容までを保証する際に使用
	 * 会員登録時などにタイムアウトエラーによる多重登録を防ぐ際などを想定
	 *
	 * @var int
	 */
	const ACCEPTED = 202;

	/**
	 * リクエストされたデータが存在しない
	 *
	 * 指定されたリソースデータがない場合などに使用
	 *
	 * @var int
	 */
	const NOT_CONTENT_DATA = 204;

	/**
	 * リセットリクエスト
	 *
	 * リクエスト成功後、クライアント側でデータのリセットが必要な場合に使用
	 *
	 * @var int
	 */
	const RESET_CONTENT_DATA = 205;

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
	 * タイムアウトエラー
	 *
	 * リクエストが時間内に完了していない場合に使用.
	 *
	 * @var int
	 */
	const REQUEST_TIMEOUT = 408;

	/**
	 * リクエストURIが長すぎる
	 *
	 * リクエストURIが長すぎる場合に使用.
	 *
	 * @var int
	 */
	const REQUEST_URI_TOO_LARGE = 414;

	/**
	 * 不明なエラー
	 * @var int
	 */
	const UNKNOWN_ERROR = 500;

	public static function sendStatusCode( $status, $message = '' )
	{
		if( false == Util_Validator::isNumeric( $status ) ){
			throw new Exception( 'status code is not numeric.' );
		}
		switch( $status ){
			case self::PROCESSING:
			case self::SUCCESS:
			case self::CREATED:
			case self::ACCEPTED:
			case self::NOT_CONTENT_DATA:
			case self::RESET_CONTENT_DATA:
			case self::BAD_REQUEST:
			case self::UNAUTHORIZED:
			case self::FOBIDDEN:
			case self::NOT_FOUND:
			case self::REQUEST_TIMEOUT:
			case self::REQUEST_URI_TOO_LARGE:
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