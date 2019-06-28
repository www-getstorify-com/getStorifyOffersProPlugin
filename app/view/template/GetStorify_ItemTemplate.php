<?php
/**
 * Author: Yusuf Shakeel
 * Date: 18-jun-2019 tue
 * Version: 1.0
 *
 * File: GetStorify_ItemTemplate.php
 * Description: This file contains item templates.
 */

class GetStorify_ItemTemplate
{
    /**
     * This will return cards of all the items.
     *
     * @param array $data
     * @return string
     */
    public static function getItems_MDB($data)
    {
        $html = "";

        foreach ($data as $item) {

            $item_item_name = isset($item['offer_item_name']) ? trim($item['offer_item_name']) : '';

            $item_item_description = isset($item['offer_item_description']) ? trim($item['offer_item_description']) : '';

            $item_item_description = substr($item_item_description, 0, 30);
            $item_item_description = strlen($item_item_description) == 30 ? $item_item_description . '...' : $item_item_description;

            $itemImage = '';
            if (isset($item['offer_item_image']) && isset($item['offer_item_imagethumbnail'])) {
                $itemImage = <<<HTML
<img src="{$item['offer_item_imagethumbnail']}" data-src="{$item['offer_item_image']}" class="gtst-offer-item-img">
HTML;
            }

            $quantity = '';
            if (isset($item['offer_item_quantity']) && isset($item['offer_item_quantity_unit'])) {

                $qty = number_format(floatval($item['offer_item_quantity']), 2);
                $qtyUnit = trim($item['offer_item_quantity_unit']);

                $qty = str_replace(".00", "", $qty);

                $quantity = <<<HTML
<span class="gtst-item-quantity">{$qty} {$qtyUnit}</span>
HTML;

            }

            $pricing = '';
            $itemOfferType = '';

            $offerType = $item['offer_item_offer_type'];

            $sellingPrice = '';
            if (isset($item['offer_item_selling_price'])) {
                $sellingPrice = number_format(floatval($item['offer_item_selling_price']), 2);

                $sellingPrice = str_replace(".00", "", $sellingPrice);
            }

            $mrp = '';
            if (isset($item['offer_item_mrp'])) {
                $mrp = number_format(floatval($item['offer_item_mrp']), 2);

                $mrp = str_replace(".00", "", $mrp);
            }

            if (isset($offerType)) {

                $itemOfferType = <<<HTML
<span class="gtst-item-offertype">{$offerType}</span>
HTML;

                switch ($offerType) {
                    case 'DISCOUNT':
                        $pricing = <<<HTML
<span class="gtst-item-selling-price"><i class="fa fa-inr"></i> {$sellingPrice}</span>
<span><s>{$mrp}</s></span>
HTML;
                        break;

                    case 'BOGO':
                        $pricing = <<<HTML
<span class="gtst-item-selling-price"><i class="fa fa-inr"></i> {$sellingPrice}</span>
HTML;
                        break;
                }

            }

            $itemCardHTML = <<<HTML
<div class="gtst-item-card">
    <div class="row" style="min-height: 90px;">
        <div class="col-4">
            {$itemImage}
        </div>
        <div class="col-8 gtst-item-info-container">
            <p class="gtst-item-title">{$item_item_name}</p>
            <p class="gtst-item-description">{$item_item_description}</p>
        </div>
    </div>
    <div class="row">
        <div class="col-12 gtst-item-info-container-detail">
            <div class="gtst-item-my">
                {$itemOfferType}
                {$quantity}
            </div>
            <div class="gtst-item-my">{$pricing}</div>
        </div>
    </div>
</div>
HTML;

            $html .= <<<HTML
<div class="col-sm-12 col-md-6 col-lg-3">
{$itemCardHTML}
</div>
HTML;
        }

        return $html;
    }

    /**
     * This method will return the prev next buttons.
     *
     * @param int $count This represents the number of items fetched in the given page.
     * @param int $page
     * @param int $pagelimit
     * @return string
     */
    public static function getPrevNextButtons($count, $page, $pagelimit = GETSTORIFY_OFFERS_PLUGIN_API_SERVICE_DB_PAGE_LIMIT)
    {
        $prevNextNavButtons = "";

        $homeLink = get_permalink();

        // add prev-next nav button
        if ($count == $pagelimit) {

            // if no. of items fetched equals the page limit

            // on page 1 just return next button
            if ($page === 1) {
                $nextPage = $page + 1;

                $prevNextNavButtons = <<<HTML
<div style="margin-top: 15px; margin-bottom: 15px; clear: both; min-height: 50px;">
<button onclick="window.location='{$homeLink}/page/{$nextPage}'" class="getstorify btn float-right"> Next &rarr; </button>
</div>
HTML;

            } else {

                // on page > 1 return both prev next buttons

                $prevPage = $page - 1;
                $nextPage = $page + 1;
                $prevNextNavButtons = <<<HTML
<div style="margin-top: 15px; margin-bottom: 15px; clear: both; min-height: 50px;">
<button onclick="window.location='{$homeLink}/page/{$prevPage}'" class="getstorify btn float-left"> &larr; Prev </button>
<button onclick="window.location='{$homeLink}/page/{$nextPage}'" class="getstorify btn float-right"> Next &rarr; </button>
</div>
HTML;
            }

        } else {

            // no. of items fetched is less than the page limit

            if ($page > 1) {

                // on page > 1 return prev button

                $prevPage = $page - 1;
                $prevNextNavButtons = <<<HTML
<div style="margin-top: 15px; margin-bottom: 15px; clear: both; min-height: 50px;">
<button onclick="window.location='{$homeLink}/page/{$prevPage}'" class="getstorify btn float-left"> &larr; Prev </button>
</div>
HTML;

            }

        }

        return $prevNextNavButtons;
    }

    /**
     * This method will return the prev next buttons for the items of an offer.
     *
     * @param string $offerid
     * @param int $count This represents the number of items fetched in the given page.
     * @param int $page
     * @param int $pagelimit
     * @return string
     */
    public static function getPrevNextButtons_Offer($offerid, $count, $page, $pagelimit = GETSTORIFY_OFFERS_PLUGIN_API_SERVICE_DB_PAGE_LIMIT)
    {
        $prevNextNavButtons = "";

        $homeLink = get_permalink();

        // add prev-next nav button
        if ($count == $pagelimit) {

            // if no. of items fetched equals the page limit

            // on page 1 just return next button
            if ($page === 1) {
                $nextPage = $page + 1;

                $prevNextNavButtons = <<<HTML
<div style="margin-top: 15px; margin-bottom: 15px; clear: both; min-height: 50px;">
<button onclick="window.location='{$homeLink}{$offerid}/page/{$nextPage}'" class="getstorify btn float-right"> Next &rarr; </button>
</div>
HTML;

            } else {

                // on page > 1 return both prev next buttons

                $prevPage = $page - 1;
                $nextPage = $page + 1;
                $prevNextNavButtons = <<<HTML
<div style="margin-top: 15px; margin-bottom: 15px; clear: both; min-height: 50px;">
<button onclick="window.location='{$homeLink}{$offerid}/page/{$prevPage}'" class="getstorify btn float-left"> &larr; Prev </button>
<button onclick="window.location='{$homeLink}{$offerid}/page/{$nextPage}'" class="getstorify btn float-right"> Next &rarr; </button>
</div>
HTML;
            }

        } else {

            // no. of items fetched is less than the page limit

            if ($page > 1) {

                // on page > 1 return prev button

                $prevPage = $page - 1;
                $prevNextNavButtons = <<<HTML
<div style="margin-top: 15px; margin-bottom: 15px; clear: both; min-height: 50px;">
<button onclick="window.location='{$homeLink}{$offerid}/page/{$prevPage}'" class="getstorify btn float-left"> &larr; Prev </button>
</div>
HTML;

            }

        }

        return $prevNextNavButtons;
    }

}
