<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Article;
use Illuminate\Support\Str;

class ArticleSeeder extends Seeder
{
    public function run(): void
    {
        $articles = [
            [
                'title' => 'Mengenal Burnout Akademik: Ketika Kuliah Terasa Melelahkan',
                'summary' => 'Ketahui gejala-gejala kelelahan fisik, mental, dan emosional akibat tekanan akademik serta cara membedakannya dengan rasa lelah biasa.',
                'category' => 'Mental Health',
                'read_time' => 5,
                'content' => "Burnout akademik bukan sekadar rasa malas atau kelelahan biasa setelah begadang semalaman mengerjakan laporan. Ini adalah kondisi kelelahan kronis yang disebabkan oleh paparan stres jangka panjang yang tidak terkelola dengan baik terkait dengan beban studi perkuliahan Anda.\n\n### Mengapa Burnout Terjadi?\nMahasiswa tingkat akhir sering kali memikul beban berlebih: pengerjaan skripsi, tekanan kelulusan, kekhawatiran masa depan karir, hingga ekspektasi dari orang tua. Ketika semua hal ini menumpuk tanpa adanya mekanisme koping yang sehat, burnout emosional dan fisik pun tak terhindarkan.\n\n### Gejala Utama Burnout Akademik:\n1. **Kelelahan Kronis (Exhaustion):** Merasa lelah secara fisik dan emosional bahkan sebelum hari dimulai. Tidur cukup tidak lagi terasa mengembalikan energi.\n2. **Kehilangan Minat & Sinisme (Cynicism):** Mulai bersikap apatis terhadap mata kuliah, menjauhkan diri dari kegiatan kampus, dan merasa skripsi yang dikerjakan tidak memiliki arti.\n3. **Penurunan Efektivitas (Inefficacy):** Merasa tidak kompeten, kesulitan berkonsentrasi, dan merasa usaha yang dilakukan sia-sia karena hasil belajar yang terus menurun.\n\n### Langkah Awal Mengatasinya:\nJika Anda mulai merasakan gejala tersebut, hal pertama yang harus disadari adalah bahwa Anda tidak sendiri. Ambillah jeda sejenak dari aktivitas belajar untuk menyegarkan pikiran. Hubungi teman dekat atau konselor profesional jika perasaan tertekan mulai membebani aktivitas harian Anda. Ingat, kesehatan mental Anda jauh lebih penting daripada kelulusan yang terburu-buru.",
            ],
            [
                'title' => 'Teknik Pomodoro: Kunci Produktivitas Mahasiswa Tanpa Burnout',
                'summary' => 'Metode manajemen waktu sederhana untuk membantu Anda menyelesaikan tugas akhir secara konsisten dan menjaga pikiran tetap segar.',
                'category' => 'Produktivitas',
                'read_time' => 4,
                'content' => "Sering kali kita merasa bersalah ketika mengambil waktu istirahat di tengah kesibukan perkuliahan. Padahal, memaksakan otak untuk terus bekerja keras menatap layar laptop selama berjam-jam tanpa jeda justru akan menurunkan daya konsentrasi secara drastis.\n\n### Apa itu Teknik Pomodoro?\nTeknik Pomodoro adalah metode manajemen waktu yang diciptakan oleh Francesco Cirillo pada akhir 1980-an. Konsep dasarnya sangat sederhana: membagi waktu kerja menjadi interval fokus pendek yang diselingi dengan istirahat singkat. Satu interval fokus biasanya berdurasi 25 menit, yang disebut sebagai satu sesi \"Pomodoro\".\n\n### Cara Menerapkan Teknik Pomodoro:\n1. **Pilih Tugas:** Tentukan satu tugas spesifik yang ingin Anda selesaikan (misal: menulis Bab 2 skripsi).\n2. **Pasang Timer:** Atur alarm/timer selama 25 menit.\n3. **Fokus Penuh:** Kerjakan tugas dengan fokus total tanpa gangguan (matikan notifikasi media sosial) hingga timer berbunyi.\n4. **Istirahat Singkat:** Istirahatlah selama 5 menit. Gunakan waktu ini untuk berdiri, meregangkan tubuh, atau minum air.\n5. **Ulangi:** Lakukan putaran tersebut sebanyak 4 kali. Setelah itu, ambil istirahat lebih panjang (15–30 menit) sebelum memulai siklus baru.\n\n### Manfaat Nyata:\nDengan memberikan jeda istirahat berkala, Anda mencegah otak mengalami kelelahan ekstrem. Produktivitas Anda akan meningkat secara konsisten tanpa merusak keseimbangan kesehatan mental Anda.",
            ],
            [
                'title' => 'Seni Mengelola Overthinking Saat Menyusun Tugas Akhir',
                'summary' => 'Mengatasi pikiran berlebih (overthinking) dan sindrom kegagalan yang sering menghantui mahasiswa tingkat akhir.',
                'category' => 'Self-Care',
                'read_time' => 6,
                'content' => "Menjelang kelulusan, kecemasan hebat sering kali menghantui pikiran mahasiswa tingkat akhir. Pertanyaan-pertanyaan seperti \"Bagaimana jika dosen pembimbing menolak revisian saya?\" atau \"Apakah saya bisa mendapat pekerjaan setelah lulus?\" terus berputar tanpa henti. Pola pikir berlebih (*overthinking*) ini jika dibiarkan dapat melumpuhkan produktivitas Anda.\n\n### Dampak Overthinking pada Skripsi\nOverthinking menyebabkan penundaan (*procrastination*). Karena takut hasil tulisan Anda tidak sempurna, Anda memilih untuk tidak memulainya sama sekali. Hal ini justru memperburuk stres karena tenggat waktu kelulusan semakin mendekat.\n\n### Strategi Menaklukkan Overthinking:\n1. **Ubah Fokus ke Langkah Kecil:** Jangan melihat skripsi sebagai buku tebal yang harus diselesaikan besok. Fokuslah untuk menulis satu paragraf, satu sub-bab, atau sekadar merapikan daftar pustaka hari ini.\n2. **Tuliskan Pikiran Anda (Brain Dump):** Tumpahkan semua kekhawatiran Anda di atas kertas kosong. Menuliskan kecemasan membantu otak melihat masalah secara lebih objektif dan terstruktur.\n3. **Batasi Waktu Khawatir:** Jadwalkan waktu khusus selama 10-15 menit untuk memikirkan kekhawatiran Anda. Setelah waktu habis, alihkan fokus kembali ke tindakan nyata.\n4. **Apresiasi Proses Kecil:** Apresiasi setiap progres sekecil apa pun. Menyelesaikan satu halaman atau membaca satu jurnal referensi adalah kemajuan yang patut disyukuri.\n\nIngatlah bahwa kesempurnaan adalah musuh dari penyelesaian. Skripsi yang baik adalah skripsi yang selesai, bukan yang sempurna namun tidak pernah terwujud.",
            ],
            [
                'title' => 'Pentingnya Menjaga Kualitas Tidur di Tengah Kesibukan Kuliah',
                'summary' => 'Mengapa tidur cukup adalah senjata rahasia performa kognitif Anda untuk menaklukkan skripsi.',
                'category' => 'Kesehatan Fisik',
                'read_time' => 5,
                'content' => "Di kalangan mahasiswa, begadang sering kali dianggap sebagai lencana kehormatan yang menunjukkan dedikasi belajar. Namun, secara sains, mengorbankan waktu tidur demi mengejar deadline adalah strategi jangka pendek yang sangat merugikan kemampuan kognitif otak Anda.\n\n### Apa yang Terjadi Saat Anda Kurang Tidur?\nSaat kurang tidur, otak depan yang mengontrol fungsi eksekutif—seperti pemecahan masalah, kreativitas, dan pengambilan keputusan—mengalami penurunan performa yang signifikan. Anda akan merasa lambat berpikir, mudah lupa materi referensi, dan rentan melakukan kesalahan pengetikan dasar.\n\n### Tips Menjaga Kualitas Tidur:\n1. **Konsistensi Jadwal:** Usahakan tidur dan bangun pada jam yang sama setiap hari, bahkan saat akhir pekan.\n2. **Batasi Screen Time:** Matikan layar laptop dan ponsel minimal 30 menit sebelum tidur. Paparan cahaya biru menghambat produksi hormon melatonin (hormon tidur).\n3. **Buat Kamar Nyaman:** Pastikan suhu kamar sejuk dan kondisi ruangan cukup gelap untuk memicu tidur yang lebih nyenyak.\n4. **Hindari Kafein Berlebih:** Hindari konsumsi kopi atau minuman energi di sore hari karena kafein bertahan di dalam tubuh hingga 6 jam setelah dikonsumsi.\n\nMemperbaiki pola tidur akan langsung berdampak pada kejelasan berpikir Anda keesokan paginya, sehingga proses penulisan tugas akhir Anda bisa berjalan jauh lebih efektif.",
            ],
        ];

        foreach ($articles as $art) {
            Article::create([
                'title' => $art['title'],
                'slug' => Str::slug($art['title']),
                'summary' => $art['summary'],
                'category' => $art['category'],
                'read_time' => $art['read_time'],
                'content' => $art['content'],
                'image_url' => null,
            ]);
        }
    }
}
