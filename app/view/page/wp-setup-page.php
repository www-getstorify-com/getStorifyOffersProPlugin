<?php
/**
 * Author: Yusuf Shakeel
 * Date: 18-jun-2019 tue
 * Version: 1.0
 *
 * File: wp-setup-page.php
 * Description: This page contains the form to setup the plugin.
 */

require_once __DIR__ . '/../../config/constants.php';
require_once __DIR__ . '/../../getStorifyPlugin-routes.php';

// shortcode
if (!get_option(GETSTORIFY_OFFERS_PLUGIN_WP_OPTIONS_TABLE_OPTION_NAME_PLUGIN_SHORTCODE)) {

    update_option(
        GETSTORIFY_OFFERS_PLUGIN_WP_OPTIONS_TABLE_OPTION_NAME_PLUGIN_SHORTCODE,
        GETSTORIFY_OFFERS_PLUGIN_WP_SHORTCODE
    );

}


/** save data: getStorify offers plugin credentials **/
if (isset($_POST['getStorifyOffersPluginOptions_data_save'])) {

    //Form data sent
    unset($_POST['getStorifyOffersPluginOptions_data_save']);

    foreach ($_POST as $key => $val) {
        update_option($key, $val);
    }

    // output the success message
    echo <<<HTML
    <div class="notice notice-success is-dismissible">
        <h2>getStorify credentials saved.</h2>
        <p>Now, check the <a href="#getstorify-configured-profile">Configured Profile</a> section to see if your account is set.</p>
        <button type="button" class="notice-dismiss">
            <span class="screen-reader-text">Dismiss this notice.</span>
        </button>
    </div>
HTML;


}
// save data: getStorify plugin credentials


/** save data: getStorify google api key **/
if (isset($_POST['getStorifyOffersPluginOptions_googleApiKey_data_save'])) {

    //Form data sent
    unset($_POST['getStorifyOffersPluginOptions_googleApiKey_data_save']);

    foreach ($_POST as $key => $val) {
        update_option($key, $val);
    }

    // output the success message
    echo <<<HTML
    <div class="notice notice-success is-dismissible">
        <h2>Google API Key saved.</h2>
        <button type="button" class="notice-dismiss">
            <span class="screen-reader-text">Dismiss this notice.</span>
        </button>
    </div>
HTML;


}
// save data: getStorify google api key

$app_user_id = get_option(GETSTORIFY_OFFERS_PLUGIN_WP_OPTIONS_TABLE_OPTION_NAME_PLUGIN_USER_ID);
$app_id = get_option(GETSTORIFY_OFFERS_PLUGIN_WP_OPTIONS_TABLE_OPTION_NAME_PLUGIN_APP_ID);
$app_token = get_option(GETSTORIFY_OFFERS_PLUGIN_WP_OPTIONS_TABLE_OPTION_NAME_PLUGIN_APP_TOKEN);
$app_shortcode = get_option(GETSTORIFY_OFFERS_PLUGIN_WP_OPTIONS_TABLE_OPTION_NAME_PLUGIN_SHORTCODE);
$app_google_api_key = get_option(GETSTORIFY_OFFERS_PLUGIN_WP_OPTIONS_TABLE_OPTION_NAME_PLUGIN_GOOGLE_API_KEY_WEB_KEY);

$app_isConfiguredCorrectly = false;

/** register page/post route **/
if (isset($_POST['getStorifyOffersPluginOptions_Routes_data_save'])) {

    //Form data sent
    unset($_POST['getStorifyOffersPluginOptions_Routes_data_save']);

    if (isset($_POST['getStorifyOffersPluginOptions_Routes_slug'])) {

        $slug = trim($_POST['getStorifyOffersPluginOptions_Routes_slug']);

        // add route
        if (getStorifyOffersPlugin_Routes_AddRouteRule_func($slug) === true) {
            $isRouteAddedSuccessfully = true;
        } else {
            $isRouteAddedSuccessfully = false;
        }

    }

    if ($isRouteAddedSuccessfully) {

        echo <<<HTML
<div class="notice notice-success is-dismissible">
    <h2>Routes updated</h2>
    <p>Slug added: {$slug}</p>
    <p>Now head over to <strong>Settings > Permalinks</strong> page and click the <strong>Save Changes</strong> button.</p>
    <button type="button" class="notice-dismiss">
        <span class="screen-reader-text">Dismiss this notice.</span>
    </button>
</div>
HTML;

    } else {

        echo <<<HTML
<div class="notice notice-error is-dismissible">
    <h2>Failed to update routes</h2>
    <p>Slug: {$slug}</p>
    <p>Please try again later.</p>
    <button type="button" class="notice-dismiss">
        <span class="screen-reader-text">Dismiss this notice.</span>
    </button>
</div>
HTML;

    }

}
// register page/post routes ends here

/** remove page/post route **/
if (isset($_POST['getStorifyOffersPluginOptions_RoutesRemove_data_save'])) {

    //Form data sent
    unset($_POST['getStorifyOffersPluginOptions_RoutesRemove_data_save']);

    if (isset($_POST['getStorifyOffersPluginOptions_RoutesRemove_slug'])) {

        $slug = trim($_POST['getStorifyOffersPluginOptions_RoutesRemove_slug']);

        // remove route
        if (getStorifyOffersPlugin_Routes_RemoveRouteRule_func($slug) === true) {
            $isRouteRemovedSuccessfully = true;
        } else {
            $isRouteRemovedSuccessfully = false;
        }

    }

    if ($isRouteRemovedSuccessfully) {

        echo <<<HTML
<div class="notice notice-success is-dismissible">
    <h2>Routes updated</h2>
    <p>Slug removed: {$slug}</p>
    <p>Now head over to <strong>Settings > Permalinks</strong> page and click the <strong>Save Changes</strong> button.</p>
    <button type="button" class="notice-dismiss">
        <span class="screen-reader-text">Dismiss this notice.</span>
    </button>
</div>
HTML;

    } else {

        echo <<<HTML
<div class="notice notice-error is-dismissible">
    <h2>Failed to update routes</h2>
    <p>Slug: {$slug}</p>
    <p>Please try again later.</p>
    <button type="button" class="notice-dismiss">
        <span class="screen-reader-text">Dismiss this notice.</span>
    </button>
</div>
HTML;

    }

}
// remove page/post routes ends here


/** pages route **/
$gs_wp_plugin_options_pages = json_decode(
    get_option(GETSTORIFY_OFFERS_PLUGIN_WP_OPTIONS_TABLE_OPTION_NAME_PLUGIN_PAGES),
    true
);
if (isset($_POST['getStorifyOffersPluginOptions_Pages_data_save'])) {

    //Form data sent
    unset($_POST['getStorifyOffersPluginOptions_Pages_data_save']);

    if (isset($_POST['getStorifyOffersPluginOptions_OfferPage_slug'])) {

        $slug = trim($_POST['getStorifyOffersPluginOptions_OfferPage_slug']);

        $gs_wp_plugin_options_pages['offer_page'] = $slug;

        update_option(
            GETSTORIFY_OFFERS_PLUGIN_WP_OPTIONS_TABLE_OPTION_NAME_PLUGIN_PAGES,
            json_encode($gs_wp_plugin_options_pages)
        );

    }

    if (isset($_POST['getStorifyOffersPluginOptions_StorePage_slug'])) {

        $slug = trim($_POST['getStorifyOffersPluginOptions_StorePage_slug']);

        $gs_wp_plugin_options_pages['store_page'] = $slug;

        update_option(
            GETSTORIFY_OFFERS_PLUGIN_WP_OPTIONS_TABLE_OPTION_NAME_PLUGIN_PAGES,
            json_encode($gs_wp_plugin_options_pages)
        );

    }

    getStorifyOffersPlugin_WP_add_rewrite_rule_func();

    echo <<<HTML
<div class="notice notice-success is-dismissible">
    <h2>Pages saved!</h2>
    <p>Now head over to <strong>Settings > Permalinks</strong> page and click the <strong>Save Changes</strong> button.</p>
    <button type="button" class="notice-dismiss">
        <span class="screen-reader-text">Dismiss this notice.</span>
    </button>
</div>
HTML;

}
// pages routes ends here


/** get the list of routes slug added by the user **/

$customRoutesSlugAddedHTML = getStorifyOffersPlugin_List_AddedRoutes_func();

// get the list of routes slug added by the user ends here

?>

<div class="wrap">

    <h2>getStorify Offers Pro Plugin Configurations</h2>

    <div class="gtst-shortcode-form-container">

        <h2>Upload API Service Config JSON file</h2>

        <form id="form-api-service-config-file">
            <input type="file"
                   id="form-api-service-config-file-index"
                   accept=".json" style="font-size: 16px;">

            <div id="form-api-service-config-file-msg-container" style="margin-top: 15px; margin-bottom: 15px;"></div>
        </form>

    </div>

    <h4>--- OR ---</h4>

    <div class="gtst-shortcode-form-container">

        <form name="getStorifyPluginOptions_form"
              method="post"
              action="<?php echo str_replace('%7E', '~', $_SERVER['REQUEST_URI']); ?>">

            <h2>Enter the following details:</h2>

            <p>
                <label>User ID:</label>
                <input required
                       type="text"
                       maxlength="64"
                       name="getStorifyOffersPluginOptions_user_id"
                       id="getStorifyOffersPluginOptions_user_id"
                       value="<?php echo $app_user_id; ?>">
            </p>

            <p>
                <label>App ID:</label>
                <input required
                       type="text"
                       maxlength="64"
                       name="getStorifyOffersPluginOptions_app_id"
                       id="getStorifyOffersPluginOptions_app_id"
                       value="<?php echo $app_id; ?>">
            </p>

            <p>
                <label>App Token:</label>
                <input required
                       type="text"
                       maxlength="500"
                       name="getStorifyOffersPluginOptions_app_token"
                       id="getStorifyOffersPluginOptions_app_token"
                       value="<?php echo $app_token; ?>">
            </p>

            <p class="submit">
                <input type="submit"
                       class="button-primary"
                       name="getStorifyOffersPluginOptions_data_save"
                       value="Save"/>


                <input type="reset"
                       class="button-secondary"
                       value="Reset"
                       onclick="window.location.reload();"/>
            </p>

        </form><!--/ .form -->

    </div>

    <hr/>

    <div class="gtst-shortcode-form-container">

        <form name="getStorifyOffersOptions_googleApiKey_form"
              method="post"
              action="<?php echo str_replace('%7E', '~', $_SERVER['REQUEST_URI']); ?>">

            <h2>Connect your Google API Key</h2>

            <p>Create your key from your Google Developer account and add it here.</p>

            <p>
                <label>Google API Key:</label>
                <input required
                       type="text"
                       maxlength="1024"
                       name="getStorifyOffersPluginOptions_googleApiKey"
                       id="getStorifyOffersPluginOptions_googleApiKey"
                       value="<?php echo $app_google_api_key; ?>">
            </p>

            <p class="submit">
                <input type="submit"
                       class="button-primary"
                       name="getStorifyOffersPluginOptions_googleApiKey_data_save"
                       value="Save"/>


                <input type="reset"
                       class="button-secondary"
                       value="Reset"
                       onclick="window.location.reload();"/>
            </p>

        </form><!--/ .form -->

    </div>

    <hr/>

    <?php if ($app_id && $app_token && $app_user_id) {

        require_once __DIR__ . '/../../GetStorifyOffers/autoload.php';

        /**
         * create object
         */
        $GetStorifyOffersAPIServiceObj = new \GetStorifyOffers\GetStorifyOffers(
            $app_id,
            $app_user_id,
            $app_token
        );

        /**
         * get access token
         */
        $result = $GetStorifyOffersAPIServiceObj->getAccessToken();

        /**
         * is access token issued
         */
        if (isset($result['success'])) {

            // get user profile detail
            $result = $GetStorifyOffersAPIServiceObj->getUserDetail();

            if (isset($result['success'])) {

                $app_isConfiguredCorrectly = true;

                $result = $result['success'];

                $picture = GETSTORIFY_OFFERS_PLUGIN_USER_DEFAULT_PROFILE_IMAGE;
                if ($result['picture'] != null) {
                    $picture = $result['picturethumbnail'];
                }

                $fullname = '';
                if ($result['firstname'] != null) {
                    $fullname = $result['firstname'] . " ";
                }
                if ($result['lastname'] != null) {
                    $fullname .= $result['lastname'];
                }

                $resultHTML = <<<HTML
<hr>

<a name="getstorify-configured-profile"></a>
<h1>Configured Profile:</h1>

<div class="gtst-shortcode-configured-profile-container">

<div class='getstorify media'>
<img class='getstorify mr-1 rounded-circle img-thumbnail view-user-profile user-profile-image' style='width: 64px; height: 64px;' src='{$picture}' data-userid='{$result['userid']}'>
<div class='getstorify media-body'>
<h1 class='getstorify getstorify-wrap mt-0 font-weight-light mb-1'>
<strong class='getstorify view-user-profile user-fullname' data-userid='{$result['userid']}'>{$fullname}</strong>
</h1>
</div><!--/ .media-body -->
</div><!--/ .media -->

</div>
HTML;

            } else {

                $resultHTML = <<<HTML
<hr>
<div style="background-color: crimson; padding: 10px;">
<h2 style="color: #fff;">Failed to fetch profile details. Please check the UserID, AppID and AppToken.</h2>
</div>
HTML;

            }

        } else {

            $resultHTML = <<<HTML
<hr>
<div style="background-color: crimson; padding: 10px;">
<h2 style="color: #fff;">Invalid credential. Please check the UserID, AppID and AppToken.</h2>
</div>
HTML;

        }

        echo $resultHTML;

    } ?>

    <hr/>

    <?php if ($app_id && $app_token) { ?>

        <h1>Pages</h1>

        <div class="gtst-shortcode-attribute-container">

            <div class="gtst-shortcode-form-container">

                <form name="getStorifyOffersPluginOptions_Pages_form"
                      method="post"
                      action="<?php echo str_replace('%7E', '~', $_SERVER['REQUEST_URI']); ?>">

                    <h2>Offer Page</h2>

                    <p>Enter page slug where you want to render offer and its items</p>

                    <p>Example:</p>

                    <p>If you want to show an offer and its items on a page
                        <strong><?php echo get_home_url(); ?>/offer</strong> then, add <code>offer</code> in the offer
                        slug field.</p>

                    <p>
                        <label>Offer Page Slug:</label>
                        <input required
                               type="text"
                               maxlength="200"
                               name="getStorifyOffersPluginOptions_OfferPage_slug"
                               id="getStorifyOffersPluginOptions_OfferPage_slug"
                               value="<?php echo $gs_wp_plugin_options_pages['offer_page']; ?>"/>
                    </p>

                    <hr>

                    <h2>Store Page</h2>

                    <p>Enter page slug where you want to render store and its offers</p>

                    <p>Example:</p>

                    <p>If you want to show store and its offers on a page
                        <strong><?php echo get_home_url(); ?>/store</strong> then, add <code>store</code> in the store
                        slug field.</p>

                    <p>
                        <label>Store Page Slug:</label>
                        <input required
                               type="text"
                               maxlength="200"
                               name="getStorifyOffersPluginOptions_StorePage_slug"
                               id="getStorifyOffersPluginOptions_StorePage_slug"
                               value="<?php echo $gs_wp_plugin_options_pages['store_page']; ?>"/>
                    </p>

                    <hr>

                    <p class="submit">
                        <input type="submit"
                               class="button-primary"
                               name="getStorifyOffersPluginOptions_Pages_data_save"
                               value="Save"/>


                        <input type="reset"
                               class="button-secondary"
                               value="Reset"
                               onclick="window.location.reload();"/>
                    </p>

                </form><!--/ .form -->

                <h4>Note!</h4>
                <p>To refresh the routes go to <strong>Settings > Permalinks</strong> page and click the <strong>Save
                        Changes</strong> button.</p>

            </div>

        </div>


        <h1>Register page where you are using the shortcode</h1>

        <div class="gtst-shortcode-attribute-container">

            <div class="gtst-shortcode-form-container">

                <form name="getStorifyOffersPluginOptions_Routes_form"
                      method="post"
                      action="<?php echo str_replace('%7E', '~', $_SERVER['REQUEST_URI']); ?>">

                    <h2>Enter page slug:</h2>

                    <p>Example:</p>

                    <p>If the page were you have used the shortcode is https://example.com/hello then <strong>slug =
                            hello</strong></p>

                    <p>
                        <label>Slug:</label>
                        <input required
                               type="text"
                               maxlength="200"
                               name="getStorifyOffersPluginOptions_Routes_slug"
                               id="getStorifyOffersPluginOptions_Routes_slug"
                    </p>

                    <p class="submit">
                        <input type="submit"
                               class="button-primary"
                               name="getStorifyOffersPluginOptions_Routes_data_save"
                               value="Add Route Rule"/>


                        <input type="reset"
                               class="button-secondary"
                               value="Reset"
                               onclick="window.location.reload();"/>
                    </p>

                </form><!--/ .form -->

                <div class="custom-route-slug-container">
                    <p><strong>Added routes:</strong></p>
                    <?php echo $customRoutesSlugAddedHTML; ?>
                </div>

                <h4>Note!</h4>
                <p>To refresh the routes go to <strong>Settings > Permalinks</strong> page and click the <strong>Save
                        Changes</strong> button.</p>

            </div>

        </div>


        <h1>Remove page routes where you are using the shortcode</h1>

        <div class="gtst-shortcode-attribute-container">

            <div class="gtst-shortcode-form-container">

                <form name="getStorifyOffersPluginOptions_RoutesRemove_form"
                      method="post"
                      action="<?php echo str_replace('%7E', '~', $_SERVER['REQUEST_URI']); ?>">

                    <h2>Enter page slug:</h2>

                    <p>Example:</p>

                    <p>If the page were you have used the shortcode is https://example.com/hello then <strong>slug =
                            hello</strong></p>

                    <p>
                        <label>Slug:</label>
                        <input required
                               type="text"
                               maxlength="200"
                               name="getStorifyOffersPluginOptions_RoutesRemove_slug"
                               id="getStorifyOffersPluginOptions_RoutesRemove_slug"
                    </p>

                    <p class="submit">
                        <input type="submit"
                               class="button-primary"
                               name="getStorifyOffersPluginOptions_RoutesRemove_data_save"
                               value="Remove Route Rule"/>


                        <input type="reset"
                               class="button-secondary"
                               value="Reset"
                               onclick="window.location.reload();"/>
                    </p>

                </form><!--/ .form -->

                <h4>Note!</h4>
                <p>To refresh the routes go to <strong>Settings > Permalinks</strong> page and click the <strong>Save
                        Changes</strong> button.</p>

            </div>

        </div>

        <h2>How to use the shortcode?</h2>

        <div class="gtst-shortcode-attribute-container">
            <p>Place the shortcode <b style="font-size: 20px;">[<?php echo $app_shortcode; ?>]</b>
                on the page where you want to display stories from getStorify.
            </p>
        </div>

        <hr>

        <h2>Shortcode configurations</h2>

        <div class="gtst-shortcode-attribute-container">

            <div class="getstorify table-responsive">

                <table class="getstorify table">

                    <tr>
                        <th>Task</th>
                        <th>Shortcode</th>
                        <th>Example</th>
                    </tr>

                    <tr>
                        <td>Fetch all stores</td>
                        <td>[<?php echo $app_shortcode; ?> view="stores"]</td>
                        <td>[<?php echo $app_shortcode; ?> view="stores"]</td>
                    </tr>

                    <tr>
                        <td>Fetch all stores with offers</td>
                        <td>[<?php echo $app_shortcode; ?> view="stores_with_offers"]</td>
                        <td>[<?php echo $app_shortcode; ?> view="stores_with_offers"]</td>
                    </tr>

                    <tr>
                        <td>Fetch all offers</td>
                        <td>[<?php echo $app_shortcode; ?> view="offers"]</td>
                        <td>[<?php echo $app_shortcode; ?> view="offers"]</td>
                    </tr>

                    <tr>
                        <td>Fetch popular offers
                            (max <?php echo GETSTORIFY_OFFERS_PLUGIN_API_SERVICE_DB_PAGE_LIMIT; ?>)
                        </td>
                        <td>[<?php echo $app_shortcode; ?> view="offers_popular"]</td>
                        <td>[<?php echo $app_shortcode; ?> view="offers_popular"]</td>
                    </tr>

                    <tr>
                        <td>Fetch all offers of a store</td>
                        <td>[<?php echo $app_shortcode; ?> view="store_offers"]</td>
                        <td>[<?php echo $app_shortcode; ?> view="store_offers"]</td>
                    </tr>

                    <tr>
                        <td>Fetch all items of an offer of a store</td>
                        <td>[<?php echo $app_shortcode; ?> view="store_offer_items"]</td>
                        <td>[<?php echo $app_shortcode; ?> view="store_offer_items"]</td>
                    </tr>

                </table>

            </div>

        </div>

        <hr>

        <h1>Attributes you can add to the shortcode.</h1>

        <div class="gtst-shortcode-attribute-container">

            <h2>Columns</h2>

            <h3><code>columns="n"</code></h3>

            <p>This will render the offers/stores in columns.</p>

            <p><code>n</code> can take only positive integer values.</p>

            <p>Allowed values for n: 1, 2, 3 and 4 for one, two, three and four columns respectively.</p>

            <p>Example:</p>

            <p>The following shortcode settings will render offers in 3 columns.</p>

            <p><code>[<?php echo $app_shortcode; ?> view="offers" columns="3"]</code></p>

            <p>Applicable for the following views:</p>

            <ul>
                <li><code>view="offers"</code></li>
                <li><code>view="offers_popular"</code></li>
                <li><code>view="stores"</code></li>
                <li><code>view="stores_with_offers"</code></li>
            </ul>

        </div>

        <div class="gtst-shortcode-attribute-container">

            <h2>Store Per page</h2>

            <h3><code>store_per_page="n"</code></h3>

            <p>This will control the total number of stores fetched per page.</p>

            <p><code>store_per_page</code> takes positive integer value like 1,2,3...</p>

            <p>Default value for <code>store_per_page</code>
                is <?php echo GETSTORIFY_OFFERS_PLUGIN_API_SERVICE_DB_PAGE_LIMIT; ?>.</p>

            <p>Max value for <code>store_per_page</code>
                is <?php echo GETSTORIFY_OFFERS_PLUGIN_API_SERVICE_DB_PAGE_LIMIT; ?>.</p>

            <p>Example:</p>

            <p>The following shortcode settings will render 5 stores per page.</p>

            <p><code>[<?php echo $app_shortcode; ?> view="stores" store_per_page="5"]</code></p>

            <p>Applicable for the following views:</p>

            <ul>
                <li><code>view="stores"</code></li>
                <li><code>view="stores_with_offers"</code></li>
            </ul>

        </div>

        <div class="gtst-shortcode-attribute-container">

            <h2>Offer Per page</h2>

            <h3><code>offer_per_page="n"</code></h3>

            <p>This will control the total number of offers fetched per page.</p>

            <p><code>offer_per_page</code> takes positive integer value like 1,2,3...</p>

            <p>Default value for <code>offer_per_page</code>
                is <?php echo GETSTORIFY_OFFERS_PLUGIN_API_SERVICE_DB_PAGE_LIMIT; ?>.</p>

            <p>Max value for <code>offer_per_page</code>
                is <?php echo GETSTORIFY_OFFERS_PLUGIN_API_SERVICE_DB_PAGE_LIMIT; ?>.</p>

            <p>Example:</p>

            <p>The following shortcode settings will render 5 offers per page.</p>

            <p><code>[<?php echo $app_shortcode; ?> view="offers" offer_per_page="5"]</code></p>

            <p>Applicable for the following views:</p>

            <ul>
                <li><code>view="offers"</code></li>
                <li><code>view="store_offers"</code></li>
            </ul>

        </div>

        <div class="gtst-shortcode-attribute-container">

            <h2>Item Per page</h2>

            <h3><code>item_per_page="n"</code></h3>

            <p>This will control the total number of items fetched per page.</p>

            <p><code>item_per_page</code> takes positive integer value like 1,2,3...</p>

            <p>Default value for <code>item_per_page</code>
                is <?php echo GETSTORIFY_OFFERS_PLUGIN_API_SERVICE_DB_PAGE_LIMIT; ?>.</p>

            <p>Max value for <code>item_per_page</code>
                is 20.</p>

            <p>Example:</p>

            <p>The following shortcode settings will render 5 items per page.</p>

            <p><code>[<?php echo $app_shortcode; ?> view="store_offer_items" item_per_page="5"]</code></p>

            <p>Applicable for the following views:</p>

            <ul>
                <li><code>view="store_offer_items"</code></li>
            </ul>

        </div>

    <?php } ?>

</div><!--/ .wrap -->

<style>
    .gtst-shortcode-configured-profile-container,
    .gtst-shortcode-form-container,
    .gtst-shortcode-attribute-container {
        padding: 15px;
        background-color: #fff;
        border-top-color: #999;
        border-top-width: 5px;
        margin-bottom: 15px;
    }

    label {
        width: 200px;
        float: left;
    }

    input[type="text"], select {
        padding: 7px 7px;
        width: 44%;
    }

    .getstorify.table-responsive {
        overflow-x: scroll;
    }

    table.getstorify.table {
        width: 100%;
        margin-bottom: 20px;
    }

    table.getstorify.table tr td,
    table.getstorify.table tr th {
        padding: 10px 5px;
        border-bottom: 1px solid black;
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
        background-color: #fff;
    }
</style>

<script type="text/javascript">
    window.onload = function () {

        // check json form input field change
        document
            .getElementById('form-api-service-config-file-index')
            .addEventListener('change', function (event) {

                var reader = new FileReader();

                if (typeof event.target.files[0] !== 'undefined') {

                    reader.onload = function (event) {
                        var jsonObj = JSON.parse(event.target.result);

                        if (typeof jsonObj.appid !== 'undefined') {

                            // set the config fields
                            document
                                .getElementById('getStorifyOffersPluginOptions_app_id')
                                .value = jsonObj.appid;

                            document
                                .getElementById('getStorifyOffersPluginOptions_user_id')
                                .value = jsonObj.userid;

                            document
                                .getElementById('getStorifyOffersPluginOptions_app_token')
                                .value = jsonObj.apptoken;


                            // reset form
                            document
                                .getElementById("form-api-service-config-file")
                                .reset();

                            var html = "<div class='notice notice-info is-dismissible' id='form-api-service-config-file-notification'>" +
                                "<h4>Configuration added</h4>" +
                                "<p>Click the <strong>SAVE</strong> button to save.</p>" +
                                "<button type='button' class='notice-dismiss'>" +
                                "<span class='screen-reader-text'>Dismiss this notice.</span>" +
                                "</button>" +
                                "</div>";

                            document
                                .getElementById('form-api-service-config-file-msg-container')
                                .innerHTML = html;

                            setTimeout(function () {
                                document
                                    .getElementById('form-api-service-config-file-msg-container')
                                    .innerHTML = "";
                            }, 5000);

                        }
                    };

                    reader.readAsText(event.target.files[0]);

                }

            });

    };
</script>