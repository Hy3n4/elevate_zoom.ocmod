<?php
/**
 * Created by PhpStorm.
 * User: patrikchadima
 * Date: 07/11/2017
 * Time: 21:25
 */
class ControllerExtensionModuleElevateZoom extends Controller {
    public function __construct($params) {
        parent::__construct($params);

        $this->options_fadein       = $this->config->get('module_elevate_zoom_fadein');
        $this->options_fadeout       = $this->config->get('module_elevate_zoom_fadeout');
    }

    public function index() {
        $this->load->model('catalog/product');
    }
    public function js() {
        header('Content-Type: application/javascript');
        /*$product_id = isset($this->request->get['product_id']) ? (int)$this->request->get['product_id'] : 0;

        if ($product_id == 0 || !$this->status) {
            exit;
        }*/
        $js = <<<HTML
			$('#{{ model }}').elevateZoom({
                    zoomType: "inner",
                    cursor: "crosshair",
                    zoomWindowFadeIn: {{ module_elevate_zoom.module_elevate_zoom_fadein }},
                    zoomWindowFadeOut: {{ module_elevate_zoom.module_elevate_zoom_fadeout }}
HTML;

        echo $js;
        exit;
    }
}