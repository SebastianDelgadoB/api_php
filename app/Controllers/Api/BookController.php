<?php

namespace App\Controllers\Api;

use CodeIgniter\RESTful\ResourceController;
use App\Models\BookModel;

class BookController extends ResourceController
{
    public function addBook()
	{
        $rules = [
			"isbn" => "required|is_unique[books.isbn]",
			"title" => "required",
			"description" => "required",
            "author" => "required",
		];

		$messages = [
			"isbn" => [
				"required" => "isbn is required"
			],
			"title" => [
				"required" => "Title required"
			],
			"description" => [
				"required" => "description is required"
			],
            "author" => [
				"required" => "author is required"
			],
		];

		if (!$this->validate($rules, $messages)) {

			$response = [
				'status' => 500,
				'error' => true,
				'message' => $this->validator->getErrors(),
				'data' => []
			];
		} else {

			$emp = new BookModel();

            $input = $this->request->getRawInput();	
            $data['isbn'] = $input["isbn"];
            $data['title'] = $input["title"];
            $data['description'] = $input["description"];
            $data['author'] = $input["author"];

            $emp->update($data);

            $response = [
                'status' => 200,
                'error' => false,
                'message' => 'Book updated successfully',
                'data' => []
            ];

			$emp->save($data);

			$response = [
				'status' => 200,
				'error' => false,
				'message' => 'Employee added successfully',
				'data' => []
			];
		}
		return $this->respond($response);
	}


    public function listBook()
	{
		$emp = new BookModel();
            
        //log_message('error', $e->getMessage());
        
		$response = [
			'status' => 200,
			"error" => false,
			'messages' => 'Book list',
			'data' => $emp->findAll()
		];

		return $this->respond($response);
	}

    public function showBook($emp_id)
	{
		$emp = new BookModel();

		$data = $emp->find($emp_id);
        //$data = $model->where(['id' => $emp_id])->first();

		if (!empty($data)) {

			$response = [
				'status' => 200,
				"error" => false,
				'messages' => 'Single book data',
				'data' => $data
			];

		} else {

			$response = [
				'status' => 500,
				"error" => true,
				'messages' => 'No book found',
				'data' => []
			];
		}

		return $this->respond($response);
	}

    public function updateBook($emp_id)
	{
		$rules = [
			"isbn" => "required|is_unique[books.isbn]",
			"title" => "required",
			"description" => "required",
            "author" => "required",
		];

		$messages = [
			"isbn" => [
				"required" => "isbn is required"
			],
			"title" => [
				"required" => "Title required"
			],
			"description" => [
				"required" => "description is required"
			],
            "author" => [
				"required" => "author is required"
			],
		];

		if (!$this->validate($rules, $messages)) {

			$response = [
				'status' => 500,
				'error' => true,
				'message' => $this->validator->getErrors(),
				'data' => []
			];
		} else {

			$emp = new BookModel();

			if ($emp->find($emp_id)) {

				//Retrieving Raw Data (PUT, PATCH, DELETE)
				$input = $this->request->getRawInput();	
				$data['isbn'] = $input["isbn"];
				$data['title'] = $input["title"];
				$data['description'] = $input["description"];
				$data['author'] = $input["author"];

				$emp->update($emp_id, $data);

				$response = [
					'status' => 200,
					'error' => false,
					'message' => 'Book updated successfully',
					'data' => []
				];
			}else {

				$response = [
					'status' => 500,
					"error" => true,
					'messages' => 'No book found',
					'data' => []
				];
			}
		}

		return $this->respond($response);
	}

    public function deleteBook($emp_id)
	{
		$emp = new BookModel();

		$data = $emp->find($emp_id);

		if (!empty($data)) {

			$emp->delete($emp_id);

			$response = [
				'status' => 200,
				"error" => false,
				'messages' => 'Book deleted successfully',
				'data' => []
			];

		} else {

			$response = [
				'status' => 500,
				"error" => true,
				'messages' => 'No book found',
				'data' => []
			];
		}

		return $this->respond($response);
	}
}
