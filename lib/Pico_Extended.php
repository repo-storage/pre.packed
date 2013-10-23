<?php

/**
 * The file description. TODO*
 * @package TODO
 * @subpackage Basejump TODO
 * @since BJ 1.0 TODO
 * @author Shawn Sandy <shawnsandy04@gmail.com>
 */
class Pico_Extended extends Pico {

    public function __construct() {
        // Load plugins
		$this->load_plugins();
		$this->run_hooks('plugins_loaded');

		// Get request url and script url
		$url = '';
		$request_url = (isset($_SERVER['REQUEST_URI'])) ? $_SERVER['REQUEST_URI'] : '';
		$script_url  = (isset($_SERVER['PHP_SELF'])) ? $_SERVER['PHP_SELF'] : '';

		// Get our url path and trim the / of the left and the right
		if($request_url != $script_url) $url = trim(preg_replace('/'. str_replace('/', '\/', str_replace('index.php', '', $script_url)) .'/', '', $request_url, 1), '/');
		$url = preg_replace('/\?.*/', '', $url); // Strip query string
		$this->run_hooks('request_url', array(&$url));

		// Get the file path
		if($url) $file = CONTENT_DIR . $url;
		else $file = CONTENT_DIR .'index';

		// Load the file
		if(is_dir($file)) $file = CONTENT_DIR . $url .'/index'. CONTENT_EXT;
		else $file .= CONTENT_EXT;

		$this->run_hooks('before_load_content', array(&$file));
		if(file_exists($file)){
			$content = file_get_contents($file);
		} else {
			$this->run_hooks('before_404_load_content', array(&$file));
			$content = file_get_contents(CONTENT_DIR .'404'. CONTENT_EXT);
			header($_SERVER['SERVER_PROTOCOL'].' 404 Not Found');
			$this->run_hooks('after_404_load_content', array(&$file, &$content));
		}
		$this->run_hooks('after_load_content', array(&$file, &$content));

		// Load the settings
		$settings = $this->get_config();
		$this->run_hooks('config_loaded', array(&$settings));

		$meta = $this->read_file_meta($content);
		$this->run_hooks('file_meta', array(&$meta));
		$content = $this->parse_content($content);
		$this->run_hooks('content_parsed', array(&$content));

		// Get all the pages
		$pages = $this->get_pages($settings['base_url'], $settings['pages_order_by'], $settings['pages_order'], $settings['excerpt_length']);
		$prev_page = array();
		$current_page = array();
		$next_page = array();
		while($current_page = current($pages)){
			if((isset($meta['title'])) && ($meta['title'] == $current_page['title'])){
				break;
			}
			next($pages);
		}
		$prev_page = next($pages);
		prev($pages);
		$next_page = prev($pages);
		$this->run_hooks('get_pages', array(&$pages, &$current_page, &$prev_page, &$next_page));

		// Load the theme
		$this->run_hooks('before_twig_register');
		Twig_Autoloader::register();
		$loader = new Twig_Loader_Filesystem(THEMES_DIR . $settings['theme']);
		$twig = new Twig_Environment($loader, $settings['twig_config']);
		$twig->addExtension(new Twig_Extension_Debug());
                $twig->addExtension(new Twig_Extension_StringLoader());
		$twig_vars = array(
			'config' => $settings,
			'base_dir' => rtrim(ROOT_DIR, '/'),
			'base_url' => $settings['base_url'],
			'theme_dir' => THEMES_DIR . $settings['theme'],
			'theme_url' => $settings['base_url'] .'/'. basename(THEMES_DIR) .'/'. $settings['theme'],
			'site_title' => $settings['site_title'],
			'meta' => $meta,
			'content' => $content,
			'pages' => $pages,
			'prev_page' => $prev_page,
			'current_page' => $current_page,
			'next_page' => $next_page,
			'is_front_page' => $url ? false : true,
		);
		$this->run_hooks('before_render', array(&$twig_vars, &$twig));
                $page_template = 'index.html';

                $this->run_hooks('before_output', array(&$page_template));

                if(isset($meta['layout']) && !empty($meta['layout'])):
                    $template_file = THEMES_DIR.$settings['theme'].'/'.$meta['layout'];
                    if(file_exists($template_file)):
                    $page_template = $meta['layout'];
                    endif;
                endif;

		$output = $twig->render($page_template, $twig_vars);
		$this->run_hooks('after_render', array(&$output));
		echo $output;

    }

}