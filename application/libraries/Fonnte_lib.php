<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Fonnte_lib
{

	protected $CI;
	private $api_key;
	private $url_endpoint = 'https://api.fonnte.com/send';

	public function __construct()
	{
		$this->CI = &get_instance();
		$this->CI->config->load('fonnte_config');

		$this->api_key = $this->CI->config->item('fonnte_api_key');

		if (empty($this->api_key)) {
			log_message('error', 'Fonnte API Key belum dikonfigurasi di application/config/fonnte_config.php');
			show_error('Fonnte API credentials are not properly set up. Please check application/config/fonnte_config.php and ensure API Key is filled.');
		}
	}

	/**
	 * Mengirim pesan WhatsApp via Fonnt.com
	 *
	 * @param string $target_number Nomor tujuan (e.g., '6281234567890')
	 * @param string $message Isi pesan
	 * @return array Hasil respons dari API Fonnt.com
	 */
	public function send_message($target_number, $message)
	{
		$target_number = preg_replace('/[^0-9]/', '', $target_number);
		if (substr($target_number, 0, 1) == '0') {
			$target_number = '62' . substr($target_number, 1);
		} elseif (substr($target_number, 0, 2) != '62') {
			$target_number = '62' . $target_number;
		}

		$curl = curl_init();

		curl_setopt_array($curl, array(
			CURLOPT_URL => $this->url_endpoint,
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_ENCODING => "",
			CURLOPT_MAXREDIRS => 10,
			CURLOPT_TIMEOUT => 0,
			CURLOPT_FOLLOWLOCATION => true,
			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST => "POST",
			CURLOPT_POSTFIELDS => array(
				'target' => $target_number,
				'message' => $message,
			),
			CURLOPT_HTTPHEADER => array(
				'Authorization: ' . $this->api_key
			),
		));

		$response = curl_exec($curl);
		$err = curl_error($curl);

		curl_close($curl);

		log_message('debug', 'Fonnte API Response: ' . $response);
		if ($err) {
			log_message('error', "cURL Error #:" . $err);
			return ['status' => 'error', 'message' => 'Failed to connect to Fonnte API: ' . $err];
		} else {
			return json_decode($response, true);
		}
	}
}
