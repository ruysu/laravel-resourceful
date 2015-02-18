<?php namespace Ruysu\Resourceful;

use Illuminate\Http\Request;
use Illuminate\Html\FormBuilder as Form;
use Ruysu\Forms\FormBuilder;
use Ruysu\Forms\FormField;

abstract class ResourcefulFormBuilder extends FormBuilder {
	protected $repository;

	public function __construct(ResourcefulRepositoryInterface $repository, Form $builder, Request $request) {
		$this->repository = $repository;
		parent::__construct($builder, $request);
	}
}
