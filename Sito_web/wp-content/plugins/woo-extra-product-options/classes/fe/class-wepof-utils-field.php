<?php
/**
 * Woo Extra Product Options common functions
 *
 * @author    ThemeHiGH
 * @category  Admin
 */

if(!defined('ABSPATH')){ exit; }

if(!class_exists('WEPOF_Utils_Field')) :
class WEPOF_Utils_Field {
	public static function is_valid_field($field){
		if(isset($field) && ($field instanceof WEPOF_Product_Field_InputText || $field instanceof WEPOF_Product_Field_Select) && self::is_valid($field)){
			return true;
		} 
		return false;
	}
	
	public static function is_enabled($field){
		if(self::is_valid_field($field) && $field->get_property('enabled')){
			return true;
		}
		return false;
	}
	
	public static function is_valid($field){
		if(empty($field->name) || empty($field->type)){
			return false;
		}
		return true;
	}
	
	public static function show_field($field, $product, $categories){
		$show = true;
		$conditional_rules = $field->get_property('conditional_rules');
		if(!empty($conditional_rules)){
			foreach($conditional_rules as $conditional_rule){				
				if(!$conditional_rule->is_satisfied($product, $categories)){
					$show = false;
				}
			}
		}
		return $show;
	}
	
	public static function convert_cssclass_string($cssclass){
		if(!is_array($cssclass)){
			$cssclass = array_map('trim', explode(',', $cssclass));
		}
		
		if(is_array($cssclass)){
			$cssclass = implode(" ",$cssclass);
		}
		return $cssclass;
	}
	
	public static function render_field($field){
		echo self::get_html($field);
	}

	public static function get_html($field){
		$html = '';
		if(self::is_valid_field($field)){
			$name  = $field->get_property('name');
			$type  = $field->get_property('type');
			$value = isset($_POST[$name]) ? $_POST[$name] : $field->get_property('value');
			$value = $value ? trim(stripslashes($value)) : $value;
			
			$input_html = false;
			if($type === 'inputtext'){
				$input_html = self::get_html_inputtext($field, $name, $value);
			}else if($type === 'select'){
				$input_html = self::get_html_select($field, $name, $value);
			}
			
			$title_html  = $field->get_property('title');
			$title_html .= self::get_required_html($field);
			
			if($input_html){
				if($field->get_property('title_position') === 'left'){
					$html .= '<p class="thwepo-extra-options left form-row form-row-wide '. $field->get_property('cssclass_str') .'">';
					$html .= '<label for="'. $name .'" class="'. $field->get_property('title_class_str') .'">'.$title_html.'</label>';
					$html .= $input_html;
					$html .= '</p>';
				}else{
					$html .= '<p class="thwepo-extra-options form-row form-row-wide '. $field->get_property('cssclass_str') .'">';
					$html .= '<label for="'. $name .'" class="'. $field->get_property('title_class_str') .'">'.$title_html.'</label>';
					$html .= $input_html;
					$html .= '</p>';
				}
			}
		}	
		return $html;
	}
	
	private static function get_required_html($field){
		$html = '';
		if($field->get_property('required')){
			$html = apply_filters( 'thwepof_required_html', ' <abbr class="required" title="required">*</abbr>', $field->get_property('name') );
		}
		return $html;
	}
	
	private static function get_html_inputtext($field, $name, $value){
		$html = '<input type="text" id="'.$name.'" name="'.$name.'" placeholder="'.$field->get_property('placeholder').'" value="'.$value.'" />';
		return $html;
	}
	
	private static function get_html_select($field, $name, $value){
		$html = '<select id="'.$name.'" name="'.$name.'" placeholder="'.$field->get_property('placeholder').'" value="'.$value.'" >';
		foreach($field->get_property('options') as $option_key => $option_text){
			$selected = ($option_text === $value) ? 'selected' : '';
			$html .= '<option value="'.$option_text.'" '.$selected.'>'.$option_text.'</option>';
		}
		$html .= '</select>';
		return $html;
	}
}
endif;