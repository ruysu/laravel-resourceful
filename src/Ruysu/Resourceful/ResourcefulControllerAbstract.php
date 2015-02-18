<?php namespace Ruysu\Resourceful;

use anlutro\LaravelController\Controller;
use Ruysu\Forms\FormBuilder;

abstract class ResourcefulControllerAbstract extends Controller {
	/**
	 * The ResourcefulRepositoryInterface instance.
	 *
	 * @var \Ruysu\Resourceful\ResourcefulRepositoryInterface
	 */
	protected $repository;
	protected $form;

	/**
	 * @param \Ruysu\Resourceful\ResourcefulRepositoryInterface $repository
	 */
	public function __construct(ResourcefulRepositoryInterface $repository, FormBuilder $form = null) {
		$this->repository = $repository;
		$this->form = $form;
	}

	public function find($params) {
		$resource_id = end($params);
		return $this->repository->findByKey($resource_id);
	}

	protected function indexing($resources) {}
	protected function creating($resource) {}
	protected function editing($resource) {}
	protected function composing($resource) {}
}
