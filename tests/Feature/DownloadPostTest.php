<?php

namespace Tests\Feature;

use App\Post;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Request;
use Tests\TestCase;

class DownloadPostTest extends TestCase
{
    use RefreshDatabase;

    public function test_download_page()
    {
        $user = factory(User::class)->create();
        $post = factory(Post::class, 2)->create();
        $this->actingAs($user);
        $response = $this->get(route('post.download'));
        $response->assertStatus(200);
        $response->assertSee('Download Posts');
        $response->assertSee('#check_all');
        $response->assertSee('#download-all');
        $response->assertSeeText($post[0]->title);
        $response->assertSeeText($post[1]->title);
        $response->assertSee('fas fa-download');
        $response->assertSuccessful();
    }

    public function test_download_single_post()
    {
        $user = factory(User::class)->create();
        $post = factory(Post::class)->create();
        $this->actingAs($user);
        $response = $this->get(route('post.download.data', $post->id));
        $this->assertTrue($response->headers->get('content-type') == 'text/plain; charset=UTF-8');
        $this->assertTrue($response->headers->get('content-disposition') == 'attachment; filename="'.$post->title.' '.$post->created_at->format('dmY').'.txt');
        $response->assertSuccessful();
    }

    // public function test_download_multiple_post()
    // {
    //     $user  = factory(User::class)->create();
    //     $posts = factory(Post::class, 3)->create();
    //     $this->actingAs($user);
    //     $arr   = [];
    //     foreach ($posts as $post) { array_push($arr, $post->id); }
    //     $new_arr  = json_encode($arr);
    //     $response = $this->post(route('post.download.multiple', [ 'data' => $new_arr ]));
    //     $this->assertTrue($response->headers->get('content-type') == 'application/zip');
    //     $fileName = now().'.zip';
    //     $this->assertTrue($response->headers->get('content-disposition') == 'attachment; filename="'.$fileName.'"');
    //     unlink(public_path('storage/txt/'.$fileName));
    //     $response->assertSuccessful();
    // }
}
