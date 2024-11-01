<?php



/*

Plugin Name: WP Beautiful Charts

Plugin URI: 

Version: 1.26

Description: Create beautiful Charts for your webiste or blog

Author: InfoD74

Author URI: https://www.info-d-74.com/en/shop/

Network: false

Text Domain: wp-beautiful-charts

Domain Path: 

*/







register_activation_hook( __FILE__, 'wp_beautiful_charts_install' );



register_uninstall_hook(__FILE__, 'wp_beautiful_charts_desinstall');







function wp_beautiful_charts_install() {







	global $wpdb;







	$graphs_table = $wpdb->prefix . "wp_beautiful_charts";



	$graphs_data_table = $wpdb->prefix . "wp_beautiful_charts_data";







	require_once(ABSPATH . 'wp-admin/includes/upgrade.php');







	$sql = "



        CREATE TABLE `".$graphs_table."` (



          id int(11) NOT NULL AUTO_INCREMENT,          



          name varchar(50) NOT NULL,



          width int(11) NOT NULL,



          height int(11) NOT NULL,



          type varchar(20) NOT NULL,



          text_color varchar(30) NOT NULL,



          text_size varchar(10) NOT NULL,



          PRIMARY KEY  (id)



        ) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;



    ";







    dbDelta($sql);







    $sql = "



        CREATE TABLE `".$graphs_data_table."` (



          id int(11) NOT NULL AUTO_INCREMENT,          



          name varchar(50) NOT NULL,



          `values` text NOT NULL,



          color varchar(30) NOT NULL,



          id_graph int(11),



          PRIMARY KEY (id)



        ) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;



    ";



    



    dbDelta($sql);



}







function wp_beautiful_charts_desinstall() {







	global $wpdb;







	$graphs_table = $wpdb->prefix . "wp_beautiful_charts";



	$graphs_data_table = $wpdb->prefix . "wp_beautiful_charts_data";







	//suppression des tables



	$sql = "DROP TABLE ".$graphs_table.";";



	$wpdb->query($sql);







    $sql = "DROP TABLE ".$graphs_data_table.";";   



	$wpdb->query($sql);



}







add_action( 'admin_menu', 'register_wp_beautiful_charts_menu' );



function register_wp_beautiful_charts_menu() {



	add_menu_page('WP Beautiful Charts', 'WP Beautiful Charts', 'edit_pages', 'wp_beautiful_charts', 'wp_beautiful_charts', plugins_url( 'wp-beautiful-charts/images/icon.png' ), 36);



}







add_action('admin_print_styles', 'wp_beautiful_charts_css' );



function wp_beautiful_charts_css() {



    wp_enqueue_style( 'WPBeautifulChartsStylesheet', plugins_url('css/admin.css', __FILE__) );



}



function wp_beautiful_charts() {



	global $wpdb;



	$graphs_table = $wpdb->prefix . "wp_beautiful_charts";



	$graphs_data_table = $wpdb->prefix . "wp_beautiful_charts_data";





	if(current_user_can('edit_pages'))

	{



		if(isset($_GET['task']))

		{



			switch($_GET['task'])

			{



				case 'new':

				case 'edit':



					if(sizeof($_POST))

					{



						$query = "REPLACE INTO ".$graphs_table." (`id`, `name`, `width`, `height`, `type`, `text_size`, `text_color`)



						VALUES (%d, %s, %d, %d, %s, %d, %s)";



						$query = $wpdb->prepare( $query, $_POST['id'], sanitize_text_field(stripslashes_deep($_POST['name'])), $_POST['width'], $_POST['height'], sanitize_text_field(stripslashes_deep($_POST['type'])), $_POST['text_size'], sanitize_text_field(stripslashes_deep($_POST['text_color'])) );



						$wpdb->query( $query );







						//on affiche tous les graphs



						$charts = $wpdb->get_results("SELECT * FROM ".$graphs_table." ORDER BY name");



						include(plugin_dir_path( __FILE__ ) . 'views/graphs.php');







					}

					else

					{



						//édition d'un graph existant ?



						if(is_numeric($_GET['id']))



						{



							$q = "SELECT * FROM ".$graphs_table." WHERE id = %d";



							$query = $wpdb->prepare( $q, $_GET['id']);



							$chart = $wpdb->get_row( $query );



						}







						if(empty($chart))



							$chart = (object)'';







						include(plugin_dir_path( __FILE__ ) . 'views/edit.php');



					}



				break;



				case 'manage':



					if(is_numeric($_GET['id']))

					{



						if(sizeof($_POST))

						{

							//on prépare les données à enregistrer



							$data = [];



							foreach ($_POST['name'] as $key => $value) {



								$data[$value] = array();



								foreach ($_POST['data'][$key] as $values) {



									$data[$value][] = $values;



								}



							}







							//on vide les données précédentes



							$q = "DELETE FROM ".$graphs_data_table." WHERE id_graph = %d";



							$query = $wpdb->prepare( $q, $_POST['id']);



							$wpdb->query( $query );







							//on insére chaque jeu de données



							$i = 0;



							foreach ($data as $key => $value) {							



								$values = array();



								$q = "INSERT INTO ".$graphs_data_table." (`name`, `values`, `color`, `id_graph`) VALUES (%s, %s, %s, %d)";						



								$query = $wpdb->prepare( $q, $key, serialize($value), $_POST['color'][$i], $_POST['id']);



								$wpdb->query( $query );



								$i++;



							}



							echo '<h3>Chart data saved !</h3>';



						}







						$q = "SELECT * FROM ".$graphs_table." WHERE id = %d";



						$query = $wpdb->prepare( $q, $_GET['id']);



						$chart = $wpdb->get_row( $query );



						if($chart)

						{



							$q = "SELECT * FROM ".$graphs_data_table." WHERE id_graph = %d";



							$query = $wpdb->prepare( $q, $_GET['id']);



							$data = $wpdb->get_results( $query );



							foreach($data as $key => $values)



								$data[$key]->values = unserialize($data[$key]->values);



							$chart->data = $data;







							include(plugin_dir_path( __FILE__ ) . 'views/manage.php');

						}					



					}



				break;



				case 'remove':



					if(is_numeric($_GET['id']))

					{



						//on supprime les données et le graph



						$q = "DELETE FROM ".$graphs_data_table." WHERE id_graph = %d";



						$query = $wpdb->prepare( $q, $_GET['id']);



						$wpdb->query( $query );







						$q = "DELETE FROM ".$graphs_table." WHERE id = %d";



						$query = $wpdb->prepare( $q, $_GET['id']);



						$wpdb->query( $query );



					}



					//on affiche tous les graphs



					$charts = $wpdb->get_results("SELECT * FROM ".$graphs_table." ORDER BY name");



					include(plugin_dir_path( __FILE__ ) . 'views/graphs.php');



				break;



			}

		}

		else

		{



			if(!is_numeric($_GET['id']))

			{

				//on affiche tous les graphs



				$charts = $wpdb->get_results("SELECT * FROM ".$graphs_table." ORDER BY name");



				include(plugin_dir_path( __FILE__ ) . 'views/graphs.php');

			}



		}



	}



}







add_shortcode('wp-beautiful-chart', 'display_wp_beautiful_chart');



function display_wp_beautiful_chart($atts) {



	if(is_numeric($atts['id']))

	{



		global $wpdb;



		$graphs_table = $wpdb->prefix . "wp_beautiful_charts";



		$graphs_data_table = $wpdb->prefix . "wp_beautiful_charts_data";







		$q = "SELECT * FROM ".$graphs_table." WHERE id = %d";



		$query = $wpdb->prepare( $q, $atts['id']);



		$chart = $wpdb->get_row( $query );



		if($chart)

		{



			$q = "SELECT * FROM ".$graphs_data_table." WHERE id_graph = %d";



			$query = $wpdb->prepare( $q, $atts['id'] );



			$data = $wpdb->get_results( $query );



			foreach($data as $key => $values)



				$data[$key]->values = unserialize($data[$key]->values);



			$chart->data = $data;



			wp_enqueue_script( 'jquery' );



			wp_enqueue_script( 'jquery-ui-core' );



			wp_enqueue_script( 'jquery-ui-tooltip' );



			wp_enqueue_script( 'wp-beautiful-charts-scripts', plugins_url( 'js/Chart.min.js', __FILE__ ));



			wp_enqueue_script( 'wp-beautiful-charts-front-js', plugins_url( 'js/front.js', __FILE__ ));



			wp_enqueue_style('jquery-ui-css', 'https://code.jquery.com/ui/1.9.1/themes/smoothness/jquery-ui.css');



			ob_start();



			if($atts['show_title'] == true)



				echo '<h3>'.esc_html($chart->name).'</h3>';



			include(plugin_dir_path( __FILE__ ) . 'views/templates/'.$chart->type);



			$content = ob_get_clean();



			return $content;



		}

		else



			return 'Chart ID '.$atts['id'].' not found !';	



	}



}



?>