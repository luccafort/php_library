<?php
/**
 * ページャー管理.
 */
class Util_Pager
{
	
	/**
	 * 取り出す最大レコード数.
	 * @var int
	 */
	private $_separater = 50;
	
	/**
	 * 
	 * オフセットの位置.
	 * @var int
	 */
	private $_position = 0;
	
	/**
	 * 
	 * 現在のページ位置.
	 * @var int
	 */
	private $_page = 0;
	
	/**
	 * ページャーの名称.
	 */
	private $_name = 'offset';
	
	/**
	 * 遷移先URL
	 * @var String
	 */
	private $_url = '';
	
	/**
	 * 
	 * POST/GETのメソッド値
	 * @var String
	 */
	private $_method = 'get';
	
	/**
	 * 
	 * 表示するページャーの表示幅
	 * @var int
	 */
	private $_width = 5;
	
	private $_leftMarker  = "&lt;";
	private $_rightMarker = "&gt;";
	
	public function __construct( $url )
	{
		$this->_url = $url;
	}
	
	/**
	 * セパレーターを設定.
	 */
	public function setSeparater( $num )
	{
		if( Validate::isNum( $num ) ){
			$this->_separater = $num;
		}
	}
	
	/**
	 * 
	 * セパレーターを取得.
	 */
	public function getSeparater()
	{
		return $this->_separater;
	}
	
	/**
	 * 生成するメソッドを設定.
	 * @param String $method
	 */
	public function setMethod( $method = 'get' )
	{
		if( $method === 'post' ){
			$this->_method = 'post';
		} else if( $method === 'get' ){
			$this->_method = 'get';
		}
	}
	
	/**
	 * 
	 * オフセット位置を設定.
	 * @param int $page
	 */
	public function setPosition( $page ){
		if( Validate::isNum( $page ) ){
			$this->_position = $page;
		}
	}
	
	/**
	 * 現在のオフセット位置を取得.
	 * @return int
	 */
	public function getPosition()
	{
		return $this->_position;
	}
	
	/**
	 * オフセットとリミットを設定したLIMIT句を取得.
	 * 
	 * @param int $page
	 * @param int $limit
	 */
	public function getLimit( $page, $limit )
	{
		$this->setSeparater( $limit );
		$this->_page = $page;
		$position = ( $page - 1 ) * $this->getSeparater();
		if( $position < 0 ){
			$position = 0;
		}
		$this->setPosition( $position );
		return ' LIMIT ' . $position . ', ' . $this->getSeparater() . ' ';
	}
	
	/**
	 * 
	 * 生成されたページャーを取得.
	 * @param int $totalRecordNum
	 * @param String $hidden
	 * @return String
	 */
	public function get( $totalRecordNum, $hidden = '' )
	{
		$result = '';
		$string = '';
		$pager = '';
		
		if( $this->_method === 'get' ){
			if( Validate::isStr( $hidden ) == false ){
				$hidden = '';
			}
			$result = $this->_onCreateGetPager($totalRecordNum, $this->_page, $hidden );
		}
		return $result;
	}
	
	/**
	 * 
	 * $_GETパラメータ用ページャー生成.
	 * @param int $total
	 * @param int $pageNum
	 * @param String $hidden
	 * @return String
	 */
	private function _onCreateGetPager( $total, $pageNum, $hidden = '' )
	{
		$result = '';
		//表示するページの最初と最後のページ番号を定義.
		$first = 1;
		$last  = ceil( $total / $this->_separater );
		
		if( Validate::isNum( $pageNum ) ){
			if( $pageNum < $first ){
				$pageNum = $first;
			} else if( $pageNum > $last ){
				$pageNum = $last;
			}
		} else {
			$pageNum = $first;
		}
		
		//各ページ番号への移動リンカーを生成.
		$start = $pageNum - $this->_width;
		if( $start < 1 ){
			$start = 1;
		}
		$max = $pageNum + $this->_width;
		if( $max > $last ){
			$max = $last;
		}
		
		for( $start ; $start <= $max; $start++ ){
			if( $start === (int)$pageNum ){
				//現在表示中のページはリンカーなし.
				$result .= $start . '&nbsp';
			} else {
				$result .= '<a href="'.$this->_url . '?' . $this->_name . '=' . $start . $hidden . '" >'
						.  $start . '</a>&nbsp';
			}
		}
		return $result;
	}
}