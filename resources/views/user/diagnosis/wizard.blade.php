@extends('layouts.user')
@section('title', 'Kuesioner Diagnosis Burnout')

@section('content')
<style>
    .progress-track-panel {
        background: rgba(255, 255, 255, 0.03);
        border: var(--border-glass);
        border-radius: 12px;
        padding: 16px;
        margin-bottom: 32px;
    }
    [data-theme="light"] .progress-track-panel {
        background: rgba(0, 0, 0, 0.02);
    }
</style>

<div class="neo-card wizard-container animated-card" style="max-width: 800px; margin: 0 auto; padding: 36px;">
    
    <!-- Title Section -->
    <div style="text-align: center; margin-bottom: 36px;">
        <h2 style="font-size: 24px; font-weight: 800; color: var(--text-dark); margin-bottom: 8px; letter-spacing: -0.5px;">Diagnosis Tingkat Burnout</h2>
        <p style="font-size: 13px; color: var(--text-secondary); line-height: 1.5; max-width: 500px; margin: 0 auto;">
            Isi penilaian mandiri ini secara jujur untuk memetakan tingkat kelelahan akademik Anda secara ilmiah.
        </p>
    </div>

    <!-- Wizard Form -->
    <form id="wizard-form" action="{{ route('diagnosis.calculate') }}" method="POST">
        @csrf
        
        <!-- Progress Tracking Panel -->
        <div class="progress-track-panel">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 12px; flex-wrap: wrap; gap: 8px;">
                <span id="step-counter" style="font-size: 12px; font-weight: 800; color: var(--accent); text-transform: uppercase; letter-spacing: 0.5px;">
                    Pertanyaan 1 dari {{ count($symptoms) }}
                </span>
                <span id="encouragement-tag" style="font-size: 12px; font-weight: 600; color: var(--color-normal); transition: all 0.3s ease;">
                    Mulai dengan jujur pada dirimu sendiri 🌿
                </span>
            </div>
            <div class="progress-container" style="margin-bottom: 0;">
                <div class="progress-bar-fill" id="progress-bar" style="width: 0%;"></div>
            </div>
        </div>
        
        <!-- Questions Loop Container -->
        <div style="position: relative; min-height: 250px;">
            @foreach($symptoms as $index => $symptom)
            <div class="question-step animated-card" data-step="{{ $index }}" style="{{ $index === 0 ? '' : 'display: none;' }}">


                <h3 style="font-size: 18px; color: var(--text-dark); margin-bottom: 28px; font-weight: 700; line-height: 1.6; letter-spacing: -0.3px;">
                    {{ $symptom->question }}
                </h3>
                
                <!-- Option Radio Grid -->
                <div class="row g-3">
                    @php
                        $options = [
                            ['label' => 'Hampir Selalu', 'value' => 1.0, 'emoji' => '😰'],
                            ['label' => 'Sering', 'value' => 0.8, 'emoji' => '😟'],
                            ['label' => 'Kadang-kadang', 'value' => 0.6, 'emoji' => '🤔'],
                            ['label' => 'Jarang', 'value' => 0.4, 'emoji' => '😐'],
                            ['label' => 'Hampir Tidak', 'value' => 0.2, 'emoji' => '🙂'],
                            ['label' => 'Tidak Pernah', 'value' => 0.0, 'emoji' => '😊'],
                        ];
                    @endphp

                    @foreach($options as $opt)
                    <div class="col-6 col-md-4">
                        <label class="option-card" style="display: flex; flex-direction: column; align-items: center; justify-content: center; position: relative; padding: 14px 10px; text-align: center; cursor: pointer; height: 100%; min-height: 75px; gap: 6px;">
                            <input type="radio" name="symptoms[{{ $symptom->id }}]" value="{{ $opt['value'] }}" style="position: absolute; opacity: 0; cursor: pointer; height: 0; width: 0;">
                            <span style="font-size: 18px; line-height: 1;">{{ $opt['emoji'] }}</span>
                            <div style="font-weight: 600; font-size: 12px; color: var(--text-secondary); transition: all 0.3s; line-height: 1.2;">
                                {{ $opt['label'] }}
                            </div>
                        </label>
                    </div>
                    @endforeach
                </div>
            </div>
            @endforeach
        </div>

        <!-- Consent Option (Only visible on last step to keep user interface clean) -->
        <div id="consent-panel" style="display: none; margin-top: 32px; padding: 20px; border-radius: var(--radius-md, 12px); background: rgba(20, 184, 166, 0.04); border: 1px solid rgba(20, 184, 166, 0.15); animation: fadeInUp 0.4s ease;">
            <div style="display: flex; align-items: flex-start; gap: 12px; cursor: pointer;">
                <input type="checkbox" name="is_shared" id="is_shared" value="1" style="width: 20px; height: 20px; border-radius: 6px; border: 2px solid var(--accent); cursor: pointer; flex-shrink: 0; margin-top: 2px;">
                <label for="is_shared" style="font-size: 13px; font-weight: 600; color: var(--text-dark); cursor: pointer; line-height: 1.5; user-select: none;">
                    <span style="display: block; font-size: 14px; font-weight: 700; margin-bottom: 4px; color: var(--accent);">Bagikan hasil diagnosis ini dengan Unit Konseling Kampus</span>
                    Dengan mencentang opsi ini, Anda menyetujui hasil kuesioner Anda dipantau secara aman oleh konselor kampus untuk keperluan pemberian bantuan akademik atau dukungan kesehatan mental jika diperlukan. Jika dibiarkan kosong, hasil tes Anda bersifat **100% privat** hanya untuk Anda sendiri.
                </label>
            </div>
        </div>

        <!-- Navigation Buttons -->
        <div class="wizard-footer" style="display: flex; justify-content: space-between; margin-top: 48px; padding-bottom: 12px;">
            <button type="button" id="prev-btn" class="btn-neo-secondary" style="display: none; padding: 12px 28px;">
                <i class="ph-bold ph-arrow-left"></i> Sebelumnya
            </button>
            <div style="margin-left: auto;">
                <button type="button" id="next-btn" class="btn-neo" style="padding: 12px 32px;">
                    Selanjutnya <i class="ph-bold ph-arrow-right"></i>
                </button>
                <button type="submit" id="submit-btn" class="btn-neo" style="display: none; padding: 12px 36px; background: linear-gradient(135deg, #10b981, #059669); box-shadow: 0 4px 15px rgba(16, 185, 129, 0.3);">
                    Lihat Hasil Diagnosis <i class="ph-bold ph-check-circle" style="font-size: 18px;"></i>
                </button>
            </div>
        </div>
    </form>
</div>

<!-- Scripts for Step-by-Step Questionnaire Wizard -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const steps = document.querySelectorAll('.question-step');
        const totalSteps = steps.length;
        let currentStep = 0;
        
        const prevBtn = document.getElementById('prev-btn');
        const nextBtn = document.getElementById('next-btn');
        const submitBtn = document.getElementById('submit-btn');
        const progressBar = document.getElementById('progress-bar');
        const stepCounter = document.getElementById('step-counter');
        const encouragementTag = document.getElementById('encouragement-tag');
        
        // Positive check milestones encouragement text
        const encouragements = {
            2: "Hebat! Kamu meluangkan waktu untuk memetakan beban mentalmu. ✨",
            5: "Langkah bagus! Teruskan menjawab secara apa adanya. 🌿",
            8: "Sedikit lagi selesai! Tarik napas dalam-dalam, tenangkan pikiran. 🍃",
            10: "Hampir sampai! Jawabanmu membantu sistem memberikan rekomendasi akurat. 💚"
        };
        
        function updateWizard() {
            // Safety: clamp currentStep to valid bounds
            if (currentStep < 0) currentStep = 0;
            if (currentStep >= totalSteps) currentStep = totalSteps - 1;
            
            // Show current question, hide others
            steps.forEach((step, idx) => {
                if (idx === currentStep) {
                    step.style.display = 'block';
                    step.classList.remove('fadeInUp');
                    void step.offsetWidth; // trigger reflow
                    step.classList.add('fadeInUp');
                } else {
                    step.style.display = 'none';
                }
            });
            
            // Update counter text
            stepCounter.textContent = `Pertanyaan ${currentStep + 1} dari ${totalSteps}`;
            
            // Update progress bar width
            const percent = ((currentStep + 1) / totalSteps) * 100;
            progressBar.style.width = `${percent}%`;
            
            // Update milestone encouragement tag
            if (encouragements[currentStep]) {
                encouragementTag.textContent = encouragements[currentStep];
                encouragementTag.style.opacity = 1;
            } else if (currentStep === 0) {
                encouragementTag.textContent = "Mulai dengan jujur pada dirimu sendiri 🌿";
            } else if (currentStep === totalSteps - 1) {
                encouragementTag.textContent = "Pertanyaan terakhir! Ayo lihat hasil analisisnya. 🎯";
            } else {
                // Keep the current text but fade slightly
                encouragementTag.style.opacity = 0.8;
            }
            
            // Update navigation buttons visibility
            if (currentStep === 0) {
                prevBtn.style.display = 'none';
            } else {
                prevBtn.style.display = 'inline-flex';
            }
            
            if (currentStep === totalSteps - 1) {
                nextBtn.style.display = 'none';
                submitBtn.style.display = 'inline-flex';
                document.getElementById('consent-panel').style.display = 'block';
            } else {
                nextBtn.style.display = 'inline-flex';
                submitBtn.style.display = 'none';
                document.getElementById('consent-panel').style.display = 'none';
            }
        }
        
        function validateCurrentStep() {
            if (!steps[currentStep]) return false;
            const currentStepEl = steps[currentStep];
            const checkedRadio = currentStepEl.querySelector('input[type="radio"]:checked');
            return checkedRadio !== null;
        }
        
        nextBtn.addEventListener('click', function() {
            if (validateCurrentStep()) {
                if (currentStep < totalSteps - 1) {
                    currentStep++;
                    updateWizard();
                }
            } else {
                // Custom visually pleasing warning instead of basic alert
                alert('Pilih salah satu opsi frekuensi terlebih dahulu sebelum melanjutkan!');
            }
        });
        
        prevBtn.addEventListener('click', function() {
            if (currentStep > 0) {
                currentStep--;
                updateWizard();
            }
        });
        
        // Auto transition after selecting option to improve UX speed
        let autoAdvanceTimer = null;
        steps.forEach((step, idx) => {
            const labels = step.querySelectorAll('.option-card');
            labels.forEach(label => {
                label.addEventListener('click', function() {
                    // Visual feedback class
                    labels.forEach(l => l.classList.remove('selected'));
                    label.classList.add('selected');
                    
                    const radio = label.querySelector('input[type="radio"]');
                    radio.checked = true;
                    
                    // Clear any pending auto-advance to prevent double increments
                    if (autoAdvanceTimer) {
                        clearTimeout(autoAdvanceTimer);
                        autoAdvanceTimer = null;
                    }
                    
                    // Auto-advance to next question (but NOT on the last question so submit button remains clickable)
                    if (currentStep < totalSteps - 1) {
                        autoAdvanceTimer = setTimeout(() => {
                            // Double-check bounds at execution time (prevents race condition with Next button)
                            if (currentStep < totalSteps - 1) {
                                currentStep++;
                                updateWizard();
                            }
                            autoAdvanceTimer = null;
                        }, 350);
                    }
                });
            });
        });
        
        // Form submission validation for the last step
        const form = document.getElementById('wizard-form');
        form.addEventListener('submit', function(e) {
            if (!validateCurrentStep()) {
                e.preventDefault();
                alert('Pilih salah satu opsi frekuensi terlebih dahulu sebelum melihat hasil!');
            }
        });
        
        // Set initial state
        updateWizard();
    });
</script>
@endsection
