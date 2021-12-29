# AP Breaking News

## Description

Show breaking news ticker with shortcode/code inside your header, add custom background color, text color or even custom title, extended to work with date picker so you never need to disable it.

* Change custom title
* Change background color
* Change color of text

## Installation

1. Upload the plugin files to the `/wp-content/plugins/ap-breaking-news` directory, or install the plugin through the WordPress plugins screen directly.
2. Activate the plugin through the 'Plugins' screen in WordPress
3. Go to Settings/Tools -> AP Breaking News -> Change things you need
4. Go to your theme header.php and put 
   1. ```<?php echo do_shortcode('[ap-breaking-news]'); ?>```


## Frequently Asked Questions

### How it works
 - You don't need to worry about dates that much, the plugin will show the latest (expiration date), so the highest `expire date` will be shown before others.
 - Please visit the website after post changes/update so everything gets updated in places
 - Post with expiration date have advantages over normal (just checked "Make this breaking news")
 - For normal themes use shortcode 
    ```
   <?php echo do_shortcode('[ap-breaking-news]'); ?>
   ```
 - For Gutenberg ready themes (HTML blocks) please use this code
    ```
   <!-- wp:shortcode -->
   [ap-breaking-news]
    <!-- /wp:shortcode -->

### Will this work with any theme ?

AP breaking news should work with any theme, place a shortcode/code and adjust settings in backend (Color, Background) if needed adjust/add custom CSS. 
 - You can target `#abpn-container` or `.apbn-container`


### What to do if plugin isnt working ?
 1. Check did you enable plugin
 2. Clear Cache
 3. Go to Settings > Save Permalinks
 4. Go to Latest post and check (Make this post breaking news)
    1. Save the page
    2. Visit the link
 5. Check did you place shortcode in right place, its usually on this places:
    1. yourtheme/header.php 
    2. yourtheme/template-parts/header/site-header.php
    3. yourtheme/block-template-parts/header.html
    4. yourtheme/parts/header.html


### Testing
    ./vendor/bin/phpcs -i 
    ./vendor/bin/phpcs --standard=WordPress D:\wordpress\wp-content\plugins\ap-breaking-news\admin\any-file.php 

