<?php
/**
 * index.php - File utama untuk CV Formal dan Bersih.
 */

// 1. Ambil Data Diri Formal
require_once 'data.php';
$data = get_cv_data();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CV Profesional: <?php echo htmlspecialchars($data['name']); ?></title>
    
    <style>
        :root {
            --color-primary: #007BFF; /* Biru Profesional */
            --color-secondary: #f8f9fa; /* Latar Belakang Sidebar */
            --color-text: #343a40;
            --color-border: #dee2e6;
        }
        
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f1f1f1;
            padding: 20px;
            color: var(--color-text);
            line-height: 1.6;
        }

        .cv-container {
            max-width: 1000px;
            margin: 20px auto;
            background-color: white;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
            display: flex;
            border-radius: 8px;
            overflow: hidden;
        }
        
        /* Kolom Kiri (Kontak & Skill) - Sidebar */
        .sidebar {
            width: 30%;
            background-color: var(--color-secondary);
            padding: 30px;
        }

        /* Kolom Kanan (Pengalaman & Edukasi) - Main Content */
        .main-content {
            width: 70%;
            padding: 30px;
        }

        /* --- Header & Judul --- */
        .header-main {
            border-bottom: 2px solid var(--color-primary);
            padding-bottom: 10px;
            margin-bottom: 20px;
        }
        
        h1 {
            color: var(--color-primary);
            font-size: 2.2em;
            margin-bottom: 0;
        }

        h2.title {
            font-size: 1.2em;
            color: #6c757d;
            font-weight: normal;
        }
        
        h3 {
            color: var(--color-text);
            font-size: 1.2em;
            border-bottom: 1px dashed var(--color-border);
            padding-bottom: 5px;
            margin-top: 25px;
            margin-bottom: 15px;
        }
        
        /* --- Detail Kontak Sidebar --- */
        .contact-info div {
            margin-bottom: 10px;
        }
        .contact-info strong {
            display: block;
            font-size: 0.9em;
            color: var(--color-primary);
        }
        .contact-info a {
            color: var(--color-text);
            text-decoration: none;
            font-size: 0.9em;
        }
        
        /* --- Daftar Keahlian --- */
        .skills-list ul {
            list-style-type: none;
            padding: 0;
            margin: 0;
        }
        .skills-list li {
            background-color: var(--color-primary);
            color: white;
            display: inline-block;
            padding: 4px 10px;
            margin: 0 5px 8px 0;
            border-radius: 3px;
            font-size: 0.85em;
        }

        /* --- Pengalaman --- */
        .experience-item, .education-item {
            margin-bottom: 25px;
            padding-left: 15px;
            border-left: 3px solid var(--color-border);
        }
        .experience-item h4 {
            font-size: 1.1em;
            margin: 0;
            color: var(--color-primary);
        }
        .experience-item h5 {
            font-size: 0.95em;
            margin: 5px 0 10px 0;
            color: #6c757d;
            font-style: italic;
        }
        .experience-item ul {
            margin-top: 8px;
            padding-left: 20px;
        }
        .experience-item li {
            margin-bottom: 5px;
            font-size: 0.95em;
        }
        
        /* --- Animasi (JavaScript Minimalis) --- */
        #summary-text {
            /* Pastikan teks awal tersembunyi untuk efek typing */
            visibility: hidden; 
        }
        
    </style>
</head>
<body>
    <div class="cv-container">
        
        <div class="sidebar">
            
            <section class="contact-info">
                <h3>KONTAK</h3>
                <div><strong>Telepon</strong> <a href="tel:<?php echo htmlspecialchars($data['contact']['phone']); ?>"><?php echo htmlspecialchars($data['contact']['phone']); ?></a></div>
                <div><strong>Email</strong> <a href="mailto:<?php echo htmlspecialchars($data['contact']['email']); ?>"><?php echo htmlspecialchars($data['contact']['email']); ?></a></div>
                <div><strong>LinkedIn</strong> <a href="<?php echo htmlspecialchars($data['contact']['linkedin']); ?>" target="_blank">Profil LinkedIn</a></div>
                <div><strong>GitHub</strong> <a href="<?php echo htmlspecialchars($data['contact']['github']); ?>" target="_blank">Profil GitHub</a></div>
                <div><strong>Lokasi</strong> <?php echo htmlspecialchars($data['contact']['address']); ?></div>
            </section>
            
            <section class="skills-list">
                <h3>KEAHLIAN TEKNIS</h3>
                <ul>
                    <?php foreach ($data['skills'] as $skill): ?>
                        <li><?php echo htmlspecialchars($skill); ?></li>
                    <?php endforeach; ?>
                </ul>
            </section>
            
             <section class="education-section">
                <h3>PENDIDIKAN</h3>
                <?php foreach ($data['education'] as $edu): ?>
                    <div class="education-item">
                        <h4><?php echo htmlspecialchars($edu['degree']); ?></h4>
                        <h5><?php echo htmlspecialchars($edu['institution']); ?> (<?php echo htmlspecialchars($edu['duration']); ?>)</h5>
                    </div>
                <?php endforeach; ?>
            </section>
            
        </div>
        
        <div class="main-content">
            
            <header class="header-main">
                <h1><?php echo htmlspecialchars($data['name']); ?></h1>
                <h2 class="title"><?php echo htmlspecialchars($data['title']); ?></h2>
            </header>

            <section class="summary-section">
                <h3>RINGKASAN PROFESIONAL</h3>
                <p id="summary-text"><?php echo nl2br(htmlspecialchars($data['summary'])); ?></p>
            </section>
            
            <section class="experience-section">
                <h3>PENGALAMAN KERJA</h3>
                <?php foreach ($data['experience'] as $exp): ?>
                    <div class="experience-item">
                        <h4><?php echo htmlspecialchars($exp['role']); ?></h4>
                        <h5><?php echo htmlspecialchars($exp['company']); ?> | <?php echo htmlspecialchars($exp['duration']); ?></h5>
                        <ul>
                            <?php foreach ($exp['duties'] as $duty): ?>
                                <li><?php echo htmlspecialchars($duty); ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                <?php endforeach; ?>
            </section>
            
        </div>
        
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const summaryElement = document.getElementById('summary-text');
            const fullText = summaryElement.textContent;
            let i = 0;
            
            // Atur teks awal kosong dan visibility normal
            summaryElement.textContent = '';
            summaryElement.style.visibility = 'visible';

            const typing = () => {
                if (i < fullText.length) {
                    summaryElement.textContent += fullText.charAt(i);
                    i++;
                    // Kecepatan ketikan (misalnya, 25ms)
                    setTimeout(typing, 25); 
                }
            }

            // Jalankan animasi setelah jeda singkat
            setTimeout(typing, 500); 
        });
    </script>
</body>
</html>