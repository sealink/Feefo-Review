<?php
namespace Craft;

class FeefoReviewService extends BaseApplicationComponent
{
  public $plugin = null;
  public $settings = array();

  public function __construct()
  {
    $this->plugin   = craft()->plugins->getPlugin('feeforeview');
    $this->settings = $this->plugin->getSettings();
  }

  public function getReviewSummary($id)
  {
    if ($this->feefoMerchantId() == null) return null;

    $products = $this->getProducts();
    if ($products == null) return null;

    $key = array_search($id, array_column($products, 'vendor_ref'));
    return $key !== false ? $products[$key] : null;
  }

  public function feefoMerchantId() {
    return $this->settings->feefoMerchantId;
  }

  private function getProducts() {
    $cacheKey = 'feefo_'.$this->feefoMerchantId();
    $products = craft()->cache->get($cacheKey);
    if ($products)
      return $products;
    else {
      $products = $this->getProductReviews();
      if ($products)
    craft()->cache->set($cacheKey, $products, 24*3600 /*24 hours*/);
      return $products;
    }
  }

  private function getProductReviews()
  {
    $data = file_get_contents('https://api.feefo.com/api/10/products/ratings?merchant_identifier='.$this->feefoMerchantId().'&review_count=true&since_period=year');
    $decodedData = json_decode($data);
    return $decodedData->products;
  }
}
