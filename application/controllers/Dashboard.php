<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {

	/*
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */
    
	public function index()
	{
        if(isset($_SESSION['login'])){
            $this->load->view('header');
            $this->load->view('topbar');
            $this->load->view('sidebar');
            $this->load->view('dashboard/content');
            $this->load->view('footer');
            $this->load->view('control_sidebar');
            $this->load->view('page_scripts/dashboard');
            $this->load->view('eof');
        } else
            header("Location: /");
	}
}

?>