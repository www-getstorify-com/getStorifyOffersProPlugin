<?php
/**
 * Author: Yusuf Shakeel
 * Date: 18-jun-2019 tue
 * Version: 1.0
 *
 * File: style_css.php
 * Description: This page contains the style.
 */
?>
<style>
    .getstorify-wrap {
        word-wrap: break-word;
        overflow-wrap: break-word;
    }

    .getstorify.story-content-container {
        margin-bottom: 30px;
    }

    .getstorify.story-covercontent.image {
        border: 1px solid #eee;
    }

    .getstorify.story-title-container {
        margin-top: 10px;
    }

    .getstorify.story-description {
        margin-bottom: 5px;
    }

    .getstorify.btn.float-right {
        float: right;
    }

    .getstorify.btn.float-left {
        float: left;
    }

    .getstorify.post-container {
        margin-bottom: 15px;
    }

    .media {
        display: -ms-flexbox;
        display: flex;
        -ms-flex-align: start;
        align-items: flex-start;
    }

    .media-body {
        flex: 1;
    }

    .mr-1 {
        margin-right: 5px;
    }

    img.rounded-circle.img-thumbnail {
        border: 2px solid #eee;
        border-radius: 50%;
    }

    .getstorify.btn {
        display: inline-block;
        padding: 6px 12px;
        margin-bottom: 0;
        font-size: 20px;
        font-weight: normal;
        line-height: 1.42857143;
        text-align: center;
        white-space: nowrap;
        vertical-align: middle;
        -ms-touch-action: manipulation;
        touch-action: manipulation;
        cursor: pointer;
        -webkit-user-select: none;
        -moz-user-select: none;
        -ms-user-select: none;
        user-select: none;
        background-image: none;
        border: 1px solid transparent;
        border-radius: 4px;
    }

    /**
     * =========================================
     * form style
     * =========================================
     */
    .gtst-form-control {
        display: block;
        width: 100%;
        /*height: calc(1.5em + .75rem + 2px);*/
        height: 50px;
        padding: .375rem 1.5rem !important;
        font-size: 1rem;
        font-weight: 400;
        line-height: 1.5;
        color: #495057;
        background-color: #fff;
        background-clip: padding-box;
        border: 1px solid #ced4da;
        border-radius: .25rem;
        transition: border-color .15s ease-in-out, box-shadow .15s ease-in-out;
    }

    /**
     * =========================================
     * searchbar store
     * =========================================
     */
    @media screen and (min-width: 768px) {
        .gtst-searchbar-store-right-side-padding {
            padding-right: 2px !important;
        }

        .gtst-searchbar-store-both-side-padding {
            padding-left: 2px !important;
            padding-right: 2px !important;
        }

        .gtst-searchbar-store-left-side-padding {
            padding-left: 2px !important;
        }
    }

    .gtst-searchbar-store-city,
    .gtst-searchbar-store-city-location,
    .gtst-searchbar-store-btn {
        margin-bottom: 5px;
        border-radius: 0;
        -webkit-appearance: none;
    }

    .gtst-searchbar-store-btn {
        display: inline-block;
        width: 100%;
        height: 50px;
        font-weight: 400;
        color: #111;
        text-align: center;
        vertical-align: middle;
        -webkit-user-select: none;
        -moz-user-select: none;
        -ms-user-select: none;
        user-select: none;
        background-color: transparent;
        border: 1px solid transparent;
        /*padding: .375rem .75rem;*/
        font-size: 1rem;
        line-height: 1.5;
        /*border-radius: .25rem;*/
        border-radius: 0;
        -webkit-appearance: none;
        /*transition: color .15s ease-in-out,background-color .15s ease-in-out,border-color .15s ease-in-out,box-shadow .15s ease-in-out;*/
    }

    .gtst-searchbar-store-btn.gtst-btn-primary {
        color: #111;
        background-color: #ffe600;
        border-color: #ffe600;
    }

    .gtst-searchbar-store-city,
    .gtst-searchbar-store-city-location,
    .gtst-searchbar-store-btn {
        border-radius: 50px !important;
    }

    /**
     * =========================================
     * searchbar offer
     * =========================================
     */
    @media screen and (min-width: 768px) {
        .gtst-searchbar-offer-right-side-padding {
            padding-right: 2px !important;
        }

        .gtst-searchbar-offer-both-side-padding {
            padding-left: 2px !important;
            padding-right: 2px !important;
        }

        .gtst-searchbar-offer-left-side-padding {
            padding-left: 2px !important;
        }
    }

    .gtst-searchbar-offer-city,
    .gtst-searchbar-offer-city-location,
    .gtst-searchbar-offer-btn {
        margin-bottom: 5px;
        border-radius: 0;
        -webkit-appearance: none;
    }

    .gtst-searchbar-offer-btn {
        display: inline-block;
        width: 100%;
        height: 50px;
        font-weight: 400;
        color: #111;
        text-align: center;
        vertical-align: middle;
        -webkit-user-select: none;
        -moz-user-select: none;
        -ms-user-select: none;
        user-select: none;
        background-color: transparent;
        border: 1px solid transparent;
        /*padding: .375rem .75rem;*/
        font-size: 1rem;
        line-height: 1.5;
        /*border-radius: .25rem;*/
        border-radius: 0;
        -webkit-appearance: none;
        /*transition: color .15s ease-in-out,background-color .15s ease-in-out,border-color .15s ease-in-out,box-shadow .15s ease-in-out;*/
    }

    .gtst-searchbar-offer-btn.gtst-btn-primary {
        color: #111;
        background-color: #ffe600;
        border-color: #ffe600;
    }

    .gtst-searchbar-offer-city,
    .gtst-searchbar-offer-city-location,
    .gtst-searchbar-offer-btn {
        border-radius: 50px !important;
    }

    /**
     * =========================================
     * offers style
     * =========================================
     */
    .gtst-offer-card {
        background-color: #fff;
        border: 1px solid #eee;
        margin-bottom: 50px;
        box-shadow: 0 4px 5px 0 #eee;
    }

    .gtst-offer-card .gtst-offer-card-header .gtst-offer-cover-img {
        width: 100%;
        height: auto;
    }

    .gtst-offer-card .gtst-offer-card-body {
        padding: 15px;
    }

    .gtst-offer-card .gtst-offer-card-body .gtst-offer-title {
        font-size: 24px;
        margin-top: 0;
        margin-bottom: 5px;
    }

    .gtst-offer-card .gtst-offer-card-body .gtst-offer-description {
        margin-top: 0;
        margin-bottom: 5px;
    }

    .gtst-offer-card .gtst-offer-card-body .gtst-offer-storename {
        margin-top: 0;
        margin-bottom: 5px;
    }

    .gtst-offer-card .gtst-offer-card-body .gtst-offer-ends-in {
        margin-top: 5px;
        margin-bottom: 10px;
        color: #f00;
    }

    .gtst-offer-card .gtst-offer-card-footer {
        padding: 0 15px 15px;
        min-height: 50px;
    }

    .gtst-offer-card .gtst-offer-card-footer .gtst-offer-icon {
        display: inline-block;
        margin-right: 8px;
        background-color: #ffe600;
        width: 44px;
        height: 44px;
        font-size: 24px;
        border-radius: 50%;
        box-shadow: 0 2px 5px 0 #eee;
    }

    .gtst-offer-card .gtst-offer-card-footer .gtst-offer-icon.map-marker {
        padding: 11px 16px;
        line-height: 24px;
    }

    .gtst-offer-card .gtst-offer-card-footer .gtst-offer-icon.share {
        padding: 11px 13px;
        line-height: 24px;
    }

    .gtst-offer-card .gtst-offer-card-footer .gtst-offer-icon.share i {
        font-size: 20px;
        color: #111;
    }

    .gtst-offer-card .gtst-offer-card-footer .gtst-offer-icon.map-marker i {
        font-size: 20px;
        color: #111;
    }

    .gtst-offer-card .gtst-offer-card-footer .gtst-offer-icon.phone {
        padding: 11px 14px;
    }

    .gtst-offer-card .gtst-offer-card-footer .gtst-offer-view-offer {
        display: inline-block;
        font-size: 16px;
        position: absolute;
        right: 0;
        margin-right: 15px;
        margin-top: 1px;
        background-color: #ffe600;
        padding: 10px 10px 10px 20px;
        border-top-left-radius: 36px;
        border-bottom-left-radius: 36px;
        box-shadow: -2px 2px 5px 0 #eee;
    }

    .gtst-offer-card .gtst-offer-view-offer-link,
    .gtst-offer-card .gtst-offer-card-footer .gtst-offer-view-offer-store-location {
        text-decoration: none;
        color: #000;
    }

    /**
     * =========================================
     * stores style
     * =========================================
     */
    .gtst-store-card {
        background-color: #fff;
        border: 1px solid #eee;
        margin-bottom: 50px;
        box-shadow: 0 4px 5px 0 #eee;
    }

    .gtst-store-card .gtst-store-card-header .gtst-store-cover-img {
        width: 100%;
        height: auto;
    }

    .gtst-store-card .gtst-store-card-body {
        padding: 15px;
    }

    .gtst-store-card .gtst-store-card-body .gtst-store-title,
    .gtst-store-card .gtst-store-card-body .gtst-store-description,
    .gtst-store-card .gtst-store-card-body .gtst-store-address,
    .gtst-store-card .gtst-store-card-body .gtst-store-contact-phone {
        margin-top: 0;
        margin-bottom: 5px;
    }

    .gtst-store-card .gtst-store-card-body .gtst-store-title {
        font-size: 24px;
    }

    .gtst-store-card .gtst-store-card-footer {
        padding: 0 15px 15px;
        min-height: 50px;
    }

    .gtst-store-card .gtst-store-card-footer .gtst-store-icon {
        display: inline-block;
        margin-right: 15px;
        background-color: #ffe600;
        width: 44px;
        height: 44px;
        font-size: 20px;
        border-radius: 50%;
        box-shadow: 0 2px 5px 0 #eee;
    }

    .gtst-store-card .gtst-store-card-footer .gtst-store-icon.map-marker {
        padding: 11px 16px;
        line-height: 24px;
    }

    .gtst-store-card .gtst-store-card-footer .gtst-store-icon.map-marker i {
        font-size: 20px;
        color: #111;
    }

    .gtst-store-card .gtst-store-card-footer .gtst-store-icon.phone {
        padding: 11px 14px;
    }

    .gtst-store-card .gtst-store-card-footer .gtst-store-view-offer {
        display: inline-block;
        font-size: 16px;
        position: absolute;
        right: 0;
        margin-right: 15px;
        margin-top: 1px;
        background-color: #ffe600;
        padding: 10px 10px 10px 20px;
        border-top-left-radius: 36px;
        border-bottom-left-radius: 36px;
        box-shadow: -2px 2px 5px 0 #eee;
    }

    .gtst-store-card .gtst-store-view-store-link,
    .gtst-store-card .gtst-store-view-offer-link,
    .gtst-store-card .gtst-store-card-footer .gtst-store-view-offer-store-location {
        text-decoration: none;
        color: #000;
    }

    /**
     * =========================================
     * items style
     * =========================================
     */
    .gtst-item-card {
        background-color: #fff;
        border: 1px solid #eee;
        margin-bottom: 50px;
        box-shadow: 0 2px 5px 0 #eee;
    }

    .gtst-item-card .gtst-offer-item-img {
        width: 100%;
        height: auto;
    }

    .gtst-item-card .row .gtst-item-info-container {
        padding: 5px 30px 5px 0;
    }

    .gtst-item-card .row .gtst-item-info-container-detail {
        padding: 0 25px;
    }

    .gtst-item-card .gtst-item-title {
        font-size: 20px;
        margin-top: 0;
        margin-bottom: 5px;
    }

    .gtst-item-card .gtst-item-description {
        margin-top: 0;
        margin-bottom: 5px;
    }

    .gtst-item-card .gtst-item-my {
        margin-top: 10px;
        margin-bottom: 10px;
    }

    .gtst-item-card .gtst-item-offertype,
    .gtst-item-card .gtst-item-quantity {
        font-weight: bold;
        display: inline-block;
        font-size: 16px;
        background-color: #ffe600;
        padding: 5px;
        border-radius: 10px;
        box-shadow: 0 2px 5px 0 #eee;
    }

    .gtst-item-card .gtst-item-quantity {
        float: right;
    }

    .gtst-item-card .gtst-item-selling-price {
        font-size: 20px;
        font-weight: bold;
    }
</style>
