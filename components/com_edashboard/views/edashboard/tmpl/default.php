<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');
$lang      = JFactory::getLanguage();
$lang->load('com_edashboard', JPATH_ADMINISTRATOR .'/components/com_edashboard', $lang->getTag());
?>

	                <?php if (!JFactory::getUser()->authorise('acts.view.item', 'com_edashboard')) 
    { ?>
<div class="nothing alert alert-warning"><?php echo JText::_('COM_EDASHBOARD_DO_NOT_ACESS_CATEGORY'); ?></div>
<?php } else { ?>
<div class="edashboard-list-page">
    <div class="table-responsive">
        <table class="table table-striped table-bordered table-hover">
            <thead>
                <tr>
                    <th class="title"><?php echo JText::_('COM_EDASHBOARD_HEADING_NAME'); ?></th>
                    <th class="title"><?php echo JText::_('COM_EDASHBOARD_HEADING_DOCUMENT_NUMBER'); ?></th>
                    <th class="title"><?php echo JText::_('COM_EDASHBOARD_HEADING_DOCUMENT_DATE'); ?></th>
                    <th class="title"><?php echo JText::_('COM_EDASHBOARD_HEADING_PUBLISH_DATE'); ?></th>
                    <th class="title"><?php echo JText::_('COM_EDASHBOARD_HEADING_SUSPEND_DATE'); ?></th>
                </tr>
            </thead>

            <tbody>
            	<?php if ($this->edashboards) { ?>
                <tr>
    				<td class="hidden-phone"><?php echo $this->edashboards->name; ?></td>
    				<td class="hidden-phone"><?php echo $this->edashboards->document_number; ?></td>
				    <td class="hidden-phone"><?php echo $this->edashboards->document_date; ?></td>
			        <td class="hidden-phone"><?php echo $this->edashboards->publish_up; ?></td>
			        <td class="hidden-phone"><?php echo $this->edashboards->publish_down; ?></td>
				</tr>
				<?php } ?>
            </tbody>
        </table>
    </div>
	
	<div class="edashboard-items">
		<h1 class="componentheading"><?php echo JText::_('COM_EDASHBOARD_ATTACHMENTS'); ?></h1>
		<?php if (!JFactory::getUser()->authorise('acts.download.itemfiles', 'com_edashboard')) 
    { ?>
<div class="nothing alert alert-warning"><?php echo JText::_('COM_EDASHBOARD_DO_NOT_ACESS_ATTACHMENTS'); ?></div>
<?php } else { ?>
		<div class="table-responsive">
			<?php 
							if (count($this->attachments))
							{ ?>
        	<table class="table table-striped table-bordered table-hover">
        		<thead>
	                <tr>
	                    <th class="title"><?php echo JText::_('COM_EDASHBOARD_ATTACHMENTS_HEADING_NAME'); ?></th>
	                    <th class="title"><?php echo JText::_('COM_EDASHBOARD_ATTACHMENTS_HEADING_SIZE'); ?></th>
	                </tr>
	            </thead>
	             <tbody>
<?php 
								foreach ($this->attachments as $attachment)
								{
									$head = array_change_key_case(get_headers(JURI::base() . 'edashboard_uploads/'.$attachment->file, TRUE));
									$filesize = $head['content-length'];
						?>
							<tr>
								<td><a class="hasTooltip" download title="" href="edashboard_uploads/<?php echo $attachment->file; ?>"/><i class="icon-large icon-download"></i><?php echo $attachment->name; ?></a></td>
								<td><?php echo $filesize; ?></td>
							</tr>
						

<?php 
								}  ?>
	                	
					
	            </tbody>
				
			</table>
			<?php 
								} 
							}
							else 
							{
						?>
							<div class="nothing alert alert-warning"><?php echo JText::_('COM_EDASHBOARD_ATTACHMENT_NOT_FOUND'); ?></div>
						<?php 
							}
						?>
    	</div>	
    	    <?php
	
    } ?>
	</div>
	
	<?php if (count($this->attachments)) { ?>
		<div class="pagination">
			<?php echo $this->pagination->getListFooter(); ?>
		</div>
	<?php } ?>	
</div>
    <?php
	
    } ?>