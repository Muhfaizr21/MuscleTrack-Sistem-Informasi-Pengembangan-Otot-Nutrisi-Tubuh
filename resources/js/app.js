// 1. Import CSS (Penting agar style 'Dark Premium' kita jalan)
import '../css/app.css';

// 2. Import Bootstrap (Default Laravel)
import './bootstrap';

// 3. Import dan Jalankan Alpine.js (INI KUNCINYA!)
import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();
