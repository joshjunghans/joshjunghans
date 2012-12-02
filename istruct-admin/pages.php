<?php include( 'admin.class.php' ); ?>
<?php $admin->page_head(); ?>
<body class="admin">
	<?php $admin->admin_top_bar(); ?>

	<div id="content">

	<?php

	global $user;

	$action = ( isset( $_GET['action'] ) && !empty( $_GET['action'] ) ) ? $_GET['action'] : 'list';

	switch( $action ) {

		case 'new':
			?>
			<form method="post" action="func/process.php?type=page&action=add" id="new_page" class="boxed-out">
				<h4>Create a Page: <small class="results float-right"></small></h4>
				<ul>
					<li>
						<label for="Page_Title">Page Title:</label>
						<input type="text" name="Page_Title" id="Page_Title" />
					</li>
					<li>
						<label for="Page_Slug">Page URL:</label>
						<input type="text" name="Page_Slug" id="Page_Slug" />
					</li>
					<li>
						<textarea class="editor" name="Page_Content" id="Page_Content"></textarea>
					</li>
					<li>
						<input type="submit" class="small button" value="Save Page" />
					</li>
				</ul>
				<input type="hidden" name="Page_Author" value="<?php echo $user->User_ID; ?>" />					
			</form>			
			<?php			
		break;
		case 'edit':

			$q = new Query();

			if( !isset( $_GET['p_id'] ) ) {
				$result = $q->get( 'istruct_pages', array() );
				
				if( !$result ) {
					echo '<p>No pages found. Click <a href="pages.php?action=new">here</a> to get started.</p>';
				} else {
					var_dump( $result );
				}

			} else {
				$result = $q->get( 'istruct_pages', array(), 'Page_ID=' . $_GET['p_id'] );

				if( !$result ) {
					echo '<p>No pages found. Click <a href="pages.php?action=new">here</a> to get started.</p>';
				} else {
			?>
			<form method="post" action="func/process.php?type=page&action=update&id=<?php echo $result->Page_ID; ?>" id="edit_page" class="boxed-out">
				<h4>Edit Page: <?php echo $result->Page_Title; ?><small class="results float-right"></small></h4>
				<ul>
					<li>
						<label for="Page_Title">Page Title:</label>
						<input type="text" name="Page_Title" id="Page_Title" value="<?php echo $result->Page_Title; ?>" />
					</li>
					<li>
						<label for="Page_Slug">Page URL:</label>
						<input type="text" name="Page_Slug" id="Page_Slug" value="<?php echo $result->Page_Slug; ?>" />
					</li>
					<li>
						<textarea class="editor" name="Page_Content" id="Page_Content"><?php echo $result->Page_Content; ?></textarea>
					</li>
					<li>
						<input type="submit" class="small button" value="Update Page" />
					</li>
				</ul>
			</form>			
			<?php			
				}
			}

		break;
		case 'list':

			$q = new Query;
			$result = $q->get( 'istruct_pages', array(), null, 'Page_Date', 'DESC' );

			if( !$result ) {
				echo '<p>You have no pages yet. Click <a href="pages.php?action=new">here</a> to get started.</p>';
			} else {
				$out  = '<div class="boxed-out">'."\n";
				$out .= '<h4>Pages:</h4>'."\n";
				$out .= '<div>'."\n";
				$out .= '<table border="0" cellpadding="0" cellspacing="0">'."\n";
				$out .= '<tr>'."\n";
				$out .= '<th class="text-left">ID</th>'."\n";
				$out .= '<th class="text-left">Slug</th>'."\n";
				$out .= '<th class="text-left">Date</th>'."\n";
				$out .= '<th class="text-left">Type</th>'."\n";
				$out .= '<th class="text-left">Category</th>'."\n";
				$out .= '<th class="text-right">Admin</th>'."\n";
				$out .= '</tr>'."\n";

				for( $i = 0; $i < count( $result ); $i++ ) {
					$edit_link = 'pages.php?action=edit&p_id=' . $result[$i]->Page_ID;
					$out .= '<tr>'."\n";
					$out .= '<td>' . $result[$i]->Page_ID . '</td>'."\n";
					$out .= '<td>' . $result[$i]->Page_Slug . '</td>'."\n";
					$out .= '<td>' . $result[$i]->Page_Date . '</td>'."\n";
					$out .= '<td>' . $result[$i]->Page_Type . '</td>'."\n";
					$out .= '<td>' . $result[$i]->Page_Category . '</td>'."\n";
					$out .= '<td class="text-right"><a href="pages.php?action=edit&p_id='. $result[$i]->Page_ID .'">Edit</a></td>'."\n";
					$out .= '</tr>'."\n";
				}

				$out .= '</table>'."\n";
				$out .= '</div>'."\n";
				$out .= '</div>'."\n";

				echo $out;
			}
		break;
	}

	?>
	</div>

</body>
</html>