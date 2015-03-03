<?php namespace Ruysu\Resourceful;

use anlutro\LaravelRepository\EloquentRepository;

abstract class ResourcefulDatabaseRepository extends EloquentRepository implements ResourcefulRepositoryInterface {
	use ResourcefulRepositoryTrait;
}
