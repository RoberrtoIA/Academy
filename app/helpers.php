<?php

if (!function_exists('replaceRequiredForFillableRules')) {

    /**
     * Replace all `required` rule for `filled` rule in validation rules array.
     *
     * @param array $rules
     * @return array
     */
    function replaceRequiredForFillableRules(array $rules): array
    {
        return collect($rules)->map(function ($attr) {
            if (!is_array($attr)) {
                $attr = explode('|', $attr);
            }

            return collect($attr)->map(function ($rule) {
                if (is_string($rule) and $rule === 'required') {
                    return 'filled';
                }
                return $rule;
            });
        })->all();
    }
}
