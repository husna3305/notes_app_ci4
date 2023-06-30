<?php

namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;
use App\Models\NotesModel;
use CodeIgniter\Files\File;

class Notes extends ResourceController
{
	use ResponseTrait;
	var $notes;

	function __construct()
	{
		$this->notes = new NotesModel();
		helper('response_format_helper');
	}

	public function index()
	{
		$data = $this->notes->orderBy('id', 'DESC')->findAll();
		if (count($data) > 0) {
			$response = response_success($data, 'Sukses');
		} else {
			$response = response_error('', 'Belum Ada Data');
		}
		return $this->respond($response, 200);
	}

	public function show($id = null)
	{
		$data = $this->notes->getWhere(['id' => $id])->getRow();
		if ($data) {
			$response = response_success($data);
		} else {
			$response = response_error('', 'Data tidak ditemukan. ID : ' . $id);
		}
		return $this->respond($response, 200);
	}

	public function create()
	{
		$data = [
			'title'    => $this->request->getVar('title'),
			'content'  => $this->request->getVar('content'),
			'date'     => date("Y-m-d")
		];
		$this->notes->insert($data);
		$response = response_success('', 'Berhasil menyimpan data');
		return $this->respond($response, 200);
	}

	public function update($id = null)
	{
		// Cek Data
		$row = $this->notes->find($id);
		if ($row) {
			$input = $this->request->getRawInput();
			$data = [
				'title'    => $input['title'],
				'content'  => $input['content'],
			];
			$this->notes->update($id, $data);
			$response = response_success('', 'Berhasil mengedit data');
		} else {
			$response = response_error('', 'Data tidak ditemukan. ID : ' . $id);
		}
		return $this->respond($response);
	}

	public function delete($id = null)
	{
		$data = $this->notes->find($id);
		if ($data) {
			$this->notes->delete($id);
			$response = response_success('', 'Berhasil menghapus data');
		} else {
			$response = response_error('', 'Data tidak ditemukan. ID : ' . $id);
		}
		return $this->respond($response);
	}
}
