<?php
namespace Craft;

class FeefoReviewService extends BaseApplicationComponent {
  public $plugin = null;
  public $settings = array();

  public function __construct(){
    $this->plugin   = craft()->plugins->getPlugin('feeforeview');
    $this->settings = $this->plugin->getSettings();
  }

  public function getReviewSummary($id){
    $merchantId = $this->feefoMerchantId();
    $products = $this->getProducts();
    if (is_null($merchantId) || is_null($products)) {
      return null;
    } else {
      $index = array_search($id, array_column($products, 'vendor_ref'));
      return $index !== false ? $products[$index] : null;
    }
  }

  public function feefoMerchantId() {
    return $this->settings->feefoMerchantId;
  }

  private function getProducts() {
    $cacheKey = 'feefo_'.$this->feefoMerchantId();
    $products = $this->getProductReviews();
    if (!is_null($products)) {
      craft()->cache->set($cacheKey, $products, 24*3600 /*24 hours*/);
      return $products;
    } else {
      return null;
    }
  }

  private function getProductReviews() {
    $data = @file_get_contents('https://api.feefo.com/api/10/products/ratings?merchant_identifier='.$this->feefoMerchantId().'&review_count=true&since_period=year');
    $decodedData = @json_decode($data);
    if(isset($decodedData) && isset($decodedData->products)){
      return $decodedData->products;
    } else {
      return null;
    }
  }
}