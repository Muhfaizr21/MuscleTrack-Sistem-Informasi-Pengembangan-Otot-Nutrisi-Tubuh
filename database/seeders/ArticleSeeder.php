<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\NewsArticle;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class ArticleSeeder extends Seeder
{
    public function run(): void
    {
        // Nonaktifkan foreign key sementara agar aman
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        NewsArticle::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $articles = [
            [
                'title' => '5 Tips Latihan Efektif untuk Pemula',
                'slug' => Str::slug('5 Tips Latihan Efektif untuk Pemula'),
                'category' => 'Fitness',
                'summary' => 'Panduan praktis agar latihanmu lebih konsisten dan terarah.',
                'content' => 'Mulailah dengan teknik yang benar, lakukan pemanasan, dan fokus pada progres, bukan hanya beban berat. Ingat, konsistensi lebih penting dari intensitas.',
                'author' => 'Coach Arif',
                'image' => 'fitness-tips.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Nutrisi Penting untuk Pembentukan Otot',
                'slug' => Str::slug('Nutrisi Penting untuk Pembentukan Otot'),
                'category' => 'Nutrition',
                'summary' => 'Protein, karbohidrat, dan lemak sehat berperan penting dalam pembentukan otot.',
                'content' => 'Kunci utama pembentukan otot adalah keseimbangan antara latihan dan nutrisi. Pastikan asupan protein cukup untuk regenerasi otot, serta karbohidrat kompleks untuk energi.',
                'author' => 'Coach Dinda',
                'image' => 'muscle-nutrition.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Mindset Fitness: Kunci Konsistensi dan Hasil Maksimal',
                'slug' => Str::slug('Mindset Fitness: Kunci Konsistensi dan Hasil Maksimal'),
                'category' => 'Motivation',
                'summary' => 'Latihan tanpa mindset yang tepat hanya akan membuatmu cepat menyerah.',
                'content' => 'Konsistensi dalam fitness dimulai dari pola pikir yang benar. Fokus pada progres kecil, bukan hasil instan. Nikmati proses, bukan hanya tujuan akhir.',
                'author' => 'Coach Rizky',
                'image' => 'mindset-fitness.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        NewsArticle::insert($articles);
    }
}
