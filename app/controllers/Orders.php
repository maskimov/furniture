<?php 

namespace Controller;

use Core\Request;
use Core\Session;
use Model\Order;
use Model\Product;

defined('ROOTPATH') OR exit('Access Denied!');

class Orders
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

        if ((!$ses->is_manager() && user('department') != 'sales') && !$ses->is_admin())
        {
            redirect('home');
			die;
        }

        $product = new Product;
        $products = $product->where([],['stock' => 0]);

        $order = new Order;
        $orders = $order->findAll();

        if ($orders){
			foreach ($orders as $order) {
				$row = $product->first(['id' => $order->product_id]);
				$order->product_id = $row->name;
			}
		}

        $this->data = [
			'isAdmin' => $ses->is_admin(), 
			'isManager' => $ses->is_manager(), 
			'page' => 'Замовлення',
            'department' => user('department'),
            'products' => $products,
            'orders' => $orders
		];

        $request = new Request;
		if (!$request->posted()){
            $this->view('orders', $this->data);
            die;
        }

        if ($request->input("submit") == "create")
        {
            $newData = [
                'customer_name' => $request->post('customer_name'),
                'customer_email' => $request->post('customer_email'),
                'product_id' => $request->post('product_id'),
                'count' => $request->post('count'),
                'created' => date('Y-m-d H:i:s'),
            ];

            $order = new Order;

            if (!$order->validate($newData)){
                $this->data['errors'] = $order->errors;
				$this->view('orders', $this->data);
				die;
            }

            $order->insert($newData);
            $product = new Product;
            $productRow = $product->first(['id' => $newData['product_id']]);
            $oldStock = $productRow->stock;
            $newStock = $oldStock - $newData['count'];

            $product->update($newData['product_id'], ['stock' => $newStock]);
        }

		redirect('orders');
	}
}
