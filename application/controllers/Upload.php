<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Upload extends CI_Controller {

	public function __construct()
	{
	        parent::__construct();
	        $this->load->helper(array('form', 'url'));
	        $this->load->library('session');

	}


	// Chargement de la page
	public function index()
	{
		$this->load->view('file_upload');
	}

	/**
	 * Fonction qui upload un fichier dans un dossier pour pouvoir le modifier par la suite
	 */
	public function do_upload()
	{
		$config['upload_path']          = './upload/';
		$config['allowed_types']        = 'mp3|wav|ogg|m4a|aac|flac';

		$this->load->library('upload',$config); // chargement de la librairie

		 if (!$this->upload->do_upload('userfile'))
        {
			$error = array('error' => $this->upload->display_errors());
			$this->load->view('file_upload', $error);
        }
        else
        {
			$data = array('upload_data' => $this->upload->data());
			// $infos = $this->upload->data(); // Les infos du fichier

			$tagid3['upload_data'] = $this->read_file($this->upload->data());

			// var_dump($tagid3);
			$this->load->view('file_upload_edit', $tagid3);
        }
	}

	/**
	 * Fonction qui va lire les propriétés du fichier
	 * @param $file : array (le fichier)
	 */
	public function read_file($file)
	{    	
		$name = $_SESSION['filename'] = $file['file_path'].$file['file_name']; // Mon fichier
		$infos = [];
		$id3_obj = new getID3;
		$analyze = $id3_obj->analyze($name);

		$infos['artist'] = $analyze['tags']['id3v2']['artist'][0]; // artist from any/all available tag formats
		$infos['title'] = $analyze['tags']['id3v2']['title'][0];  // title from ID3v2
		$infos['album'] = $analyze['tags']['id3v2']['album'][0]; // album name
		$infos['year'] = $analyze['tags']['id3v2']['year'][0]; // publication year
		$infos['genre'] = $analyze['tags']['id3v2']['genre'][0]; // genre
		$infos['track_number'] = $analyze['tags']['id3v2']['track_number'][0]; // genre
		// $infos['picture'] = $analyze['comments']['picture'][0];

		$clean_array = array_filter($infos); 

		if(!empty($clean_array))
		{
			return $clean_array;
		}
		else
		{
			return false;
		}
	}

	/**
	 * Traitement du formulaire d'édition id3tag
	 */
	public function edit_media()
	{
		$getid3 = new getID3;
		$writetags = new getid3_writetags;
		
		$name = $writetags->filename = $this->session->filename;
	}
}
