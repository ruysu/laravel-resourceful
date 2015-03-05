<?php namespace Ruysu\Resourceful;

abstract class ResourcefulController extends ResourcefulControllerAbstract {
	protected $views_folder = NULL;

	public function index() {
		$resources = parent::index();
		return $this->view("{$this->views_folder}/index", compact('resources'));
	}

	public function create() {
		$resource = parent::create();
		$form = $this->form;
		return $this->view("{$this->views_folder}/create", compact('resource', 'form'));
	}

	public function store() {
		$params = $this->parameters;

		if ($resource = parent::store()) {
			$params []= $resource->id;
			return $this->redirect('edit', $params)->with('notice', ['success', 'Resource created successfully']);
		}
		else {
			return $this->redirect('create', $params)->withInput()->withErrors($this->repository->getErrors());
		}
	}

	public function show() {
		$resource = parent::show();
		return $this->view("{$this->views_folder}/show", compact('resource'));
	}

	public function edit() {
		$resource = parent::edit();
		$form = $this->form;
		return $this->view("{$this->views_folder}/edit", compact('resource', 'form'));
	}

	public function update() {
		$updated = parent::update();

		if ($updated) {
			return $this->redirect('edit', $this->parameters)->with('notice', ['success', 'Resource updated successfully']);
		}
		else {
			return $this->redirect('edit', $this->parameters)->withInput()->withErrors($this->repository->getErrors());
		}
	}

	public function destroy() {
		$params = $this->parameters;
		$destroyed = parent::destroy();
		return $this->redirect('index', $params)->with('notice', ['success', 'Resource deleted successfully']);
	}
}
