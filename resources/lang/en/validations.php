<?php

return [
    'deposit' => [
        'user_id' => [
            'required' => 'The user ID field is required.',
            'integer' => 'The user ID must be an integer.',
            'exists' => 'User not found.'
        ],
        'amount' => [
            'required' => 'The amount field is required.',
            'numeric' => 'The amount must be a number.',
        ],
        'comment' => [
            'string' => 'The comment must be a string.',
            'max' => 'The comment may not be greater than 500 characters.'
        ]
    ],

    'withdraw' => [
        'user_id' => [
            'required' => 'The user ID field is required.',
            'integer' => 'The user ID must be an integer.',
            'exists' => 'User not found.'
        ],
        'amount' => [
            'required' => 'The amount field is required.',
            'numeric' => 'The amount must be a number.',
        ],
        'comment' => [
            'string' => 'The comment must be a string.',
            'max' => 'The comment may not be greater than 500 characters.'
        ]
    ],

    'transfer' => [
        'from_user_id' => [
            'required' => 'The sender ID field is required.',
            'integer' => 'The sender ID must be an integer.',
            'exists' => 'Sender not found.',
        ],
        'to_user_id' => [
            'required' => 'The recipient ID field is required.',
            'integer' => 'The recipient ID must be an integer.',
            'exists' => 'Recipient not found.',
        ],
        'amount' => [
            'required' => 'The amount field is required.',
            'numeric' => 'The amount must be a number.',
        ],
        'comment' => [
            'string' => 'The comment must be a string.',
            'max' => 'The comment may not be greater than 500 characters.'
        ]
    ]
];
