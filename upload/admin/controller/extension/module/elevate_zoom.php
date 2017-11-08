<?php
/**
 * Created by PhpStorm.
 * User: patrikchadima
 * Date: 07/11/2017
 * Time: 14:19
 */
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
class ControllerExtensionModuleElevateZoom extends Controller
{
    public $option_fadein_value	        = '500';
    public $option_fadeout_value        = '750';
    
    private $error = array(); // This is used to set the errors, if any.

    public function index() {   // Default function

    $this->load->language('extension/module/elevate_zoom');
    $this->document->setTitle($this->language->get('heading_title'));

        $this->load->model('setting/setting');

        if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
            $this->model_setting_setting->editSetting('module_elevate_zoom', $this->request->post);

            $this->session->data['success'] = $this->language->get('text_success');

            $this->response->redirect($this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'] . '&type=module', true));
        }

        if (isset($this->error['warning'])) {
            $data['error_warning'] = $this->error['warning'];
        } else {
            $data['error_warning'] = '';
        }

        if (isset($this->session->data['success'])) {
            $data['success'] = $this->session->data['success'];
            unset($this->session->data['success']);
        } else {
            $data['success'] = '';
        }

        $data['breadcrumbs'] = array();

        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('text_home'),
            'href' => $this->url->link('common/dashboard', 'user_token=' . $this->session->data['user_token'], true)
        );

        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('text_extension'),
            'href' => $this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'] . '&type=module', true)
        );

        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('heading_title'),
            'href' => $this->url->link('extension/module/elevate_zoom', 'user_token=' . $this->session->data['user_token'], true)
        );

        $data['action'] = $this->url->link('extension/module/elevate_zoom', 'user_token=' . $this->session->data['user_token'], true);

        $data['cancel'] = $this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'] . '&type=module', true);

        if (isset($this->request->post['module_elevate_zoom_fadein'])) {
            $data['module_elevate_zoom_fadein'] = $this->request->post['module_elevate_zoom_fadein'];
        } elseif ( null !== $this->config->get('module_elevate_zoom_fadein')) {
            $data['module_elevate_zoom_fadein'] = $this->config->get('module_elevate_zoom_fadein');
        } else {
            $data['module_elevate_zoom_fadein'] = $this->option_fadein_value;
        }

        if (isset($this->request->post['module_elevate_zoom_fadeout'])) {
            $data['module_elevate_zoom_fadeout'] = $this->request->post['module_elevate_zoom_fadeout'];
        } elseif ( null !== $this->config->get('module_elevate_zoom_fadeout')) {
            $data['module_elevate_zoom_fadeout'] = $this->config->get('module_elevate_zoom_fadeout');
        } else {
            $data['module_elevate_zoom_fadeout'] = $this->option_fadeout_value;
        }

        if (isset($this->request->post['module_elevate_zoom_status'])) {
            $data['module_elevate_zoom_status'] = $this->request->post['module_elevate_zoom_status'];
        } else {
            $data['module_elevate_zoom_status'] = $this->config->get('module_elevate_zoom_status');
        }

        $data['header'] = $this->load->controller('common/header');
        $data['column_left'] = $this->load->controller('common/column_left');
        $data['footer'] = $this->load->controller('common/footer');
        $data['current_lang_id'] = $this->config->get('config_language_id');

        $this->response->setOutput($this->load->view('extension/module/elevate_zoom', $data));
    }
    protected function validate() {
        if (!$this->user->hasPermission('modify', 'extension/module/elevate_zoom')) {
            $this->error['warning'] = $this->language->get('error_permission');
        }

        return !$this->error;
    }
}