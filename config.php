<?php

// Override any of the default settings below:

$config['site_title'] = 'Pico.Based';   // Site title
$config['base_url'] = 'http://localhost/pico-master';     // Override base URL (e.g. http://example.com)
$config['theme'] = 'base-start';    // Set the theme (defaults to "default")
$config['date_format'] = 'jS M Y';  // Set the PHP date format
$config['twig_config'] = array(// Twig settings
    'cache' => false, // To enable Twig caching change this to CACHE_DIR
    'autoescape' => false, // Autoescape Twig vars
    'debug' => true     // Enable Twig debug
);
$config['pages_order_by'] = 'alpha'; // Order pages by "alpha" or "date"
$config['pages_order'] = 'asc';   // Order pages "asc" or "desc"
$config['excerpt_length'] = 50;   // The pages excerpt length (in words)
// To add a custom config setting:
//Adv meta valuse add some valuse to the content
$config['custom_meta_values'] = array(
    //page slug keep lower case
    'slug' => 'Slug',
    //page category
    'category' => 'Category',
    //page status
    'status' => 'Status',
    //Type -- page, post, plugin
    'type' => 'Type',
    //Page Thumbnail -- (theme/images)
    'thumbnail' => 'Thumbnail',
    // image for page icon -- (theme/images/)
    'icon' => 'Icon',
    //use custom page template(s)
    'tpl' => 'Tpl',
    //page layout
    'layout' => 'Layout',
    //template page
    'template' => 'Template',
    //post format
    'format' => 'Format'
);

$config['active_themes'] = array('default','base_start','jugs','block-kit','prepack-launch');

//Theme info config
/*
 * Sample theme config
 * Setting to use with the theme
 * Helps if user does not them directly edit theme files
 */
$config['copyright'] = '2013 All rights reserved.';
$config['organization'] = 'Managed Pixels';
$config['contact_name'] = 'Full name';
$config['contact_address'] = 'Street City State';
$config['contact_number'] = '000 000 0000';
$config['facebook_username'] = 'shawnjsandy';
$config['facebook_page_url'] = 'shawnjsandy';
$config['twitter_username'] = 'shawnsandy';