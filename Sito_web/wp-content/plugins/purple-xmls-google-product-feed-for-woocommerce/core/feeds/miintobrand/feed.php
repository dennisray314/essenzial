<?php
if (!defined('ABSPATH')) {
    exit;
}
// Exit if accessed directly
/********************************************************************
 * Version 3.0
 * An eBay Commerce Network (shopping.com) Feed
 * Copyright 2014 Purple Turtle Productions. All rights reserved.
 * license    GNU General Public License version 3 or later; see GPLv3.txt
 * By: Keneto 2014-05-08
 * 2014-09 Moved to Attribute mapping v3.0
 ********************************************************************/

require_once dirname(__FILE__) . '/../basicfeed.php';

class PMiintoBrandFeed extends PTSVFeedEx
{
    public $currency = null;
    public $miino_country_code = null;
    public $attributeLangtitle = array();
    public $attributeLangdesc = array();
    public $attributeLang = array();

    public function __construct()
    {
        parent::__construct();
        $this->providerName = 'MiintoBrand';
        $this->providerNameL = 'MiintoBrand';

        $this->fileformat = 'tsv';
        $this->fields = array();
        $this->fieldDelimiter = "\t";
        global $pfcore;
        //Basic product information

        $this->addAttributeMapping('ean', 'gtin', true, true); //internal product id
        $this->addAttributeMapping('item_group_id', 'item_group_id', false, true); //Internal product group id - Must not be changed
        $this->addAttributeMapping('brand', 'brand', true, true); //Brand name
        $this->addAttributeMapping('title', 'title', true, true); //Title of the product
        $this->addAttributeMapping('current_category', 'product_type', true, true); //Category name - can be mapped to MiintoBrand category in Feed Management. It could contains both MiintoBrand Gender and MiintoBrand Category splitted by google category delimiter, e.g. Mand > Slippe.
        $this->addAttributeMapping('gender', 'gender', true, false); //Sex value - Possible values: Male/Female/Unisex or M/F/U
        $this->addAttributeMapping('color', 'color', true, true); //Color name of the product
        $this->addAttributeMapping('size', 'size', true, true); //Product size name


        $this->addAttributeMapping('description', 'description', true, true); //Description of the product


        $this->addattributeMapping('material', 'material', true, false);
        $this->addAttributeMapping('washing', 'washing', true, false);

        $currency = array('NOK', 'DKK', 'SEK', 'EUR', 'PLN', 'CHF');

        foreach ($currency as $code) {
            if ($code == $pfcore->currency) {
                $this->addAttributeMapping('sale_price', 'c:discount_retail_price_' . $pfcore->currency . ':integer', true, false);
                $this->addAttributeMapping('regular_price', 'c:retail_price_' . $pfcore->currency . ':integer', true, false);
                $this->addAttributeMapping('original_regular_price', 'c:wholesale_price_' . $pfcore->currency . ':integer', true, false);
            } else {
                $this->addAttributeMapping('c:discount_retail_price_' . $code . ':integer', 'c:discount_retail_price_' . $code . ':integer', true, false);
                $this->addAttributeMapping('c:retail_price_' . $code . ':integer', 'c:retail_price_' . $code . ':integer', true, false);
                $this->addAttributeMapping('c:wholesale_price_' . $code . ':integer', 'c:wholesale_price_' . $code . ':integer', true, false);
            }

        }

        $this->addAttributeMapping('feature_imgurl', 'image_link', true, true); //Link to a main product image - Prefered image size is 1000x1000 pixels or larger. Only JPEG is supported
        $this->addAttributeMapping("additional_image_link", "additional_image_link"); //Links to additional product images separated with comma (","). Only JPEG is supported

        $this->addAttributeMapping('', 'c:season_tag:string', true, false); //Tag defining seasonability of a product
        $this->addAttributeMapping('stock_status', 'availability', false, false); //Is product "in stock" or is "out of stock"
        $this->addAttributeMapping('stock_quantity', 'c:stock_level:integer', true, true); //Current stock level of the product

        $this->addAttributeMapping('id', 'c:style_id:string', true, false); //Product style id

//        $this->addAttributeMapping('description', 'c:description_' . $this->miinto_country_code.':string', true, false);
        $langarray = array('DA', 'SV', 'NL', 'NO', 'EN', 'DE', 'PL');
        if (function_exists('icl_object_id')) {
            foreach ($this->attributeLang as $key => $lang){
                $this->addAttributeMapping('title_'.$lang, 'c:title_' . $lang . ':string', true, false); //Title of the product
            }
            foreach ($this->attributeLang as $key => $lang){
                $this->addAttributeMapping('description_'.$lang, 'c:description_' . $lang . ':string', true, false); //Title of the product
            }
        }
        $this->addRule('miinto_price_conversion', 'PriceConversion');
        $this->addRule('price_rounding', 'pricerounding');
    }

    public function formatProduct($product)
    {
        if (function_exists('icl_object_id')) {
            $langarray = array('DA', 'SV', 'NL', 'NO', 'EN', 'DE', 'PL','ES','FI');
            $currentpID = $product->id;
            global $sitepress;
            $translated_ids = Array();
            if (isset($sitepress)) {
                $trid = $sitepress->get_element_trid($currentpID, 'post_product');
                $translations = $sitepress->get_element_translations($trid, 'product');
                foreach ($translations as $lang => $translation) {
                    $product_instance = wc_get_product($translation->element_id);
                    $translated_ids[] = $translation->element_id;
                    if (in_array(strtoupper($translation->language_code), $langarray)) {
                        if (empty($translation->source_language_code)) {
                            if(strlen($product_instance->short_description)>10){
                                $product->attributes['description'] = $product_instance->short_description;
                            }

                        } else {
                            if(strlen($product_instance->short_description)<=5){
                                global $wpdb;
                                $table = $wpdb->prefix."posts";
                                $result = $wpdb->get_row("SELECT post_excerpt FROM $table WHERE ID=$translation->element_id");
                                $product->attributes['description_'.strtoupper($translation->language_code)] = $result->post_excerpt;
                            }else{
                                $product->attributes['description_'.strtoupper($translation->language_code)] = $product_instance->short_description;
                            }
                            if($translation->source_language_code=='en'){
                                if(strlen($product_instance->get_title())>0)
                                    $product->attributes['title'] = $product_instance->get_title();
                            }else{
                                $product->attributes['title_'.strtoupper($translation->language_code)] = $product_instance->get_title();
                            }
                            if(!empty($product->attributes['title_'.strtoupper($translation->language_code)])&&strlen($product->attributes['title_'.strtoupper($translation->language_code)])>0){
                                if(!in_array(strtoupper($translation->language_code),$this->attributeLangtitle) && $translation->language_code!=='en'){
                                    $this->attributeLangtitle[]=strtoupper($translation->language_code);
                                    $this->addAttributeMapping('title_'.strtoupper($translation->language_code), 'c:title_' . strtoupper($translation->language_code) . ':string', true, false); //Title of the product
                                }
                            }
                            if(!empty($product->attributes['description_'.strtoupper($translation->language_code)])&&strlen($product->attributes['description_'.strtoupper($translation->language_code)])>0){
                                if(!in_array(strtoupper($translation->language_code),$this->attributeLangdesc) && $translation->language_code!=='en'){
                                    $this->attributeLangdesc[]=strtoupper($translation->language_code);
                                    $this->addAttributeMapping('description_'.strtoupper($translation->language_code), 'c:description_' . strtoupper($translation->language_code) . ':string', true, false); //Title of the product
                                }
                            }

                        }
                    }
                }

            }
        }
        /*$product->attributes['feature_imgurl'] = str_replace('https://', 'http://', $product->attributes['feature_imgurl']);*/

        $product->attributes['description'] = trim(html_entity_decode($product->attributes['description_short']));
        $product->attributes['description'] = str_replace("&nbsp;", " ", $product->attributes['description_short']);
        if ($product->attributes['stock_status'] == 1) {
            $product->attributes['stock_status'] = 'In Stock';
        } else {
            $product->attributes['stock_status'] = 'Out Of Stock';
        }

        $product->attributes['additional_image_link'] = implode(',', $product->imgurls);

        //Manage Additional image link
        // $image_count = 1;
        // foreach($product->imgurls as $imgurl) {
        //  $image_index = "additional_image_link$image_count";
        //  $product->attributes[$image_index] = $imgurl;
        //  $image_count++;
        //  if ($image_count >= 4)
        //   break;
        // }

        /*Check sale_price has value or not .If not save regular price as sale price*/
        if ($product->attributes['has_sale_price'] == '') {
            $product->attributes['sale_price'] = null;
        }
        if ($product->attributes['regular_price'] == 0) {
            $product->attributes['regular_price'] = null;
        }

        $lang_code = $this->get_Lang_from_Currency_Code($product->attributes['currency']);

        if (isset($product->attributes['material']) || isset($product->attributes['Material'])) {
            if (isset($product->attributes['Material'])) {
                $material_array = array($lang_code => str_replace('|', ',', $product->attributes['Material']));
                $product->attributes['material'] = json_encode($material_array);
            } else {
                $material_array = array($lang_code => str_replace('|', ',', $product->attributes['material']));
                $product->attributes['material'] = json_encode($material_array);
            }

        }

        if (isset($product->attributes['washing']) || isset($product->attributes['Washing'])) {
            if (isset($product->attributes['Washing'])) {
                $washing_array = array($lang_code => str_replace('|', ',', $product->attributes['Washing']));
                $product->attributes['washing'] = json_encode($washing_array);
            } else {
                $washing_array = array($lang_code => str_replace('|', ',', $product->attributes['washing']));
                $product->attributes['washing'] = json_encode($washing_array);
            }

        }

        if (isset($product->attributes['currency_SEK'])) {
            if (isset($product->attributes['currency_discount_SEK']) && $product->attributes['currency_discount_SEK'] > 0)
                $product->attributes['c:discount_retail_price_SEK:integer'] = $product->attributes['currency_discount_SEK'];
            if (isset($product->attributes['currency_SEK_wholesale']) && $product->attributes['currency_SEK_wholesale'] > 0)
                $product->attributes['c:wholesale_price_SEK:integer'] = $product->attributes['currency_SEK_wholesale'];
            if (isset($product->attributes['currency_SEK']) && $product->attributes['currency_SEK'] > 0)
                $product->attributes['c:retail_price_SEK:integer'] = $product->attributes['currency_SEK'];
        }

        if (isset($product->attributes['currency_NOK'])) {
            if (isset($product->attributes['currency_discount_NOK']) && $product->attributes['currency_discount_NOK'] > 0)
                $product->attributes['c:discount_retail_price_NOK:integer'] = $product->attributes['currency_discount_NOK'];
            if (isset($product->attributes['currency_NOK_wholesale']) && $product->attributes['currency_NOK_wholesale'] > 0)
                $product->attributes['c:wholesale_price_NOK:integer'] = $product->attributes['currency_NOK_wholesale'];
            if (isset($product->attributes['currency_NOK_wholesale']) && $product->attributes['currency_NOK_wholesale'] > 0)
                $product->attributes['c:retail_price_NOK:integer'] = $product->attributes['currency_NOK'];
        }

        if (isset($product->attributes['currency_EUR'])) {
            if (isset($product->attributes['currency_discount_EUR']) && $product->attributes['currency_discount_EUR'] > 0)
                $product->attributes['c:discount_retail_price_EUR:integer'] = $product->attributes['currency_discount_EUR'];
            if (isset($product->attributes['currency_EUR_wholesale']) && $product->attributes['currency_EUR_wholesale'] > 0)
                $product->attributes['c:wholesale_price_EUR:integer'] = $product->attributes['currency_EUR_wholesale'];
            if (isset($product->attributes['currency_EUR']) && $product->attributes['currency_EUR'] > 0)
                $product->attributes['c:retail_price_EUR:integer'] = $product->attributes['currency_EUR'];
        }

        if (isset($product->attributes['currency_DKK'])) {
            if (isset($product->attributes['currency_discount_DKK']) && $product->attributes['currency_discount_DKK'] > 0)
                $product->attributes['c:discount_retail_price_DKK:integer'] = $product->attributes['currency_discount_DKK'];
            if (isset($product->attributes['currency_DKK_wholesale']) && $product->attributes['currency_DKK_wholesale'] > 0)
                $product->attributes['c:wholesale_price_DKK:integer'] = $product->attributes['currency_DKK_wholesale'];
            if (isset($product->attributes['currency_DKK']) && $product->attributes['currency_DKK'] > 0)
                $product->attributes['c:retail_price_DKK:integer'] = $product->attributes['currency_DKK'];
        }

        if (isset($product->attributes['currency_PLN'])) {
            if (isset($product->attributes['currency_discount_PLN']) && $product->attributes['currency_discount_PLN'] > 0)
                $product->attributes['c:discount_retail_price_PLN:integer'] = $product->attributes['currency_discount_PLN'];
            if (isset($product->attributes['currency_PLN_wholesale']) && $product->attributes['currency_PLN_wholesale'] > 0)
                $product->attributes['c:wholesale_price_PLN:integer'] = $product->attributes['currency_PLN_wholesale'];
            if (isset($product->attributes['currency_PLN']) && $product->attributes['currency_PLN'] > 0)
                $product->attributes['c:retail_price_PLN:integer'] = $product->attributes['currency_PLN'];
        }

        if (isset($product->attributes['currency_CHF'])) {
            if (isset($product->attributes['currency_discount_CHF']) && $product->attributes['currency_discount_CHF'] > 0)
                $product->attributes['c:discount_retail_price_CHF:integer'] = $product->attributes['currency_discount_CHF'];
            if (isset($product->attributes['currency_CHF_wholesale']) && $product->attributes['currency_CHF_wholesale'] > 0)
                $product->attributes['c:wholesale_price_CHF:integer'] = $product->attributes['currency_CHF_wholesale'];
            if (isset($product->attributes['currency_CHF']) && $product->attributes['currency_CHF_wholesale'] > 0)
                $product->attributes['c:retail_price_CHF:integer'] = $product->attributes['currency_CHF'];
        }
        if ($product->attributes['regular_price'] == 0)
            $product->attributes['regular_price'] = null;
        if ($product->attributes['sale_price'] == 0)
            $product->attributes['sale_price'] = null;
        if ($product->attributes['original_regular_price'] == 0)
            $product->attributes['original_regular_price'] = null;
        //Allowed condition values: New, Open Box, OEM, Refurbished, Pre-Owned, Like New, Good, Very Good, Acceptable
        return parent::formatProduct($product);
    }

    public function get_Lang_from_Currency_Code($currency)
    {
        switch ($currency) {
            case 'GBP':
                $lang_code = 'en_GB.utf8';
                break;
            case 'USD':
                $lang_code = 'en_US.utf8';
                break;
            case 'DKK':
                $lang_code = 'da_DK.utf8';
                break;
            case 'PLN':
                $lang_code = 'pl_PL.utf8';
                break;
            case 'SEK':
                $lang_code = 'sv_SE.utf8';
                break;
            case 'ANG':
                $lang_code = 'sv_SE.utf8';
                break;

            default:
                $lang_code = get_locale() . '.utf8';
                break;
        }

        return $lang_code;
    }

}
