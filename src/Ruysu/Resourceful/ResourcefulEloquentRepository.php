<?php namespace Ruysu\Resourceful;

use anlutro\LaravelRepository\EloquentRepository;

class ResourcefulEloquentRepository extends EloquentRepository implements ResourcefulRepositoryInterface {
	use ResourcefulRepositoryTrait;
}
