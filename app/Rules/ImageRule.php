<?php

namespace App\Rules;

use App\Traits\Data;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\Validator;

class ImageRule implements Rule
{
    use Data;
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public $type;
    public $file;
    public $folder;

    public function __construct($type, $folder, $file)
    {
        $this->type = $type;
        $this->folder = $folder;
        $this->file = $file;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param string $attribute
     * @param mixed $value
     * @return bool
     */
    public function passes($attribute, $value)
    {

        if ($this->type === 'update') {
            if (!is_object($this->file)) {
                $extensions = ['jpg', 'png', 'jpeg', 'gif', 'svg','doc','docx','pdf'];
                $fileExplode = explode('.', $this->file);
                $path = 'storage/images/' . $this->folder . '/' . $this->file;
                Validator::make([$this->file], [ 'file' => 'required|mimes:jpg,png,jpeg,gif,svg,doc,docx,pdf|max:500']);
                if (in_array($fileExplode[1], $extensions)) {
                    return true;
                } else if (file_exists($path)) {
                    return false;
                } else {
                    return true;
                }
            } else {
                $validator = Validator::make([$this->file], [
                    'file' => 'required|mimes:jpg,png,jpeg,gif,svg,doc,docx,pdf|max:500',
                ]);
            }

        }
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The validation error message.';
    }
}
