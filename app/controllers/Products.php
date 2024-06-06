<?php 

namespace Controller;

use Core\Request;
use Core\Session;
use Model\Product;

defined('ROOTPATH') OR exit('Access Denied!');

class Products
{
	use MainController;

	private $data = [];

	public function index()
	{
		$ses = new Session;
		
		if (!$ses->is_logged_in())
		{
			redirect('login');
			die;
		}

        if (!$ses->is_manager() && !$ses->is_admin())
        {
            redirect('home');
			die;
        }

        $product = new Product;
        $products = $product->findAll();
        
        $this->data = [
			'isAdmin' => $ses->is_admin(),
			'isManager' => $ses->is_manager(),
			'page' => 'Меблі',
            'department' => user('department'),
            'products' => $products
		];

        $request = new Request;

		if (!$request->posted()){
            $this->view('products', $this->data);
            die;
        }

        if ($request->input('submit') == 'edit')
        {
            $productId = $request->post('id');
            $newData = [
                'description' => $request->post('description'),
                'price' => $request->post('price')
            ];

            if (!$product->validateEdit($newData))
            {
                $this->data['errors'] = $product->errors;
				$this->view('products', $this->data);
				die;
            }

            $product = new Product;
            $product->update($productId, $newData);
        }

        if ($request->input('submit') == 'create')
        {
            $data = [
                'name' => $request->post('name'),
                'description' => $request->post('description'),
                'image' => NULL,
                'price' => $request->post('price'),
                'stock' => 0,
                'created' => date('Y-m-d H:i:s')
            ];

            if (!$product->validateCreate($data))
            {
                $this->data['errors'] = $product->errors;
				$this->view('products', $this->data);
				die;
            }

            $product = new Product;
            $product->insert($data);
        }

		redirect('products');
	}
}
