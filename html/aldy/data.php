<?php
/**
 * data.php - Menyimpan semua data CV Formal.
 */

$cv_data = [
    // Informasi Utama
    "name" => "Aldy Fahri Firmansyah",
    "title" => "Web Desainer",
    "summary" => "Seorang Full-Stack Developer berpengalaman 5 tahun dengan keahlian mendalam dalam arsitektur berbasis PHP (Laravel/CodeIgniter) dan JavaScript modern (React/Vue). Berfokus pada pengembangan sistem yang skalabel, aman, dan berorientasi pada pengguna.",
    
    // Kontak & Tautan
    "contact" => [
        "phone" => "+62 838 2415 3429 ",
        "email" => "aldy.firmansyah@email.com",
        "linkedin" => "linkedin.com/in/rizkyfirmansyah",
        "github" => "github.com/rizkydev",
        "address" => "Jakarta, Indonesia"
    ],
    
    // Pendidikan
    "education" => [
        [
            "institution" => "Universitas Teknologi Jaya",
            "degree" => "S.Kom. - Teknik Informatika",
            "duration" => "2015 - 2019"
        ]
    ],

    // Pengalaman Kerja
    "experience" => [
        [
            "role" => "Senior Web Developer",
            "company" => "PT. Solusi Digital Abadi",
            "duration" => "2021 - Sekarang",
            "duties" => [
                "Memimpin tim pengembangan 4 orang untuk proyek e-commerce skala besar.",
                "Merancang dan mengimplementasikan RESTful API menggunakan Laravel.",
                "Mengoptimasi performa database (MySQL) yang menghasilkan pengurangan latency 40%."
            ]
        ],
        [
            "role" => "Junior Programmer",
            "company" => "CV. Kreatif Mandiri",
            "duration" => "2019 - 2021",
            "duties" => [
                "Mengembangkan modul internal perusahaan menggunakan CodeIgniter.",
                "Bertanggung jawab dalam pemeliharaan dan debugging aplikasi lama.",
                "Bekerja sama dengan tim UI/UX untuk menerapkan desain responsif."
            ]
        ]
    ],
    
    // Keahlian Teknis (Ganti dengan keahlian kamu)
    "skills" => [
        "PHP (Laravel, CodeIgniter)", 
        "JavaScript (React.js, Vue.js, Node.js)", 
        "Database (MySQL, PostgreSQL)",
        "DevOps (Docker, Git, CI/CD)",
        "UI/UX (Bootstrap, Tailwind CSS)"
    ]
];

function get_cv_data() {
    global $cv_data;
    return $cv_data;
}
?>