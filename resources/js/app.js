import './bootstrap';

// Import fonts
import '@fontsource/public-sans/400.css';
import '@fontsource/public-sans/500.css';
import '@fontsource/public-sans/700.css';
import '@fontsource/public-sans/900.css';
import '@fontsource/noto-sans/400.css';
import '@fontsource/noto-sans/500.css';
import '@fontsource/noto-sans/700.css';
import '@fontsource/noto-sans/900.css';
import { Chart } from 'chart.js/auto';
window.Chart = Chart; // ถ้าต้องการเรียกใช้นอกไฟล์ JS
// Import Material Symbols
import '@material-symbols/font-400/outlined.css';

// jQuery - ต้องโหลดก่อน Select2
import $ from "jquery";
window.$ = $;
window.jQuery = $;

// Select2 - Import และ register กับ jQuery
import select2 from 'select2';
select2($); // Register Select2 กับ jQuery instance
import 'select2/dist/css/select2.css';

// SweetAlert2
import Swal from 'sweetalert2';
window.Swal = Swal;

// Import Alpine.js แต่ยังไม่ start
import Alpine from 'alpinejs';
window.Alpine = Alpine;

// รอให้ทุกอย่างพร้อมก่อนจะเริ่ม Alpine
document.addEventListener('DOMContentLoaded', function() {
    // ตรวจสอบว่า Select2 โหลดสำเร็จหรือไม่
    if (typeof $.fn.select2 !== 'undefined') {
        console.log('✅ Select2 loaded successfully');
        console.log('✅ jQuery version:', $.fn.jquery);
        console.log('✅ Select2 version:', $.fn.select2.defaults);
    } else {
        console.error('❌ Select2 failed to load');
        console.log('Available jQuery methods:', Object.keys($.fn));
    }
    
    // เริ่ม Alpine.js หลังจาก DOM และ dependencies พร้อมแล้ว
    Alpine.start();
    console.log('✅ Alpine.js started');
});
