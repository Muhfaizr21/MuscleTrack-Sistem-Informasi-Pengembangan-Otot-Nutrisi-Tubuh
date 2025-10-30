Tentu, ini adalah draf README.md yang rapi dan profesional berdasarkan informasi yang Anda berikan. Saya telah mengaturnya menggunakan format Markdown standar yang ideal untuk repositori GitHub.

Anda bisa menyalin dan menempelkan teks di bawah ini ke dalam *file* `README.md` di proyek Anda.

-----

# 💪 MuscleTrack — Sistem Informasi Pengembangan Otot & Nutrisi Tubuh

`MuscleTrack` adalah sistem informasi berbasis web yang dikembangkan sebagai bagian dari proyek seleksi magang. Sistem ini berfokus pada pemantauan perkembangan otot, kebutuhan nutrisi protein, panduan latihan, serta konsultasi dengan trainer profesional bagi pengguna.

<br>

\<details\>
\<summary\>\<strong\>Table of Contents\</strong\>\</summary\>
\<ol\>
\<li\>\<a href="\#tentang-proyek"\>Tentang Proyek\</a\>\</li\>
\<li\>\<a href="\#fitur-utama"\>Fitur Utama\</a\>\</li\>
\<li\>\<a href="\#kredensial-demo"\>Kredensial Demo\</a\>\</li\>
\<li\>\<a href="\#%EF%B8%8F-teknologi-yang-digunakan"\>Teknologi yang Digunakan\</a\>\</li\>
\<li\>\<a href="\#-instalasi--menjalankan-proyek"\>Instalasi & Menjalankan Proyek\</a\>\</li\>
\<li\>\<a href="\#-alur-kerja-sistem"\>Alur Kerja Sistem\</a\>\</li\>
\<li\>\<a href="\#-struktur-halaman--fitur"\>Struktur Halaman & Fitur\</a\>
\<ul\>
\<li\>\<a href="\#-halaman-autentikasi"\>Halaman Autentikasi\</a\>\</li\>
\<li\>\<a href="\#-admin-panel"\>Admin Panel\</a\>\</li\>
\<li\>\<a href="\#-trainer-panel"\>Trainer Panel\</a\>\</li\>
\<li\>\<a href="\#-user-panel"\>User Panel\</a\>\</li\>
\</ul\>
\</li\>
\<li\>\<a href="\#-rencana-pengembangan-roadmap"\>Rencana Pengembangan (Roadmap)\</a\>\</li\>
\</ol\>
\</details\>

## Tentang Proyek

Sistem ini dirancang untuk menjembatani kesenjangan antara pengguna yang ingin membangun massa otot dan informasi yang mereka butuhkan. Dengan tiga peran utama (Admin, Trainer, dan User), MuscleTrack menyediakan ekosistem lengkap mulai dari manajemen program oleh admin, pendampingan profesional oleh trainer, hingga pelacakan progres yang mendetail bagi user.

Fokus utama sistem ini adalah:

  * **Admin:** Membuat dan mengelola program latihan & nutrisi.
  * **Trainer:** Memantau kemajuan member dan memberikan konsultasi.
  * **User:** Mengikuti program, melacak progres, dan berkonsultasi dengan trainer.

## Fitur Utama

  * **Tiga Peran Pengguna:** Manajemen terpisah untuk Admin, Trainer, dan User.
  * **Manajemen Program:** Admin dapat membuat, mengubah, dan menghapus rencana latihan dan nutrisi.
  * **Pelacakan Progres:** Grafik interaktif untuk memvisualisasikan perkembangan otot dan berat badan.
  * **Pelacak Protein & Kalori:** Sistem otomatis menghitung BMR, TDEE, dan kebutuhan protein harian.
  * **Konsultasi Profesional:** Fitur chat *real-time* antara User dan Trainer (layanan premium).
  * **Laporan & Analitik:** Ringkasan mingguan dan laporan kemajuan untuk semua peran.

## Kredensial Demo

Anda dapat mencoba sistem menggunakan kredensial login di bawah ini:

| Role | Email | Password |
| :--- | :--- | :--- |
| Admin | `admin@muscletrack.com` | `password123` |
| User | `user@muscletrack.com` | `password123` |
| Trainer | `trainer@muscletrack.com` | `password123` |

## 🛠️ Teknologi yang Digunakan

  * **Framework:** Laravel 11
  * **Bahasa:** PHP 8.3
  * **Database:** MySQL
  * **Frontend:** Blade, Bootstrap 5, JavaScript
  * **Lainnya:** Chart.js (untuk grafik)

## 🚀 Instalasi & Menjalankan Proyek

1.  **Clone repositori:**

    ```bash
    git clone https://github.com/username-anda/muscletrack.git
    cd muscletrack
    ```

2.  **Install dependensi (Composer & NPM):**

    ```bash
    composer install
    npm install
    ```

3.  **Setup Environment:**

    ```bash
    cp .env.example .env
    ```

      * Buka *file* `.env` dan atur koneksi database Anda (DB\_DATABASE, DB\_USERNAME, DB\_PASSWORD).

4.  **Generate Kunci & Migrasi Database:**

    ```bash
    php artisan key:generate
    php artisan migrate --seed  // Gunakan --seed jika Anda membuatnya
    ```

5.  **Build Aset Frontend:**

    ```bash
    npm run dev
    ```

6.  **Jalankan Server:**

    ```bash
    php artisan serve
    ```

      * Aplikasi akan berjalan di `http://127.0.0.1:8000`

## ⚙️ Alur Kerja Sistem

1.  **Admin** login, kemudian membuat program latihan dan rencana nutrisi. Admin juga memantau aktivitas semua user.
2.  **Trainer** login, memantau progres member yang menjadi kliennya. Trainer dapat memberikan *feedback* melalui chat dan menyesuaikan program jika diperlukan.
3.  **User** login, melihat dashboard. User mengikuti program latihan, meng-update progres harian (latihan, berat badan, asupan nutrisi).
4.  Sistem secara otomatis menampilkan grafik perkembangan, total asupan protein/kalori, dan memberikan ringkasan mingguan.
5.  User (Premium) dapat memulai konsultasi berbayar dengan Trainer profesional.

## 🧭 Struktur Halaman & Fitur

### 🔐 Halaman Autentikasi

  * Antarmuka registrasi dan login yang sederhana.
  * Mendukung tiga *role*: `admin`, `user`, dan `trainer`.

### 👑 Admin Panel

  * **🏠 Dashboard:** Ringkasan progres semua user dan statistik latihan/nutrisi.
  * **🏋️‍♂️ Workout Plans:** (CRUD) Buat & kelola program latihan.
  * **🍗 Nutrition Plans:** (CRUD) Kelola rencana nutrisi tiap user.
  * **📈 Progress Reports:** Laporan perkembangan otot & kalori semua user.
  * **👥 Users:** Daftar pengguna, profil, log aktivitas, dan statistik.
  * **💊 Supplements:** (CRUD) Tambahkan rekomendasi suplemen/vitamin.
  * **🔥 Goals:** Kelola target kebugaran (bulking, cutting, maintenance).
  * **🧍‍♂️ Body Metrics:** Pantau berat, tinggi, dan lemak tubuh user.
  * **⚙️ Settings:** Pengaturan profil admin dan sistem.
  * **🔔 Notifications:** Update progres & pengingat.

### 🏋️‍♂️ Trainer Panel

  * **👥 Member List:** Konsolidasi semua user/member yang dilatih.
  * **📊 Activity Tracking:** Pantau progres latihan dan nutrisi tiap member.
  * **💬 Chat with Member:** Chat *real-time* untuk konsultasi dan *feedback*.
  * **💎 Premium Access:** Mengelola layanan berbayar.
  * **🏋️‍♂️ Workout & Nutrition Adjustment:** Menyesuaikan program latihan/nutrisi member.

### 💪 User Panel

  * **💪 My Progress:** Grafik perkembangan berat badan & otot.
  * **🥩 Protein Tracker:** Pantau kebutuhan protein harian & asupan tercapai.
  * **🏋️‍♀️ Workout Plans:** Ikuti panduan latihan sesuai level.
  * **🥗 Nutrition Plans:** Menu nutrisi sesuai target tubuh.
  * **📊 Weekly Summary:** Rekap mingguan latihan & nutrisi.
  * **🧠 Tips & Articles:** Artikel edukasi *fitness* & nutrisi.
  * **💬 Chat with Trainer:** Konsultasi dengan trainer (premium untuk profesional).
  * **👤 My Profile:** Data akun & pengaturan pribadi.
  * **🚪 Logout:** Keluar dari sistem.

## 🧩 Rencana Pengembangan (Roadmap)

Berikut adalah fitur-fitur yang direncanakan untuk pengembangan selanjutnya:

  * **AI Nutrition Advisor:**
      * Hitung otomatis kalori & protein harian (BMR, TDEE) berdasarkan BMI, aktivitas, dan tujuan.
      * Rekomendasi makanan tinggi protein & nutrisi seimbang.
  * **Workout Progress Visualization:**
      * Grafik interaktif perkembangan berat, otot, dan kekuatan.
      * Fitur unggah foto progres mingguan & analisis *trend*.
  * **Meal Planning System:**
      * Rekomendasi menu harian sesuai kebutuhan protein.
      * *Reminder* untuk konsumsi makanan tepat waktu.
  * **Exercise Video Library:**
      * Panduan video gerakan latihan, bisa disesuaikan peralatan (rumah/gym).
  * **Notification & Email System:**
      * Pengingat jadwal latihan & konsumsi nutrisi via web/email.
      * Email motivasi & *update* mingguan.
  * **Report & Analytics Dashboard:**
      * Rekap mingguan & bulanan perkembangan otot, kalori, protein.
      * Perbandingan performa user per waktu.
  * **Community & Motivation Forum:**
      * Forum diskusi antar pengguna, fitur *like*, *comment*, dan *leaderboard*.
  * **Premium Trainer Access:**
      * Layanan chat & konsultasi profesional berbayar dengan riwayat konsultasi & pembayaran.

> ### 🧠 Konsep Masa Depan (Concept Mode)
>
> **DNA-Based Recommendation:** Mengintegrasikan fitur di mana User bisa mengunggah hasil tes DNA (misal: 23andMe). Sistem kemudian menyesuaikan program latihan & nutrisi berdasarkan metabolisme, potensi pertumbuhan otot, dan toleransi makanan.
