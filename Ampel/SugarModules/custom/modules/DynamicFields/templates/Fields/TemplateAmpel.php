<?php
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');
/*********************************************************************************
 AMPEL
 ********************************************************************************/

require_once('modules/DynamicFields/templates/Fields/TemplateInt.php');

class TemplateAmpel extends TemplateInt
{
	var $type = 'int';
    var $supports_unified_search = true;

	public function __construct(){
		parent::__construct();
		$this->vardef_map['autoinc_next'] = 'autoinc_next';
		$this->vardef_map['autoinc_start'] = 'autoinc_start';
		$this->vardef_map['auto_increment'] = 'auto_increment';

        $this->vardef_map['min'] = 'ext1';
        $this->vardef_map['max'] = 'ext2';
        $this->vardef_map['disable_num_format'] = 'ext3';
    }

	function get_html_edit(){
		$this->prepare();
		return "<input type='text' name='". $this->name. "' id='".$this->name."' title='{" . strtoupper($this->name) ."_HELP}' size='".$this->size."' maxlength='".$this->len."' value='{". strtoupper($this->name). "}'>";
	}

/*
	public function populateFromPost(Request $request = null)
    {
        if (!$request) {
            $request = InputValidation::getService();
        }

        parent::populateFromPost($request);
		if (isset($this->auto_increment))
		{
		    $this->auto_increment = $this->auto_increment == "true" || $this->auto_increment === true;
		}
	}
*/

    function get_field_def(){
		$vardef = parent::get_field_def();
		$vardef['disable_num_format'] = isset($this->disable_num_format) ? $this->disable_num_format : $this->ext3;//40005

        $vardef['min'] = isset($this->min) ? $this->min : $this->ext1;
        $vardef['max'] = isset($this->max) ? $this->max : $this->ext2;
        $vardef['min'] = filter_var($vardef['min'], FILTER_VALIDATE_INT);
        $vardef['max'] = filter_var($vardef['max'], FILTER_VALIDATE_INT);

        if ($vardef['min'] !== false || $vardef['max'] !== false)
        {
            $vardef['validation'] = array(
                'type' => 'range',
                'min' => $vardef['min'],
                'max' => $vardef['max']
            );
        }

        if(!empty($this->auto_increment))
		{
			$vardef['auto_increment'] = $this->auto_increment;
			if ((empty($this->autoinc_next)) && isset($this->module) && isset($this->module->table_name))
			{
				global $db;
                $helper = $db->gethelper();
                $auto = $helper->getAutoIncrement($this->module->table_name, $this->name);
                $this->autoinc_next = $vardef['autoinc_next'] = $auto;
			}
		}
//EK start
		$vardef['dbType'] = 'int'; //!!!!!!!
        if(!empty($this->ext4))
        {
  		  $ext4=unserialize($this->ext4);
		  $vardef['range_min'] = $ext4['range_min'];
		  $vardef['range_max'] = $ext4['range_max'];
        }
        //$GLOBALS['log']->debug("EK: get_field_def1 this".print_r($this,true));
//EK end
		return $vardef;
    }

    function save($df){
        $GLOBALS['log']->debug("EK: save ".print_r($_REQUEST,true));
        $next = false;
		if (!empty($this->auto_increment) && (!empty($this->autoinc_next) || !empty($this->autoinc_start)) && isset($this->module))
        {
            if (!empty($this->autoinc_start) && $this->autoinc_start > $this->autoinc_next)
			{
				$this->autoinc_next = $this->autoinc_start;
			}
			if(isset($this->module->table_name)){
				global $db;
	            $helper = $db->gethelper();
	            //Check that the new value is greater than the old value
	            $oldNext = $helper->getAutoIncrement($this->module->table_name, $this->name);
	            if ($this->autoinc_next > $oldNext)
	            {
	                $helper->setAutoIncrementStart($this->module->table_name, $this->name, $this->autoinc_next);
				}
			}
			$next = $this->autoinc_next;
			$this->autoinc_next = false;
        }
//EK start

		$ext4=array();
		$ext4['range_min'] = $_REQUEST['range_min'];
		$ext4['range_max'] = $_REQUEST['range_max'];
        //$this->ext4=base64_encode(serialize($ext4));
        $this->ext4=serialize($ext4); // a:2:{s:9:"range_min";s:3:"333";s:9:"range_max";s:3:"444";}
        //$GLOBALS['log']->debug("EK: save ext4: ".$this->ext4);
// EK end

		parent::save($df);
		if ($next)
		  $this->autoinc_next = $next;
    }
}


?>
