<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use App\Models\SymptomCategory;
use App\Models\Symptom;
use App\Models\BurnoutLevel;

class KnowledgeBaseSeeder extends Seeder {
    public function run(): void {
        $cat1 = SymptomCategory::create(['name' => 'Exhaustion', 'description' => 'Kelelahan Fisik/Mental']);
        $cat2 = SymptomCategory::create(['name' => 'Cynicism', 'description' => 'Sinisme/Kehilangan Minat']);
        $cat3 = SymptomCategory::create(['name' => 'Inefficacy', 'description' => 'Rasa Tidak Kompeten']);

        $symptoms = [
            ['cat' => $cat3, 'code' => 'G001', 'name' => 'Sulit Konsentrasi', 'question' => 'Seberapa sering Anda kesulitan berkonsentrasi pada materi atau tugas?', 'mb' => 0.6, 'md' => 0.1],
            ['cat' => $cat2, 'code' => 'G002', 'name' => 'Malas Tugas', 'question' => 'Seberapa sering Anda menunda dan bermalas-malasan mengerjakan tugas akademik?', 'mb' => 0.7, 'md' => 0.1],
            ['cat' => $cat3, 'code' => 'G003', 'name' => 'Mudah Lupa', 'question' => 'Seberapa sering Anda mudah lupa dengan materi pelajaran atau instruksi?', 'mb' => 0.5, 'md' => 0.2],
            ['cat' => $cat1, 'code' => 'G004', 'name' => 'Overthinking', 'question' => 'Seberapa sering Anda overthinking terhadap beban tugas perkuliahan?', 'mb' => 0.7, 'md' => 0.1],
            ['cat' => $cat1, 'code' => 'G005', 'name' => 'Kosong & Habis Energi', 'question' => 'Seberapa sering Anda merasa kosong dan kehabisan energi secara emosional?', 'mb' => 0.9, 'md' => 0.1],
            ['cat' => $cat2, 'code' => 'G006', 'name' => 'Frustasi/Marah', 'question' => 'Seberapa sering Anda mudah frustasi, tersinggung, atau marah karena hal kecil?', 'mb' => 0.8, 'md' => 0.1],
            ['cat' => $cat1, 'code' => 'G007', 'name' => 'Putus Asa', 'question' => 'Seberapa sering Anda merasa putus asa dan tertekan?', 'mb' => 0.9, 'md' => 0.0],
            ['cat' => $cat2, 'code' => 'G008', 'name' => 'Apatis', 'question' => 'Seberapa sering Anda merasa apatis (tidak peduli) terhadap lingkungan kampus?', 'mb' => 0.9, 'md' => 0.1],
            ['cat' => $cat1, 'code' => 'G009', 'name' => 'Gejala Fisik', 'question' => 'Seberapa sering Anda mengalami gejala fisik (insomnia, sakit kepala, dsb) akibat beban kuliah?', 'mb' => 0.8, 'md' => 0.1],
            ['cat' => $cat3, 'code' => 'G010', 'name' => 'Merasa Stagnan', 'question' => 'Seberapa sering Anda merasa kegiatan belajar tidak memberikan kemajuan yang berarti?', 'mb' => 0.7, 'md' => 0.1],
            ['cat' => $cat3, 'code' => 'G011', 'name' => 'Hasil Tidak Maksimal', 'question' => 'Seberapa sering Anda merasa hasil akademik tidak maksimal meski sudah berusaha keras?', 'mb' => 0.6, 'md' => 0.1],
            ['cat' => $cat3, 'code' => 'G012', 'name' => 'Hilang Percaya Diri', 'question' => 'Seberapa sering Anda kehilangan rasa percaya diri terhadap kemampuan lulus Anda?', 'mb' => 0.8, 'md' => 0.1],
        ];

        foreach($symptoms as $s) {
            Symptom::create([
                'category_id' => $s['cat']->id,
                'code' => $s['code'],
                'name' => $s['name'],
                'question' => $s['question'],
                'mb' => $s['mb'],
                'md' => $s['md'],
                'cf_expert' => $s['mb'] - $s['md'],
                'is_active' => true,
            ]);
        }

        BurnoutLevel::create(['code' => 'B001', 'name' => 'Normal', 'description' => 'Tidak ada indikasi burnout', 'min_cf' => 0.00, 'max_cf' => 0.20]);
        BurnoutLevel::create(['code' => 'B002', 'name' => 'Burnout Ringan', 'description' => 'Beberapa gejala ringan, mulai ada kelelahan', 'min_cf' => 0.21, 'max_cf' => 0.40]);
        BurnoutLevel::create(['code' => 'B003', 'name' => 'Burnout Sedang', 'description' => 'Gejala signifikan, produktivitas mulai terganggu', 'min_cf' => 0.41, 'max_cf' => 0.60]);
        BurnoutLevel::create(['code' => 'B004', 'name' => 'Burnout Berat', 'description' => 'Frustasi tinggi, butuh dukungan sosial/keluarga', 'min_cf' => 0.61, 'max_cf' => 0.80]);
        BurnoutLevel::create(['code' => 'B005', 'name' => 'Burnout Sangat Berat', 'description' => 'Kritis, berpotensi depresi, sangat disarankan ke ahli', 'min_cf' => 0.81, 'max_cf' => 1.00]);
    }
}
