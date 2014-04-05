<?php

class PostsTableSeeder extends Seeder {

    protected $content = 'In mea autem etiam menandri, quot elitr vim ei, eos semper disputationi id? Per facer appetere eu, duo et animal maiestatis. Omnesque invidunt mnesarchum ex mel, vis no case senserit dissentias. Te mei minimum singulis inimicus, ne labores accusam necessitatibus vel, vivendo nominavi ne sed. Posidonium scriptorem consequuntur cum ex? Posse fabulas iudicabit in nec, eos cu electram forensibus, pro ei commodo tractatos reformidans.';

    public function run()
    {
        DB::table('posts')->delete();

        $user_id = User::first()->id;

        DB::table('posts')->insert( array(
            array(
                'user_id'    => $user_id,
                'title'      => 'A Great Blog',
                'slug'       => 'a-great-blog',
                'content'    => $this->content,
                'meta_title' => 'Great Blog',
                'meta_description' => 'This is a great description.',
                'meta_keywords' => 'great,blog',
                'created_at' => new DateTime,
                'updated_at' => new DateTime,
                'status' => 1
            ),
            array(
                'user_id'    => $user_id,
                'title'      => 'A Decent Blog',
                'slug'       => 'a-decent-blog',
                'content'    => $this->content,
                'meta_title' => 'Decent Blog',
                'meta_description' => 'This is a decent description.',
                'meta_keywords' => 'decent,blog',
                'created_at' => new DateTime,
                'updated_at' => new DateTime,
                'status' => 1
            ),
            array(
                'user_id'    => $user_id,
                'title'      => 'A Good Blog',
                'slug'       => 'a-good-blog',
                'content'    => $this->content,
                'meta_title' => 'Good Blog',
                'meta_description' => 'This is the good description.',
                'meta_keywords' => 'good,blog',
                'created_at' => new DateTime,
                'updated_at' => new DateTime,
                'status' => 1
            ))
        );
    }

}
