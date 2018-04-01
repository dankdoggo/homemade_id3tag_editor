<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Upload extends CI_Controller {

	public function __construct()
	{
	        parent::__construct();
	        $this->load->helper(array('form', 'url'));
	        $this->load->library('session'); // starting session to store filename

	}


	// Chargement de la page
	public function index()
	{
		$this->load->view('file_upload');
	}

	/**
	 * Uploading file
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
	 * Read file property
	 * @param $file : array | string (le fichier)
	 */
	public function read_file($file)
	{    	
		if(is_array($file) && count($file) > 0)
		{
			$name = $_SESSION['filename'] = $file['file_path'].$file['file_name']; // Mon fichier
		}
		else
		{
			$name = $_SESSION['filename'] = $file; // Mon fichier
		}

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
	 * Editing form
	 */
	public function edit_media()
	{

		// You should pass data here with standard field names as follows:
		// * TITLE
		// * ARTIST
		// * ALBUM
		// * TRACKNUMBER
		// * COMMENT
		// * GENRE
		// * YEAR
		// * ATTACHED_PICTURE (ID3v2 only)

		$id3_obj = new getID3;
		$writetags = new getid3_writetags; // object to edit tags
		$name = $this->session->filename;

		$data = [];
		$data['ARTIST'][0]		= $this->input->post('artist');
		$data['TITLE'][0]		= $this->input->post('title');
		$data['ALBUM'][0]		= $this->input->post('album');
		$data['YEAR'][0]		= $this->input->post('year');
		$data['GENRE'][0]		= $this->input->post('genre');
		$data['TRACKNUMBER'][0]	= $this->input->post('track_number');

		$writetags->tag_data = $data;
		$writetags->tag_encoding = 'UTF-8';
		$writetags->tagformats = array('id3v2.2', 'id3v2.4');
		$writetags->filename = $name;

		if($writetags->WriteTags())
		{
			var_dump($id3_obj->analyze($name));
		}
		else
		{
			var_dump($writetags->errors);
		}
	}
}
