<?php

/*
	File: admin.class.php
	Desc: Builds the Admin necessities
	Uses: DBQuery (class)
*/

class Admin {

	public $user;
	
	public function __construct() {
	/**
	 * Description: Checks if a user is logged in, if so then the needed files
	 *              are brought in and $this->user is filled with their values
	 *              (ex. $this->user->{db_column} )
	 *
	 * @param  none
	 * @return bool
	 * 
	 */

		session_start();

		if( !$this->admin_user_logged_in() ) {
			header("Location:login.php");
		} else {

			require_once '../istruct-classes/istruct.config.php';
			require_once ISTRUCT_DB_CLASS;

			try {
				$this->set_admin_user();
				return true;
			} catch( Exception $e ) {
				/* ERROR REPORT HERE */
				return $e->getMessage();
			}

		}

	}

	public function admin_user_logged_in() {
	/**
	 * Description: Checks if a user is logged in
	 *
	 * @param  none
	 * @return bool
	 * 
	 */

		if( !isset( $_SESSION ) || !array_key_exists( 'istruct_user', $_SESSION ) || empty( $_SESSION['istruct_user'] ) ) {
			return false;
		} else {
			return true;
		}

	}

	private function set_admin_user() {
	/**
	 * Description: Performs a db fetch for the current admin user
	 *              and $this->user is filled with their values
	 *              (ex. $this->user->{db_column} )
	 *
	 * @param  none
	 * @return bool
	 * 
	 */

		$params = array(
			'tbl'    => 'istruct_users',
			'fields' => array( 'User_ID','User_Email','User_First','User_Last','User_Role','Last_Logged_In' ),
			'where'  => 'User_Email=' . $_SESSION['istruct_user'],
		);

		extract( $params );

		$q = new Query;
		$user_record = $q->get( $tbl, $fields, $where );

		if( !$user_record ) {
			return false;
		} else {
			global $user;
			$user = $user_record;
			$user->User_Full = $user->User_First . ' ' . $user->User_Last;
			$this->user = $user;
		}

	}

	public function user_pages() {
	/**
	 * Description: Performs a db fetch for the current admin user's
	 *              pages and returns the results
	 *
	 * @param  none
	 * @return bool
	 * 
	 */

		global $user;

		$params = array(
			'tbl'    => 'istruct_pages',
			'fields' => array(),
			'where'  => 'Page_Author=' . $user->User_ID
		);

		extract( $params );

		$q = new Query;
		$user_pages = $q->get( $tbl, $fields, $where );

		if( !$user_pages ) {
			return false;
		} else {
			return $user_pages;
		}

	}

	public function page_head() {
	/**
	 * Description: Outputs the HTML <head> for the admin pages
	 *
	 * @param  none
	 * @return bool
	 * 
	 */

		?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head profile="http://gmpg.org/xfn/11">
	<title>istruct Admin</title> 
	<meta http-equiv="content-type" content="text/html; charset=UTF-8" />
	<meta http-equiv="content-language" content="en-US" />
	<link id="template-style" href="style.css" media="all" rel="stylesheet" />
	<script type="text/javascript" id="jquery" src="<?php echo ISTRUCT_JQUERY; ?>"></script>
	<script type="text/javascript" id="istruct-js-ui" src="js/istruct.ui.js"></script>
	<script type="text/javascript" src="ckeditor/ckeditor.js"></script>
	<script type="text/javascript" src="ckeditor/adapters/jquery.js"></script>
	<script type="text/javascript" id="misc-scripts" src="js/scripts.js"></script>
	<script type="text/javascript" id="save-forms" src="js/save.js"></script>
	<script type="text/javascript" id="user-info" src="js/user_info.js"></script>
</head>
		<?php
	}

	public function admin_top_bar() {
	/**
	 * Description: Outputs the top Admin Menu bar
	 *
	 * @param  none
	 * @return bool
	 * 
	 */

		global $user;
		?>
		<div id="header_wrap">
			<div id="header">
				<img id="logo" src="images/istruct-logo_86x25.png" title="istruct Admin" alt="istruct" />

				<div id="user_info">
					<ul>
						<li><a href="pages.php" title="Pages"><img src="images/admin_menu_pages.png" alt="Pages" title="Pages" /></a></li>
						<li><a href="site_settings.php" title="Site Settings"><img src="images/admin_menu_site.png" alt="Site" title="Site Settings" /></a></li>
						<li>
							<a href="#" class="toggle" title="My Profile">My Profile</a>
							<ul>
								<li>Name: <?php echo $user->User_Full; ?></li>
								<li>Email: <?php echo $user->User_Email; ?></li>
								<li>Role: <?php echo ucfirst( $user->User_Role ); ?></li>
								<li class="logout text-right"><a href="user_profile.php">Edit Profile</a><a href="logout.php">Logout</a></li>
							</ul>
						</li>
					</ul>
				</div>

			</div><!-- #header -->
		</div><!-- #header_wrap -->
		<?php
	}

	public function index_content() {
	/**
	 * Description: Outputs the content for the main admin page (admin/index.php)
	 *
	 * @param  none
	 * @return bool
	 * 
	 */

		var_dump( $this->user );

	}

	public function user_profile_content() {
	/**
	 * Description: Outputs the content for the current admin user's profile page
	 * @param  none
	 * @return bool
	 * 
	 */

		global $user;
		global $user_roles;
		$the_pages = $this->user_pages();
		?>
			<h2>Your Profile:</h2>

			<div class="inner">

				<div id="left">

					<div class="boxed-out" id="your_pages">
						<h4>Your Pages: <small class="results float-right"></small></h4>
						<div>
						
						<?php
							if( !$the_pages ) {
								echo '<p>You have no pages yet. Click <a href="pages.php?action=new">here</a> to get started.</p>';
							} else {

								$out  = '<table border="0" cellpadding="0" cellspacing="0">'."\n";
								$out .= '<tr>'."\n";
								$out .= '<th class="text-left">ID</th>'."\n";
								$out .= '<th class="text-left">Slug</th>'."\n";
								$out .= '<th class="text-left">Date</th>'."\n";
								$out .= '<th class="text-left">Type</th>'."\n";
								$out .= '<th class="text-left">Category</th>'."\n";
								$out .= '<th class="text-right">Admin</th>'."\n";
								$out .= '</tr>'."\n";

								for( $i = 0; $i < count( $the_pages ); $i++ ) {
									$edit_link = 'pages.php?action=edit&p_id=' . $the_pages[$i]->Page_ID;
									$out .= '<tr>'."\n";
									$out .= '<td>' . $the_pages[$i]->Page_ID . '</td>'."\n";
									$out .= '<td>' . $the_pages[$i]->Page_Slug . '</td>'."\n";
									$out .= '<td>' . $the_pages[$i]->Page_Date . '</td>'."\n";
									$out .= '<td>' . $the_pages[$i]->Page_Type . '</td>'."\n";
									$out .= '<td>' . $the_pages[$i]->Page_Category . '</td>'."\n";
									$out .= '<td class="text-right"><a href="'.$edit_link.'">Edit</a></td>'."\n";
									$out .= '</tr>'."\n";
								}

								$out .= '</table>'."\n";

								echo $out;
							}
						?>
						</div>
						
					</div>

				</div>
				
				<form method="post" action="func/update.php?type=user&user_id=<?php echo $user->User_ID; ?>" id="edit_profile" class="float-right boxed-out">
					<h4>Update Your Profile: <small class="results float-right"></small></h4>
					<ul>
						<li>
							<label for="User_First">First Name:</label>
							<input type="text" name="User_First" id="User_First" value="<?php echo $user->User_First; ?>" />
						</li>
						<li>
							<label for="User_Last">Last Name:</label>
							<input type="text" name="User_Last" id="User_Last" value="<?php echo $user->User_Last; ?>" />
						</li>
						<li>
							<label for="User_Email">Email Address:</label>
							<input type="text" name="User_Email" id="User_Email" value="<?php echo $user->User_Email; ?>" />
						</li>
						<li>
							<label for="User_Role">Role:</label>
							<select name="User_Role" id="User_Role">
							<?php
								$out = '';
								for( $i = 0; $i < count( $user_roles ); $i++ ) {
									$out .= '<option value="' . $user_roles[$i] . '"';

									if( $user_roles[$i] == $user->User_Role ) {
										$out .= ' selected="selected"';
									}

									$out .= '>' . ucfirst( $user_roles[$i] ) . '</option>'."\n";
								}
								echo $out;
							?>
							</select>
						</li>
						<li>
							<input type="submit" class="small button" value="Update Profile" />
						</li>
					</ul>
				</form>
			</div>

			<div class="cb"></div>
			
		<?php
	}

}

$admin = new Admin();
$user = $admin->user;
$user_roles = array( 'admin', 'author', 'moderator', 'developer' );

?>