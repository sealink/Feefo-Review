<?php
namespace Craft;

class FeefoReviewPlugin extends BasePlugin
{

  public function getName()
  {
    return Craft::t('Feefo Review');
  }

  public function getDescription()
  {
    return 'Feefo Review Feeds';
  }

  public function getVersion()
  {
    return '1.0';
  }

  public function getDeveloper()
  {
    return 'SeaLink Travel Group';
  }

  public function getDeveloperUrl()
  {
    return 'https://github.com/sealink';
  }

  public function hasCpSection()
  {
    return false;
  }

  protected function defineSettings()
  {
    return array(
      'feefoMerchantId' => AttributeType::String
    );
  }

  public function getSettingsHtml()
  {
    return craft()->templates->render('feeforeview/settings', array(
      'settings' => $this->getSettings()
    ));
  }

}
