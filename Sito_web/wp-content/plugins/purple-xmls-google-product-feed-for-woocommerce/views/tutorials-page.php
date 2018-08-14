<?php 

Class View{
   
   public function tutorial_page_view()
   {
    // require_once '/core/data/productlist.php';
    // $providers = new AMWSCP_PProviderList();
    require_once plugin_dir_path(__FILE__).'../core/classes/providerlist.php';
    $providers = new PProviderList();
    $embed_code = wp_oembed_get('https://www.youtube.com/watch?v=QEHoUtlDN54&feature=youtu.be');
    $embed_code1 = wp_oembed_get('https://www.youtube.com/watch?v=loeJuYLdVvQ&feature=youtu.be');

    $selectOption='';
     $arrayNeed = array();
    foreach ($providers->items as $key => $value) {
        $arrayNeed[$value->name] = $value->name;
        $selectOption.= '<option value="'.$value->name.'">'.$value->prettyName.'</option>';
    }
    $output = '
    <div style="margin:10px;">
         <h4>Select a merchant type.</h4>
          <select id="selectFeedType" onchange="selectFunction(this.value);">
                        <option>Please Select Merchant Type</option>
                        '.
                           $selectOption
                        .'
                        
                        </select>
<div id="default_div" class="cpf_tutorials_page">
   <div class="cpf_google_merchant_tutorials">
    <h2>Some of the popular merchants and the links to help you get information about how  to integrate and start creating feeds for them</h2>
    </div>

   <ul style="display: block;
    list-style-type: disc;
    line-height: 20px;
    margin-top: 1em;
    margin-bottom: 1 em;
    margin-left: 0;
    margin-right: 0;
    padding-left: 40px;">
      <li>Google Shopping : <a href="https://www.exportfeed.com/documentation/google-merchant-shopping-product-upload/">Merchant integration guide</a>  :  <a href="https://www.exportfeed.com/documentation/instructions-for-trial-and-new-customers/">Feed Creation Guide </a></li>
      <li>Amazon Seller Merchant : <a href="https://www.exportfeed.com/documentation/amazon-seller-central-product-guide/">Merchant integration guide</a> 
      : <a href="https://www.exportfeed.com/documentation/instructions-for-trial-and-new-customers/">Feed Creation Guide </a></li>
      <li>Bing : <a href="https://www.exportfeed.com/documentation/bing-product-ads-guide/">Merchant integration guide</a> 
      : <a href="https://www.exportfeed.com/documentation/instructions-for-trial-and-new-customers/">Feed Creation Guide </a></li>
      <li>Minto : <a href="https://www.exportfeed.com/documentation/miinto-guide/">Merchant integration guide</a> 
      : <a href="https://www.exportfeed.com/documentation/instructions-for-trial-and-new-customers/">Feed Creation Guide </a></li>
      <li>Kelko : <a href="https://www.exportfeed.com/documentation/kelkoo-guide/">Merchant integration guide</a> 
      : <a href="https://www.exportfeed.com/documentation/instructions-for-trial-and-new-customers/">Feed Creation Guide </a></li>
      <li>Rakuten : <a href="https://www.exportfeed.com/documentation/rakuten/">Merchant integration guide</a> 
      : <a href="https://www.exportfeed.com/documentation/instructions-for-trial-and-new-customers/">Feed Creation Guide </a></li>
     
    </ul>
   
   
</div>

<div style="display:none;" id="for_amzon"  class="cpf_tutorials_page" style="margin-top: 59px;">
                <div id="for_amzon" class="cpf_google_merchant_tutorials">
                    <h2 id="tutorial_title" > ExportFeed : Amazon Marketplace Feed Creation Tutorials</h2>
                </div>'.$embed_code.'</div>
 <div style="display:none;" id="for_google" class="cpf_tutorials_page" style="margin-top: 59px;">
                <div id="for_google" class="cpf_google_merchant_tutorials">
                    <h2 id="tutorial_title" > ExportFeed : Google Feed Creation Tutorials</h2>
                </div>'.$embed_code1.'</div>
 <div style="display:none;" id="for_other" class="cpf_tutorials_page" style="margin-top: 59px;">
                <div id="for_other" class="cpf_google_merchant_tutorials">
                    <h2 id="tutorial_title_other" ></h2>
                </div><div id="doc_link">Video is not available. <span id="inner_doc_link"></span> is the detail documentation for it.</div></div>


<div class="clear"></div>
<div class="cpf_tutorials_page" style="margin-top: 59px;">
<p><b>Was this helpful ? For Further Support Contact our live support <a target="_blank" href="http://www.exportfeed.com/support/">here</a></b></p>
</div>

</div>


<script type="text/javascript">
    // jQuery("#selectFeedType").click(function(){
    //      var merchant_lists=amwscp_doFetchLocalCategories();
    //      console.log(merchant_lists);
    // });
    function selectFunction(value){
        var merchantArray = {
    Admarkt :"https://www.exportfeed.com/documentation/",
    Google :"https://www.exportfeed.com/documentation/google-merchant-shopping-product-upload/",
    Amazon:"https://www.exportfeed.com/documentation/amazon-seller-central-product-guide/",
    AmazonPAUK:"https://www.exportfeed.com/documentation/amazon-seller-central-product-guide/",
    AmazonSC:"https://www.exportfeed.com/documentation/amazon-seller-central-product-guide/",
    eBaySeller:"https://www.exportfeed.com/documentation/ebay-seller-guide-2/",
    Miinto:"https://www.exportfeed.com/documentation/miinto-guide/",
    MiintoBrand:"https://www.exportfeed.com/documentation/miinto-guide/",
    ElevenMain:"https://www.exportfeed.com/documentation/",
    AffiliateWindow:"https://www.exportfeed.com/documentation/affiliate-windows-feed-guide/",
    AffiliateWindowXML:"https://www.exportfeed.com/documentation/affiliate-windows-feed-guide/",
    AmmoSeek:"https://www.exportfeed.com/documentation/ammoseek-integration-guide/",
    Become:"https://www.exportfeed.com/documentation/become-integration-guide/",
    Bonanza:"https://www.exportfeed.com/documentation/bonanza/",
    Beslist:"https://www.exportfeed.com/documentation/beslist-integration-guide/",
    Bing:"https://www.exportfeed.com/documentation/bing-product-ads-guide/",
    eBay:"https://www.exportfeed.com/documentation/ebay-seller-guide-2/",
    FacebookXML:"https://www.exportfeed.com/documentation/facebook-dynamic-product-ads/",
    GPAnalysis:"https://www.exportfeed.com/documentation/gpanalysis-merchant-integration-guide/",
    GraziaShop:"https://www.exportfeed.com/documentation/",
    HardwareInfo:"https://www.exportfeed.com/documentation/",
    Houzz:"https://www.exportfeed.com/documentation/houzz-export-guide/",
    Kelkoo:"https://www.exportfeed.com/documentation/kelkoo-guide/",
    Newegg:"https://www.exportfeed.com/documentation/newegg-integration-guide/",
    Nextag:"https://www.exportfeed.com/documentation/nextag-integration-guide/",
    Polyvore:"https://www.exportfeed.com/documentation/",
    Pricefalls:"https://www.exportfeed.com/documentation/pricefalls-com-integration-guide/",
    PriceGrabber:"https://www.exportfeed.com/documentation/pricegrabber-com-integration-guide/",
    PriceRunner:"https://www.exportfeed.com/documentation/",
    Pronto:"https://www.exportfeed.com/documentation/pronto-integration-guide/",
    Rakuten:"https://www.exportfeed.com/documentation/",
    RakutenNewSku:"https://www.exportfeed.com/documentation/",
    RakutenUK:"https://www.exportfeed.com/documentation/rakuten/",
    ShareASale:"https://www.exportfeed.com/documentation/shareasale-integration-guide/",
    Shopzilla:"https://www.exportfeed.com/documentation/",
    Slickguns:"https://www.exportfeed.com/documentation/",
    Webgains:"https://www.exportfeed.com/documentation/webgains-integration-guide/",
    Winesearcher:"https://www.exportfeed.com/documentation/",
    Atterley:"https://www.exportfeed.com/documentation/",
    Avantlink:"https://www.exportfeed.com/documentation/avantlink-integration-guide/",
    TradeTracker:"https://www.exportfeed.com/documentation/",
    Zomato:"https://www.exportfeed.com/documentation/",
    Trademe:"https://www.exportfeed.com/documentation/",
    Productlistxml:"https://www.exportfeed.com/documentation/",
    Productlistcsv:"https://www.exportfeed.com/documentation/",
    Productlisttxt:"https://www.exportfeed.com/documentation/",
    Productlistraw:"https://www.exportfeed.com/documentation/",
    AggXmlGoogle:"https://www.exportfeed.com/documentation/",
    AggCsv:"https://www.exportfeed.com/documentation/",
    AggTsv:"https://www.exportfeed.com/documentation/",
    AggTxt:"https://www.exportfeed.com/documentation/",
    AggXml:"https://www.exportfeed.com/documentation/"
};
        jQuery("#default_div").hide();
        if(value=="Google"){
            jQuery("#for_amzon").hide();
            jQuery("#for_other").hide();
            jQuery("#for_google").show();
        }
        else if(value=="Amazon"){
             jQuery("#for_amzon").show();
             jQuery("#for_google").hide();
             jQuery("#for_other").hide();
        }
        else{
             jQuery("#for_amzon").hide();
             jQuery("#for_google").hide();
             jQuery("#for_other").show();
             jQuery("#tutorial_title_other").html(value);
             var a = document.createElement("a");

             a.href = merchantArray[value]; 
             a.target = "_blank";
             a.innerHTML = "here";
             
             console.log(a);
             jQuery("#inner_doc_link").html(a);
            
        }
        jQuery("#tutorial_title").html(value);
    }
</script>';
echo $output;
   }
}
$view=new View(); 
?>
