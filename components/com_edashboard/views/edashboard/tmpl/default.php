<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');

?>

	                <?php if (!JFactory::getUser()->authorise('acts.view.item', 'com_edashboard')) 
    { ?>
<div class="nothing alert alert-warning"><?php echo JText::_('EDASHBOARD_DO_NOT_ACESS_CATEGORY'); ?></div>
<?php } else { ?>
<div class="edashboard-list-page">
    <div class="table-responsive">
        <table class="table table-striped table-bordered table-hover">
            <thead>
                <tr>
                    <th class="title">Name Act</th>
                    <th class="title">Document number</th>
                    <th class="title">Document date</th>
                    <th class="title">Start Publishing</th>
                    <th class="title">End Publishing</th>
                </tr>
            </thead>

            <tbody>
                <tr>
    				<td><a class="hasTooltip" title="" href="/albo-pretorio/1-delibera-1"/><?php echo $this->edashboards->name; ?></a></td>
    				<td class="hidden-phone"><?php echo $this->edashboards->name; ?></td>
				    <td class="hidden-phone"><?php echo $this->edashboards->document_number; ?></td>
			        <td class="hidden-phone"><?php echo $this->edashboards->publish_up; ?></td>
			        <td class="hidden-phone"><?php echo $this->edashboards->publish_down; ?></td>
				</tr>
            </tbody>
        </table>
    </div>
	
	<div class="edashboard-items">
		<h1 class="componentheading">Attachments</h1>
		<?php if (!JFactory::getUser()->authorise('acts.download.itemfiles', 'com_edashboard')) 
    { ?>
<div class="nothing alert alert-warning"><?php echo JText::_('EDASHBOARD_DO_NOT_ACESS_ATTACHMENTS'); ?></div>
<?php } else { ?>
		<div class="table-responsive">
        	<table class="table table-striped table-bordered table-hover">
        		<thead>
	                <tr>
	                    <th class="title">Attachment Name</th>
	                    <th class="title">Dimensions</th>
	                </tr>
	            </thead>
	             <tbody>
<?php 
							if (count($this->attachments))
							{
								foreach ($this->attachments as $attachment)
								{
						?>
							<tr>
								<td><a class="hasTooltip" download title="" href="edashboard_uploads/<?php echo $attachment->file; ?>"/><i class="icon-large icon-download"></i><?php echo $attachment->name; ?></a></td>
								<td><a class="hasTooltip" title="" href="/albo-pretorio/1-delibera-1"/><?php echo $attachment->name; ?></a></td>
							</tr>
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


	                	
					
	            </tbody>
				
			</table>
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