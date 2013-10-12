
	<main id="main">
		<div class="row">
			<div class="large-12 small-12">
				<p class="center">
					<img src="./img/admin/user.png" alt="Users" /><br />
					<?php echo "".ucwords($User->getUsername()).", "; echo $Lang->getAdminText('generalAccountType'); echo " '".$User->getRankText()."'"; ?>
				</p>
			</div>

			<div class="large-9 small-9 columns">
				<h4><?php echo $Lang->getAdminText('usersBodyTitle1'); ?></h4>
				<table class="large-12">
					<tbody>
						<?php
						for( $i = 0 ; $i < count($usersList) ; $i++ )
						{
							if( $User->getRank() == 3 ) {
						?>
							<tr>
								<td class="center large-1 columns"><?php echo (int)$usersList[$i]['id']; ?></td>
								<td class="center large-4 columns"><a href="#" data-dropdown="dropFeature1"><?php echo (String)ucwords($usersList[$i]['username']); ?></a></td>
								<td class="smaller center large-3 columns"><?php if( (String)$usersList[$i]['token'] == $usersList[$i]['id'] ) echo "Not activated"; else echo (String)$usersList[$i]['token']; ?></td>
								<td class="smaller center large-2 columns"><?php if( (int)$usersList[$i]['rank'] == 3 ) echo "<span class='bold'>Super Admin</span>"; else if( (int)$usersList[$i]['rank'] == 2 ) echo "<span class='bold'>Admin</span>"; else echo "Member"; ?></td>
								<td class="smaller center large-2 columns"><a href="#" data-dropdown="dropFeature2">Reset!</a></td>
							</tr>
						<?php
							} else {
						?>
							<tr>
								<td class="center large-1 columns"><?php echo (int)$usersList[$i]['id']; ?></td>
								<td class="center large-5 columns"><a href="#" data-dropdown="dropFeature1"><?php echo (String)ucwords($usersList[$i]['username']); ?></a></td>
								<td class="smaller center large-3 columns"><?php if( (String)$usersList[$i]['token'] == $usersList[$i]['id']) echo "Not activated"; else echo "Activated"; ?></td>
								<td class="smaller center large-2 columns"><?php if( (int)$usersList[$i]['rank'] == 3 ) echo "<span class='bold'>Super Admin</span>"; else if( (int)$usersList[$i]['rank'] == 2 ) echo "<span class='bold'>Admin</span>"; else echo "Member"; ?></td>
							</tr>
						<?php
							}
						}
						if( count($usersList) == 0 OR $usersList == 0 )
						{
							echo "<tr><td colspan='3'><span class='bold'>Oups !</span><br />Vous êtes allé trop loin, cette partie du classement n'existe pas.</td></tr>";
						}
						?>
					</tbody>
					<tfoot>
						<?php
						if( $User->getRank() == 3 ) {
						?>
						<tr>
							<th class="center large-1 columns">ID</th>
							<th class="center large-4 columns">Username</th>
							<th class="smaller center large-3 columns">Private Token</th>
							<th class="smaller center large-2 columns">Rank</th>
							<th class="smaller center large-2 columns">Password</th>
						</tr>
						<?php
							} else {
						?>
						<tr>
							<th class="center large-1 columns">ID</th>
							<th class="center large-5 columns">Username</th>
							<th class="smaller center large-3 columns">Private Token</th>
							<th class="smaller center large-2 columns">Rank</th>
						</tr>
						<?php } ?>
					</tfoot>
				</table>
				
				<dl class="sub-nav" style="width: 90%; margin: auto;">	
					<dt>Pagination : </dt>
					
					<?php
						$countPlayer = $User->countUsers( 0 );
						if( $countPlayer > $size )
						{
							?>
								<dd <?php if( !isset($_GET['p']) ) echo 'class="active"'; ?>><a href="users.php">1</a></dd>
							<?php
							$countPage = ceil($countPlayer / $size);
							for( $i = 1 ; $i < $countPage ; $i++ )
							{
								?>
								<dd <?php if( isset($_GET['p']) && $_GET['p'] == $i ) echo 'class="active"'; ?>><a href="users.php?p=<?php echo $i; ?>"><?php echo $i+1; ?></a></dd>
								<?php
							}
						}
						else {
							?><dd <?php if( !isset($_GET['p']) ) echo 'class="active"'; ?>><a href="users.php">1</a></dd><?php
						} ?>
				</dl>
			</div>
			
			<ul id="dropFeature1" class="f-dropdown content" data-dropdown-content>
				<p><span class="bold">User profil</span><br /><br />Feature to come<br /><span class="italic">Medium priority</span></p>
			</ul>
			<ul id="dropFeature2" class="f-dropdown content" data-dropdown-content>
				<p><span class="bold">User password</span><br /><br />Feature to come<br /><span class="italic">Low priority</span></p>
			</ul>

			<div class="large-3 small-3 columns">
				<h4><?php echo $Lang->getAdminText('usersBodyTitle2'); ?></h4>
				
				<div class="large-12">
					<p class="center">
						<?php echo $User->countUsers( 0 ); ?> users
					</p>
				</div>
				<div class="large-4 small-4 columns">
					<p class="center">
						<?php echo $User->countUsers( 0, 1 ); ?><br />
						<?php echo $User->countUsers( 0, 2 ); ?><br />
						<?php echo $User->countUsers( 0, 3 ); ?>
					</p>
				</div>
				<div class="large-8 small-8 columns">
					<p>
						Member<br />
						Admin<br />
						Super Admin
					</p>
				</div>
			</div>
		</div>
	</main>
	
	