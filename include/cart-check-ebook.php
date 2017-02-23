<?php


class makano_cart_check {
	public $has_ebook = 0, $has_book = 0, $max = 0, $items = array();
	function __construct() {
		$res = CSaleBasket::GetList(
			array(),
			array(
				"FUSER_ID" => CSaleBasket::GetBasketUserID(),
				"ORDER_ID" => "NULL",
				"LID" => SITE_ID,
			), false, false, array()
		);
		while($i = $res->Fetch()){
			$this->items[] = $i;
			if(preg_match('~^/catalog/ebooks/~', $i['DETAIL_PAGE_URL']))
				$this->has_ebook = 1;
			else 
				$this->has_book = 1;
			$this->max++;
		}
		return $this;
	}
}