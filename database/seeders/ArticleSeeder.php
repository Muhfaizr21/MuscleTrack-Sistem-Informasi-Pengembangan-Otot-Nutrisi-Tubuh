<?php

namespace Database\Seeders;

use App\Models\NewsArticle;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

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
                'image' => 'nutrition-muscle.jpg',
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
            [
                'title' => '10 Superfood Lokal Indonesia yang Kaya Nutrisi',
                'slug' => Str::slug('10 Superfood Lokal Indonesia yang Kaya Nutrisi'),
                'category' => 'Nutrition',
                'summary' => 'Ternyata Indonesia memiliki banyak bahan pangan super yang tak kalah dengan quinoa atau chia seeds.',
                'content' => '1. Tempe - Sumber protein tinggi dan probiotik alami
2. Ubi Ungu - Kaya antioksidan dan serat
3. Daun Kelor - Mengandung vitamin C 7x lebih banyak dari jeruk
4. Ikan Gabus - Protein tinggi untuk regenerasi otot
5. Beras Merah - Karbohidrat kompleks dengan indeks glikemik rendah
6. Jantung Pisang - Sumber serat dan mineral
7. Kacang Hijau - Protein nabati berkualitas
8. Rumput Laut - Kaya mineral dan yodium
9. Kunyit - Anti-inflamasi alami
10. Bawang Dayak - Antioksidan kuat',
                'author' => 'Coach Dinda',
                'image' => 'superfood-indonesia.jpg',
                'created_at' => now()->subDays(2),
                'updated_at' => now()->subDays(2),
            ],
            [
                'title' => 'Meal Prep Mingguan untuk Fitness Enthusiast',
                'slug' => Str::slug('Meal Prep Mingguan untuk Fitness Enthusiast'),
                'category' => 'Nutrition',
                'summary' => 'Strategi menyiapkan makanan seminggu sekali agar nutrisi tetap terjaga.',
                'content' => 'LANGKAH-LANGKAH MEAL PREP:
1. Rencana Menu (Sabtu): Tentukan menu harian dengan komposisi 40% protein, 40% karbo, 20% lemak sehat
2. Belanja Bahan (Minggu pagi): Beli bahan segar sesuai daftar
3. Masak Massal (Minggu siang):
   - Masak nasi merah untuk 3-4 hari
   - Panggang ayam atau daging
   - Kukus sayuran
   - Bagi dalam kontainer sesuai porsi
4. Penyimpanan: Simpan di kulkas (3-4 hari) atau freezer (lebih lama)
5. Tips: Gunakan bumbu dasar, variasikan sayuran setiap hari',
                'author' => 'Coach Arif',
                'image' => 'meal-prep-guide.jpg',
                'created_at' => now()->subDays(5),
                'updated_at' => now()->subDays(5),
            ],
            [
                'title' => 'Peran Lemak Sehat dalam Program Fitness',
                'slug' => Str::slug('Peran Lemak Sehat dalam Program Fitness'),
                'category' => 'Nutrition',
                'summary' => 'Lemak bukan musuh, asalkan memilih jenis yang tepat.',
                'content' => 'Sumber Lemak Sehat yang Direkomendasikan:
1. Alpukat - Lemak tak jenuh tunggal
2. Kacang-kacangan - Almond, walnut, mete
3. Minyak Zaitun - Untuk dressing salad
4. Ikan Salmon - Omega-3 untuk anti-inflamasi
5. Telur Utuh - Kuning telur mengandung vitamin D dan kolin
6. Biji Chia & Flaxseed - Serat dan omega-3

Fungsi Lemak Sehat:
- Produksi hormon (termasuk testosteron)
- Penyerapan vitamin A, D, E, K
- Sumber energi jangka panjang
- Kesehatan sendi dan otak',
                'author' => 'Coach Dinda',
                'image' => 'healthy-fats.jpg',
                'created_at' => now()->subDays(7),
                'updated_at' => now()->subDays(7),
            ],
            [
                'title' => 'Hidrasi Optimal untuk Performa Latihan',
                'slug' => Str::slug('Hidrasi Optimal untuk Performa Latihan'),
                'category' => 'Nutrition',
                'summary' => 'Air mineral saja tidak cukup, ketahui kebutuhan elektrolit saat latihan intensif.',
                'content' => 'JADWAL MINUM UNTUK LATIHAN:
Sebelum Latihan (2 jam): 500ml air
30 menit sebelum: 250ml air
Selama Latihan: 200-300ml setiap 20 menit
Setelah Latihan: 500ml + elektrolit jika latihan >60 menit

TANDA DEHIDRASI:
- Urin berwarna gelap
- Sakit kepala ringan
- Kelelahan berlebihan
- Kram otot

ELEKTROLIT ALAMI:
- Air kelapa muda
- Buah semangka
- Pisang
- Larutan gula + garam (untuk latihan sangat intens)',
                'author' => 'Coach Rizky',
                'image' => 'hydration-guide.jpg',
                'created_at' => now()->subDays(10),
                'updated_at' => now()->subDays(10),
            ],
            [
                'title' => 'Post-Workout Nutrition: Makanan Pemulihan Otot',
                'slug' => Str::slug('Post-Workout Nutrition: Makanan Pemulihan Otot'),
                'category' => 'Nutrition',
                'summary' => 'Apa yang kamu makan setelah latihan menentukan seberapa cepat otot pulih.',
                'content' => 'WINDOW OF OPPORTUNITY: 30-45 menit setelah latihan

KOMBINASI IDEAL POST-WORKOUT:
1. Protein Whey + Pisang (cepat diserap)
2. Nasi Putih + Dada Ayam (karbo sederhana + protein)
3. Greek Yogurt + Madu + Buah Beri
4. Roti Gandum + Telur Rebus + Alpukat

HINDARI SETELAH LATIHAN:
- Makanan tinggi lemak (memperlambat pencernaan)
- Alkohol (mengganggu sintesis protein)
- Makanan proses tinggi

SUPLEMEN YANG MEMBANTU:
- BCAA (untuk latihan pagi sebelum sarapan)
- Glutamine (pemulihan lebih cepat)
- Creatine (untuk latihan beban berat)',
                'author' => 'Coach Arif',
                'image' => 'post-workout-meal.jpg',
                'created_at' => now()->subDays(12),
                'updated_at' => now()->subDays(12),
            ],
            // TAMBAHAN ARTIKEL TUTORIAL APLIKASI
            [
                'title' => 'Tutorial Lengkap: Cara Menggunakan Aplikasi MuscleXpert',
                'slug' => Str::slug('Tutorial Lengkap: Cara Menggunakan Aplikasi MuscleXpert'),
                'category' => 'Tutorial',
                'summary' => 'Panduan step-by-step menggunakan aplikasi MuscleXpert untuk memaksimalkan program fitness Anda.',
                'content' => '# Tutorial Menggunakan Aplikasi MuscleXpert

## **Akses Aplikasi**
Aplikasi MuscleXpert dapat diakses melalui: **https://www.muscleXpert.my.id**

## **Fitur Utama MuscleXpert:**

### 1. **Dashboard Personal**
- Pantau progres harian/mingguan
- Statistik latihan dan nutrisi
- Grafik perkembangan berat badan

### 2. **Workout Planner**
- Buat jadwal latihan custom
- Pilih dari berbagai program: Beginner, Intermediate, Advanced
- Video panduan setiap gerakan

### 3. **Nutrition Tracker**
- Hitung kalori dan makronutrien
- Database makanan Indonesia
- Rekomendasi meal plan

### 4. **Progress Photos**
- Upload foto perkembangan
- Bandingkan sebelum & sesudah
- Private atau public sharing

## **Langkah-Langkah Penggunaan:**

### **Step 1: Registrasi & Login**
1. Buka https://www.muscleXpert.my.id
2. Klik "Register" atau "Daftar"
3. Isi data: nama, email, password
4. Verifikasi email
5. Login dengan akun yang dibuat

### **Step 2: Setup Profil Awal**
1. Isi data dasar: tinggi, berat, usia
2. Tentukan tujuan: muscle gain, fat loss, maintenance
3. Pilih tingkat aktivitas
4. Sistem akan hitung kebutuhan kalori

### **Step 3: Buat Program Latihan**
1. Pilih menu "Workout"
2. Pilih program sesuai level
3. Atur hari latihan
4. Tambah latihan custom jika perlu

### **Step 4: Tracking Harian**
1. Log latihan setiap sesi
2. Input makanan yang dikonsumsi
3. Update berat badan mingguan
4. Upload foto progress bulanan

## **Tips & Trik:**
- Gunakan mobile app untuk tracking mudah
- Enable notifications untuk reminder
- Join community untuk motivasi
- Export data untuk konsultasi dengan trainer

## **Troubleshooting:**
- **Lupa password?** Klik "Forgot Password"
- **App error?** Clear cache browser
- **Data hilang?** Cek backup otomatis
- **Butuh bantuan?** Kontak support@muscleXpert.my.id

## **Platform Support:**
- Web: https://www.muscleXpert.my.id
- Mobile: Responsive design (bisa diakses via browser mobile)
- Desktop: Kompatibel semua browser modern

**Mulai journey fitness Anda sekarang dengan MuscleXpert!**',
                'author' => 'Admin MuscleXpert',
                'image' => 'musclexpert-tutorial.jpg',
                'created_at' => now()->subDays(1),
                'updated_at' => now()->subDays(1),
            ],
            [
                'title' => 'Panduan Fitur Advanced: Workout Customization di MuscleXpert',
                'slug' => Str::slug('Panduan Fitur Advanced: Workout Customization di MuscleXpert'),
                'category' => 'Tutorial',
                'summary' => 'Pelajari cara membuat program latihan custom yang sesuai dengan kebutuhan spesifik Anda.',
                'content' => '# Advanced Tutorial: Custom Workout di MuscleXpert

## **Membuat Program Latihan Custom**

### **Step 1: Akses Workout Builder**
1. Login ke https://www.muscleXpert.my.id
2. Navigasi ke "My Workouts" → "Create New"
3. Beri nama program: "My Custom Program"

### **Step 2: Atur Split Routine**
Pilih tipe split yang sesuai:
- **Full Body**: 3x seminggu
- **Upper/Lower**: 4x seminggu
- **Push/Pull/Legs**: 6x seminggu
- **Bro Split**: 5x seminggu (per muscle group)

### **Step 3: Tambahkan Exercises**
Untuk setiap hari latihan:
1. Klik "Add Exercise"
2. Pilih dari kategori:
   - Compound Movements (Squat, Deadlift, Bench)
   - Isolation Exercises (Bicep curl, Tricep extension)
   - Cardio Options
   - Bodyweight Exercises

3. Atur parameter:
   - Sets: 3-4 sets
   - Reps: 8-12 untuk hypertrophy
   - Rest: 60-90 detik
   - Weight: Progressive overload

### **Step 4: Progressive Overload Tracking**
- Setiap minggu, tambah beban 2.5-5%
- Atau tambah 1-2 reps dengan beban sama
- System akan rekam semua progres

## **Fitur Specialized:**

### **1. Superset & Dropset**
- Pilih 2+ exercises
- Klik "Superset" untuk menggabungkan
- Atur rest time antar exercises

### **2. One Rep Max Calculator**
- Input beban & reps terakhir
- System hitung estimasi 1RM
- Gunakan untuk program periodization

### **3. Volume Calculator**
- Otomatis hitung weekly volume
- Pantau apakah over/under training
- Rekomendasi adjustment

## **Contoh Program Custom:**

### **Program Intermediate (PPL Split)**
**Push Day:**
1. Bench Press: 4x8-10
2. Overhead Press: 3x8-10
3. Incline DB Press: 3x10-12
4. Tricep Pushdown: 3x12-15
5. Lateral Raises: 4x12-15

**Pull Day:**
1. Pull-ups: 4xAMRAP
2. Barbell Rows: 4x8-10
3. Lat Pulldown: 3x10-12
4. Face Pulls: 4x15-20
5. Bicep Curls: 3x10-12

**Leg Day:**
1. Squats: 4x8-10
2. RDL: 3x8-10
3. Leg Press: 3x10-12
4. Leg Curls: 3x12-15
5. Calf Raises: 4x15-20

## **Sharing & Community:**
1. **Share Program**: Buat program public untuk dibagikan
2. **Import Program**: Gunakan program dari user lain
3. **Rating System**: Beri rating program yang digunakan
4. **Comments**: Diskusi teknik dan modifikasi

## **Mobile Optimization:**
- **Quick Add**: Tambah exercise dengan scan barcode makanan
- **Voice Log**: Input latihan via voice command
- **Offline Mode**: Tetap bisa log saat tidak ada internet
- **Widget**: Quick log dari home screen

## **Tips Pro:**
- Gunakan **RPE Scale** (Rate of Perceived Exertion)
- Implement **Deload Week** setiap 4-6 minggu
- **Periodize** program: Hypertrophy → Strength → Cut
- **Track Measurements**: Arm, chest, waist, thigh circumference

**Custom program adalah kunci untuk hasil maksimal!**',
                'author' => 'Coach Arif',
                'image' => 'workout-customization.jpg',
                'created_at' => now()->subDays(3),
                'updated_at' => now()->subDays(3),
            ],
            [
                'title' => 'Nutrition Tracking & Meal Planning dengan MuscleXpert',
                'slug' => Str::slug('Nutrition Tracking & Meal Planning dengan MuscleXpert'),
                'category' => 'Tutorial',
                'summary' => 'Optimalkan nutrisi Anda dengan fitur tracking makanan dan meal planner yang lengkap.',
                'content' => '# Tutorial Nutrition Tracking di MuscleXpert

## **Setup Nutrition Profile**

### **Step 1: Hitung Kebutuhan Kalori**
1. Setelah login, ke "Nutrition" → "My Goals"
2. System otomatis hitung berdasarkan:
   - Basal Metabolic Rate (BMR)
   - Aktivitas harian (TDEE)
   - Tujuan: bulk, cut, atau maintain

3. **Contoh Perhitungan:**
   - Pria, 25 tahun, 70kg, 175cm
   - Aktivitas: Moderate (olahraga 3-4x/minggu)
   - Tujuan: Muscle Gain (+300 kalori surplus)
   - **Hasil**: 2800-3000 kalori/hari

### **Step 2: Atur Makronutrien**
Rekomendasi default:
- **Muscle Gain**: 40% Protein, 40% Carb, 20% Fat
- **Fat Loss**: 45% Protein, 35% Carb, 20% Fat
- **Maintenance**: 30% Protein, 40% Carb, 30% Fat

**Customize sesuai preferensi:**
1. Protein: 1.6-2.2g per kg berat badan
2. Carbs: Sisa kalori setelah protein & fat
3. Fat: Minimum 0.8g per kg berat badan

## **Fitur Food Tracking:**

### **1. Database Makanan Indonesia**
- 1000+ makanan lokal dengan nutrisi akurat
- Makanan tradisional: rendang, sate, gado-gado
- Street food: bakso, mie ayam, nasi goreng
- **Tips**: Scan barcode produk kemasan

### **2. Custom Food Entry**
Untuk makanan homemade:
1. Klik "Add Custom Food"
2. Input bahan-bahan
3. System hitung nutrisi otomatis
4. Save sebagai "My Recipes"

### **3. Quick Add Options**
- **Foto Makanan**: AI analyze estimasi kalori
- **Voice Input**: "Sarapan: nasi, telur, tempe"
- **Favorites**: Save makanan sering dikonsumsi
- **Meal Templates**: Breakfast, Lunch, Dinner, Snack

## **Meal Planner Feature:**

### **Step-by-Step Meal Planning:**
1. **Generate Auto Plan**:
   - Pilih preferensi: vegetarian, halal, allergies
   - System generate 7-day meal plan
   - Adjust sesuai budget dan waktu masak

2. **Weekly Shopping List**:
   - Otomatis generate belanjaan
   - Categorized: sayur, buah, protein, carbs
   - Export ke WhatsApp atau PDF

3. **Prep Schedule**:
   - Waktu masak per meal
   - Storage instructions
   - Reheating tips

## **Contoh Meal Plan (3000 kalori):**

**Sarapan (07:00) - 700 kalori**
- Oatmeal 80g + Whey Protein 1 scoop
- Telur 3 butir (2 putih, 1 utuh)
- Alpukat 1/2 buah
- Kopi hitam

**Snack (10:30) - 300 kalori**
- Greek yogurt 200g
- Kacang almond 30g
- Madu 1 sdt

**Makan Siang (13:00) - 800 kalori**
- Nasi merah 150g
- Dada ayam 150g (grilled)
- Brokoli 200g (steamed)
- Sambal terasi secukupnya

**Pre-Workout (16:30) - 200 kalori**
- Pisang 2 buah
- Kopi hitam

**Post-Workout (19:00) - 600 kalori**
- Nasi putih 100g
- Daging sapi 120g
- Mix vegetables 150g
- Whey protein 1 scoop

**Snack Malam (21:30) - 400 kalori**
- Casein protein 1 scoop
- Kacang tanah 40g
- Dark chocolate 20g

## **Advanced Features:**

### **1. Nutrient Timing**
- Atur waktu makan optimal
- Pre/post workout nutrition
- Intermittent fasting tracker

### **2. Supplement Log**
- Track supplement intake
- Reminder untuk minum
- Integration dengan e-commerce

### **3. Restaurant Mode**
- Nutrition info restaurant lokal
- Healthy choices recommendations
- Portion size estimator

### **4. Progress Correlation**
- Analytics: nutrition vs weight change
- Identify food sensitivities
- Optimal macro ratios untuk Anda

## **Tips Sukses:**
1. **Consistency**: Track setiap hari, minimal 80%
2. **Honesty**: Jangan underestimate portion
3. **Flexibility**: 80/20 rule - 80% clean, 20% flexible
4. **Weekly Review**: Adjust berdasarkan progress
5. **Hydration**: Track water intake juga

## **Troubleshooting Nutrition:**
- **Plateau?**: Adjust kalori ±200 setiap 2 minggu
- **Hungry terus?**: Tambah serat & protein
- **Energy rendah?**: Review carb intake timing
- **Digestion issues?**: Track fiber & water

**Remember: Nutrition adalah 70% dari hasil fitness Anda!**',
                'author' => 'Coach Dinda',
                'image' => 'nutrition-tracking.jpg',
                'created_at' => now()->subDays(4),
                'updated_at' => now()->subDays(4),
            ],
            // TAMBAHAN ARTIKEL BARU DENGAN GAMBAR BERBEDA
            [
                'title' => 'Workout di Rumah: Tanpa Alat, Tetap Efektif',
                'slug' => Str::slug('Workout di Rumah: Tanpa Alat, Tetap Efektif'),
                'category' => 'Fitness',
                'summary' => 'Rutinitas latihan bodyweight yang bisa dilakukan di rumah tanpa alat khusus.',
                'content' => '## **Program Home Workout 30 Menit**

### **Pemanasan (5 menit):**
1. Jumping Jacks - 60 detik
2. High Knees - 60 detik
3. Arm Circles - 60 detik
4. Leg Swings - 60 detik
5. Torso Twists - 60 detik

### **Latihan Inti (20 menit):**
**Circuit 1 (ulangi 3x):**
- Push-ups: 10-15 reps
- Squats: 15-20 reps
- Plank: 30-60 detik
- Lunges: 10 reps per kaki

**Circuit 2 (ulangi 3x):**
- Tricep Dips: 10-15 reps
- Glute Bridges: 15-20 reps
- Mountain Climbers: 30-45 detik
- Russian Twists: 20 reps

### **Pendinginan (5 menit):**
1. Child Pose - 60 detik
2. Cobra Stretch - 60 detik
3. Quad Stretch - 30 detik per sisi
4. Hamstring Stretch - 30 detik per sisi
5. Shoulder Stretch - 30 detik per sisi

### **Tips Tambahan:**
- **Konsistensi**: Lakukan 3-4x seminggu
- **Progres**: Tambah reps atau waktu setiap minggu
- **Form**: Prioritaskan teknik yang benar
- **Istirahat**: 30-60 detik istirahat antar circuit',
                'author' => 'Coach Rizky',
                'image' => 'home-workout.jpg',
                'created_at' => now()->subDays(6),
                'updated_at' => now()->subDays(6),
            ],
            [
                'title' => 'Protein Shake: Kapan Waktu Terbaik Meminumnya?',
                'slug' => Str::slug('Protein Shake: Kapan Waktu Terbaik Meminumnya'),
                'category' => 'Nutrition',
                'summary' => 'Panduan timing konsumsi protein shake untuk hasil optimal.',
                'content' => '## **Waktu Terbaik Konsumsi Protein Shake**

### **1. Pagi Hari (Setelah Bangun Tidur)**
- **Waktu**: 30 menit setelah bangun
- **Alasan**: Menghentikan katabolisme malam
- **Rekomendasi**: Whey protein cepat serap

### **2. Pre-Workout (30-60 menit sebelum latihan)**
- **Waktu**: 30-60 menit sebelum latihan
- **Alasan**: Menyediakan asam amino selama latihan
- **Rekomendasi**: Whey protein dengan sedikit carbs

### **3. Post-Workout (Dalam 30 menit setelah latihan)**
- **Waktu**: Window anabolik 30-45 menit
- **Alasan**: Recovery otot maksimal
- **Rekomendasi**: Whey protein + karbohidrat cepat

### **4. Sebelum Tidur**
- **Waktu**: 30 menit sebelum tidur
- **Alasan**: Regenerasi otot selama tidur
- **Rekomendasi**: Casein protein lambat serap

### **5. Di Antara Makanan Utama**
- **Waktu**: 2-3 jam setelah makan
- **Alasan**: Mempertahankan level protein darah
- **Rekomendasi**: Blend protein (whey + casein)

### **Formulasi Protein Shake:**

**Post-Workout Shake:**
- 30g Whey Protein
- 1 Pisang
- 200ml Susu Almond
- 1 sdm Madu
- Es batu (opsional)

**Bedtime Shake:**
- 30g Casein Protein
- 200ml Susu
- 1 sdm Selai Kacang
- 1/2 sdt Kayu Manis

### **Kesalahan Umum:**
1. **Terlalu Banyak**: Max 40g per serving
2. **Waktu Salah**: Tidak memperhatikan timing
3. **Kualitas Rendah**: Pilih protein berkualitas
4. **Hanya Protein**: Butuh karbohidrat untuk sintesis',
                'author' => 'Coach Dinda',
                'image' => 'protein-shake.jpg',
                'created_at' => now()->subDays(8),
                'updated_at' => now()->subDays(8),
            ],
            [
                'title' => 'Recovery Day: Mengapa Istirahat Penting dalam Fitness',
                'slug' => Str::slug('Recovery Day: Mengapa Istirahat Penting dalam Fitness'),
                'category' => 'Fitness',
                'summary' => 'Hari istirahat bukan berarti malas, tapi strategi untuk hasil maksimal.',
                'content' => '## **Mengapa Recovery Day Penting?**

### **Fisiologi Recovery:**
1. **Perbaikan Otot**: Micro-tears diperbaiki selama istirahat
2. **Sintesis Protein**: Puncak 24-48 jam setelah latihan
3. **Restock Glikogen**: Energi otot dikembalikan
4. **Sistem Saraf**: CNS recovery sangat penting

### **Tanda Anda Butuh Recovery Day:**
- [ ] Kelelahan ekstrem
- [ ] Nyeri sendi berlebihan
- [ ] Performa menurun drastis
- [ ] Mood tidak stabil
- [ ] Gangguan tidur
- [ ] Nafsu makan berubah

### **Jenis Recovery Day:**

**1. Active Recovery:**
- Jalan santai 30 menit
- Yoga ringan
- Stretching
- Foam rolling

**2. Complete Rest:**
- Tidak ada aktivitas fisik
- Fokus pada tidur
- Hidrasi optimal
- Nutrisi recovery

**3. Deload Week (setiap 4-6 minggu):**
- Kurangi volume 40-60%
- Kurangi intensitas
- Fokus pada teknik
- Tidak ada PR attempt

### **Frekuensi Recovery:**
- **Beginner**: 3-4 hari latihan, 3-4 hari recovery
- **Intermediate**: 4-5 hari latihan, 2-3 hari recovery
- **Advanced**: 5-6 hari latihan, 1-2 hari recovery

### **Recoday Activities yang Direkomendasikan:**

**1. Foam Rolling:**
- Calves: 60 detik per sisi
- Hamstrings: 60 detik per sisi
- Quads: 60 detik per sisi
- Glutes: 60 detik per sisi
- Upper Back: 60 detik

**2. Stretching Routine:**
- Downward Dog: 60 detik
- Pigeon Pose: 45 detik per sisi
- Butterfly Stretch: 60 detik
- Quad Stretch: 45 detik per sisi
- Chest Opener: 60 detik

**3. Nutrisi Recovery:**
- **Protein**: 1.6-2.2g per kg berat badan
- **Carbs**: 3-5g per kg untuk refill glikogen
- **Fat**: 0.8-1g per kg untuk hormon
- **Air**: 35ml per kg berat badan

### **Tips Recovery Optimal:**
1. **Tidur**: 7-9 jam kualitas baik
2. **Hidrasi**: 3-4 liter per hari
3. **Nutrisi**: Fokus pada whole foods
4. **Stress Management**: Meditasi, breathing exercises
5. **Suplementasi**: Magnesium, Zinc, Omega-3

### **Kesalahan Recovery:**
1. **No Rest**: Tidak ada hari istirahat
2. **Overtraining**: Latihan berlebihan
3. **Poor Nutrition**: Tidak cukup protein/carbs
4. **Dehydration**: Kurang minum air
5. **Bad Sleep**: Tidur tidak berkualitas

**Ingat: Progress terjadi saat istirahat, bukan saat latihan!**',
                'author' => 'Coach Arif',
                'image' => 'recovery-day.jpg',
                'created_at' => now()->subDays(9),
                'updated_at' => now()->subDays(9),
            ],
            [
                'title' => 'Membangun Komunitas Fitness yang Supportif',
                'slug' => Str::slug('Membangun Komunitas Fitness yang Supportif'),
                'category' => 'Community',
                'summary' => 'Tips menciptakan lingkungan fitness yang positif dan saling mendukung.',
                'content' => '## **Pilar Komunitas Fitness yang Sehat**

### **1. Inklusivitas**
- **Prinsip**: Semua level welcome
- **Aksi**: Tidak ada body shaming
- **Fokus**: Progress personal, bukan kompetisi

### **2. Dukungan Emosional**
- **Celebrate Wins**: Rayakan pencapaian kecil
- **Empathy**: Pahami perjuangan masing-masing
- **Accountability**: Saling mengingatkan tujuan

### **3. Edukasi Berbagi**
- **Knowledge Sharing**: Tips dan pengalaman
- **Fact-Based**: Informasi berdasarkan sains
- **Respectful Debate**: Diskusi sehat berbeda pendapat

### **4. Positive Reinforcement**
- **Constructive Feedback**: Kritik membangun
- **Encouragement**: Kata-kata penyemangat
- **Role Models**: Contoh dari yang lebih berpengalaman

### **Tips Membangun Komunitas:**

**1. Online Community:**
- Grup WhatsApp/Telegram
- Forum Diskusi
- Instagram Community
- Challenge Bersama

**2. Offline Community:**
- Group Workout Mingguan
- Fitness Workshop
- Healthy Potluck
- Outdoor Activities

**3. Engagement Strategies:**
- Weekly Challenges
- Progress Threads
- Q&A Sessions
- Guest Expert Sharing

### **Kode Etik Komunitas:**
1. **No Judgement**: Tidak menghakimi
2. **Respect Privacy**: Jaga privitas anggota
3. **Scientific Approach**: Rekomendasi berbasis sains
4. **No Promotion**: Tidak promosi produk
5. **Be Kind**: Selapang dada dan baik hati

### **Manfaat Komunitas Fitness:**
- **Motivation**: 73% lebih konsisten
- **Knowledge**: 65% lebih banyak belajar
- **Accountability**: 81% lebih bertanggung jawab
- **Friendship**: 58% dapat teman fitness
- **Results**: 89% mencapai tujuan lebih cepat

**Komunitas yang kuat membangun individu yang kuat!**',
                'author' => 'Coach Dinda',
                'image' => 'fitness-community.jpg',
                'created_at' => now()->subDays(11),
                'updated_at' => now()->subDays(11),
            ],
        ];

        NewsArticle::insert($articles);

        $this->command->info('✅ Seeder artikel berhasil dijalankan!');
        $this->command->info('📊 Total artikel: ' . count($articles));
        $this->command->info('📁 Gambar yang digunakan:');
        $this->command->table(
            ['No', 'Gambar', 'Artikel'],
            collect($articles)->map(function ($article, $index) {
                return [
                    $index + 1,
                    $article['image'],
                    $article['title']
                ];
            })->toArray()
        );
    }
}
