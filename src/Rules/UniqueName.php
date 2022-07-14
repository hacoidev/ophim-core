<?php

namespace Ophim\Core\Rules;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\DB;

class UniqueName implements Rule
{
    protected $table;
    protected $excludeField;
    protected $excludeVal;
    protected $md5Field;
    protected $nameField;

    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct(string $table, $nameField = 'name',  $md5Field = 'name_md5', $excludeField, $excludeVal)
    {
        $this->table = $table;
        $this->md5Field = $md5Field;
        $this->excludeField = $excludeField;
        $this->excludeVal = $excludeVal;
        $this->nameField = $nameField;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        return DB::table($this->table)->where($this->excludeField, '!=', $this->excludeVal)->where($this->md5Field, md5($value))->doesntExist();
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return ":attribute must be unique";
    }
}
