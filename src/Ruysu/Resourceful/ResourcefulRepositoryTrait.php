<?php namespace Ruysu\Resourceful;

trait ResourcefulRepositoryTrait {
	public function index(){
		return $this->performQuery($this->newQuery(), true);
	}
}
