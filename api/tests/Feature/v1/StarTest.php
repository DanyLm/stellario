<?php

use App\Models\Star;

it('does get all stars', function () {
    $response = $this->getJson('/api/v1/stars');
    $response->assertStatus(200);
});

it('can create a star', function () {
    $attributes = Star::factory()->raw();
    $response = $this->postJson('/api/v1/stars', $attributes);
    $star = Star::orderBy('created_at', 'desc')->first();

    $response->assertStatus(201)->assertJson([
        'data' => $star->toArray()
    ]);

    $this->assertDatabaseHas('stars', [
        'first_name' => $attributes['first_name'],
        'last_name' => $attributes['last_name'],
        'popularity' => $attributes['popularity'],
        'description' => $attributes['description']
    ]);
});

it('does not create a star without missing fields', function () {
    $response = $this->postJson('/api/v1/stars', []);
    $response->assertStatus(422);
});

it('can fetch a star', function () {
    $star = Star::factory()->create();

    $response = $this->getJson("/api/v1/stars/{$star->id}");
    $response->assertStatus(200)->assertJson([
        'data' => $star->toArray()
    ]);
});

it('can update a star', function () {
    $star = Star::factory()->create();
    $updatedStar = [
        'first_name' => "$star->first_name UPDATED",
        'last_name' => "$star->last_name UPDATED",
        'popularity' => 1,
        'description' => "$star->description UPDATED"
    ];
    $response = $this->putJson("/api/v1/stars/{$star->id}", $updatedStar);
    $response->assertStatus(200)->assertJson(['data' => $updatedStar]);
    $this->assertDatabaseHas('stars', $updatedStar);
});


it('can delete a star', function () {
    $star = Star::factory()->create();
    $starCount = Star::count();
    $response = $this->deleteJson("/api/v1/stars/{$star->id}");
    $response->assertStatus(200)->assertJson(['toast' => [
        'message' => 'Star supprimée aves succès',
        'type' => 'success'
    ]]);
    $this->assertCount($starCount - 1, Star::all());
});
