<?php
if (isset($_GET['_view'])){
	$_REQUEST['view'] = $_GET['_view'];
}
?>
<div id="thethefly">
  <div class="wrap">
    <h2 id="thethefly-panel-title"> <span id="thethefly-panel-icon" class="icon48">&nbsp;</span> TheThe Fly Image Slider</h2>
    <div id="thethefly-panel-frame">
      <div id="menu-management-liquid">
        <div id="menu-management"> 
          <!-- tabs -->
          <div class="nav-tabs-wrapper">
            <div class="nav-tabs">
              <?php
$view = getCurrentViewIndexIS();
if ($view == 'overview') echo "<span class='nav-tab nav-tab-active'>Overview</span>"; else echo "<a href='". getTabURLIS('overview') ."' class='nav-tab hide-if-no-js'>Overview</a>"; 
if ($view == 'sliders' || $view == 'deleteslider') echo "<span class='nav-tab nav-tab-active'>Sliders and Slides</span>"; else echo "<a href='". getTabURLIS('sliders') ."' class='nav-tab hide-if-no-js'>Sliders and Slides</a>";
if ($view == 'customcss') echo "<span class='nav-tab nav-tab-active'>Custom Style</span>"; else echo "<a href='". getTabURLIS('customcss') ."' class='nav-tab hide-if-no-js'>Custom Style</a>"; 
if ($view == 'addnew') echo "<span class='nav-tab nav-tab-active'>Add New Slider</span>"; 
if ($view == 'editslider') echo "<span class='nav-tab nav-tab-active'>Edit Slider</span>";
if ($view == 'editslide') echo "<span class='nav-tab nav-tab-active'>Edit Slide</span>";
if ($view == 'addnewslide') echo "<span class='nav-tab nav-tab-active'>Add New Slide</span>";
?>
            </div>
          </div>
          <!-- /tabs -->
          
          <?php 
$tabDesc = '';
$view  = ($view == 'deleteslider') ? 'sliders' : $view;
switch ($view) {
	case 'sliders': $tabDesc = 'Sliders and Slides';break;
	case 'addnew': $tabDesc = 'Add New Slider';break;
	case 'addnewslide': $tabDesc = 'Add New Slide';break;
	case 'editslider': $tabDesc = 'Edit Slider';break;
	case 'editslide': $tabDesc = 'Edit Slide';break;
	case 'customcss': $tabDesc = 'Custom Style';break;
	default: $tabDesc = 'Overview';
}?>
          <div class='menu-edit tab-overview'>
            <div id='nav-menu-header'>
              <div class='major-publishing-actions'> <span><?php echo $tabDesc; ?></span>
                <div class="sep">&nbsp;</div>
              </div>
              <!-- END .major-publishing-actions --> 
            </div>
            <!-- END #nav-menu-header -->
            <div id='post-body'>
              <div id='post-body-content'>
              <?php if ($view != 'sliders'){?>
                <form method="post" action=""> <?php /*?>admin.php?page=thethe-image-slider&amp;view=<?php echo $view?><?php */?>
              <?php }?>
                  <?php
					if($view != 'overview' && $view != 'sliders' && $view != 'customcss') include 'inc.submit-buttons.php';
					include 'view-tab-'.$view.'.php';
					if($view != 'overview' && $view != 'sliders' && $view != 'customcss') include 'inc.submit-buttons.php';
				  ?>
			  <?php if ($view != 'sliders'){?>
                </form>
              <?php }?>
              </div>
              <!-- /#post-body-content --> 
            </div>
            <!-- /#post-body --> 
          </div>
          <!-- /.menu-edit --> 
          
        </div>
      </div>
      <!-- sidebar -->
      <div id="thethefly-admin-sidebar" class="metabox-holder">
        <div class="meta-box-sortables">
          <?php include 'inc.sidebar.donate.php';?>
          <?php include 'inc.sidebar.newsletter.php';?>
          <?php include 'inc.sidebar.themes.php';?>
          <?php include 'inc.sidebar.plugins.php';?>
          <?php include 'inc.sidebar.thethe-help.php';?>
        </div>
      </div>
      <!-- /sidebar -->
      <div class="clear"></div>
    </div>
  </div>
</div>