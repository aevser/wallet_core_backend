<?php

return [
    'transaction' => [
        'success' => [
            'deposit' => 'Средства успешно начислились пользователю.',
            'withdraw' => 'Средства успешно списались у пользователя.',
            'transfer' => 'Перевод успешно выполнен.'
        ],

        'error' => [
            'must_be_positive' => 'Сумма должна быть больше нуля.',
            'insufficient_funds' => 'Недостаточно средств.',
            'cannot_transfer_to_self' => 'Нельзя переводить самому себе.'
        ]
    ]
];
