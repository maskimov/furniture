<?php 

namespace Controller;
use Core\Session;
use Core\Request;
use Model\Task;
use Model\User;
use Model\Product;
use Model\Image;


defined('ROOTPATH') OR exit('Access Denied!');

class Tasks
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

        if ($ses->department() == 'sales' || $ses->department() == 'none')
        {
            redirect('home');
            die;
        }
		
		if ($ses->user('privilege') != "manager")
		{
			redirect('tasks/mytasks');
            die;
		}

		redirect('tasks/createtasks');
        die;
	}

	public function CreateTasks()
	{
		$ses = new Session;
		
		if (!$ses->is_logged_in())
		{
			redirect('login');
			die;
		}

        if ($ses->department() == 'sales' || $ses->department() == 'none')
        {
            redirect('home');
            die;
        }
		
		if (user('privilege') != "manager")
		{
			redirect('tasks/mytasks');
            die;
		}

		$tasks = [];

		$task = new Task('asc', 'approved');
		$tasks = $task->where(['creator_id'=>user('id')]);

		$user = new User;
		if ($tasks){
			foreach ($tasks as $task) {
				$row = $user->first(['id' => $task->performer_id]);
				$task->performer_id = $row->username;
			}
		}

		$product = new Product;
		if ($tasks){
			foreach ($tasks as $task) {
				$row = $product->first(['id' => $task->product_id]);
				$task->product_id = $row->name;
				if (user('department') == "design")
					$task->amount = $row->image ?? '';
			}
		}

		$product = new Product;

		if (user('department') == "design")
			$products = $product->findAll();
		else if (user('department') == "industrial")
			$products = $product->where([],['image'=>'null']);

		$workers = $user->where(['privilege'=>'worker', 'department'=>user('department')]);

		$this->data = [
			'isAdmin' => $ses->is_admin(), 
			'isManager' => $ses->is_manager(),
			'department' => $ses->department(), 
			'page' => 'Створити Завдання',
			'tasks' => $tasks,
			'products' => $products,
			'workers' => $workers
		];

		$request = new Request;
		if (!$request->posted()){
            $this->view('create-tasks', $this->data);
            die;
        }

		if ($request->input('submit') == 'create')
		{
			$newData = [
				'creator_id' => user('id'),
				'performer_id' => $request->post('performer'),
				'description' => $request->post('description'),
				'product_id' => $request->post('product'),
				'amount' => user('department') == "industrial" ? $request->post('amount') : 0,
				'created' => date('Y-m-d H:i:s'),
			];

			$task = new Task('asc', 'approved');
			if (!$task->validateCreate([
				'performer_id' => $newData['performer_id'], 
				'product_id' => $newData['product_id'],
				'amount'=> user('department') == 'design' ? 2 : $newData['amount']
			]))
			{
				$this->data['errors_create'] = $task->errors;
				$this->view('create-tasks', $this->data);
				die;
			}
			$task->insert($newData);
		}
		
		if ($request->input('submit') == 'approve')
		{
			$task = new Task('asc', 'approved');
			$product = new Product;

			$taskId = $request->post('id');
			$taskRow = $task->first(['id'=> $taskId]);
			$productRow = $product->first(['id'=> $taskRow->product_id]);

			if (!$task->validate(['approved' => $taskRow->approved, 'performed' => $taskRow->performed]))
			{
				$this->data['errors'] = $task->errors;
				$this->view('create-tasks', $this->data);
				die;
			}

			$previousStock = $productRow->stock;
			$newStock = $previousStock + $taskRow->amount;
			
			$product->update($productRow->id, ['stock' => $newStock]);
			$task->update($taskRow->id, ['approved' => 1]);
		}

		redirect('tasks');
	}

	public function MyTasks()
	{
		$ses = new Session;
		
		if (!$ses->is_logged_in())
		{
			redirect('login');
			die;
		}

        if ($ses->department() == 'sales' || $ses->department() == 'none')
        {
            redirect('home');
            die;
        }
		
		if ($ses->user('privilege') == "manager")
		{
			redirect('tasks/createtasks');
            die;
		}

		$task = new Task('asc', 'approved');
		$tasks = $task->where(['performer_id'=>user('id')]);

		$product = new Product;
		foreach ($tasks as $task) {
			$row = $product->first(['id' => $task->product_id]);
			$task->product_id = $row->name;
			if (user('department') == "design")
					$task->amount = $row->image ?? '';
		}

		$this->data = [
			'isAdmin' => $ses->is_admin(), 
			'isManager' => $ses->is_manager(), 
			'department' => $ses->department(), 
			'page' => 'Мої Завдання',
			'tasks' => $tasks,
		];

		$request = new Request;
		if (!$request->posted()){
            $this->view('my-tasks', $this->data);
            die;
        }

		if ($request->input('submit') == 'photo'){
			$image = new Image;
			$photoPath = $image->saveImage("assets/images/products/", $request->files("photo"));

			$productName= $request->post('product_name');
			$productRow = $product->first(['name' => $productName]);
			
			if ($productRow->image)
			{
				$image->deleteImage($productRow->image);
			}

			$product->update($productRow->id, ['image' => $photoPath]);
		}

		if ($request->input('submit') == 'perform')
		{
			$this->data['errors'] = [];
			$task = new Task('asc', 'approved');

			$taskId = $request->post('id');
			$taskRow = $task->first(['id'=> $taskId]);
			$productId = $taskRow->product_id;
			$productRow = $product->first(['id'=> $productId]);

			if ($productRow->image != null)
			{
				$task->update($taskId, ['performed' => 1]);
			}
			else
			{
				$this->data['errors']['image'] = 'Фото продукту має бути завантажене'; 
				$this->view('my-tasks',$this->data);
			}
		}

		redirect('tasks/mytasks');
	}
}
