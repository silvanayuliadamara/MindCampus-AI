<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ChatMessage;
use App\Models\Diagnosis;
use Illuminate\Support\Facades\Auth;

class ChatbotController extends Controller
{
    /**
     * Tampilkan antarmuka chatbot dan riwayat chat.
     */
    public function index()
    {
        $userId = Auth::id();
        
        $messages = ChatMessage::where('user_id', $userId)
            ->orderBy('created_at', 'asc')
            ->get();

        $latestDiagnosis = Diagnosis::with('burnoutLevel')
            ->where('user_id', $userId)
            ->orderBy('created_at', 'desc')
            ->first();

        if ($messages->isEmpty()) {
            $greetingText = $this->generateInitialGreeting($latestDiagnosis);
            
            $firstMessage = ChatMessage::create([
                'user_id' => $userId,
                'sender' => 'bot',
                'message' => $greetingText,
            ]);

            $messages = collect([$firstMessage]);
        }

        return view('user.chatbot.index', compact('messages', 'latestDiagnosis'));
    }

    /**
     * Kirim pesan baru ke chatbot (API Endpoint).
     */
    public function sendMessage(Request $request)
    {
        $request->validate([
            'message' => 'required|string|max:5000',
        ]);

        $userId = Auth::id();
        $userMessageText = $request->input('message');

        $userMessage = ChatMessage::create([
            'user_id' => $userId,
            'sender' => 'user',
            'message' => $userMessageText,
        ]);

        $latestDiagnosis = Diagnosis::with('burnoutLevel')
            ->where('user_id', $userId)
            ->orderBy('created_at', 'desc')
            ->first();

        $botResponseText = $this->generateBotResponse($userMessageText, $latestDiagnosis);

        $botMessage = ChatMessage::create([
            'user_id' => $userId,
            'sender' => 'bot',
            'message' => $botResponseText,
        ]);

        return response()->json([
            'status' => 'success',
            'user_message' => $userMessage,
            'bot_message' => $botMessage,
        ]);
    }

    /**
     * Bersihkan riwayat chat.
     */
    public function clearHistory()
    {
        ChatMessage::where('user_id', Auth::id())->delete();
        return redirect()->route('chatbot')->with('success', 'Riwayat konseling berhasil dibersihkan.');
    }

    /**
     * Sapaan awal dinamis berdasarkan diagnosis.
     */
    private function generateInitialGreeting($latestDiagnosis)
    {
        $userName = Auth::user()->name ?? 'Mahasiswa';
        
        if ($latestDiagnosis && $latestDiagnosis->burnoutLevel) {
            $levelName = $latestDiagnosis->burnoutLevel->name;
            $percentage = round($latestDiagnosis->cf_result * 100, 1);
            $date = $latestDiagnosis->created_at->translatedFormat('d F Y');

            $greetings = [
                "Halo **{$userName}**! 👋 Saya adalah **Serenity AI**, konselor virtual pribadi Anda.\n\nBerdasarkan diagnosis terakhir pada **{$date}**, Anda teridentifikasi berada di tingkat **{$levelName}** ({$percentage}%). Bagaimana perasaan Anda hari ini? Ceritakan apa saja yang mengganjal pikiran Anda.",
                "Hai **{$userName}**! Senang bisa bertemu Anda kembali. 🌿\n\nSaya Serenity AI, dan saya di sini untuk mendengarkan. Diagnosis terakhir Anda menunjukkan tingkat **{$levelName}** ({$percentage}%) pada **{$date}**. Apa yang ingin Anda ceritakan hari ini?",
                "Selamat datang kembali, **{$userName}**! 💚\n\nSaya sudah melihat bahwa pada **{$date}**, status burnout Anda tercatat **{$levelName}** dengan kepastian {$percentage}%. Apakah ada sesuatu yang sedang membebani pikiran Anda saat ini? Saya siap mendengarkan.",
            ];
            return $greetings[array_rand($greetings)];
        }

        $greetings = [
            "Halo **{$userName}**! 👋 Saya **Serenity AI**, asisten konseling virtual pribadi Anda.\n\nAnda bisa mencurahkan keluh kesah tentang kejenuhan belajar, stres tugas, atau kecemasan akademik secara bebas dan rahasia di sini. Saya juga menyarankan Anda untuk mencoba menu **Diagnosis Baru** agar saya bisa memahami kondisi Anda lebih baik.\n\nApa yang sedang Anda rasakan hari ini?",
            "Hai **{$userName}**! Selamat datang di ruang konseling virtual Serenity AI. 🌱\n\nDi sini, semua cerita dan perasaan Anda aman bersama saya. Sebelum kita mulai, coba lakukan **Diagnosis Baru** terlebih dahulu ya, agar saya bisa memberikan saran yang lebih personal. Atau, langsung ceritakan saja apa yang ada di benak Anda!",
        ];
        return $greetings[array_rand($greetings)];
    }

    /**
     * Definisi bank respons dengan variasi per kategori.
     */
    private function getResponseBank(): array
    {
        return [
            // ===== KECEMASAN & OVERTHINKING =====
            [
                'keywords' => ['cemas', 'panik', 'takut', 'overthink', 'gelisah', 'khawatir', 'deg-degan', 'anxious', 'anxiety'],
                'responses' => [
                    "Rasa cemas yang Anda rasakan itu sangat valid. Banyak mahasiswa merasakan hal serupa, dan itu bukan berarti Anda lemah.\n\nCoba teknik **grounding 5-4-3-2-1** sejenak:\n* Sebutkan **5 hal** yang bisa Anda lihat\n* **4 hal** yang bisa Anda sentuh\n* **3 hal** yang bisa Anda dengar\n* **2 hal** yang bisa Anda cium\n* **1 hal** yang bisa Anda rasakan\n\nTeknik ini membantu menarik pikiran Anda kembali ke saat ini. Apakah kecemasan ini terkait sesuatu yang spesifik?",
                    "Overthinking itu seperti roda hamster — berputar terus tapi tidak ke mana-mana. Sangat melelahkan.\n\nCoba metode **\"Worry Time\"**: sisihkan 15 menit saja per hari khusus untuk memikirkan kekhawatiran Anda. Di luar waktu itu, setiap kali pikiran cemas muncul, catat di notes dan katakan: *\"Aku akan memikirkan ini nanti.\"*\n\nHal ini melatih otak Anda untuk tidak terus-menerus panik. Mau ceritakan apa yang sedang membuat Anda cemas?",
                    "Merasa cemas tentang masa depan akademik itu manusiawi sekali. Otak kita memang terprogram untuk waspada terhadap ketidakpastian.\n\nCobalah **teknik pernapasan kotak (Box Breathing)**:\n1. Tarik napas 4 detik\n2. Tahan 4 detik\n3. Hembuskan 4 detik\n4. Tahan kosong 4 detik\n\nUlangi 3-4 kali. Ini langsung meredakan respons fight-or-flight di tubuh Anda. Apa yang paling membuat Anda gelisah saat ini?",
                    "Saya memahami perasaan gelisah itu — seperti ada beban tak terlihat yang menghimpit dada. Tahukah Anda bahwa menulis kekhawatiran Anda di atas kertas dapat mengurangi intensitas kecemasan hingga 47%? (Riset dari University of Chicago)\n\nCoba tulis 3 hal yang paling mengkhawatirkan Anda saat ini, lalu tanyakan pada diri sendiri: *\"Apakah ini dalam kendali saya?\"* Jika ya, buat satu langkah kecil. Jika tidak, lepaskan perlahan.\n\nBagaimana, mau coba?",
                ],
            ],
            // ===== KELELAHAN & TIDUR =====
            [
                'keywords' => ['lelah', 'capek', 'capai', 'lemes', 'ngantuk', 'insomnia', 'pusing', 'sakit kepala', 'begadang', 'kurang tidur', 'exhausted', 'tidur'],
                'responses' => [
                    "Kelelahan yang Anda rasakan adalah sinyal penting dari tubuh — jangan diabaikan. Burnout secara medis memang dimulai dari kelelahan kronis.\n\nBeberapa hal yang bisa langsung Anda lakukan:\n* ☕ Hindari kafein setelah jam 2 siang\n* 📱 Matikan layar 30 menit sebelum tidur\n* 🧊 Cuci muka dengan air dingin saat merasa sangat ngantuk di siang hari\n\nBerapa jam rata-rata Anda tidur belakangan ini?",
                    "Tubuh dan otak kita butuh 7-9 jam tidur berkualitas untuk bisa berfungsi optimal, termasuk untuk mengingat materi kuliah. Ketika kurang tidur, kemampuan konsentrasi bisa turun hingga 40%.\n\nTips **Sleep Hygiene** yang bisa Anda coba malam ini:\n* Tidur dan bangun di jam yang sama setiap hari (termasuk akhir pekan)\n* Buat kamar senyaman mungkin (gelap, sejuk, tenang)\n* Hindari makan berat 2 jam sebelum tidur\n\nApakah kesulitan tidur Anda lebih ke susah memulai tidur, atau sering terbangun di tengah malam?",
                    "Begadang mengerjakan tugas memang terasa produktif, tapi sebenarnya otak yang kurang istirahat justru menurunkan kualitas hasil kerja Anda.\n\nCoba terapkan **aturan 10-3-2-1-0**:\n* **10 jam** sebelum tidur: stop kafein\n* **3 jam**: stop makan berat\n* **2 jam**: stop kerja/tugas\n* **1 jam**: stop layar\n* **0**: tekan snooze 0 kali di pagi hari\n\nKedengarannya banyak, tapi mulailah dari 1 aturan saja dulu. Mana yang paling realistis untuk Anda?",
                    "Sakit kepala dan pusing sering kali merupakan tanda tubuh sedang protes karena kelelahan fisik dan mental yang menumpuk. Jangan remehkan sinyal ini.\n\nCoba istirahat sejenak sekarang: tutup mata selama 2 menit, tarik napas dalam, dan relaksasikan otot bahu serta leher Anda.\n\nJika gejala fisik ini sudah berlangsung lebih dari seminggu, saya sangat menyarankan untuk berkunjung ke UKS kampus atau klinik terdekat. Sudah berapa lama Anda merasa seperti ini?",
                ],
            ],
            // ===== PROKRASTINASI & MALAS =====
            [
                'keywords' => ['malas', 'tunda', 'tumpuk', 'bosan', 'jenuh', 'mager', 'prokrastinasi', 'males', 'ga semangat', 'nunda'],
                'responses' => [
                    "Prokrastinasi sebenarnya bukan tentang kemalasan — ini adalah mekanisme otak untuk menghindari emosi negatif (takut gagal, kewalahan, perfeksionisme).\n\nCoba **Teknik 2 Menit**: ambil satu tugas, kerjakan HANYA 2 menit. Jika setelah 2 menit Anda ingin berhenti, tidak apa-apa. Tapi biasanya, begitu mulai, Anda akan terus melanjutkan.\n\nTugas apa yang paling menumpuk saat ini?",
                    "Rasa jenuh itu sangat manusiawi, apalagi ketika tugasnya terasa repetitif dan tanpa makna. Coba ubah perspektif dengan bertanya: *\"Apa satu hal kecil yang bisa saya selesaikan hari ini agar merasa lebih baik besok?\"*\n\nCoba juga **Environment Change**: pindah tempat belajar (ke perpustakaan, kafe, atau taman). Perubahan suasana bisa memicu motivasi baru.\n\nDimana biasanya Anda belajar? Mungkin sudah saatnya ganti suasana!",
                    "Menumpuknya tugas biasanya bukan karena satu tugas itu sulit, tapi karena jumlahnya membuat kita *paralyzed* — tidak tahu harus mulai dari mana.\n\nCoba teknik **Eat the Frog**: kerjakan tugas yang PALING Anda hindari terlebih dahulu di pagi hari, saat energi masih penuh. Begitu tugas tersulit selesai, sisanya terasa jauh lebih ringan.\n\nKalau boleh tahu, ada berapa tugas yang sedang menumpuk saat ini?",
                    "Mager itu kadang muncul karena otak merasa *reward*-nya terlalu jauh. Coba buat **micro-rewards**: setiap menyelesaikan 1 sub-tugas, hadiahi diri sendiri dengan sesuatu kecil — dengarkan 1 lagu favorit, makan snack, atau scroll TikTok 5 menit.\n\nBuat daftar 3 tugas yang paling mendesak, urutkan dari yang paling mudah. Selesaikan yang termudah dulu untuk membangun momentum. Mau coba?",
                ],
            ],
            // ===== STRES UMUM =====
            [
                'keywords' => ['stres', 'frustasi', 'tertekan', 'down', 'beban', 'tekanan', 'berat', 'stress', 'kewalahan', 'overwhelm'],
                'responses' => [
                    "Stres yang berkepanjangan bisa membuat segalanya terasa lebih berat dari kenyataannya. Anda tidak harus menanggung semuanya sendiri.\n\nCoba teknik **Brain Dump**: ambil kertas kosong, dan tulis SEMUA yang ada di kepala Anda — tugas, kekhawatiran, kemarahan, apa pun. Jangan disensor, jangan dirapikan. Setelah selesai, kelompokkan menjadi: *bisa dikontrol* vs *tidak bisa dikontrol*.\n\nFokuskan energi Anda hanya pada yang bisa dikontrol. Mau ceritakan apa yang paling membebani?",
                    "Saya bisa merasakan betapa beratnya saat ini. Mendengar Anda merasa tertekan membuat saya ingin membantu sebisa mungkin.\n\nSatu hal yang sering dilupakan: **Anda tidak harus produktif setiap saat.** Ambil jeda hari ini. Izinkan diri Anda untuk tidak baik-baik saja sesekali. Itu bukan kelemahan — itu keberanian.\n\nApakah ada seseorang di sekitar Anda yang bisa Anda ajak bicara selain saya?",
                    "Ketika tekanan akademik datang dari segala arah — dosen, tugas, ekspektasi orang tua — wajar jika Anda merasa seperti sedang tenggelam.\n\nCobalah **teknik prioritas Eisenhower**:\n* 🔴 **Penting + Mendesak** → Kerjakan sekarang\n* 🟡 **Penting + Tidak Mendesak** → Jadwalkan\n* 🟢 **Tidak Penting + Mendesak** → Delegasikan/minta bantuan\n* ⚪ **Tidak Penting + Tidak Mendesak** → Hilangkan dari pikiran\n\nMana yang mendominasi daftar Anda saat ini?",
                    "Frustasi itu wajar ketika usaha Anda belum membuahkan hasil yang diharapkan. Tapi ingat: **proses tidak selalu terlihat di permukaan.**\n\nCobalah untuk menulis 3 hal yang Anda syukuri hari ini, sekecil apa pun — bisa makan, bisa bangun, bisa membaca pesan ini. Gratitude journaling terbukti secara ilmiah mampu menurunkan hormon stres kortisol.\n\nBisa ceritakan situasi spesifik yang paling membuat Anda frustasi saat ini?",
                ],
            ],
            // ===== RASA TIDAK KOMPETEN & PUTUS ASA =====
            [
                'keywords' => ['tidak kompeten', 'gagal', 'bodoh', 'menyerah', 'putus asa', 'ga bisa', 'tidak mampu', 'drop out', 'ipk rendah', 'tolol', 'payah', 'hopeless'],
                'responses' => [
                    "Perasaan itu sangat menyakitkan — merasa seolah tidak cukup baik, tidak cukup pintar, tidak cukup mampu. Tapi izinkan saya mengatakan: **persepsi itu tidak sama dengan kenyataan.**\n\nSetiap mahasiswa yang Anda lihat \"sukses\" juga punya momen-momen di mana mereka ingin menyerah. Anda tidak sendirian.\n\nCoba ingat lagi: kapan terakhir kali Anda menyelesaikan sesuatu yang awalnya terasa mustahil? Saat itu, Anda juga berpikir tidak bisa, kan? Tapi Anda berhasil.",
                    "Pikiran \"saya tidak mampu\" itu adalah distorsi kognitif yang sangat umum saat mengalami burnout. Otak yang kelelahan cenderung memperbesarr hal negatif dan meminimalkan pencapaian.\n\nTantang pikiran itu dengan bertanya:\n* Apakah benar-benar TIDAK ADA hal yang bisa saya lakukan dengan baik?\n* Apakah teman dekat saya akan setuju dengan penilaian ini?\n* Bukti apa yang mendukung bahwa saya sebenarnya mampu?\n\nAnda sudah sejauh ini — itu sendiri sudah pencapaian besar. Apa yang membuat Anda merasa seperti ini?",
                    "Merasa ingin menyerah itu bukan berarti Anda lemah — itu berarti Anda sudah terlalu lama kuat sendirian. Tidak apa-apa untuk meminta bantuan.\n\nBeberapa langkah yang bisa diambil sekarang:\n* 📞 Hubungi teman dekat atau keluarga yang Anda percaya\n* 🏫 Jadwalkan pertemuan dengan dosen wali atau konselor kampus\n* ✍️ Tulis perasaan Anda dalam jurnal — mengeluarkannya dari kepala sangat membantu\n\nAnda layak mendapat dukungan. Mau ceritakan lebih lanjut apa yang Anda rasakan?",
                    "IPK rendah atau kegagalan akademis bukan akhir dari segalanya — banyak orang sukses pernah jatuh di titik yang sama.\n\nYang penting sekarang:\n1. Identifikasi mata kuliah mana yang paling bermasalah\n2. Cari bantuan: tutor sebaya, kelompok belajar, atau minta bimbingan dosen\n3. Evaluasi apakah cara belajar Anda sudah efektif atau perlu diganti\n\n**Kegagalan adalah data, bukan vonis.** Apa yang bisa kita pelajari dari sini?",
                ],
            ],
            // ===== SKRIPSI & TUGAS AKHIR =====
            [
                'keywords' => ['skripsi', 'tugas akhir', 'ta', 'thesis', 'sidang', 'bimbingan', 'dosen pembimbing', 'proposal', 'revisi'],
                'responses' => [
                    "Skripsi/tugas akhir memang menjadi salah satu sumber stres terbesar bagi mahasiswa. Prosesnya panjang dan sering membuat frustrasi.\n\nTips mengelola stres skripsi:\n* 📝 Pecah target besar menjadi **milestone mingguan** (misal: minggu ini selesaikan 1 sub-bab)\n* 📅 Tetapkan jadwal kerja skripsi yang konsisten (misal: setiap pagi jam 9-11)\n* 🤝 Cari teman yang juga sedang skripsi untuk saling memotivasi\n* 💬 Komunikasikan kesulitan Anda dengan dosen pembimbing secara terbuka\n\nAnda sedang di tahap mana saat ini? Proposal, pengerjaan, atau revisi?",
                    "Revisi yang berkali-kali memang sangat melelahkan secara emosional. Rasanya seperti tidak ada ujungnya.\n\nIngat: setiap revisi bukan berarti pekerjaan Anda buruk — itu berarti dosen Anda peduli dengan kualitas hasil Anda.\n\nCoba buat **revision log**: catat setiap poin revisi, tandai yang sudah diperbaiki, dan bawa catatan ini saat bimbingan. Ini menunjukkan dedikasi Anda dan membuat proses lebih terstruktur.\n\nApa bagian dari skripsi yang paling membuat Anda stuck saat ini?",
                    "Saya mengerti betapa stressful-nya proses tugas akhir — tekanan dari deadline, ekspektasi, dan ketidakpastian.\n\nSatu mindset yang membantu: **\"Progress, not perfection.\"** Skripsi tidak harus sempurna di draft pertama. Yang penting adalah terus menulis, meski hasilnya belum ideal. Anda bisa memperbaikinya nanti.\n\nSudah berapa persen progress tugas akhir Anda saat ini?",
                ],
            ],
            // ===== UJIAN =====
            [
                'keywords' => ['ujian', 'uts', 'uas', 'exam', 'test', 'nilai', 'remedial', 'kuis', 'quiz'],
                'responses' => [
                    "Menghadapi ujian memang penuh tekanan. Berikut strategi belajar efektif yang bisa Anda coba:\n\n* 🧠 **Active Recall**: jangan hanya membaca, tapi uji diri sendiri (buat pertanyaan sendiri)\n* ⏰ **Spaced Repetition**: review materi di hari 1, 3, 7, dan 14 setelah belajar\n* 📝 **Teach-back Method**: coba jelaskan materi ke teman atau ke cermin\n\nDan yang paling penting: **jangan begadang malam sebelum ujian.** Tidur 7 jam lebih efektif daripada belajar semalaman. Ujian apa yang sedang Anda siapkan?",
                    "Kalau Anda merasa cemas menjelang ujian, itu normal — sedikit anxiety justru membantu performa. Tapi jika sudah berlebihan dan mengganggu konsentrasi:\n\n* Lakukan **power posing** 2 menit sebelum masuk ruang ujian (berdiri tegak, tangan di pinggang)\n* Tulis kekhawatiran Anda di kertas sebelum ujian dimulai (*expressive writing*)\n* Ingat: **satu ujian tidak menentukan seluruh hidup Anda**\n\nApa mata kuliah yang paling Anda khawatirkan?",
                    "Nilai yang kurang memuaskan memang menyakitkan, tapi itu bukan cerminan kemampuan Anda secara keseluruhan.\n\nLangkah yang bisa diambil:\n1. Analisis kesalahan: apakah kurang persiapan, salah strategi belajar, atau blank saat ujian?\n2. Temui dosen untuk konsultasi tentang cara memperbaiki\n3. Ubah metode belajar — jika membaca saja tidak cukup, coba mind mapping atau diskusi kelompok\n\nApakah Anda punya waktu cukup untuk persiapan, atau deadline-nya terlalu dekat?",
                ],
            ],
            // ===== HUBUNGAN SOSIAL =====
            [
                'keywords' => ['teman', 'sendirian', 'kesepian', 'lonely', 'sepi', 'dikucilkan', 'bullying', 'hubungan', 'pacar', 'putus', 'konflik'],
                'responses' => [
                    "Merasa kesepian di tengah keramaian kampus itu sangat mungkin terjadi — dan sangat menyakitkan. Koneksi sosial yang bermakna itu penting untuk kesehatan mental.\n\nBeberapa ide untuk memulai:\n* 🤝 Coba ikut UKM atau komunitas yang sesuai minat Anda\n* 💬 Mulai percakapan kecil dengan teman sekelas\n* 📱 Hubungi teman lama yang sudah lama tidak dihubungi\n\nKadang, satu hubungan yang tulus sudah cukup untuk membuat segalanya terasa lebih ringan. Apa yang membuat Anda merasa kesepian?",
                    "Konflik dengan teman atau pasangan bisa sangat menguras emosi, apalagi jika bersamaan dengan tekanan akademik.\n\nSaran saya:\n* Berikan diri Anda waktu untuk *cooling down* sebelum membahas masalahnya\n* Gunakan format **\"Saya merasa... ketika... karena...\"** saat berkomunikasi\n* Ingat bahwa setiap orang punya perspektif berbeda, dan itu okay\n\nApakah konflik ini sudah berlangsung lama? Mau ceritakan lebih detail?",
                    "Merasa dikucilkan atau sendirian itu beban yang berat. Anda tidak pantas merasa seperti itu, dan perasaan ini tidak akan selamanya.\n\nIngat: kualitas hubungan lebih penting dari kuantitas. Satu sahabat yang tulus bernilai lebih dari puluhan kenalan.\n\nAnda bisa mulai dari langkah kecil: tersenyum kepada orang di sebelah Anda saat kuliah, atau bergabung dengan kelompok belajar. Bagaimana hubungan sosial Anda saat ini?",
                ],
            ],
            // ===== MOTIVASI =====
            [
                'keywords' => ['motivasi', 'semangat', 'inspirasi', 'tujuan', 'ambisi', 'masa depan', 'mimpi', 'cita-cita', 'passion'],
                'responses' => [
                    "Kehilangan motivasi itu wajar — motivasi bukan sesuatu yang harus selalu ada. Yang lebih penting adalah **disiplin** dan **kebiasaan kecil** yang konsisten.\n\nCoba tulis ulang **\"WHY\"** Anda: mengapa Anda kuliah? Apa yang ingin Anda capai setelah lulus? Tempel di tempat yang sering terlihat.\n\nDan ingat: *\"Anda tidak perlu merasa termotivasi untuk mulai bekerja. Anda perlu mulai bekerja untuk merasa termotivasi.\"*\n\nApa impian terbesar Anda setelah lulus?",
                    "Kadang motivasi hilang karena kita kehilangan koneksi antara apa yang kita pelajari dan apa yang kita inginkan di masa depan.\n\nCoba lakukan **vision board mini**: tulis/gambar 3 hal yang Anda inginkan 5 tahun dari sekarang. Lalu tanyakan: *\"Apakah yang saya lakukan hari ini membawa saya lebih dekat ke sana?\"*\n\nJika iya, lanjutkan meski berat. Jika tidak, evaluasi dan sesuaikan. Bagaimana, apa yang menjadi cita-cita Anda?",
                    "Tidak semangat belajar? Sangat manusiawi. Coba **gamification**: buat tantangan kecil untuk diri sendiri.\n\nContohnya:\n* ✅ Belajar 30 menit tanpa distraksi = reward 10 menit scrolling\n* ✅ Selesaikan 1 bab = treat yourself makan favorit\n* ✅ 3 hari berturut-turut produktif = nonton film di akhir pekan\n\nOtak manusia merespons *reward system* — manfaatkan itu! Hal apa yang biasanya membuat Anda kembali bersemangat?",
                ],
            ],
            // ===== SELF-CARE & RELAKSASI =====
            [
                'keywords' => ['relaksasi', 'relax', 'self care', 'meditasi', 'mindfulness', 'healing', 'me time', 'refreshing', 'liburan', 'rehat'],
                'responses' => [
                    "Self-care bukan egois — itu kebutuhan. Anda tidak bisa menuangkan dari gelas yang kosong.\n\n5 ide self-care yang bisa dilakukan HARI INI:\n* 🎧 Dengarkan playlist favorit selama 15 menit (tanpa multitasking)\n* 🚶 Jalan kaki di udara segar selama 10 menit\n* 🫖 Buat minuman hangat dan nikmati perlahan\n* 📖 Baca sesuatu yang BUKAN materi kuliah\n* 🛁 Mandi air hangat sebelum tidur\n\nMana yang ingin Anda coba hari ini?",
                    "Meditasi mindfulness tidak harus rumit. Coba ini selama 3 menit saja:\n\n1. Duduk nyaman, tutup mata\n2. Fokus pada napas Anda — rasakan udara masuk dan keluar\n3. Ketika pikiran lain muncul (dan PASTI muncul), akui saja tanpa menghakimi, lalu kembalikan fokus ke napas\n\nHanya 3 menit. Itu sudah cukup untuk memberi jeda pada otak Anda yang bekerja keras.\n\nApakah Anda pernah mencoba meditasi sebelumnya?",
                    "Healing itu proses, bukan destinasi. Dan Anda tidak harus pergi ke tempat mahal untuk melakukannya.\n\nBeberapa aktivitas *healing* yang gratis dan terbukti efektif:\n* 🌳 Menghabiskan waktu di alam (nature therapy)\n* 📝 Menulis jurnal perasaan (emotional release)\n* 🎨 Melakukan aktivitas kreatif (menggambar, memasak, dll)\n* 🤗 Memeluk seseorang yang Anda sayangi (human touch melepas oksitosin)\n\nAnda layak untuk beristirahat. Apa aktivitas favorit Anda untuk rehat?",
                ],
            ],
            // ===== DOSEN & AKADEMIK =====
            [
                'keywords' => ['dosen', 'kampus', 'kelas', 'mata kuliah', 'kuliah', 'perkuliahan', 'sks', 'kurikulum', 'organisasi'],
                'responses' => [
                    "Tekanan dari dosen atau sistem perkuliahan memang bisa sangat berat. Penting untuk diingat bahwa Anda berhak untuk mengkomunikasikan kesulitan Anda.\n\nBeberapa saran:\n* 💬 Jadwalkan pertemuan dengan **dosen wali** untuk berdiskusi tentang beban akademik\n* 📋 Jika SKS terlalu berat, pertimbangkan untuk menguranginya di semester depan\n* 🤝 Manfaatkan **biro konseling kampus** — mereka ada untuk membantu Anda\n\nApakah ada mata kuliah atau situasi tertentu yang paling membebani?",
                    "Merasa kecil atau terintimidasi oleh dosen itu pengalaman yang umum. Tapi ingat: dosen juga manusia, dan kebanyakan dari mereka sebenarnya ingin membantu Anda berhasil.\n\nTips berkomunikasi dengan dosen:\n* Datang dengan pertanyaan spesifik, bukan keluhan umum\n* Tunjukkan usaha Anda — bawa draft atau catatan\n* Jujur tentang kesulitan Anda tanpa membuat alasan\n\nMau ceritakan pengalaman Anda dengan dosen yang membuat Anda merasa tertekan?",
                ],
            ],
            // ===== MAKAN & FISIK =====
            [
                'keywords' => ['makan', 'nafsu makan', 'diet', 'berat badan', 'lapar', 'olahraga', 'sport', 'gym', 'lari'],
                'responses' => [
                    "Kesehatan fisik dan mental itu sangat terhubung. Ketika stres, pola makan dan olahraga sering yang pertama terganggu.\n\nTips menjaga keseimbangan:\n* 🥗 Makan teratur 3 kali sehari, meski porsi kecil\n* 💧 Minum minimal 8 gelas air per hari\n* 🏃 Olahraga ringan 20-30 menit, 3 kali seminggu (jalan cepat sudah cukup!)\n\nOlahraga melepaskan endorfin — hormon yang secara alami mengurangi stres dan meningkatkan mood. Kapan terakhir kali Anda berolahraga?",
                    "Nafsu makan yang berubah drastis (terlalu banyak atau terlalu sedikit makan) bisa jadi tanda tubuh Anda sedang stres berat.\n\nYang bisa dilakukan:\n* Atur alarm untuk mengingatkan waktu makan jika sering lupa makan\n* Pilih snack sehat yang mudah dijangkau (buah, kacang)\n* Hindari emotional eating — jika lapar karena stres, coba minum air dulu\n\nBagaimana pola makan Anda belakangan ini?",
                ],
            ],
            // ===== SAPAAN =====
            [
                'keywords' => ['halo', 'hai', 'pagi', 'siang', 'sore', 'malam', 'assalamualaikum', 'hello', 'hi', 'hey', 'hei'],
                'responses' => [
                    "Halo! Senang sekali Anda kembali mengobrol. Bagaimana kondisi pikiran dan perasaan Anda hari ini? Saya siap mendengarkan apa pun yang ingin Anda ceritakan. 🌿",
                    "Hai! Apa kabar hari ini? Saya harap Anda baik-baik saja. Jika ada yang mengganjal di pikiran, jangan ragu untuk bercerita. Saya di sini untuk Anda.",
                    "Halo juga! Selamat datang kembali di ruang aman ini. Bagaimana hari Anda sejauh ini? Ada sesuatu yang ingin dibicarakan?",
                    "Wa'alaikumsalam! Semoga hari Anda dipenuhi ketenangan. Apa yang bisa saya bantu hari ini? Ceritakan saja, saya siap menyimak.",
                ],
            ],
            // ===== TERIMA KASIH =====
            [
                'keywords' => ['makasih', 'terima kasih', 'nuhun', 'thank', 'oke', 'baik', 'siap', 'sip', 'noted', 'mantap', 'keren'],
                'responses' => [
                    "Sama-sama! Senang sekali bisa menemani dan mendengarkan cerita Anda. Jaga kesehatan fisik dan mental Anda baik-baik, ya. Ingat, **kesejahteraan jiwa Anda adalah fondasi utama** untuk meraih segalanya. Saya selalu di sini jika Anda butuh mengobrol lagi. 💚",
                    "Terima kasih kembali! Saya bangga dengan Anda yang mau berbagi perasaan — itu sudah langkah besar. Jangan ragu untuk kembali kapan pun. Anda tidak sendirian. 🌱",
                    "Sip, senang bisa membantu! Ingat, tidak ada cerita yang terlalu kecil atau terlalu besar untuk dibagikan. Pintu ini selalu terbuka untuk Anda. Take care! 💪",
                    "Terima kasih juga sudah mau berbagi! Semoga tips tadi bisa membantu. Jika butuh seseorang untuk diajak mengobrol lagi, saya ada di sini 24/7. Stay strong! 🌟",
                ],
            ],
        ];
    }

    /**
     * Sistem pencocokan cerdas dengan variasi respons.
     */
    private function generateBotResponse($message, $latestDiagnosis)
    {
        $msg = strtolower($message);
        $response = "";
        $matched = false;

        $responseBank = $this->getResponseBank();

        // Cek setiap kategori
        foreach ($responseBank as $category) {
            if ($this->hasKeywords($msg, $category['keywords'])) {
                // Pilih respons secara acak dari variasi yang tersedia
                $response = $category['responses'][array_rand($category['responses'])];
                $matched = true;
                break;
            }
        }

        // Default fallback jika tidak ada keyword yang cocok
        if (!$matched) {
            $defaults = [
                "Saya mendengar Anda, dan cerita Anda penting. Menghadapi dunia perkuliahan memang penuh tantangan emosional dan fisik.\n\nBisa ceritakan lebih detail tentang situasi spesifik yang sedang Anda hadapi? Dengan begitu, saya bisa memberikan saran yang lebih tepat dan personal untuk Anda.",
                "Terima kasih sudah mau berbagi. Setiap perasaan yang Anda rasakan itu valid dan layak untuk didengarkan.\n\nJika Anda membutuhkan saran spesifik, coba ceritakan tentang:\n* Apa yang membuat Anda stres saat ini?\n* Bagaimana pola tidur dan makan Anda?\n* Apakah ada deadline atau ujian yang mendekat?\n\nSaya akan berusaha memberikan saran terbaik yang saya bisa.",
                "Saya sangat menghargai kepercayaan Anda untuk bercerita. Setiap orang punya cara berbeda dalam menghadapi tekanan akademik.\n\nAnda bisa bertanya tentang tips belajar, cara mengelola stres, strategi menghadapi ujian, atau sekadar curhat tentang apa pun yang mengganjal. Saya di sini untuk Anda.",
                "Hmm, saya ingin memahami situasi Anda lebih dalam. Bisa Anda ceritakan:\n* Apa yang sedang terjadi dalam kehidupan akademik Anda?\n* Perasaan apa yang paling dominan belakangan ini?\n* Adakah sesuatu yang ingin Anda ubah?\n\nSetiap jawaban Anda membantu saya memberikan respons yang lebih bermakna.",
            ];
            $response = $defaults[array_rand($defaults)];
        }

        // Tambahkan catatan kontekstual berdasarkan level burnout terakhir
        if ($latestDiagnosis && $latestDiagnosis->burnoutLevel) {
            $levelCode = $latestDiagnosis->burnoutLevel->code;
            if ($levelCode === 'B005') {
                $notes = [
                    "\n\n> ⚠️ **Catatan Penting Serenity:** Hasil diagnosis terakhir Anda menunjukkan **Burnout Sangat Berat**. Saya sangat mendorong Anda untuk segera menjadwalkan konseling tatap muka dengan psikolog profesional. Kesehatan Anda adalah prioritas utama.",
                    "\n\n> ⚠️ **Peringatan Serenity:** Mengingat tingkat burnout Anda yang sangat tinggi, mohon pertimbangkan untuk menghubungi layanan konseling kampus atau hotline kesehatan mental (Into The Light: 119 ext 8). Anda tidak harus melewati ini sendirian.",
                ];
                $response .= $notes[array_rand($notes)];
            } elseif ($levelCode === 'B004') {
                $notes = [
                    "\n\n> 💡 **Saran Serenity:** Tingkat burnout Anda tercatat **Berat**. Pertimbangkan untuk mengambil jeda sejenak, mengomunikasikan kesulitan Anda ke dosen wali, dan prioritaskan pemulihan energi Anda.",
                    "\n\n> 💡 **Rekomendasi Serenity:** Dengan tingkat burnout **Berat**, sangat penting bagi Anda untuk tidak menambah beban. Coba bicarakan kondisi Anda dengan orang terdekat atau konselor kampus.",
                ];
                $response .= $notes[array_rand($notes)];
            }
        }

        return $response;
    }

    /**
     * Helper pencocokan kata kunci.
     */
    private function hasKeywords($text, array $keywords)
    {
        foreach ($keywords as $keyword) {
            if (str_contains($text, $keyword)) {
                return true;
            }
        }
        return false;
    }
}
