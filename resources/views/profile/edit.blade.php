@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900">
                <div id="app">
                    <profile-form 
                        :user='@json($user)'
                        :csrf-token='@json(csrf_token())'
                    ></profile-form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://unpkg.com/vue@3/dist/vue.global.js"></script>
<script src="https://unpkg.com/axios/dist/axios.min.js"></script>
<script>
const { createApp, ref } = Vue;

// Простой компонент профиля
const ProfileForm = {
    props: ['user', 'csrfToken'],
    setup(props) {
        const form = ref({
            name: props.user.name || '',
            email: props.user.email || '',
            job: props.user.job || '',
            company: props.user.company || '',
            phone: props.user.phone || '',
            mobile: props.user.mobile || '',
            country: props.user.country || '',
        });

        const isSaving = ref(false);
        const message = ref('');

        // Настройка axios
        axios.defaults.headers.common['X-CSRF-TOKEN'] = props.csrfToken;

        const saveProfile = async () => {
            isSaving.value = true;
            message.value = '';
            
            try {
                const response = await axios.post('/profile/update', form.value);
                
                if (response.data.success) {
                    message.value = 'Профиль обновлен!';
                }
            } catch (error) {
                message.value = 'Ошибка при сохранении';
                console.error('Ошибка:', error);
            } finally {
                isSaving.value = false;
            }
        };

        const cancelEdit = () => {
            form.value = {
                name: props.user.name || '',
                email: props.user.email || '',
                job: props.user.job || '',
                company: props.user.company || '',
                phone: props.user.phone || '',
                mobile: props.user.mobile || '',
                country: props.user.country || '',
            };
            message.value = '';
        };

        return {
            form,
            isSaving,
            message,
            saveProfile,
            cancelEdit
        };
    },
    template: `
        <div class="max-w-2xl mx-auto">
            <!-- Заголовок с кнопками -->
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-xl font-semibold">Профиль пользователя</h2>
                <div class="flex gap-2">
                    <button
                        @click="cancelEdit"
                        class="px-4 py-2 bg-gray-300 text-gray-700 rounded hover:bg-gray-400"
                    >
                        Отмена
                    </button>
                    <button
                        @click="saveProfile"
                        :disabled="isSaving"
                        class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700 disabled:opacity-50"
                    >
                        {{ isSaving ? 'Сохранение...' : 'Сохранить' }}
                    </button>
                </div>
            </div>

            <!-- Аватар -->
            <div class="text-center mb-6">
                <div class="w-20 h-20 bg-gray-300 rounded-full mx-auto mb-2 flex items-center justify-center">
                    <svg class="w-10 h-10 text-gray-600" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" />
                    </svg>
                </div>
                <button class="text-blue-600 text-sm">Изменить фото</button>
            </div>

            <!-- Email (только для чтения) -->
            <div class="bg-gray-100 p-3 rounded mb-6">
                <div class="flex justify-between items-center">
                    <span class="text-gray-700">{{ form.email }}</span>
                    <span class="text-xs text-gray-500">(Приватно)</span>
                </div>
            </div>

            <!-- Основная информация -->
            <div class="space-y-4 mb-6">
                <h3 class="font-medium text-lg">Основная информация</h3>
                
                <div>
                    <label class="block text-sm font-medium mb-1">Имя *</label>
                    <input
                        v-model="form.name"
                        type="text"
                        required
                        class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:border-blue-500"
                    />
                </div>

                <div>
                    <label class="block text-sm font-medium mb-1">Должность</label>
                    <input
                        v-model="form.job"
                        type="text"
                        class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:border-blue-500"
                    />
                </div>

                <div>
                    <label class="block text-sm font-medium mb-1">Компания</label>
                    <input
                        v-model="form.company"
                        type="text"
                        class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:border-blue-500"
                    />
                </div>
            </div>

            <!-- Контакты -->
            <div class="space-y-4 mb-6">
                <h3 class="font-medium text-lg">Контакты</h3>
                
                <div class="flex gap-2">
                    <div class="flex-1">
                        <label class="block text-sm font-medium mb-1">Телефон</label>
                        <input
                            v-model="form.phone"
                            type="tel"
                            class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:border-blue-500"
                        />
                    </div>
                    <button class="mt-6 w-8 h-8 bg-green-600 text-white rounded-full flex items-center justify-center hover:bg-green-700">
                        <span class="text-sm">+</span>
                    </button>
                </div>

                <div class="flex gap-2">
                    <div class="flex-1">
                        <label class="block text-sm font-medium mb-1">Мобильный</label>
                        <input
                            v-model="form.mobile"
                            type="tel"
                            class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:border-blue-500"
                        />
                    </div>
                    <button class="mt-6 w-8 h-8 bg-green-600 text-white rounded-full flex items-center justify-center hover:bg-green-700">
                        <span class="text-sm">+</span>
                    </button>
                </div>

                <div class="flex gap-2">
                    <div class="flex-1">
                        <label class="block text-sm font-medium mb-1">Email</label>
                        <input
                            v-model="form.email"
                            type="email"
                            required
                            class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:border-blue-500"
                        />
                    </div>
                    <button class="mt-6 w-8 h-8 bg-green-600 text-white rounded-full flex items-center justify-center hover:bg-green-700">
                        <span class="text-sm">+</span>
                    </button>
                </div>
            </div>

            <!-- Адрес -->
            <div class="space-y-4 mb-6">
                <h3 class="font-medium text-lg">Адрес</h3>
                
                <div>
                    <label class="block text-sm font-medium mb-1">Страна</label>
                    <select
                        v-model="form.country"
                        class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:border-blue-500"
                    >
                        <option value="">Выберите страну</option>
                        <option value="Россия">Россия</option>
                        <option value="США">США</option>
                        <option value="Германия">Германия</option>
                        <option value="Франция">Франция</option>
                        <option value="Великобритания">Великобритания</option>
                        <option value="Канада">Канада</option>
                        <option value="Китай">Китай</option>
                        <option value="Япония">Япония</option>
                    </select>
                </div>
            </div>

            <!-- Сообщение -->
            <div v-if="message" class="mt-4 p-3 rounded" :class="message.includes('Ошибка') ? 'bg-red-100 text-red-700' : 'bg-green-100 text-green-700'">
                {{ message }}
            </div>
        </div>
    `
};

// Создаем приложение
createApp({
    components: {
        ProfileForm
    }
}).mount('#app');
</script>
@endpush
