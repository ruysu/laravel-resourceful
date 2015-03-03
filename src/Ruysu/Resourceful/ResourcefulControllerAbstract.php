<?php namespace Ruysu\Resourceful;

use anlutro\LaravelController\Controller;
use Route;
use Input;
use File;
use NotFoundException;

abstract class ResourcefulControllerAbstract extends Controller implements ResourcefulControllerInterface {
	/**
	 * The ResourcefulRepositoryInterface instance.
	 *
	 * @var \Ruysu\Resourceful\ResourcefulRepositoryInterface
	 */
	protected $repository;

	/**
	 * The ResourcefulFormBuilder instance.
	 *
	 * @var \Ruysu\Resourceful\ResourcefulFormBuilder
	 */
	protected $form;

	/**
	 * The Route params.
	 *
	 * @var array
	 */
	protected $parameters;
	protected $resource;
	protected $input;
	protected $files = [];

	/**
	 * @param \Ruysu\Resourceful\ResourcefulRepositoryInterface $repository
	 */
	public function __construct(ResourcefulRepositoryInterface $repository, ResourcefulFormBuilder $form = null) {
		$this->repository = $repository;
		$this->form = $form;
		$this->parameters = Route::current()->parameters();
	}

	public function index() {
		$resources = $this->repository->index();

		method_exists($this, 'indexing') && $this->indexing($resources);

		return $resources;
	}

	public function create() {
		$resource = $this->repository->getNew();

		method_exists($this, 'creating') && $this->creating($resource);
		method_exists($this, 'composing') && $this->composing($resource);

		$form = $this->form;

		if ($this->form) {
			$form->setAction($this->url('store', $this->parameters));
		}

		return $resource;
	}

	public function store() {
		$this->input = $this->input();

		method_exists($this, 'storing') && $this->storing();
		method_exists($this, 'saving') && $this->saving();

		if($this->valid('create')) {
			$resource = $this->repository->create($this->input);

			method_exists($this, 'stored') && $this->stored($resource);
			method_exists($this, 'saved') && $this->saved($resource);
		}
		else {
			$resource = null;
		}

		return $resource;
	}

	public function show() {
		$resource = $this->find();

		method_exists($this, 'showing') && $this->showing($resource);

		return $resource;
	}

	public function edit() {
		$resource = $this->find();
		$form = $this->form;

		if ($this->form) {
			$form->setAction($this->url('update', $this->parameters));
			$form->setModel($resource);
			$form->setMethod('put');
		}

		method_exists($this, 'editing') && $this->editing($resource);
		method_exists($this, 'composing') && $this->composing($resource);

		return $resource;
	}

	public function update() {
		$resource = $this->find();
		$this->input = $this->input();

		method_exists($this, 'updating') && $this->updating($resource);
		method_exists($this, 'saving') && $this->saving($resource);

		if($this->valid('update')) {
			$updated = $this->repository->update($resource, $this->input);

			method_exists($this, 'updated') && $this->updated($resource);
			method_exists($this, 'saved') && $this->saved($resource);
		}
		else {
			$updated = false;
		}

		return $updated ? $resource : false;
	}

	public function destroy() {
		$resource = $this->find();

		method_exists($this, 'destroying') && $this->destroying($resource);

		$destroyed = $this->repository->delete($resource);

		method_exists($this, 'destroyed') && $this->destroyed($resource);

		return $destroyed;
	}

	protected function find() {
		$resource_id = end($this->parameters);

		$this->resource = $this->repository->findByKey($resource_id);

		if (!$this->resource) {
			throw new NotFoundException;
		}

		return $this->resource;
	}

	protected function param($param) {
		return array_get($this->parameters, $param, null);
	}

	protected function valid($action) {
		$validator = $this->repository->getValidator();

		if ($action == 'update') {
			$validator && $validator->setKey($this->resource->id);
		}

		return !$validator || ($validator && $validator->valid($action, $this->input));
	}
}
