<?php 
/** 
 * @package INSTANTFBLOGIN::USERS::administrator::components::com_instantfblogin
 * @subpackage views
 * @subpackage users
 * @subpackage tmpl
 * @author Joomla! Extensions Store
 * @copyright (C) 2015 - Joomla! Extensions Store
 * @license GNU/GPLv2 http://www.gnu.org/licenses/gpl-2.0.html 
 */
defined ( '_JEXEC' ) or die ( 'Restricted access' ); 
JHTML::_('behavior.tooltip'); ?>
 
<form action="index.php" method="post" name="adminForm" id="adminForm">
	<table class="headerlist">
		<tr>
			<td class="left">
				<div class="input-prepend">
					<span class="add-on"><span class="icon-filter"></span> <?php echo JText::_('COM_INSTANTFBLOGIN_FILTER' ); ?>:</span>
					<input type="text" name="search" id="search" value="<?php echo htmlspecialchars($this->searchword, ENT_COMPAT, 'UTF-8');?>" class="text_area"/>
				</div>
				<button class="btn btn-primary btn-mini" onclick="this.form.submit();"><?php echo JText::_('COM_INSTANTFBLOGIN_GO' ); ?></button>
				<button class="btn btn-primary btn-mini" onclick="document.getElementById('search').value='';this.form.submit();"><?php echo JText::_('COM_INSTANTFBLOGIN_RESET' ); ?></button>
				
				<div class="clr vspacer"></div>
				<div class="input-prepend active">
					<span class="add-on"><span class="icon-filter"></span> <?php echo JText::_('COM_INSTANTFBLOGIN_FILTER_BY_DATE_FROM' ); ?>:</span>
					<input type="text" name="fromperiod" id="fromPeriod" data-role="calendar" value="<?php echo $this->dates['start'];?>" class="text_area"/>
				</div>
				
				<div class="input-prepend active">
					<span class="add-on"><span class="icon-filter"></span> <?php echo JText::_('COM_INSTANTFBLOGIN_FILTER_BY_DATE_TO' ); ?>:</span>
					<input type="text" name="toperiod" id="toPeriod" data-role="calendar" value="<?php echo $this->dates['to'];?>" class="text_area"/>
				</div>
				<button class="btn btn-primary btn-mini" onclick="document.adminForm.task.value='users.display';this.form.submit();"><?php echo JText::_('COM_INSTANTFBLOGIN_GO' ); ?></button>
				<button class="btn btn-primary btn-mini" onclick="document.getElementById('fromPeriod').value='';document.getElementById('toPeriod').value='';this.form.submit();"><?php echo JText::_('COM_INSTANTFBLOGIN_RESET' ); ?></button>
			</td>
			<td class="right">
				<div class="input-prepend active hidden-phone">
					<span class="add-on"><span class="icon-filter"></span> <?php echo JText::_('COM_INSTANTFBLOGIN_STATE' ); ?></span>
					<?php
						echo $this->lists['gender'];
						echo $this->lists['account_type'];
						echo $this->lists['geo'];
						echo $this->pagination->getLimitBox();
					?>
				</div>
			</td>
		</tr>
	</table>

	<table class="adminlist table table-striped table-hover">
		<thead>
			<tr>
				<th width="3%" class="title">
					<?php echo JText::_('COM_INSTANTFBLOGIN_NUM' ); ?>
				</th>
				<th width="1%" class="title">
					<input type="checkbox" name="toggle" value="" onclick="Joomla.checkAll(this);" />
				</th>
				<th width="5%" class="title hidden-tablet hidden-phone">
					<?php echo JHTML::_('grid.sort', 'COM_INSTANTFBLOGIN_JOOMLA_USERID', 'a.j_uid', @$this->orders['order_Dir'], @$this->orders['order'], 'users.display' ); ?>
				</th>  
				<th width="8%"class="title hidden-phone">
					<?php echo JHTML::_('grid.sort', 'COM_INSTANTFBLOGIN_FB_USERID', 'a.fb_uid', @$this->orders['order_Dir'], @$this->orders['order'], 'users.display' ); ?>
				</th>
				<th width="10%" class="title">
					<?php echo JHTML::_('grid.sort', 'COM_INSTANTFBLOGIN_EMAIL', 'a.first_name', @$this->orders['order_Dir'], @$this->orders['order'], 'users.display' ); ?>
				</th>
				<th width="10%" class="title">
					<?php echo JHTML::_('grid.sort', 'COM_INSTANTFBLOGIN_NAME', 'a.name', @$this->orders['order_Dir'], @$this->orders['order'], 'users.display' ); ?>
				</th>
				<th width="6%" class="title hidden-phone">
					<?php echo JHTML::_('grid.sort', 'COM_INSTANTFBLOGIN_GENDER', 'a.gender', @$this->orders['order_Dir'], @$this->orders['order'], 'users.display' ); ?>
				</th>
				<th width="6%" class="title hidden-phone">
					<?php echo JHTML::_('grid.sort', 'COM_INSTANTFBLOGIN_GEOLOCATION', 'a.geolocation', @$this->orders['order_Dir'], @$this->orders['order'], 'users.display' ); ?>
				</th>
				<th width="5%" class="title hidden-phone">
					<?php echo JHTML::_('grid.sort', 'COM_INSTANTFBLOGIN_REGISTEREDON', 'a.registered_on', @$this->orders['order_Dir'], @$this->orders['order'], 'users.display' ); ?>
				</th>
				<th width="5%" class="title hidden-tablet hidden-phone">
					<?php echo JHTML::_('grid.sort', 'COM_INSTANTFBLOGIN_LASTFB_UPDATE', 'a.last_update', @$this->orders['order_Dir'], @$this->orders['order'], 'users.display' ); ?>
				</th>
				<th width="5%" class="title hidden-tablet hidden-phone" nowrap="nowrap">
					<?php echo JHTML::_('grid.sort', 'COM_INSTANTFBLOGIN_FBVERIFIED', 'a.verified', @$this->orders['order_Dir'], @$this->orders['order'], 'users.display' ); ?>
				</th> 
				<th width="10%" class="title" nowrap="nowrap">
					<?php echo JHTML::_('grid.sort', 'COM_INSTANTFBLOGIN_FBACCOUNT_TYPE', 'a.account_type', @$this->orders['order_Dir'], @$this->orders['order'], 'users.display' ); ?>
				</th>
				<th width="5%" class="title" nowrap="nowrap">
					<?php echo JText::_('COM_INSTANTFBLOGIN_AVATAR'); ?>
				</th>
			</tr>
		</thead>
		<tfoot>
			<tr>
				<td colspan="100%">
					<?php echo $this->pagination->getListFooter(); ?>
				</td>
			</tr>
		</tfoot>
		<tbody>
		<?php
			$k = 0;
			for ($i=0, $n=count( $this->items ); $i < $n; $i++) {
				$row = $this->items[$i]; 
				
				// Read status
				$imgFbVerifiedUser 	= $row->verified ? 'icon-16-tick.png' : 'icon-16-publish_x.png'; 
				$altFbVerifiedUser 	= $row->verified ? JText::_('COM_INSTANTFBLOGIN_FBUSER_VERIFIED' ) : JText::_('COM_INSTANTFBLOGIN_FBUSER_NOTVERIFIED' );
				// Always verified
				if($row->account_type == 'goog') {
					$imgFbVerifiedUser = 'icon-16-tick.png';
					$altFbVerifiedUser = JText::_('COM_INSTANTFBLOGIN_FBUSER_VERIFIED' );
				}
			?>
			<tr class="<?php echo "row$k"; ?>">
				<td align="center">
					<?php echo $i+1+$this->pagination->limitstart;?>
				</td>
				<td align="center">
					<?php echo JHTML::_('grid.id', $i, $row->id ); ?>
				</td>
				<td class="hidden-tablet hidden-phone"> 
					<?php echo $row->j_uid; ?> 
				</td>
				<td class="hidden-phone"> 
					<?php echo $row->fb_uid; ?> 
				</td>
				<td> 
					<?php echo $row->email; ?> 
				</td>
				<td> 
					<?php echo $row->name; ?> 
				</td>
				<td class="hidden-phone"> 
					<?php echo JText::_('COM_INSTANTFBLOGIN_' . strtoupper($row->gender)); ?> 
				</td>
				<td class="hidden-phone"> 
					<?php 
						if($row->geolocation) :
							$code = strtoupper($row->geolocation);
							if (strlen ( $row->geolocation ) > 2 && strpos($row->geolocation, '_')) {
								$spliced = explode ( '_', $row->geolocation );
								$code = strtoupper(substr ( $spliced [1], 0, 2 ));
							}
							echo array_key_exists($code, $this->geoTranslations) ? $this->geoTranslations[$code]['name'] : $row->geolocation; 
						else:
							echo '-';
						endif;
					?> 
				</td>
				<td class="hidden-phone"> 
					<?php 
						// Transform the date string, get date time in UTC from DB
						$dateObject = JFactory::getDate($row->registered_on);
						// Set local time zone
						$dateObject->setTimezone(new DateTimeZone($this->joomlaConfig));
						// Format date with local date time
						echo $dateObject->format('Y-m-d H:i:s', true, false);
					?> 
				</td>
				<td class="hidden-tablet hidden-phone"> 
					<?php echo $row->last_update ? $row->last_update : JText::_('COM_INSTANTFBLOGIN_'); ?> 
				</td>
				<td class="hidden-tablet hidden-phone"> 
					<img src="<?php echo JURI::base(true) . '/components/com_instantfblogin/images/' . $imgFbVerifiedUser; ?>" alt="<?php echo $altFbVerifiedUser?>"/>
				</td>
				<td class="list_icon_<?php echo $row->account_type;?>">
					<span class="social_icon"></span>
					<span>
					<?php 
						echo JText::_('COM_INSTANTFBLOGIN_ACCOUNT_TYPE_' . strtoupper($row->account_type)); 
					?>
					</span>
				</td>
				<td> 
					<img style="height:50px" src="<?php echo $row->picture; ?>" alt="avatar"/>
				</td>
			</tr>
			<?php
				$k = 1 - $k;
				}
			?>
		</tbody>
	</table>

	<input type="hidden" name="option" value="<?php echo $this->option;?>" />
	<input type="hidden" name="task" value="users.display" /> 
	<input type="hidden" name="boxchecked" value="0" /> 
	<input type="hidden" name="filter_order" value="<?php echo $this->orders['order']; ?>" />
	<input type="hidden" name="filter_order_Dir" value="<?php echo $this->orders['order_Dir']; ?>" /> 
</form>