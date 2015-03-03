<?php namespace Ruysu\Resourceful;

use anlutro\LaravelRepository\EloquentRepository;
use RuntimeException;

abstract class ResourcefulEloquentRepository extends EloquentRepository implements ResourcefulRepositoryInterface {
	use ResourcefulRepositoryTrait;
}
