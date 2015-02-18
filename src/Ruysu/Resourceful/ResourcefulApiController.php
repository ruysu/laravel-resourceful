<?php namespace Ruysu\Resourceful;

abstract class ResourcefulApiController extends ResourcefulControllerAbstract implements ResourcefulControllerInterface {
	public function index() {
		$resources = $this->repository->index();
		$this->indexing($resources);
		return $this->jsonResponse($resources);
	}

	public function create() {
		$resource = $this->repository->getNew();
		$this->creating($resource);
		$this->composing($resource);
		return $this->jsonResponse($resource);
	}

	public function store() {
		$input = $this->input();

		$response = array('success' => false, 'errors' => true);

		if ($resource = $this->repository->create($input)) {
			$response['success'] = true;
		}
		else {
			$response['errors'] = $this->repository->getErrors();
		}

		return $this->jsonResponse($response);
	}

	public function show() {
		$resource = $this->find($params = func_get_args());
		return $this->jsonResponse($resource);
	}

	public function edit() {
		$resource = $this->find($params = func_get_args());
		$this->editing($resource);
		$this->composing($resource);
		return $this->show($resource);
	}

	public function update() {
		$resource = $this->find($params = func_get_args());
		$input = array_merge($resource->toArray(), $this->input());

		$response = array('success' => false, 'errors' => true);

		if ($this->repository->update($resource, $input)) {
			$response['success'] = true;
		}
		else {
			$response['errors'] = $this->repository->getErrors();
		}

		return $this->jsonResponse($response);
	}

	public function destroy() {
		$resource = $this->find($params = func_get_args());
	}
}
