<?php

return [
    'transaction' => [
        'success' => [
            'deposit' => 'Funds successfully deposited to user.',
            'withdraw' => 'Funds successfully withdrawn from user.',
            'transfer' => 'Transfer completed successfully.'
        ],

        'error' => [
            'must_be_positive' => 'Amount must be greater than zero.',
            'insufficient_funds' => 'Insufficient funds.',
            'cannot_transfer_to_self' => 'Cannot transfer to yourself.'
        ]
    ]
];
