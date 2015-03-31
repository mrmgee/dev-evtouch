<?php /* Smarty version 2.6.26, created on 2012-07-27 15:32:46
         compiled from /Library/WebServer/Documents/analytics/piwik/plugins/Dashboard/templates/standalone.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'ajaxLoadingDiv', '/Library/WebServer/Documents/analytics/piwik/plugins/Dashboard/templates/standalone.tpl', 11, false),)), $this); ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "Dashboard/templates/header.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<div id="menuHead">
    <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "CoreHome/templates/period_select.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
    <div id="Dashboard"><ul>
    <?php $_from = $this->_tpl_vars['dashboards']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['dashboard']):
?>
        <li class="dashboardMenuItem" id="Dashboard_embeddedIndex_<?php echo $this->_tpl_vars['dashboard']['iddashboard']; ?>
"><a href="javascript:$('#dashboardWidgetsArea').dashboard('loadDashboard', <?php echo $this->_tpl_vars['dashboard']['iddashboard']; ?>
);"><?php echo $this->_tpl_vars['dashboard']['name']; ?>
</a></li>
    <?php endforeach; endif; unset($_from); ?>
    </ul></div>
    <div class="clear"></div>
</div>
<?php echo smarty_function_ajaxLoadingDiv(array(), $this);?>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "Dashboard/templates/index.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
</body>
</html>