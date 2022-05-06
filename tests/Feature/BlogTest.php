<?php

namespace Tests\Feature;

use App\Category;
use App\Post;
use App\Tag;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class BlogTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_can_visit_homepage_with_no_post_available()
    {
        $response = $this->get(route('homepage'));
        $response->assertStatus(200);
        $response->assertSee('Blog Test');
        $response->assertSee('Not Posted Yet');
    }

    public function test_guest_can_visit_homepage_with_post_available()
    {
        $post = factory(Post::class, 2)->create();
        $response = $this->get(route('homepage'));
        $response->assertStatus(200);
        $response->assertSee('Blog Test');
        $response->assertSeeText($post[0]->title);
        $response->assertSeeText($post[1]->title);
        $response->assertDontSee('Not Posted Yet');
    }

    public function test_guest_can_visit_detail_post_blog()
    {
        $category = factory(Category::class)->create();
        $tags     = factory(Tag::class, 2)->create();
        $post     = factory(Post::class)->create(['category_id' => $category->id]);
        $post->tags()->attach($tags);
        $response = $this->get(route('blog.detail', $post->slug));
        $response->assertStatus(200);
        $response->assertSeeText($post->title);
        $response->assertSeeText($post->short_description);
        $response->assertSeeText($post->content);
        $response->assertSeeText($category->name);
        $response->assertSeeText($post->category->name);
        $response->assertSeeText($post->tags[1]->name);
        $response->assertSeeText($post->tags[1]->name);
        $response->assertSee('article-header--rating');
        $response->assertSee('article-header--rating-star');
        $response->assertSee('article-header--rating-rate');
        $response->assertSee('article-header--rating-qty');
        $response->assertSee('Review Post');
        $response->assertSee('Leave a review');
        $response->assertSee('comment-form-wrap pt-5');
        $response->assertSee('search-form');
        $response->assertSee('Categories');
        $response->assertSee('Tags');
    }

    public function test_guest_can_view_categories_list_in_detail_post()
    {
        $category = factory(Category::class)->create();
        $post     = factory(Post::class)->create(['category_id' => $category->id]);
        $response = $this->get(route('blog.detail', $post->slug));
        $response->assertStatus(200);
        $response->assertSee('Categories');
        $response->assertSee($category->name);
    }

    public function test_guest_can_view_tags_list_in_detail_post()
    {
        $category = factory(Category::class)->create();
        $tags     = factory(Tag::class, 2)->create();
        $post     = factory(Post::class)->create(['category_id' => $category->id]);
        $response = $this->get(route('blog.detail', $post->slug));
        $response->assertStatus(200);
        $response->assertSee('Tags');
        $response->assertSee($tags[0]->name);
        $response->assertSee($tags[1]->name);
    }

    public function test_guest_can_visit_post_by_categories()
    {
        $category = factory(Category::class)->create();
        $post     = factory(Post::class)->create(['category_id' => $category->id]);
        $response = $this->get(route('blog.categories', $category->slug));
        $response->assertStatus(200);
        $response->assertSee($post->title);
        $response->assertSee($post->short_desc);
    }

    public function test_guest_can_search_post()
    {
        $category = factory(Category::class)->create();
        $post     = factory(Post::class)->create(['title' => 'ini title', 'category_id' => $category->id]);
        $response = $this->get(route('blog.search', ['ti']));
        $response->assertStatus(200);
        $response->assertSee($post->title);
        $response->assertSee($post->short_desc);
    }

    public function test_guest_not_logged_cannot_post_review()
    {
        $post = factory(Post::class)->create();
        $response = $this->get(route('blog.detail', $post->slug));
        $response->assertStatus(200);
        $response->assertSee('Rating');
        $response->assertSee('Message');
        $response_rating = $this->post(route('rating.store', []));
        $response_rating->assertRedirect('login');
    }

    public function test_guest_logged_can_post_review()
    {
        $user = factory(User::class)->create();
        $post = factory(Post::class)->create();
        $this->actingAs($user);
        $response = $this->get(route('blog.detail', $post->slug));
        $response->assertStatus(200);
        $response->assertSee('Rating');
        $response->assertSee('Message');
        $response_rating = $this->post(route('rating.store', [
            'posts_id'    => $post->id,
            'users_id'    => $user->id,
            'comments'    => 'Ini comment review',
            'star_rating' => 4
        ]));
        $response_rating->assertRedirect(route('blog.detail', $post->slug));
        $response2 = $this->get(route('blog.detail', $post->slug));
        $response2->assertSee('4');
        $response2->assertSee('(1 Reviews)');
        $response2->assertSee($user->name);
        $response2->assertSee($user->email);
        $response2->assertSee('Ini comment review');
    }
}
