<?php

use function Pest\Laravel\getJson;

it('tests application health', function () {
    getJson(route('api.v1.health'))
        ->assertJson(['ping' => 'pong'])
        ->assertOk();
});
