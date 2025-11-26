💻 LAPORAN PROYEK: PENGEMBANGAN WEB SERVER DAN APLIKASI SEDERHANA
Proyek: Implementasi Web Server dengan OpenLiteSpeed dan LSPHP pada Debian Trixie

Proyek ini dibuat untuk memenuhi tugas mata pelajaran Administrasi Sistem Jaringan (ASJ), yang merupakan salah satu elemen Capaian Pembelajaran Konsentrasi Keahlian Teknik Komputer dan Jaringan (CP KKTKJ) pada program TJKT. Proyek ini berfokus pada implementasi layanan Web Server, konfigurasi PHP, dan pengamanan koneksi menggunakan SSL/HTTPS.

1. 👥 Informasi Kelompok dan Spesifikasi Lingkungan Praktik
1.1. Informasi Kelompok
|Peran |	Nama Lengkap |	Kelas |
|Ketua Kelompok |	Muhammad Rangga Maulana	XII TJKT 2 |
|Anggota 1 |	Aji Sanjani| XII TJKT 2 |
|Anggota 2 |	Aldy Fahri Firmansyah |	XII TJKT 2 |
|Anggota 3 |	Siti Zhaira Ulul Albab | 	XII TJKT 2|
|Nama Sekolah/Institusi	SMK Negeri 1 Teknologi Informatika	
1.2. Spesifikasi Alat dan Bahan (Host) 🛠️
|Komponen|	Deskripsi / Versi|
|Virtualisasi|	VMware Workstation 17 Pro|
|Sistem Operasi Host|	Windows 10 Pro|
|RAM Host (Minimal)|	4 GB|
|CPU Host|	Intel Core i3 Generasi ke-4|
1.3. Spesifikasi Server Virtual (VM) 🖥️
|Spesifikasi|	Detail|
|Sistem Operasi Tamu (Guest OS)|	Debian Trixie (13.x)|
|Alamat IP Server|	103.193.178.63|
|RAM VM|	4 GB|
|vCPU|	2 Core|
Web Server yang Dipilih	OpenLiteSpeed
Versi PHP yang Dipakai	LSPHP 8.4
2. 📝 Dokumentasi Teknis dan Langkah-Langkah Pengerjaan
2.1. Persiapan Dasar (Debian Trixie di VMware)
Langkah 1: Setup Awal Sistem

```bash
# Masuk sebagai super user
sudo su -

# Perbarui paket sistem
apt update && apt upgrade -y

# Install paket-paket penting
apt install -y wget curl nano net-tools openssh-server ufw
```
Langkah 2: Setting Jaringan Static IP

```bash
# Edit konfigurasi jaringan
nano /etc/network/interfaces

# Tambahkan setting IP statis
auto eth0
iface eth0 inet static
    address 103.193.178.63
    netmask 255.255.255.0
    gateway 103.193.178.1
    dns-nameservers 8.8.8.8 8.8.4.4

# Restart layanan jaringan
systemctl restart networking

# Cek IP address
ip addr show eth0
```
Langkah 3: Konfigurasi Keamanan

```bash
# Aktifkan SSH
systemctl start ssh
systemctl enable ssh

# Setting firewall
ufw allow 22/tcp    # Port SSH
ufw allow 80/tcp    # Port HTTP
ufw allow 443/tcp   # Port HTTPS
ufw allow 7080/tcp  # Port Web Admin
ufw enable
```
2.2. Instalasi dan Konfigurasi Web Server 🌐
Kami menggunakan OpenLiteSpeed. Berikut langkah-langkah utamanya:

Langkah 1: Persiapan Repository

```bash
# Tambahkan repository OpenLiteSpeed
wget -O - https://repo.litespeed.sh | sudo bash

# Update repository
sudo apt update
```
Langkah 2: Instalasi OpenLiteSpeed dan PHP

```bash
# Install OpenLiteSpeed
sudo apt install openlitespeed -y

# Install LSPHP 8.4 dan extensions
sudo apt install lsphp84 lsphp84-common lsphp84-curl lsphp84-mysql lsphp84-json lsphp84-opcache -y
```
Langkah 3: Manajemen Service

```bash
# Start service OpenLiteSpeed
sudo systemctl start lsws

# Enable service untuk auto-start pada boot
sudo systemctl enable lsws

# Verifikasi status service
sudo systemctl status lsws
```
Langkah 4: Set Password Panel Admin

```bash
# Jalankan script set password admin
/usr/local/lsws/admin/misc/admpass.sh

# Input data:
# Username: admin
# Password: [password_rahasia_kelompok]
```
Langkah 5: Konfigurasi Virtual Host

Akses Panel Admin: http://103.193.178.63:7080

Menu: Virtual Hosts → Example → General

Document Root: /usr/local/lsws/Example/html/

Index Files: index.php, index.html

Save → Graceful Restart

Langkah 6: Ubah Port 8088 ke 80

Menu: Listeners → Default → Edit

Ubah Port: 8088 → 80

Save → Graceful Restart

2.3. Konfigurasi PHP 🐘
Kami menggunakan LSPHP 8.4 untuk mengintegrasikan PHP dengan OpenLiteSpeed.

Langkah 1: Konfigurasi External App

Menu: Server Configuration → External App

Klik Add → Pilih LiteSpeed SAPI App → Next

Isi data:

```text
Name: lsphp84
Address: uds://tmp/lshttpd/lsphp.sock
Command: /usr/local/lsws/lsphp84/bin/lsphp
Max Connections: 35
Persistent Connection: Yes
```
Save → Graceful Restart

Langkah 2: Konfigurasi Script Handler

Menu: Server Configuration → Script Handler

Konfigurasi:

```text
Suffixes: php
Handler Type: LiteSpeed SAPI
Handler Name: lsphp84
```
Save → Graceful Restart

Langkah 3: Testing PHP Configuration

```bash
# Buat file test PHP
sudo nano /usr/local/lsws/Example/html/test.php

# Isi dengan:
<?php
echo "<h1>OpenLiteSpeed + LSPHP Test Page</h1>";
echo "<p>PHP Version: " . phpversion() . "</p>";
echo "<p>Server Software: " . $_SERVER['SERVER_SOFTWARE'] . "</p>";

// Test MySQL connection
if (extension_loaded('mysqli')) {
    echo "<p style='color: green;'>✅ MySQLi Extension: Loaded</p>";
} else {
    echo "<p style='color: red;'>❌ MySQLi Extension: Not Loaded</p>";
}
?>
```
2.4. Implementasi SSL (HTTPS) 🔒
Untuk mengaktifkan akses HTTPS, kami membuat self-signed certificate.

Langkah 1: Generate SSL Certificate

```bash
# Buat folder SSL
sudo mkdir -p /etc/ssl/private
cd /etc/ssl/private

# Generate self-signed certificate
sudo openssl req -x509 -newkey rsa:2048 -nodes -keyout self.key -out self.crt -days 365

# Set permissions
sudo chmod 600 self.key
sudo chmod 644 self.crt
```
Langkah 2: Konfigurasi SSL di OpenLiteSpeed

Menu: Listeners → Add → +

Isi data:

```text
Listener Name: SSL
IP Address: ANY
Port: 443
Secure: Yes
```
Virtual Host Mappings: Example, Domains: *

Tab SSL → isi:

```text
Private Key File: /etc/ssl/private/self.key
Certificate File: /etc/ssl/private/self.crt
```
Save → Graceful Restart

Langkah 3: Testing SSL Configuration

~~~bash
# Test HTTPS connection
curl -I -k https://103.193.178.63

# Test dari browser: https://103.193.178.63
~~~
3. 📊 Analisis Web Server
Berdasarkan pengalaman kami dalam proyek ini, berikut adalah analisis kelebihan dan kekurangan dari Web Server yang kami gunakan:

|Aspek|	Kelebihan (OpenLiteSpeed) 👍|	Kekurangan (OpenLiteSpeed) 👎|
|Performa & Kecepatan|	Event-driven architecture yang sangat cepat, caching built-in|	Kurang familiar bagi pemula dibanding Apache|
|Kemudahan Konfigurasi|	WebAdmin GUI memudahkan konfigurasi|	Konfigurasi file manual lebih kompleks daripada Nginx|
|Fitur & Modularitas|	Built-in caching dan optimization features|	Module ecosystem tidak seluas Apache|
|Resource Usage|	Efisien dalam penggunaan memory|	Dokumentasi lebih terbatas dibanding web server lain|
4. 🧠 Refleksi Proyek: Kesan dan Kendala
4.1. Kesan Selama Proses Pengerjaan ✨
"Kami sangat antusias mempelajari OpenLiteSpeed yang merupakan web server high-performance. Pengalaman konfigurasi melalui WebAdmin Console memberikan wawasan baru tentang manajemen server yang user-friendly. Kami juga merasa senang bisa menerapkan teori jaringan yang dipelajari di kelas ke dalam praktik nyata."

4.2. Kendala dan Solusi yang Diterapkan 💡
|Kendala yang Kami Hadapi 🚧|	Solusi yang Ditemukan ✅|
|Kesulitan memahami konfigurasi LSPHP di OpenLiteSpeed |	Mempelajari dokumentasi resmi dan tutorial online untuk memahami External App configuration|
|Port default OpenLiteSpeed (8088) berbeda dengan standar (80)|	Mengubah konfigurasi listener melalui WebAdmin Console ke port 80 |
|SSL self-signed menampilkan warning di browser|	Menerangkan kepada user bahwa ini normal untuk testing environment|
|Integrasi PHP dengan OpenLiteSpeed cukup kompleks|	Menggunakan LSPHP native yang sudah terintegrasi lebih baik dengan OpenLiteSpeed|
5. 📂 Dokumentasi Konten Website
Seluruh source code (Halaman Utama dan Halaman Profil) yang berada di document root server telah disalin dan di-commit ke dalam folder /html di repository GitHub ini.

Struktur File Website:
```bash
text
/usr/local/lsws/Example/html/
├── index.html          # Halaman default OpenLiteSpeed
├── index.php           # Halaman PHP info
├── test.php            # Halaman testing PHP
└── profile/           # Folder halaman profil kelompok
    ├── index.php
    ├── style.css
    └── images/
```
6. 🎬 Dokumentasi Video Pengerjaan
Seluruh proses pengerjaan telah direkam dan diunggah ke YouTube.

Link Video YouTube: https://youtube.com/example-link-proyek-kelompok

Thumbnail Video Pengerjaan
https://via.placeholder.com/800x450/4A90E2/FFFFFF?text=OpenLiteSpeed+Web+Server+Implementation+by+TJKT+Team

