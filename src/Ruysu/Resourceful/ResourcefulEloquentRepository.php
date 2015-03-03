<?php namespace Ruysu\Resourceful;

use anlutro\LaravelRepository\EloquentRepository;
use RuntimeException;

abstract class ResourcefulEloquentRepository extends EloquentRepository implements ResourcefulRepositoryInterface {
	use ResourcefulRepositoryTrait;

	public function update ($entity, array $attributes, $validate = true) {
		if ($this->validator) {
			$this->validator->replace('key', $this->getEntityKey($entity));
		}

		if (!$entity->exists) {
			throw new RuntimeException('Cannot update non-existant model');
		}

		return $this->perform('update', $entity, $attributes, $validate) ? true : false;
	}
}
