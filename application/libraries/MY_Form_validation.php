<?php if (! defined('BASEPATH')) exit('No direct script access allowed');

class MY_Form_validation extends CI_Form_validation
{

	public function __construct($rules = array())
	{
		parent::__construct($rules);
	}

	/**
	 * Valid Date
	 *
	 * @param   string  $str
	 * @return  bool
	 */
	public function valid_date($str)
	{
		if (!preg_match("/^(\d{4})-(\d{2})-(\d{2})$/", $str, $matches)) {
			$this->set_message('valid_date', 'Kolom {field} harus dalam format YYYY-MM-DD.');
			return FALSE;
		}

		if (!checkdate($matches[2], $matches[3], $matches[1])) {
			$this->set_message('valid_date', 'Kolom {field} berisi tanggal yang tidak valid.');
			return FALSE;
		}

		return TRUE;
	}
}
