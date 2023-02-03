<?php
require_once(__DIR__."/../../../../system/dashboard/template/widget/widget.php");

class gateways_widget extends widget
{
    public $available = 0;
	public $inactive = 0;
	public $probing = 0;
	public $box_id;
	public $widget_box;

    function __construct($array) {
        parent::__construct($array['panel_id'], $array['widget_name'], 2,2, $array['widget_name']);
		$this->box_id = $array['widget_box'];
		$this->set_status(widget::STATUS_OK);
		foreach ($_SESSION['boxes'] as $box) {
			if ($box['id'] == $this->box_id)
				$this->widget_box = $box;
		}
		$this->set_gateways();
    }


    function get_name() {
        return "Gateways widget";
    }
    function display_test() {
		echo ('
			<table style="table-layout: fixed;
				width: 180px; height:20px; margin: auto; margin-left: 30px; font-weight: bolder;" cellspacing="2" cellpadding="2" border="0">
			');
		echo ('
			<tr>
			<td class="rowEven">Available: </td><td><span style="color:green; font-weight: 900;">'.$this->available.'</span></td></tr>');
		if ($this->inactive > 0) {
			echo ('<tr><td class="rowEven">Inactive: </td><td><span style="color:red; font-weight: 900;">'.$this->inactive.'</span></td></tr>');
			$this->set_status(widget::STATUS_CRIT);
		}
		if ($this->probing > 0)
			echo ('<tr><td class="rowEven">Probing: </td><td><span style="color:orange; font-weight: 900;">'.$this->probing.'</span></td>
			</tr>');
		echo('</table>');
	
	}

	function set_gateways() {
		$stat_res = mi_command("dr_gw_status", array(), $this->widget_box['mi_conn'], $errors);
		foreach($stat_res['Gateways'] as $gateway) {
			switch ($gateway['State']) {
				case "Active":
					$this->available ++;
					break;
				case "Inactive": 
					$this->inactive ++;
					break;
				case "probing":
					$this->probing ++;
					break;
				default:
					error_log("Bug");
			}
		}
	}


    function echo_content() {
        $this->display_test();
    }

    function get_as_array() {
        return array($this->get_html(), $this->get_sizeX(), $this->get_sizeY());
    }

    public static function new_form($params = null) {
		$boxes_info = self::get_boxes();
        if (!$params['widget_name'])
            $params['widget_name'] = "Gateways";
        form_generate_input_text("Name", "", "widget_name", null, $params['widget_name'], 20,null);
    	form_generate_select("Box", "", "widget_box", null,  $params['widget_box'], $boxes_info[0], $boxes_info[1]);
	}

	static function get_description() {
		return "
Shows the number of available gateways vs probing/inactive ones";
	}
}

?>
