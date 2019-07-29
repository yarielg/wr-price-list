<?php  

/*
*
* @package Yariko
*
*/

namespace Inc\Pages;

class Pages{

	public function register(){



        add_action('admin_menu', function(){
            add_menu_page('WR Price List', 'WR Price List', 'manage_options', 'wrpl-main-menu', array($this,'admin_index'),'dashicons-image-rotate-right',110);
        });

        add_action('admin_menu', function(){
            add_submenu_page( 'wrpl-main-menu', 'Dashboard', 'Dashboard','manage_options', 'wrpl-main-menu', array($this,'admin_index'));
        });

        add_action('admin_menu',function(){
            $page_product =  add_submenu_page( 'wrpl-main-menu', 'Products', 'Products','manage_options', 'wrpl-products-menu', array($this,'products'));
            add_action( 'load-' . $page_product, function(){
                add_action( 'admin_enqueue_scripts',function (){

                    wp_enqueue_style('wrtable_css', PLUGIN_URL . '/assets/css/admin/wrtable.min.css'  );
                    wp_enqueue_style('main_admin_styles',  PLUGIN_URL . '/assets/css/admin/main.css' );



                    wp_enqueue_script( 'wrtable_js', PLUGIN_URL . '/assets/js/admin/wrtable.min.js');

                    wp_enqueue_script('main_js', PLUGIN_URL . '/assets/js/admin/main.js',array ('jquery'), '1.0', true );
                    wp_enqueue_script( 'main_js');
                    wp_localize_script( 'main_js', 'parameters',['ajax_url'=> admin_url('admin-ajax.php')]);
                });
            });
        });

	}

	//Assigning the template to each page
	function admin_index(){
		require_once PLUGIN_PATH . 'templates/dashboard.php';
	}

	function group_index(){
		require_once PLUGIN_PATH . 'templates/price-list.php';
	}

	function products(){
		require_once PLUGIN_PATH . 'templates/products.php';
	}


}