=== Teachable ===

Contributors: teachable
Donate link: https://teachable.com/
Tags: teachable, courses, bundles, products, LMS
Requires at least: 6.0
Tested up to: 6.5.2
Stable tag: 1.0.4
Requires PHP: 7.4
License: GPLv3
License URI: https://www.gnu.org/licenses/gpl-3.0.html

Effortlessly connect your Teachable products to WordPress with the official Teachable Buy Button Plugin.


== Description ==

Turning your WordPress site into an online storefront for your Teachable products is as simple as a few clicks. Simply add our new WordPress plugin and choose the product you’d like to feature.

The Teachable WordPress plugin seamlessly adds your product information to your WordPress blog or website without the need to duplicate information and connects directly with Teachable’s secure checkout platform. All you need is a product to sell and you’re ready to launch. And yes – it’s fully customizable to match your brand’s look.

Key points of interest:

-   Add courses & bundles to sell without any copying and pasting.
-   Sell MORE by adding your products on your WordPress site in more places.
-   Sell EVERYWHERE on your site!
-   Stay in sync with your product data on Teachable automatically.
-   Seamlessly link to Teachable for checkout.


== 3rd Party Services ==

This plugin relies on 3rd party services provided by Teachable to use the shortcodes and blocks. The following routes are used to pull data via the Teachable WordPress Key:
- https://developers.teachable.com/v1/integrations/school
- https://developers.teachable.com/v1/integrations/courses
- https://developers.teachable.com/v1/integrations/bundles

For reference on how the API works, visit: [Teachable API Documentation](https://docs.teachable.com/)

For support, visit: [Teachable Support](https://support.teachable.com/hc/en-us/articles/25418090816781-Teachable-for-Wordpress)

For privacy policy information, visit: [Teachable Privacy Policy](https://support.teachable.com/hc/en-us/articles/4411634280461-Creator-Terms-and-Privacy-Guidance)


== Frequently Asked Questions ==

= How do I generate an API key? =
Visit our support documentation for full step-by-step instructions. Available [here](https://support.teachable.com/hc/en-us/articles/25418090816781-Teachable-for-Wordpress)

= Why are my product blocks not up to date on WordPress? =
Under your settings page in WordPress, look for the “Sync data” tab. You can set the time you would like for data to sync daily. If you want to sync your data immediately, click on the “Sync Now” button. This should update your Teachable product blocks with the most up-to-date information from Teachable.

= What happens if I uninstall the Teachable plugin on WordPress? =
If you uninstall the Teachable plugin, your product blocks will remain on your pages. Please note that these blocks will no longer be synced with up-to-date data. If you want to remove the blocks, you will need to manually delete them from the page.

= What happens if I uninstall the WordPress plugin on Teachable? =
Uninstalling the WordPress plugin on Teachable will delete your integration key. This key is responsible for syncing data to the WordPress product blocks. We do not recommend uninstalling the plugin unless you no longer want to use the Teachable plugin on WordPress.

= Why is there an error on my product block? =
If you notice an error on your block, you may have deleted the product or pricing plan from your Teachable school. It’s also possible you may have deleted your WordPress key in the settings section of the plugin.

= Why does the “buy button” redirect to a broken page? =
The reason you are being redirected to a broken page is that "Pricing Plan" may no longer be linked to a product. Please make sure you have the correct product and pricing plan linked on your block.

= How can I edit the course description on my block? =
You must go to the block editor within your Teachable course. There is an optional course description hidden on the information page of the course. There, you can edit the course description.

= Other notes: =
The displayed price is not tax-inclusive.


== Screenshots ==

1. The settings page where you configure your Teachable integration.
2. Adding the Teachable Buy Button block to your editor.


== Installation ==

Visit our support documentation for full step-by-step instructions with screenshots. Available [here](https://support.teachable.com/hc/en-us/articles/25418090816781-Teachable-for-Wordpress)

1. Upload the plugin files to the `/wp-content/plugins/teachable` directory, or install the plugin through the WordPress plugins screen directly.
2. Activate the plugin through the 'Plugins' screen in WordPress
3. Use the Settings->Teachable screen to configure the plugin


== Changelog ==

= 1.0.4 =
Fixed default last sync date.

= 1.0.3 =
Fixed typos in error messages.

= 1.0.2 =
Fixed styling issues related to incorrect color displays.

= 1.0.1 =
Bug fixes to correct radio button and page preview styling inconsistencies.

= 1.0.0 =
Initial release.
