<?php

use PhpCsFixer\Config;
use PhpCsFixer\Finder;

$rules = [
    '@PSR2'                                       => true,
    'array_indentation'                           => true,
    'array_syntax'                                => ['syntax' => 'short'],
    'ordered_imports'                             => ['sortAlgorithm' => 'alpha'],
    'no_unused_imports'                           => true,
    'combine_consecutive_unsets'                  => true,
    'method_separation'                           => true,
    'no_multiline_whitespace_before_semicolons'   => true,
    'single_quote'                                => true,

    'blank_line_after_opening_tag'                => true,
    'blank_line_before_return'                    => true,
    'braces'                                      => [
        'allow_single_line_closure' => true,
    ],
    // 'cast_spaces' => true,
    // 'class_definition' => array('singleLine' => true),
    'concat_space'                                => ['spacing' => 'one'],
    'declare_equal_normalize'                     => true,
    'function_typehint_space'                     => true,
    'hash_to_slash_comment'                       => true,
    'include'                                     => true,
    'lowercase_cast'                              => true,
    // 'native_function_casing' => true,
    // 'new_with_braces' => true,
    // 'no_blank_lines_after_class_opening' => true,
    // 'no_blank_lines_after_phpdoc' => true,
    'no_empty_comment'                            => true,
    // 'no_empty_phpdoc' => true,
    // 'no_empty_statement' => true,
    'no_extra_consecutive_blank_lines'            => [
        'curly_brace_block',
        'extra',
        'parenthesis_brace_block',
        'square_brace_block',
        'throw',
        'use',
    ],
    'no_leading_import_slash'                     => true,
    'no_leading_namespace_whitespace'             => true,
    // 'no_mixed_echo_print' => array('use' => 'echo'),
    'no_multiline_whitespace_around_double_arrow' => true,
    // 'no_short_bool_cast' => true,
    // 'no_singleline_whitespace_before_semicolons' => true,
    'no_spaces_around_offset'                     => true,
    // 'no_trailing_comma_in_list_call' => true,
    // 'no_trailing_comma_in_singleline_array' => true,
    // 'no_unneeded_control_parentheses' => true,

    'no_whitespace_before_comma_in_array'         => true,
    'no_whitespace_in_blank_line'                 => true,
    // 'normalize_index_brace' => true,
    'object_operator_without_whitespace'          => true,
    // 'php_unit_fqcn_annotation' => true,
    'phpdoc_align'                                => true,
    // 'phpdoc_annotation_without_dot' => true,
    // 'phpdoc_indent' => true,
    // 'phpdoc_inline_tag' => true,
    // 'phpdoc_no_access' => true,
    // 'phpdoc_no_alias_tag' => true,
    // 'phpdoc_no_empty_return' => true,
    // 'phpdoc_no_package' => true,
    // 'phpdoc_no_useless_inheritdoc' => true,
    // 'phpdoc_return_self_reference' => true,
    // 'phpdoc_scalar' => true,
    // 'phpdoc_separation' => true,
    // 'phpdoc_single_line_var_spacing' => true,
    // 'phpdoc_summary' => true,
    // 'phpdoc_to_comment' => true,
    // 'phpdoc_trim' => true,
    // 'phpdoc_types' => true,
    // 'phpdoc_var_without_name' => true,
    // 'pre_increment' => true,
    'return_type_declaration'                     => true,
    // 'self_accessor' => true,
    // 'short_scalar_cast' => true,
    // 'single_blank_line_before_namespace'          => true,
    // 'single_class_element_per_statement' => true,
    // 'space_after_semicolon' => true,
    'standardize_not_equals'                      => true,
    'ternary_operator_spaces'                     => true,
    'trailing_comma_in_multiline_array'           => true,
    'trim_array_spaces'                           => true,
    'unary_operator_spaces'                       => true,
    'whitespace_after_comma_in_array'             => true,
];

$finder = Finder::create()
    ->notPath('storage')
    ->notPath('vendor')
    ->in(__DIR__)
    ->name('*.php')
    ->notName('_ide_helper')
    ->notName('*.blade.php')
    ->ignoreDotFiles(true)
    ->ignoreVCS(true);

return Config::create()
    ->setRules($rules)
    ->setUsingCache(false)
    ->setFinder($finder);

$rulesMain = [
    '@PSR2'                             => true,
    'array_syntax'                      => ['syntax' => 'short'],
    'ordered_imports'                   => ['sortAlgorithm' => 'alpha'],
    'no_unused_imports'                 => true,
    'no_useless_else'                   => true,
    'no_useless_return'                 => true,
    'trailing_comma_in_multiline_array' => true,
    'no_superfluous_elseif'             => true,
    'no_unneeded_curly_braces'          => true,
    'phpdoc_order'                      => true,
    'phpdoc_types_order'                => true,
    'align_multiline_comment'           => true,
];

/*$mainRules = [
    'align_multiline_comment'                     => [
        'comment_type' => 'phpdocs_only',
    ],
    'array_syntax'                                => [
        'syntax' => 'short',
    ],
    'binary_operator_spaces'                      => [
        'align_equals'       => false,
        'align_double_arrow' => null,
    ],
    'blank_line_before_statement'                 => [
        'statements' => [
            'return',
        ],
    ],
    'concat_space'                                => [
        'spacing' => 'none',
    ],
    'general_phpdoc_annotation_remove'            => [
        'access',
        'package',
        'subpackage',
    ],
    'no_extra_consecutive_blank_lines'            => [
        'throw',
        'use',
        'useTrait',
        'extra',
    ],
    'no_mixed_echo_print'                         => [
        'use' => 'echo',
    ],
    'no_spaces_around_offset'                     => [
        'inside',
    ],
    'ordered_imports'                             => [
        'sortAlgorithm' => 'length',
    ],
    'phpdoc_no_alias_tag'                         => [
        'type' => 'var',
    ],

    'blank_line_after_namespace'                  => true,
    'blank_line_after_opening_tag'                => true,
    'braces'                                      => true,
    'cast_spaces'                                 => true,
    'class_definition'                            => true,

    'declare_equal_normalize'                     => true,
    'elseif'                                      => true,
    'encoding'                                    => true,
    'full_opening_tag'                            => true,
    'function_declaration'                        => true,
    'function_typehint_space'                     => true,

    'hash_to_slash_comment'                       => true,
    'heredoc_to_nowdoc'                           => true,
    'include'                                     => true,
    'indentation_type'                            => true,
    'line_ending'                                 => true,
    'lowercase_cast'                              => true,
    'lowercase_constants'                         => true,
    'lowercase_keywords'                          => true,
    'magic_constant_casing'                       => true,
    'method_argument_space'                       => true,
    'method_separation'                           => true,
    'native_function_casing'                      => true,
    'no_alias_functions'                          => true,
    'no_blank_lines_after_class_opening'          => true,
    'no_blank_lines_after_phpdoc'                 => true,
    'no_closing_tag'                              => true,
    'no_empty_phpdoc'                             => true,
    'no_empty_statement'                          => true,

    'no_leading_import_slash'                     => true,
    'no_leading_namespace_whitespace'             => true,

    'no_multiline_whitespace_around_double_arrow' => true,
    'no_multiline_whitespace_before_semicolons'   => true,
    'no_short_bool_cast'                          => true,
    'no_singleline_whitespace_before_semicolons'  => true,
    'no_spaces_after_function_name'               => true,

    'no_spaces_inside_parenthesis'                => true,
    'no_trailing_comma_in_list_call'              => true,
    'no_trailing_comma_in_singleline_array'       => true,
    'no_trailing_whitespace'                      => true,
    'no_trailing_whitespace_in_comment'           => true,
    'no_unneeded_control_parentheses'             => true,
    'no_unreachable_default_argument_value'       => true,
    'no_unused_imports'                           => true,
    'no_useless_return'                           => true,
    'no_whitespace_before_comma_in_array'         => true,
    'no_whitespace_in_blank_line'                 => true,
    'normalize_index_brace'                       => true,
    'not_operator_with_successor_space'           => true,
    'object_operator_without_whitespace'          => true,

    'phpdoc_indent'                               => true,
    'phpdoc_inline_tag'                           => true,

    'phpdoc_no_useless_inheritdoc'                => true,
    'phpdoc_scalar'                               => true,
    'phpdoc_single_line_var_spacing'              => true,
    'phpdoc_summary'                              => true,
    'phpdoc_to_comment'                           => true,
    'phpdoc_trim'                                 => true,
    'phpdoc_types'                                => true,
    'phpdoc_var_without_name'                     => true,
    'psr4'                                        => true,
    'self_accessor'                               => true,
    'short_scalar_cast'                           => true,
    'single_blank_line_at_eof'                    => true,
    'single_blank_line_before_namespace'          => true,
    'single_class_element_per_statement'          => true,
    'single_import_per_statement'                 => true,
    'single_line_after_imports'                   => true,
    'single_quote'                                => true,
    'space_after_semicolon'                       => true,
    'standardize_not_equals'                      => true,
    'switch_case_semicolon_to_colon'              => true,
    'switch_case_space'                           => true,
    'ternary_operator_spaces'                     => true,
    'trailing_comma_in_multiline_array'           => true,
    'trim_array_spaces'                           => true,
    'unary_operator_spaces'                       => true,
    'visibility_required'                         => [
        'method',
        'property',
    ],
    'whitespace_after_comma_in_array'             => true,
];*/