require('./bootstrap');

import { createApp } from 'vue';
import ProfilePage from './components/ProfilePage.vue';

createApp({}).component('profile-page', ProfilePage).mount('#app');
