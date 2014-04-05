<?php

class CommentsTableSeeder extends Seeder {

    protected $content1 = 'A comment of some sort.';
    protected $content2 = 'Another really insightful comment.';
    protected $content3 = 'My comment is the best.';


    public function run()
    {
        DB::table('comments')->delete();

        $user_id = User::first()->id;
        $post_id = Post::first()->id;

        DB::table('comments')->insert( array(
            array(
                'user_id'    => $user_id,
                'post_id'    => $post_id,
                'content'    => $this->content1,
                'created_at' => new DateTime,
                'updated_at' => new DateTime,
                'status' => 1
            ),
            array(
                'user_id'    => $user_id,
                'post_id'    => $post_id,
                'content'    => $this->content2,
                'created_at' => new DateTime,
                'updated_at' => new DateTime,
                'status' => 1
            ),
            array(
                'user_id'    => $user_id,
                'post_id'    => $post_id,
                'content'    => $this->content3,
                'created_at' => new DateTime,
                'updated_at' => new DateTime,
                'status' => 1
            ),
            array(
                'user_id'    => $user_id,
                'post_id'    => $post_id+1,
                'content'    => $this->content1,
                'created_at' => new DateTime,
                'updated_at' => new DateTime,
                'status' => 1
            ),
            array(
                'user_id'    => $user_id,
                'post_id'    => $post_id+1,
                'content'    => $this->content2,
                'created_at' => new DateTime,
                'updated_at' => new DateTime,
                'status' => 1
            ),
            array(
                'user_id'    => $user_id,
                'post_id'    => $post_id+2,
                'content'    => $this->content1,
                'created_at' => new DateTime,
                'updated_at' => new DateTime,
                'status' => 1
            ))
        );
    }

}
