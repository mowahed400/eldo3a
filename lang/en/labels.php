<?php

return [
    'login' => [
        'sing_in'    => 'Sign In',
        'sing_up'    => 'Sign Up',
        'login'    => 'Login',
        'logout'    => 'Logout',
        'register'    => 'Register',
        'welcome-text' => 'Please sign-in to your account and start your session',
        'welcome-message' => 'Welcome',
        'create-password' => 'Create a new password',
        'login-text' => 'Sign in to start your session',
        'remember_me' => 'Remember me.',
        'forgot-password' => 'Forgot Password?',
        'forgot-text' => 'You forgot your password? Here you can easily retrieve a new password.',
        'reset-password' => 'Set New Password',
        'reset-message' => 'Reset Password',
        'reset-text' => 'Your new password must be different from previously used passwords',
        'send-reset-link' => 'Send reset link',
    ],

    'models' => [
        'role' => '{1}Role|[2.*]Roles',
        'permission' => '{1}Permission|[2.*]permissions',
        'admin' => '{1}Admin|[2.*]Admins',
        'setting' => '{1}Setting|[2.*]Settings',
        'account' => '{1}Account|[2.*]Accounts',
        'notification' => '{1}Notification|[2.*]Notifications',
        'user' => '{1}User|[2.*]Users',
        'offer' => '{1}Offer|[2.*]Offers',
        'order' => '{1}Order|[2.*]Orders',
        'rate' => '{1}Rate|[2.*]Rates',
        'location' => '{1}Location|[2.*]Locations',
        'image' => '{1}Image|[2.*]Images',
        'section' => '{1}Section|[2.*]Sections',
        'category' => '{1}Category|[2.*]Categories',
        'content' => '{1}Content|[2.*]Contents',
        'paragraph' => '{1}Paragraph|[2.*]Paragraphs',
        'shared_background' => '{1}Shared Background|[2.*]Shared Backgrounds',
        'language' => '{1}Language|[2.*]Languages',
        'margin' => '{1}Margin|[2.*]margins',
    ],

    'fields' => [
        'email' => 'Email',
        'password' => 'Password',
        'password_confirmation' => 'Password confirmation',
        'first_name' => 'Firstname',
        'last_name' => 'Lastname',
        'name' => 'Name',
        'title' => 'Title',
        'price' => 'Price',
        'old_price' => 'Old price',
        'description' => 'Description',
        'content' => 'Content',
        'value' => 'Value',
        'slug' => 'Slug',
        'state' => 'State',
        'expire_date' => 'Expire date',
        'start_date' => 'Start date',
        'end_date' => 'End date',
        'date' => 'Date',
        'created_at' => 'Created at',
        'updated at' => 'Updated at',
        'code' => 'Code',
        'color' => 'Color',
        'note' => 'Note',
        'amount' => 'Amount',
        'discount' => 'Discount',
        'payment_method' => 'Payment method',
        'phone' => 'Phone number',
        'country_code' => 'Country code',
        'phone_2' => 'Secondary phone number',
        'image' => 'Image',
        'avatar' => 'Avatar',
        'dashboard' => 'Dashboard',
        'cost' => 'Cost',
        'sku' => 'SKU',
        'upc' => 'UPC',
        'sub_total' => 'Sub total',
        'total' => 'Total',
        'qty' => 'QTY',
        'invoice' => 'Invoice',
        'currency_code' => 'Currency code',
        'site_tax' => 'Site tax',
        'min_order_amount' => 'Min order amount',
        'image_size' => 'Image size',
        'general' => 'General',
        'privacy_policy' => 'Privacy & Policy',
        'driver_terms_of_use' => 'Driver terms of use',
        'user_terms_of_use' => 'User terms of use',
        'about_us' => 'About us',
        'help' => 'Help',
        'profile' => 'Profile',
        'all' => 'All',
        'receivers' => 'Receivers',
        'message' => 'Message',
        'general_settings' => 'General settings',
        'gender' => 'Gender',
        'banned_to' => 'Banned to',
        'ban' => 'Ban',
        'car' => 'Car',
        'type' => 'Type',
        'car_images' => 'Car images',
        'shifts' => 'Shifts',
        'people_count' => 'People\'s count',
        'days_count' => 'Days count',
        'order_archive_time' => 'Order archive time',
        'offer_archive_time' => 'Offer archive time',
        'archive' => 'Archive times',
        'parent' => 'Parent',
        'voice' => 'Voice',
        'start_from' => 'Start from',
        'end_at' => 'End at',
        'direction' => 'Direction',
        'rtl' => 'right to left',
        'author_and_source' => 'Source',
        'ltr' => 'left to right',
        'terms' => 'Terminologies',
        'mail' => 'Main',
        'choose' => 'Choose',
        'display_type' => 'Display type',
    ],

    'enum' => [
        'type' => [
          1 => 'User',
          2  => 'Driver'
        ],

        'state' => [
            1 => 'Active',
            2 => 'Inactive'
        ],

        'section' => [
            'state' => [
                2 => 'Active',
                1 => 'Inactive',
            ],
            'type' => [
                1 => 'Text and banner',
                2  => 'Image'
            ],
        ],
        'category' => [
            'state' => [
                2 => 'Active',
                1 => 'Inactive',
            ],
            'type' => [
                1 => 'Text and banner',
                2  => 'Image'
            ],
        ]
    ],

    'switchs' => [
        'enable_state' => [
            1 => 'Enabled',
            2 => 'Disabled',
        ],
        'enable_color' => [
            1 => 'success',
            2 => 'danger'
        ]
    ],

    'langs' => [
        'en' => 'En',
        'ar' => 'Ar',
        'fr' => 'Fr',
    ],

];
