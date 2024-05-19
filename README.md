# Lime Free Shipping Bar

**Lime Free Shipping Bar** is a Wordpress plugin that displays a top bar with a progress bar, informing users about the possibility of free shipping without the need to set the Free Shipping option in WooCommerce settings. The plugin supports multilingual functionality via Polylang and automatically clears the WP Rocket cache when settings are changed.

## Features

-   Displays a top bar with a message about free shipping.
-   Progress bar showing how much is left until free shipping.
-   Multilingual support via Polylang.
-   WP Rocket caching support with automatic cache clearing upon setting changes.
-   Customizable colors for the bar and progress bar.
-   Can work without the Free Shipping option set in WooCommerce settings.

## Requirements

-   WordPress 5.0 or higher
-   WooCommerce 4.0 or higher
-   Polylang (optional for multilingual functionality)
-   WP Rocket (optional for cache optimization)

## Installation

1. Upload the plugin files to the `/wp-content/plugins/lime-free-shipping-bar` directory or install the plugin via the WordPress admin panel.
2. Activate the plugin through the 'Plugins' menu in WordPress.
3. Go to 'Free Shipping Bar' in the admin menu to configure the plugin.

## Usage

After activating the plugin and configuring the settings, the top bar with a progress bar will automatically appear on your site, except on the cart and checkout pages.

## Configuration

Go to 'Free Shipping Bar' in the admin menu to configure the following settings:

-   **Free Shipping Threshold**: The threshold for free shipping.
-   **Bar Background Color**: The background color of the bar.
-   **Text Color**: The text color of the bar.
-   **Amount Color**: The color of the remaining amount for free shipping.
-   **Progress Bar Color**: The color of the progress bar.
-   **Progress Bar Background Color**: The background color of the progress bar.

## Reset Settings

You can reset the settings to default values by clicking the 'Reset Settings to Default' button on the settings page.

## Compatibility

-   **Polylang**: The plugin supports multilingual functionality. Each message can be configured for each active language. Tested with Polylang Pro version 3.6.
-   **WP Rocket**: The plugin automatically clears the WP Rocket cache upon setting changes. Data is displayed using AJAX requests, ensuring the top bar and progress bar display current information on cached pages. Tested with WP Rocket version 3.1.6.
-   **WooCommerce**: No need to set the Free Shipping option in WooCommerce settings. Tested with WooCommerce version 8.8.3.

## Contributing

If you would like to contribute, please fork the repository and submit a pull request. You can also open an issue to discuss any changes you would like to make.

## License

This project is licensed under the MIT License - see the [LICENSE](LICENSE) file for details.

## Structure

lime-free-shipping-bar/
├── assets/
│ ├── css/
│ │ └── style.css
│ └── js/
│ ├── color-picker.js
│ └── fshb-script.js
├── includes/
│ ├── ajax-functions.php
│ ├── helpers.php
│ └── admin-page.php
├── templates/
│ └── free-shipping-bar.php
├── lime-free-shipping-bar.php
├── LICENSE
└── README.md
