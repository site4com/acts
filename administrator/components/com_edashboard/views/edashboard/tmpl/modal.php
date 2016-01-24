<?php

defined('_JEXEC') or die;

// Include the component HTML helpers.
JHtml::addIncludePath(JPATH_COMPONENT.'/helpers/html');

JHtml::_('bootstrap.tooltip');
JHtml::_('behavior.multiselect');
JHtml::_('formbehavior.chosen', 'select');

$app		= JFactory::getApplication();
$user		= JFactory::getUser();
$userId		= $user->get('id');
$listOrder	= $this->escape($this->state->get('list.ordering'));
$listDirn	= $this->escape($this->state->get('list.direction'));
$archived	= $this->state->get('filter.published') == 2 ? true : false;
$trashed	= $this->state->get('filter.published') == -2 ? true : false;
$canOrder	= $user->authorise('core.edit.state', 'com_edashboard.category');
$saveOrder	= $listOrder == 'a.ordering';

$function  = $app->input->getCmd('function', 'jSelectItem');

if ($saveOrder)
{
	$saveOrderingUrl = 'index.php?option=com_edashboard&task=edashboard.saveOrderAjax&tmpl=component';
	JHtml::_('sortablelist.sortable', 'articleList', 'adminForm', strtolower($listDirn), $saveOrderingUrl);
}
$sortFields = $this->getSortFields();
$assoc		= JLanguageAssociations::isEnabled();
?>
<script type="text/javascript">
	Joomla.orderTable = function()
	{
		table = document.getElementById("sortTable");
		direction = document.getElementById("directionTable");
		order = table.options[table.selectedIndex].value;
		if (order != '<?php echo $listOrder; ?>')
		{
			dirn = 'asc';
		}
		else
		{
			dirn = direction.options[direction.selectedIndex].value;
		}
		Joomla.tableOrdering(order, dirn, '');
	}
</script>
<form action="<?php echo JRoute::_('index.php?option=com_edashboard&view=edashboard'); ?>" method="post" name="adminForm" id="adminForm">
<?php if (!empty( $this->sidebar)) : ?>
<?php else : ?>
	<div id="j-main-container">
<?php endif;?>
		<div id="filter-bar" class="btn-toolbar">
			
		</div>
		<div class="clearfix"> </div>
		<table class="table table-striped" id="articleList">
			<thead>
				<tr>
					<th width="1%" class="nowrap center hidden-phone">
						<?php echo JHtml::_('grid.sort', '<i class="icon-menu-2"></i>', 'a.ordering', $listDirn, $listOrder, null, 'asc', 'JGRID_HEADING_ORDERING'); ?>
					</th>
					<th width="1%" class="hidden-phone">
						<?php echo JHtml::_('grid.checkall'); ?>
					</th>
					<th width="5%" class="nowrap center">
						<?php echo JHtml::_('grid.sort', 'JSTATUS', 'a.published', $listDirn, $listOrder); ?>
					</th>
					<th width="5%" class="title">
						<?php echo JHtml::_('grid.sort', 'JGLOBAL_TITLE', 'a.name', $listDirn, $listOrder); ?>
					</th>
                    <th width="10%" class="nowrap hidden-phone">
                        <?php echo JHtml::_('grid.sort', 'COM_EDASHBOARD_HEADING_DOCUMENT_NUMBER', 'a.document_number', $listDirn, $listOrder); ?>
                    </th>
                    <th width="10%" class="nowrap hidden-phone">
                        <?php echo JHtml::_('grid.sort', 'COM_EDASHBOARD_HEADING_OFFICIAL_NUMBER', 'a.official_number', $listDirn, $listOrder); ?>
                    </th>
                    <th width="10%" class="nowrap hidden-phone">
                        <?php echo JHtml::_('grid.sort', 'COM_EDASHBOARD_HEADING_DOCUMENT_DATE', 'a.document_date', $listDirn, $listOrder); ?>
                    </th>
                    <th width="10%" class="nowrap hidden-phone">
                        <?php echo JHtml::_('grid.sort', 'COM_EDASHBOARD_HEADING_PUBLISH_DATE', 'a.publish_up', $listDirn, $listOrder); ?>
                    </th>
                    <th width="10%" class="nowrap hidden-phone">
                        <?php echo JHtml::_('grid.sort', 'COM_EDASHBOARD_HEADING_SUSPEND_DATE', 'a.publish_down', $listDirn, $listOrder); ?>
                    </th>
					<th width="5%" class="nowrap hidden-phone">
						<?php echo JHtml::_('grid.sort', 'JGRID_HEADING_ACCESS', 'a.access', $listDirn, $listOrder); ?>
					</th>
					<?php if ($assoc) : ?>
					<th width="5%" class="nowrap hidden-phone">
						<?php echo JHtml::_('grid.sort', 'COM_EDASHBOARD_HEADING_ASSOCIATION', 'association', $listDirn, $listOrder); ?>
					</th>
					<?php endif;?>
					<th width="5%" class="nowrap hidden-phone">
						<?php echo JHtml::_('grid.sort', 'JGRID_HEADING_LANGUAGE', 'a.language', $listDirn, $listOrder); ?>
					</th>
					<th width="1%" class="nowrap center hidden-phone">
						<?php echo JHtml::_('grid.sort', 'JGRID_HEADING_ID', 'a.id', $listDirn, $listOrder); ?>
					</th>
				</tr>
			</thead>
			<tfoot>
				<tr>
					<td colspan="11">
						<?php echo $this->pagination->getListFooter(); ?>
					</td>
				</tr>
			</tfoot>
			<tbody>
			<?php foreach ($this->items as $i => $item) :
				$ordering   = ($listOrder == 'a.ordering');
				$canCreate  = $user->authorise('core.create',     'com_edashboard.category.' . $item->catid);
				// ABP: TODO: needs some more love from an helper... canEdit should take into account pub dates and special user permissions
				$canEdit    = $user->authorise('core.edit',       'com_edashboard.category.' . $item->catid);
				$canCheckin = $user->authorise('core.manage',     'com_checkin') || $item->checked_out == $user->get('id') || $item->checked_out == 0;
				$canChange  = $user->authorise('core.edit.state', 'com_edashboard.category.' . $item->catid) && $canCheckin;
				?>
				<tr class="row<?php echo $i % 2; ?>" sortable-group-id="<?php echo $item->catid?>">
					<td class="order nowrap center hidden-phone">
						<?php
						$iconClass = '';
						if (!$canChange)
						{
							$iconClass = ' inactive';
						}
						elseif (!$saveOrder)
						{
							$iconClass = ' inactive tip-top hasTooltip" title="' . JHtml::tooltipText('JORDERINGDISABLED');
						}
						?>
						<span class="sortable-handler<?php echo $iconClass ?>">
							<i class="icon-menu"></i>
						</span>
						<?php if ($canChange && $saveOrder) : ?>
							<input type="text" style="display:none" name="order[]" size="5" value="<?php echo $item->ordering;?>" class="width-20 text-area-order" />
						<?php endif; ?>
					</td>
					<td class="center hidden-phone">
						<?php echo JHtml::_('grid.id', $i, $item->id); ?>
					</td>
					<td class="center">
						<div class="btn-group">
							<?php echo JHtml::_('jgrid.published', $item->published, $i, 'edashboard.', $canChange, 'cb', $item->publish_up, $item->publish_down); ?>
							<?php
							// Create dropdown items
							$action = $archived ? 'unarchive' : 'archive';
							JHtml::_('actionsdropdown.' . $action, 'cb' . $i, 'edashboard');

							$action = $trashed ? 'untrash' : 'trash';
							JHtml::_('actionsdropdown.' . $action, 'cb' . $i, 'edashboard');

							// Render dropdown list
							echo JHtml::_('actionsdropdown.render', $this->escape($item->name));
							?>
						</div>
					</td>
					<td class="has-context">
						<div class="pull-left">
							<?php if ($item->checked_out) : ?>
								<?php echo JHtml::_('jgrid.checkedout', $i, $item->editor, $item->checked_out_time, 'edashboard.', $canCheckin); ?>
							<?php endif; ?>
							<?php if ($canEdit) : ?>
								<a href="javascript:void(0)" onclick="if (window.parent) window.parent.<?php echo $this->escape($function);?>('<?php echo $item->id; ?>', '<?php echo $this->escape(addslashes($item->name)); ?>', '<?php echo $this->escape($item->catid); ?>', null, '', '<?php //echo $this->escape($lang); ?>', null);">
									<?php echo $this->escape($item->name); ?></a>
							<?php else : ?>
									<?php echo $this->escape($item->name); ?>
							<?php endif; ?>
							
						</div>
					</td>
                    <td class="nowrap small hidden-phone">
                        <?php echo $this->escape($item->document_number); ?>
                    </td>
                    <td class="nowrap small hidden-phone">
                        <?php echo $this->escape($item->official_number); ?>
                    </td>
                    <td class="nowrap small hidden-phone">
                        <?php echo JHtml::_('date', $item->document_date, JText::_('DATE_FORMAT_LC3')); ?>
                    </td>
                    <td class="nowrap small hidden-phone">
                        <?php echo JHtml::_('date', $item->publish_up, JText::_('DATE_FORMAT_LC3')); ?>
                    </td>
                    <td class="nowrap small hidden-phone">
                        <?php echo JHtml::_('date', $item->publish_down, JText::_('DATE_FORMAT_LC3')); ?>
                    </td>
					<td class="small hidden-phone">
						<?php echo $this->escape($item->access_level); ?>
					</td>
					<?php if ($assoc) : ?>
					<td class="hidden-phone">
						<?php if ($item->association) : ?>
							<?php echo JHtml::_('edashboard.association', $item->id); ?>
						<?php endif; ?>
					</td>
					<?php endif;?>
					<td class="small hidden-phone">
						<?php if ($item->language == '*'):?>
							<?php echo JText::alt('JALL', 'language'); ?>
						<?php else:?>
							<?php echo $item->language_title ? $this->escape($item->language_title) : JText::_('JUNDEFINED'); ?>
						<?php endif;?>
					</td>
					<td class="center hidden-phone">
						<?php echo (int) $item->id; ?>
					</td>
				</tr>
				<?php endforeach; ?>
			</tbody>
		</table>

		<input type="hidden" name="task" value="" />
		<input type="hidden" name="boxchecked" value="0" />
		<input type="hidden" name="filter_order" value="<?php echo $listOrder; ?>" />
		<input type="hidden" name="filter_order_Dir" value="<?php echo $listDirn; ?>" />
		<?php echo JHtml::_('form.token'); ?>
	</div>
</form>
