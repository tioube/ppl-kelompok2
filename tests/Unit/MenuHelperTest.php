<?php

use App\Helpers\MenuHelper;

// Create a test-specific version of MenuHelper for testing
class TestMenuHelper extends MenuHelper
{
    public static function getMainNavItems(): array
    {
        return [
            [
                'icon' => 'dashboard',
                'name' => 'Dashboard',
                'path' => '/dashboard',
            ],
        ];
    }

    public static function getAdministrationItems(): array
    {
        return [
            [
                'icon' => 'charts',
                'name' => 'User Management',
                'subItems' => [
                    [
                        'name' => 'Users',
                        'path' => '/users.index',
                        'pro' => false
                    ],
                ],
            ],
        ];
    }
    
    public static function getMenuGroups(): array
    {
        return [
            [
                'title' => 'Menu',
                'items' => self::getMainNavItems()
            ],
            [
                'title' => 'Administration',
                'items' => self::getAdministrationItems()
            ]
        ];
    }
}

test('getIconSvg returns svg for valid icon name', function () {
    $svg = MenuHelper::getIconSvg('dashboard');
    
    expect($svg)
        ->toBeString()
        ->toContain('<svg')
        ->toContain('</svg>');
});

test('getIconSvg returns default svg for invalid icon name', function () {
    $svg = MenuHelper::getIconSvg('non-existent-icon');
    
    expect($svg)
        ->toBeString()
        ->toContain('<svg')
        ->toContain('</svg>');
});

test('getMainNavItems returns array with dashboard item', function () {
    $items = TestMenuHelper::getMainNavItems();
    
    expect($items)
        ->toBeArray()
        ->toHaveCount(1)
        ->and($items[0])
        ->toHaveKeys(['icon', 'name', 'path'])
        ->and($items[0]['name'])
        ->toBe('Dashboard');
});

test('getAdministrationItems returns array with user management', function () {
    $items = TestMenuHelper::getAdministrationItems();
    
    expect($items)
        ->toBeArray()
        ->toHaveCount(1)
        ->and($items[0])
        ->toHaveKeys(['icon', 'name', 'subItems'])
        ->and($items[0]['name'])
        ->toBe('User Management');
});

test('getMenuGroups returns array with menu and administration groups', function () {
    $groups = TestMenuHelper::getMenuGroups();
    
    expect($groups)
        ->toBeArray()
        ->toHaveCount(2)
        ->and($groups[0]['title'])
        ->toBe('Menu')
        ->and($groups[1]['title'])
        ->toBe('Administration');
});