<?php namespace Ruysu\Resourceful;

abstract class ResourcefulController extends ResourcefulControllerAbstract implements ResourcefulControllerInterface {
	protected $views_folder = NULL;

	public function index() {
		$resources = $this->repository->index();
		$this->indexing($resources);
		return $this->view("{$this->views_folder}/index", compact('resources'));
	}

	public function create() {
		$resource = $this->repository->getNew();

		$this->creating($resource);
		$this->composing($resource);

		$form = $this->form;

		if ($this->form) {
			$form->setAction($this->url('store'));
		}

		return $this->view("{$this->views_folder}/create", compact('resource', 'form'));
	}

	public function store() {
		$params = func_get_args();
		$input = $this->input();

		if ($resource = $this->repository->create($input)) {
			$params []= $resource->id;
			return $this->redirect('edit', $params)->with('notice', ['success', 'Resource created successfully']);
		}
		else {
			return $this->redirect('create', $params)->withInput()->withErrors($this->repository->getErrors());
		}
	}

	public function show() {
		$resource = $this->find($params = func_get_args());
		return $this->view("{$this->views_folder}/show", compact('resource'));
	}

	public function edit() {
		$resource = $this->find($params = func_get_args());

		$this->editing($resource);
		$this->composing($resource);

		$form = $this->form;

		if ($this->form) {
			$form->setAction($this->url('update', $resource->id));
			$form->setModel($resource);
			$form->setMethod('put');
		}

		return $this->view("{$this->views_folder}/edit", compact('resource', 'form'));
	}

	public function update() {
		$resource = $this->find($params = func_get_args());
		$input = array_merge($resource->toArray(), $this->input());

		if ($this->repository->update($resource, $input)) {
			return $this->redirect('edit', $params)->with('notice', ['success', 'Resource updated successfully']);
		}
		else {
			return $this->redirect('edit', $params)->withInput()->withErrors($this->repository->getErrors());
		}
	}

	public function destroy() {
		$resource = $this->find($params = func_get_args());
		$this->repository->delete($resource);
		array_pop($params);
		$this->redirect('index', $params)->with('notice', ['success', 'Resource deleted successfully']);
	}
}
