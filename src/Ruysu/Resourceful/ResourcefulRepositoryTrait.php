<?php namespace Ruysu\Resourceful;

trait ResourcefulRepositoryTrait {
	public function index(){
		return $this->performQuery($this->newQuery(), true);
	}

	public function create(array $attributes, $validate = true) {
		return $this->perform('create', $this->getNew(), $attributes, $validate);
	}
}
