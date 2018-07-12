# Feefo Review
Feefo Review Feed for Craft CMS

## Installation
Install using composer
```
"require": {
  "sealink/feefo-review": "0.1.0"
}
```

## Setting up Merchant Identifier
Please set the Merchant Identifier in the plugin settings page.
Without this value, the review widget and microdata won't appear.

## Example Usage

#### Add structured data on view template or make a partial template to render the Feefo review summary

```twig
{% set reviewSummary = craft.feefoReview.getReviewSummary(entry.feefoProductCode) %}
{% if reviewSummary %}
  <h5>Reviews</h5>
  <div itemprop="aggregateRating"
    itemscope itemtype="http://schema.org/AggregateRating">
   Rated <span itemprop="ratingValue">{{reviewSummary.rating}}</span>/5
   based on <span itemprop="reviewCount">{{reviewSummary.review_count}}</span>
  </div>
{% endif %}
```

#### Add a Feefo Widget for product reviews
This sample code can be used to render a Feefo Widget using Feefo service. The widget provides a review listing with a popup.

```twig
{% set reviewSummary = craft.feefoReview.getReviewSummary(entry.feefoProductCode) %}
<script type="text/javascript" src="https://api.feefo.com/api/javascript/{{craft.feefoReview.feefoMerchantId()}}"></script>
<div id="feefologohere" data-product-sku="{{ entry.feefoProductCode }}"></div>
```
