<?php
/*
Plugin Name: DB Cleaner
 */


add_action('wp_ajax_my_action', 'remove_site_tables_for_id');
function remove_site_tables_for_id() {
	global $wpdb;
	$raw_ids = explode(",", $_POST['id'] );
	$ids = array();
	foreach($raw_ids as $id) {
		array_push($ids, intval(trim($id)));
	}
	$dbname = $wpdb->dbname;

	$data = array();
	foreach($ids as $id) {
		$sql = "SELECT TABLE_NAME FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_NAME like '%_\_" . $id . "\__%' and TABLE_SCHEMA = '$dbname'";
		$table_names = $wpdb->get_results($sql);
		foreach($table_names as $key => $row) {
			array_push($data, $row->TABLE_NAME);
			$query = "DROP TABLE IF EXISTS $row->TABLE_NAME";
			$wpdb->query($query);
		}
	}
	echo join(":", $data);
	wp_die();
}

function myplugin_admin_page(){
		?>
	<script>
	function delete_tables() {
		var data = {
			'action': 'my_action',
			'id' : jQuery('#tableids').val()      // We pass php values differently!
	};
		console.log(data);
		jQuery.post(ajaxurl, data, function(response) {
			var rows = response.split(":");
			jQuery("#tables_found").empty();
			for (var i = 0; i < rows.length; i++ ) {
				console.log(rows[i]);
				jQuery("#tables_found").append("<li>" + rows[i] + "</li>");
			}
		});
	}

	</script>
	<div class="wrap">
		<h2>DB Cleaner</h2>
		<input id="tableids" type="text">
		<button onclick="delete_tables()">Delete Tables</button>
	</div>
	<div class="wrap">
		<ul id="tables_found">

		</ul>
	</div>
	<?php
}

function register_pages() {
	add_management_page('DB Cleaner', 'DB Cleaner', 'manage_options','db-cleaner', 'myplugin_admin_page');
}

add_action("admin_menu", "register_pages");
