<?php

use App\Models\Post;
use App\Models\Topic;
use App\Models\User;

use function Pest\Laravel\actingAs;
use function Pest\Laravel\post;

beforeEach(function () {
    $this->validData = fn() => [
        'title' => 'hello world',
        'topic_id' => Topic::factory()->create()->getKey(),
        'body' => 'Incididunt consectetur occaecat, qui tempore sunt animi assumenda accusamus, adipiscing platea aliquet debitis quo rem unde proin perspiciatis numquam justo culpa elit. Venenatis anim, diamlorem. Integer, netus venenatis. Praesentium! Deserunt? Sodales lobortis quibusdam alias qui iste, elementum nostrud eu fugit sapien eaque? Ad irure unde commodi excepteur eos consectetuer ultricies, adipisicing viverra, molestie placeat, exercitationem porta, curabitur qui fugiat eu, sociis ad mollit minus ullamco cras dolores occaecat, ullam doloremque illum varius, donec tristique scelerisque potenti, mollis aliquid lectus senectus pellentesque libero aute harum montes facilisi. Animi, cum, ornare voluptates! Interdum odio. Semper! Dicta accumsan, ad sequi nobis lacinia quaerat.

                Sociosqu rerum aliquid rerum accumsan eros, provident debitis proin pellentesque? Ab rutrum facilis iusto? Voluptate eget! Nihil consectetuer, deserunt fermentum erat. Suscipit earum hymenaeos? Maxime sed atque magna, magna quia tellus sagittis voluptate netus eu habitasse, saepe sit per illum. Explicabo fugiat! Modi eveniet, do harum inceptos ea optio assumenda cillum aliquid distinctio veritatis, tempora, consequat, rem irure? Corporis ipsam? Orci inceptos cumque aperiam, quo nisl quis ac officiis vulputate, illo dolore curae vehicula sagittis tincidunt odio a vivamus molestie. Pulvinar placeat repellat rerum harum, consectetur dicta ultrices, porro eleifend! Error nostrud aperiam, amet harum lacus. Nullam lectus quas! Montes.

                Vulputate sagittis minus, eget cupiditate penatibus, nihil pharetra ultrices! Lorem, pretium minima metus asperiores interdum aptent? Nihil, ut venenatis sem, neque ut. Dignissimos. Rem. Aute eveniet, sodales! Suscipit magni eveniet, magnam ipsa perspiciatis urna enim ornare, duis molestiae, excepteur saepe placeat assumenda erat occaecati maxime tincidunt tincidunt anim tempore aenean sed, accusamus irure diam. Iste vulputate natus deleniti, feugiat auctor, saepe earum mauris, mi diam integer quibusdam autem! Urna quia quidem risus natus placerat ut incididunt. Adipisci. Nibh. Aliquip earum. Temporibus distinctio voluptatem cumque, eu iste aliquid condimentum fugit expedita! Felis? Natus velit, iste! Eleifend mattis! Proident tristique dis id.

                Illo minim velit ipsum consectetuer placeat facere fringilla voluptatum orci adipisicing tempor sagittis feugiat ullamco fringilla dicta? Iste, excepturi dolor praesent excepteur, occaecati erat sem accusantium, sapiente nibh, veniam atque pellentesque incidunt, interdum dapibus aute hac, eos viverra mattis dis, fringilla volutpat curabitur phasellus, iste lobortis! Sequi nam exercitation, atque, cubilia? Urna iaculis tellus consectetur diam, eveniet voluptatem anim pharetra mollis laudantium bibendum ipsa, voluptate ultricies, minim assumenda quo? Laboris deleniti proin! Delectus. Consectetur incididunt totam tincidunt cillum hac nec quae. Excepturi praesent earum ornare molestiae debitis mattis, eleifend penatibus inceptos quam. Voluptas imperdiet lobortis aliqua? Erat tortor quisque fringilla.'
    ];
});

it('requires authentication',function () {
    post(route('posts.store'))->assertRedirect(route('login'));
});

it('can store a post', function () {
    $user = User::factory()->create();
    $data = value($this->validData);
    actingAs($user)
        ->post(route('posts.store', $data));

    $this->assertDatabaseHas(Post::class, [
        ...$data,
        'user_id' => $user->id
    ]);
});

it('redirects to the show page', function () {
    $user = User::factory()->create();
    actingAs($user)
        ->post(route('posts.store',value($this->validData)))
        ->assertRedirect(Post::latest('id')->first()->showRoute());

});


it('requires a valid data', function (array $badData, array|string $errors) {
    actingAs(User::factory()->create())
        ->post(route('posts.store', [...value($this->validData), ...$badData]))
        ->assertInvalid($errors);
         
})->with([
    [['title' => null], 'title'],
    [['title' => 1], 'title'],
    [['title' => 1.3], 'title'],
    [['title' => true], 'title'],
    [['title' => str_repeat('a', 121)], 'title'],
    [['title' => str_repeat('a', 9)], 'title'],
    [['topic_id' => null], 'topic_id'],
    [['topic_id' => -1], 'topic_id'],
    [['body' => null], 'body'],
    [['body' => 1], 'body'],
    [['body' => 1.3], 'body'],
    [['body' => true], 'body'],
    [['body' => str_repeat('a', 10_001)], 'body'],
    [['body' => str_repeat('a', 99)], 'body'],
]);