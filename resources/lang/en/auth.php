<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Authentication Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines are used during authentication for various
    | messages that we need to display to the user. You are free to modify
    | these language lines according to your application's requirements.
    |
    */

    'credential_not_correctly' => 'Login failed.',
    'succeeded' => 'Login succeeded',
    'get_info_succeeded' => 'Get info succeeded',
    'account_not_verify' => 'Account not verify',
    'account_not_approval' => 'Account not approval',
    'password' => 'The provided password is incorrect.',
    'throttle' => 'Too many login attempts. Please try again in :seconds seconds.',
    'logout' => 'Logout success',
    'register' => [
        'success' => 'Register success, Please contact Admin to approval',
        'failed' => 'Register failed',
        'verify_success' => 'Verify success, please wait for approval',
        'verify_failed' => 'Verify failed, please try again',
        'email_has_verified' => 'Email has verified!'
    ],
    'add_account' => [
        'success' => 'Invite account success, Please wait to member verify email',
        'failed' => 'Invite account failed',
    ],
    'token_blacklist' => 'Token in blacklist',
    'token_invalid' => 'Token invalid',
    'token_expired' => 'Login session exprired, login again',
    'token_missing' => 'Token missing',
    'update_info' => [
        'success' => 'Update info success',
        'failed' => 'Update info failed'
    ],
    'update_pass' => [
        'old_pass_incorrect' => 'Old password incorrect',
        'success' => 'Update password success',
        'failed' => 'Update password failed'
    ],
    'personal_token_missing' => 'Personal token missing',
    'personal_token_invalid' => 'Personal token invalid',
];
