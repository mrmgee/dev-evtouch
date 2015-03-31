<?php /* Smarty version 2.6.26, created on 2012-07-27 15:32:46
         compiled from Dashboard/templates/header.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'translate', 'Dashboard/templates/header.tpl', 6, false),array('function', 'loadJavascriptTranslations', 'Dashboard/templates/header.tpl', 8, false),)), $this); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
   "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title><?php echo ((is_array($_tmp='General_Dashboard')) ? $this->_run_mod_handler('translate', true, $_tmp) : smarty_modifier_translate($_tmp)); ?>
 - <?php echo ((is_array($_tmp='CoreHome_WebAnalyticsReports')) ? $this->_run_mod_handler('translate', true, $_tmp) : smarty_modifier_translate($_tmp)); ?>
</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php echo smarty_function_loadJavascriptTranslations(array('plugins' => 'CoreHome Dashboard'), $this);?>

<!--[if lt IE 9]>
<script language="javascript" type="text/javascript" src="libs/jqplot/excanvas.min.js"></script>
<![endif]-->
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "CoreHome/templates/js_global_variables.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "CoreHome/templates/js_css_includes.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<?php echo '
<style type="text/css">
    body {
    	padding-left:7px;
    }
    #dashboard {
        margin: 30px -6px 0 -12px;
        width: 100%;
        padding-top:8px;
    }
    #menuHead {
        position: absolute;
        top: 0;
        padding: 7px 0 0 2px;
    }

    #Dashboard {
        z-index:5;
        font-size:14px;
        cursor: pointer;
    }

    #Dashboard > ul {
        list-style: square inside none;
        background: #f7f7f7;
        border: 1px solid #e4e5e4;
        padding:5px 10px 6px 10px;
        border-radius:4px;
        -moz-border-radius:4px;
        -webkit-border-radius:4px;
        color:#444;
        height: 18px;
    }

    #Dashboard:hover ul {
        background:#f1f0eb;
        border-color:#a9a399;
    }

    #Dashboard > ul > li {
        float: left;
        text-align: center;
        margin: 0 15px;
    }

    #Dashboard a {
        color: #444;
        text-decoration: none;
        font-weight: normal;
        display: inline-block;
        margin: 0 -15px;
    }

    #Dashboard > ul > li:hover , #Dashboard > ul > li:hover a,
    #Dashboard > ul > li.sfHover, #Dashboard > ul > li.sfHover a {
        color: #e87500;
    }

    #Dashboard > ul > li.sfHover, #Dashboard > ul > li.sfHover a {
        font-weight: bold;
    }

    #Dashboard, #periodString, #dashboardSettings {
        float: left;
        clear: none;
        position: relative;
        margin-left: 0;
        margin-right: 10px;
    }
    .jqplock-seriespicker-popover {
        top: 0;
    }

    #ajaxLoading {
        margin: 40px 0 -30px 0;
    }

</style>
'; ?>

</head>
<body>