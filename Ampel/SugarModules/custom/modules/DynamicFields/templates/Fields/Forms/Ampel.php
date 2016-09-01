<?php
/*********************************************************************************
 AMPEL - function is called in modules/DynamicFields/FieldViewer.php
 ********************************************************************************/
 function get_body(&$ss, $vardef){

	return $ss->fetch('custom/modules/DynamicFields/templates/Fields/Forms/Ampel.tpl');
 }
?>
