<?php
class ControllerModuleVoucher extends Controller {
	public function index() {
		$this->load->language('module/voucher');
		
		$data['heading_title'] = $this->language->get('heading_title');
		
		$data['text_loading'] = $this->language->get('text_loading');
		
		$data['entry_voucher'] = $this->language->get('entry_voucher');
		
		$data['button_voucher'] = $this->language->get('button_voucher');
		
		$data['status'] = $this->config->get('voucher_status');
		
		if (isset($this->session->data['voucher'])) {
			$data['voucher'] = $this->session->data['voucher'];
		} else {
			$data['voucher'] = '';
		}
		
		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/module/voucher.tpl')) {
			return $this->load->view($this->config->get('config_template') . '/template/module/voucher.tpl', $data);
		} else {
			return $this->load->view('default/template/module/voucher.tpl', $data);
		}
	}
	
	public function voucher() {
		$this->load->language('module/voucher');
		
		$json = array();
				
		$this->load->model('checkout/voucher');
		
		if (isset($this->request->post['voucher'])) {
			$voucher = $this->request->post['voucher'];
		} else {
			$voucher = '';
		}
				
		$voucher_info = $this->model_checkout_voucher->getVoucher($voucher);			
		
		if ($voucher_info) {	
			$this->session->data['voucher'] = $this->request->post['voucher'];
				
			$this->session->data['success'] = $this->language->get('text_success');
				
			$json['redirect'] = $this->url->link('checkout/cart');			
		} else {
			$json['error'] = $this->language->get('error_voucher');
		}
		
		$this->response->setOutput(json_encode($json));		
	}
}