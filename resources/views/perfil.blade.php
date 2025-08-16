@extends('layouts.perfil')

@section('content')
<div class="profile-header">
    <a href="{{ route('dashboard') }}">
        <img src="{{ asset('images/Qualityplus.png') }}" alt="QualityPlus Logo" class="profile-logo">
    </a>
    <img src="{{ $user->profile_image ? asset('storage/' . $user->profile_image) . '?t=' . uniqid() : asset('images/Perfil.png') }}" 
     alt="Mini Perfil" 
     class="header-profile-image"   
     id="header-profile-image">
</div>
<div class="profile-container">
    <div class="profile-card">
        <div class="profile-image">
        <img src="{{ $user->profile_image ? asset('storage/' . $user->profile_image) . '?t=' . uniqid() : asset('images/Perfil.png') }}" 
     alt="Imagem do Perfil" 
     id="profile-image">
        </div>

        <div class="profile-info">
            <h2>{{ $user->name }}</h2>
            <span class="role-tag {{ $user->role === 'gerente' ? 'manager' : 'client' }}" 
                  id="role-tag" 
                  {{ $user->role === 'cliente' ? 'onclick=showUpgradeModal()' : '' }} 
                  style="{{ $user->role === 'cliente' ? 'cursor: pointer;' : '' }}">
                {{ $user->role === 'gerente' ? 'Gerente' : 'Cliente' }}
            </span>
        </div>

        @if($user->role === 'gerente')
        <div class="form-group">
                <a href="{{ route('empresa.create') }}" class="create-company-button" id="create-company-button">
                    Criar Empresa
                </a>
            </div>
        @endif

        <img src="{{ asset('images/Edit.png') }}" alt="Editar" id="edit-button" class="edit-icon">

        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="logout-button">Sair da Conta</button>
        </form>
    </div>

    <div class="bio-card">
        <form id="profile-form" class="edit-form" method="POST" action="{{ route('perfil.update') }}" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <h3>Nome</h3>
                <span class="display-field" id="display-name">{{ $user->name }}</span>
                <input type="text" name="name" class="edit-field hidden" value="{{ $user->name }}" required>
            </div>

            <div class="form-group">
                <h3>Perfil</h3>
                <div class="profile-details">
                    <div class="detail-item">
                        <label>Email</label>
                        <span class="display-field" id="display-main-email">{{ $user->email }}</span>
                        <div class="edit-field hidden email-warning">
                            <input type="email" name="email" value="{{ $user->email }}" disabled>
                            <small class="warning-text">⚠️ Alterar o email principal pode afetar seu acesso à conta e histórico de dados</small>
                        </div>
                    </div>

                    <div class="detail-item">
                        <label>Data de Nascimento</label>
                        <span class="display-field" id="display-birth-date">
                            {{ $user->birth_date ?? 'Data não informada' }}
                        </span>
                        <input type="text" name="birth_date" class="edit-field hidden birth-date-input" 
                               value="{{ $user->birth_date }}"
                               placeholder="DD/MM/AAAA"
                               maxlength="10" required>
                    </div>
                    
                    <div class="detail-item">
                        <label>Email de Contato</label>
                        <span class="display-field" id="display-email">
                            {{ $user->contact_email ?? 'Email não informado' }}
                        </span>
                        <input type="email" name="contact_email" class="edit-field hidden" 
                               value="{{ $user->contact_email }}"
                               placeholder="SeuContato@email.com" required>
                    </div>
                    
                    <div class="detail-item">
                        <label>Telefone</label>
                        <span class="display-field" id="display-phone">
                            {{ $user->phone ?? 'Telefone não informado' }}
                        </span>
                        <input type="tel" name="phone" class="edit-field hidden phone-input" 
                               value="{{ $user->phone }}"
                               placeholder="Digite seu telefone" required>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <h3>Sobre</h3>
                <span class="display-field about-text" id="display-about">
                    {{ $user->about ?? 'Compartilhe um pouco sobre você...' }}
                </span>
                <textarea name="about" class="edit-field hidden about-textarea">{{ $user->about }}</textarea>
            </div>

            <div class="form-group photo-upload hidden">
                <h3>Foto de Perfil</h3>
                <input type="file" name="profile_image" class="edit-field" accept="image/*">
            </div>
            <div class="edit-buttons hidden">
                <button type="submit" class="save-button" id="save-button">Salvar</button>
                <button type="button" class="cancel-button" id="cancel-button">Cancelar</button>
            </div>
        </form>
    </div>
</div>

<!-- Modal de Upgrade para Gerente -->
<div id="upgrade-modal" class="modal hidden">
    <div class="modal-content">
        <div class="modal-header">
            <h3>Tornar-se Gerente</h3>
        </div>
        <div class="modal-body">
            <p>Deseja se tornar um Gerente para poder criar e gerenciar empresas?</p>
        </div>
        <div class="modal-footer">
            <button class="btn-secondary" onclick="closeUpgradeModal()">Não</button>
            <button class="btn-primary" onclick="startUpgradeProcess()">Sim</button>
        </div>
    </div>
</div>

<!-- Modal de Perguntas da Empresa -->
<div id="company-questions-modal" class="modal hidden">
    <div class="modal-content large">
        <div class="modal-header">
            <h3>Informações da Empresa</h3>
            <div class="progress-bar">
                <div class="progress-fill" id="progress-fill"></div>
            </div>
            <span class="progress-text" id="progress-text">Pergunta 1 de 6</span>
        </div>
        
        <form id="company-form">
            <!-- Pergunta 1: CNPJ -->
            <div class="question-step active" data-step="1">
                <label>CNPJ da Empresa</label>
                <input type="text" name="cnpj" id="cnpj-input" placeholder="00.000.000/0000-00" maxlength="18" required>
            </div>

            <!-- Pergunta 2: Nome da Empresa -->
            <div class="question-step hidden" data-step="2">
                <label>Nome da Empresa</label>
                <input type="text" name="company_name" placeholder="Digite o nome da sua empresa" required>
            </div>

            <!-- Pergunta 3: Ano de Criação -->
            <div class="question-step hidden" data-step="3">
                <label>Ano que foi criada</label>
                <input type="number" name="foundation_year" placeholder="2020" min="1900" max="2025" required>
            </div>

            <!-- Pergunta 4: Tipo da Empresa -->
            <div class="question-step hidden" data-step="4">
                <label>Tipo da Empresa</label>
                <select name="company_type" required>
                    <option value="">Selecione o tipo</option>
                    <option value="comercio">Comércio</option>
                    <option value="servicos">Serviços</option>
                    <option value="industria">Indústria</option>
                    <option value="tecnologia">Tecnologia</option>
                    <option value="consultoria">Consultoria</option>
                    <option value="outros">Outros</option>
                </select>
            </div>

            <!-- Pergunta 5: Localização -->
            <div class="question-step hidden" data-step="5">
                <label>Localização</label>
                <input type="text" name="cep" placeholder="CEP: 00000-000" maxlength="9" required>
                <textarea name="address_details" placeholder="Informações extras sobre a localização" rows="3"></textarea>
            </div>

            <!-- Pergunta 6: Google Maps -->
            <div class="question-step hidden" data-step="6">
                <label>Link do Google Maps (opcional)</label>
                <input type="url" name="google_maps_link" placeholder="https://maps.app.goo.gl/abcde12345">
                <small>Cole aqui o link compartilhado da sua empresa no Google Maps</small>
            </div>
        </form>

        <div class="modal-footer">
            <button class="btn-secondary" id="prev-btn" onclick="previousStep()" style="display: none;">Anterior</button>
            <button class="btn-secondary" onclick="closeCompanyModal()">Cancelar</button>
            <button class="btn-primary" id="next-btn" onclick="nextStep()">Próximo</button>
            <button class="btn-primary hidden" id="finish-btn" onclick="finishUpgrade()">Finalizar</button>
        </div>
    </div>
</div>

<!-- Modal de Processamento -->
<div id="processing-modal" class="modal hidden">
    <div class="modal-content">
        <div class="modal-body text-center">
            <div class="loading-spinner"></div>
            <p>Sua empresa está sendo validada...</p>
        </div>
    </div>
</div>

@if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif
@endsection

@section('scripts')
<script>
const DDDs = [
    '11', '12', '13', '14', '15', '16', '17', '18', '19',
    '21', '22', '24', '27', '28',
    '31', '32', '33', '34', '35', '37', '38',
    '41', '42', '43', '44', '45', '46', '47', '48', '49',
    '51', '53', '54', '55',
    '61', '62', '63', '64', '65', '66', '67', '68', '69',
    '71', '73', '74', '75', '77', '79',
    '81', '82', '83', '84', '85', '86', '87', '88', '89',
    '91', '92', '93', '94', '95', '96', '97', '98', '99'
];

let currentStep = 1;
const totalSteps = 6;

document.addEventListener('DOMContentLoaded', function() {
    const editButton = document.getElementById('edit-button');
    const form = document.getElementById('profile-form');
    const editButtons = document.querySelector('.edit-buttons');
    const displayFields = document.querySelectorAll('.display-field');
    const editFields = document.querySelectorAll('.edit-field');
    const cancelButton = document.getElementById('cancel-button');
    const phoneInput = document.querySelector('.phone-input');
    const birthDateInput = document.querySelector('.birth-date-input');
    const photoUpload = document.querySelector('.photo-upload');
    const createCompanyButton = document.getElementById('create-company-button');

    function toggleEditMode(isEditing) {
        displayFields.forEach(field => {
            field.classList.toggle('hidden', isEditing);
        });
        
        editFields.forEach(field => {
            field.classList.toggle('hidden', !isEditing);
        });
        
        editButtons.classList.toggle('hidden', !isEditing);
        photoUpload.classList.toggle('hidden', !isEditing);

        if (createCompanyButton) {
            createCompanyButton.classList.toggle('hidden', isEditing);
        }
    }

    editButton.addEventListener('click', () => {
        toggleEditMode(true);
    });

    cancelButton.addEventListener('click', () => {
        location.reload();
    });

    // Sistema de formatação da data de nascimento
    birthDateInput?.addEventListener('input', function(e) {
        let value = this.value.replace(/\D/g, '');
        
        if (value.length >= 2) {
            value = value.substring(0, 2) + '/' + value.substring(2);
        }
        if (value.length >= 5) {
            value = value.substring(0, 5) + '/' + value.substring(5);
        }
        if (value.length > 10) {
            value = value.substring(0, 10);
        }
        
        this.value = value;
    });

    // Sistema inteligente de DDD e telefone
    let previousValue = '';
    phoneInput?.addEventListener('input', function(e) {
        let value = this.value.replace(/\D/g, '');
        
        if (this.value.length < previousValue.length) {
            if (value.length < 2) {
                this.value = value;
            } else {
                const ddd = value.substring(0, 2);
                if (DDDs.includes(ddd)) {
                    let restOfNumber = value.substring(2);
                    if (restOfNumber.length > 5) {
                        restOfNumber = restOfNumber.substring(0, 5) + '-' + restOfNumber.substring(5);
                    }
                    this.value = `(+${ddd}) ${restOfNumber}`;
                } else {
                    this.value = value;
                }
            }
        } else {
            if (value.length >= 2) {
                const ddd = value.substring(0, 2);
                if (DDDs.includes(ddd)) {
                    let restOfNumber = value.substring(2);
                    if (restOfNumber.length > 5) {
                        restOfNumber = restOfNumber.substring(0, 5) + '-' + restOfNumber.substring(5);
                    }
                    this.value = `(+${ddd}) ${restOfNumber}`;
                }
            }
        }
        
        previousValue = this.value;
    });

    // Preview da imagem
    const imageInput = document.querySelector('input[name="profile_image"]');
    const profileImage = document.getElementById('profile-image');
    const headerProfileImage = document.getElementById('header-profile-image');
    
    imageInput?.addEventListener('change', function(e) {
        if (this.files && this.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                profileImage.src = e.target.result;
                headerProfileImage.src = e.target.result;
            };
            reader.readAsDataURL(this.files[0]);
        }
    });

    // Formatação do CNPJ
    const cnpjInput = document.getElementById('cnpj-input');
    cnpjInput?.addEventListener('input', function(e) {
        let value = this.value.replace(/\D/g, '');
        
        if (value.length >= 2) {
            value = value.substring(0, 2) + '.' + value.substring(2);
        }
        if (value.length >= 6) {
            value = value.substring(0, 6) + '.' + value.substring(6);
        }
        if (value.length >= 10) {
            value = value.substring(0, 10) + '/' + value.substring(10);
        }
        if (value.length >= 15) {
            value = value.substring(0, 15) + '-' + value.substring(15);
        }
        if (value.length > 18) {
            value = value.substring(0, 18);
        }
        
        this.value = value;
    });
});

function showUpgradeModal() {
    document.getElementById('upgrade-modal').classList.remove('hidden');
}

function closeUpgradeModal() {
    document.getElementById('upgrade-modal').classList.add('hidden');
}

function startUpgradeProcess() {
    closeUpgradeModal();
    document.getElementById('company-questions-modal').classList.remove('hidden');
    updateProgress();
}

function closeCompanyModal() {
    document.getElementById('company-questions-modal').classList.add('hidden');
    currentStep = 1;
    updateProgress();
}

function updateProgress() {
    const progressFill = document.getElementById('progress-fill');
    const progressText = document.getElementById('progress-text');
    
    const percentage = (currentStep / totalSteps) * 100;
    progressFill.style.width = percentage + '%';
    progressText.textContent = `Pergunta ${currentStep} de ${totalSteps}`;
}

function nextStep() {
    const currentStepElement = document.querySelector(`.question-step[data-step="${currentStep}"]`);
    const inputs = currentStepElement.querySelectorAll('input[required], select[required]');
    
    let isValid = true;
    inputs.forEach(input => {
        if (!input.value.trim()) {
            isValid = false;
            input.style.borderColor = 'red';
        } else {
            input.style.borderColor = '#ddd';
        }
    });
    
    if (!isValid) {
        alert('Por favor, preencha todos os campos obrigatórios.');
        return;
    }
    
    if (currentStep < totalSteps) {
        currentStepElement.classList.add('hidden');
        currentStep++;
        document.querySelector(`.question-step[data-step="${currentStep}"]`).classList.remove('hidden');
        updateProgress();
        
        document.getElementById('prev-btn').style.display = 'inline-block';
        
        if (currentStep === totalSteps) {
            document.getElementById('next-btn').classList.add('hidden');
            document.getElementById('finish-btn').classList.remove('hidden');
        }
    }
}

function previousStep() {
    if (currentStep > 1) {
        document.querySelector(`.question-step[data-step="${currentStep}"]`).classList.add('hidden');
        currentStep--;
        document.querySelector(`.question-step[data-step="${currentStep}"]`).classList.remove('hidden');
        updateProgress();
        
        document.getElementById('next-btn').classList.remove('hidden');
        document.getElementById('finish-btn').classList.add('hidden');
        
        if (currentStep === 1) {
            document.getElementById('prev-btn').style.display = 'none';
        }
    }
}

function finishUpgrade() {
    closeCompanyModal();
    document.getElementById('processing-modal').classList.remove('hidden');
    
    // Simular processamento
    setTimeout(() => {
        fetch('{{ route("perfil.upgrade-role") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                document.getElementById('processing-modal').classList.add('hidden');
                location.reload();
            }
        });
    }, 3000);
}
</script>
@endsection
