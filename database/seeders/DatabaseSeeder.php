<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        DB::table('users')->insert([
            [
                'name' => 'admin',
                'password' => Hash::make('admin123'),
                'email' => 'admin@example.com',
                'created_at' => now(),
            ],
            [
                'name' => 'editor',
                'password' => Hash::make('editor123'),
                'email' => 'editor@example.com',
                'created_at' => now(),
            ],
        ]);

        // Categories
        DB::table('categories')->insert([
            ['name' => 'Tin tức', 'slug' => 'tin-tuc', 'parent_id' => null, 'created_at' => now()],
            ['name' => 'Văn kiện', 'slug' => 'van-kien', 'parent_id' => null, 'created_at' => now()],
            ['name' => 'Sự kiện', 'slug' => 'su-kien', 'parent_id' => null, 'created_at' => now()],
            ['name' => 'Tin trong nước', 'slug' => 'tin-trong-nuoc', 'parent_id' => 1, 'created_at' => now()],
        ]);

        // Tags
        DB::table('tags')->insert([
            ['name' => 'Đại hội', 'slug' => 'dai-hoi', 'created_at' => now()],
            ['name' => 'Chính trị', 'slug' => 'chinh-tri', 'created_at' => now()],
        ]);

        // Posts
        DB::table('posts')->insert([
            [
                'title' => 'Tin tức mới nhất',
                'content' => 'Nội dung bài viết tin tức mẫu.',
                'excerpt' => 'Mô tả ngắn về tin tức.',
                'category_id' => 1,
                'user_id' => 1,
                'published_at' => now(),
                'status' => 'published',
                'language' => 'vi',
                'views' => 100,
                'created_at' => now(),
            ],
            [
                'title' => 'Văn kiện Đại hội',
                'content' => 'Nội dung văn kiện mẫu.',
                'excerpt' => 'Mô tả ngắn về văn kiện.',
                'category_id' => 2,
                'user_id' => 1,
                'published_at' => now(),
                'status' => 'published',
                'language' => 'vi',
                'views' => 50,
                'created_at' => now(),
            ],
        ]);

        // Post Tags
        DB::table('post_tags')->insert([
            ['post_id' => 1, 'tag_id' => 1],
            ['post_id' => 1, 'tag_id' => 2],
            ['post_id' => 2, 'tag_id' => 1],
        ]);

        // Media
        DB::table('media')->insert([
            ['url' => '/images/sample.jpg', 'type' => 'image', 'post_id' => 1, 'created_at' => now()],
            ['url' => '/documents/sample.pdf', 'type' => 'document', 'post_id' => 2, 'created_at' => now()],
        ]);

        // Comments
        DB::table('comments')->insert([
            ['post_id' => 1, 'user_id' => 2, 'content' => 'Bình luận mẫu về bài viết.', 'status' => 'approved', 'created_at' => now()],
        ]);

        // Post Translations
        DB::table('post_translations')->insert([
            [
                'post_id' => 1,
                'language' => 'en',
                'title' => 'Latest News',
                'content' => 'Sample news content in English.',
                'excerpt' => 'Short description of the news.',
                'created_at' => now(),
            ],
            [
                'post_id' => 2,
                'language' => 'en',
                'title' => 'Congress Document',
                'content' => 'Sample document content in English.',
                'excerpt' => 'Short description of the document.',
                'created_at' => now(),
            ],
        ]);
    }
}
