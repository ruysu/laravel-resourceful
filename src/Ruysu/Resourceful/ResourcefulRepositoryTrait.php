<?php namespace Ruysu\Resourceful;

trait ResourcefulRepositoryTrait {
	public function index(){
		return $this->perform('index', $this->newQuery(), false, false);
	}

	public function performIndex($query) {
		return $this->perform('query', $query, true, false);
	}

	protected function performUpdate($user, array $attributes) {
		$this->uploadFiles($attributes);

		return parent::performUpdate($user, $attributes);
	}

	protected function performCreate($user, array $attributes) {
		$this->uploadFiles($attributes);

		return parent::performCreate($user, $attributes);
	}

	protected function uploadFiles(&$attributes) {
		$files = array_filter($attributes, function($file) {
			return $file instanceof UploadedFile;
		});

		foreach ($files as $key => $file) {
			$method = camel_case("upload_{$key}_file");

			if (method_exists($this, $method)) {
				$attributes[$key] = $this->$method($file);
			}
			else {
				$path = public_path('uploads');
				!is_dir($path) && mkdir($path, 0755, true);
				$file->move($path);
				$attributes[$key] = asset('uploads/' . $file->getClientOriginalName());
			}
		}
		unset($key, $file);
	}
}
