<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');

?>
<?php if (!JFactory::getUser()->authorise('acts.view.itemlist', 'com_edashboard')) { ?>
		<div class="nothing alert alert-warning"><?php echo JText::_('EDASHBOARD_DO_NOT_ACESS_CATEGORY'); ?></div>
<?php } else { ?>
	<form action="<?php echo htmlspecialchars(JUri::getInstance()->toString()); ?>" method="post" name="adminForm" id="adminForm" class="form-inline">
		<div class="edashboard-list-page">
			<?php 
				if ($this->category != null && strtolower($this->category->title) != 'root')
				{
			?>
				<h1 class="componentheading"><?php echo $this->category->title; ?></h1>
			<?php 		
				}	
			?>
			<div class="edashboard-items">
				<?php 
					if (count($this->edashboards))
					{
						foreach ($this->edashboards as $edashboards)
						{
				?>
					<div class="edashboard-item">
						<div class="edashboard-title">
							<h2>
								<a href="<?php echo 'index.php?option=com_edashboard&view=edashboard&show_title=1&edashboard_id=' . $edashboards->id; ?>"><?php echo $edashboards->name; ?></a>
							</h2>
						</div>						
					</div>
				<?php			
						}	
					}
					else 
					{
				?>
					<div class="nothing alert alert-warning"><?php echo JText::_('EDASHBOARD_CATEGORY_NO_RESULT'); ?></div>
				<?php 
					}
				?>
			</div>
			
			<?php if (count($this->edashboards)) { ?>
				<div class="pagination">
					<?php echo $this->pagination->getListFooter(); ?>
				</div>
			<?php } ?>	
		</div>
	</form>
<?php } ?>