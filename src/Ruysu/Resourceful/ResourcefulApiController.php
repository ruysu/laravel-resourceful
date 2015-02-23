<?php namespace Ruysu\Resourceful;

abstract class ResourcefulApiController extends ResourcefulControllerAbstract {
	protected $resource_key = 'resource';

	public function index() {
		$resources = parent::index();
		return $this->jsonResponse($resources);
	}

	public function create() {
		$resource = parent::create();
		$form = $this->form->render();

		return $this->jsonResponse(compact('form'));
	}

	public function store() {
		$resource = parent::store();

		return $this->jsonResponse(array(
			'success' => (bool) $resource,
			'errors' => $resource ? false : $this->repository->getErrors(),
			$this->resource_key => $resource
		));
	}

	public function show() {
		$resource = parent::show();

		return $this->jsonResponse($resource);
	}

	public function edit() {
		$resource = parent::edit();
		$form = $this->form->render();

		return $this->jsonResponse(compact('form'));
	}

	public function update() {
		$updated = (bool) parent::update();

		return $this->jsonResponse(array(
			'success' => (bool) $updated,
			'errors' => $updated ? false : $this->repository->getErrors(),
			$this->resource_key => $this->resource
		));
	}

	public function destroy() {
		$destroyed = parent::destroy();

		return $this->jsonResponse(array(
			'success' => (bool) $destroyed,
			'errors' => $destroyed ? false : $this->repository->getErrors()
		));
	}
}
