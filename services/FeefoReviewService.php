<?php
namespace Craft;

class FeefoReviewService extends BaseApplicationComponent {
  public $plugin = null;
  public $settings = array();

  public function __construct() {
    $this->plugin   = craft()->plugins->getPlugin('feeforeview');
    $this->settings = $this->plugin->getSettings();
  }

  public function getReviewSummary($id) {
    if (is_null($this->feefoMerchantId())) return null;

    $products = $this->getProducts();
    $index = array_search($id, array_column($products, 'vendor_ref'));
    return $index !== false ? $products[$index] : null;
  }

  public function feefoMerchantId() {
    return $this->settings->feefoMerchantId;
  }

  private function getProducts() {
    $cacheKey = 'feefo_'.$this->feefoMerchantId();
    $products = craft()->cache->get($cacheKey);
    if ($products === false) {
      $products = $this->getProductReviews();
      craft()->cache->set($cacheKey, $products, 24*3600 /*24 hours*/);
    }
    return $products;
  }

  private function getProductReviews() {
    $data = @file_get_contents('https://api.feefo.com/api/10/products/ratings?merchant_identifier='.$this->feefoMerchantId().'&review_count=true&since_period=year');
    $decodedData = @json_decode($data);
    if (isset($decodedData) && isset($decodedData->products)) {
      return $decodedData->products;
    } else {
      return [];
    }
  }
}