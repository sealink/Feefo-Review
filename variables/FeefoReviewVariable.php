<?php
namespace Craft;

class FeefoReviewVariable
{
    public function getReviewSummary($id)
    {
        return craft()->feefoReview->getReviewSummary($id);
    }

    public function feefoMerchantId()
    {
        return craft()->feefoReview->feefoMerchantId();
    }
}
