<template>
  <div class="mx-auto" style="max-width: 860px;">
    <div class="card mb-3 mx-auto" style="max-width: 900px;">
      <div class="card-header d-flex justify-content-between align-items-center text-center">
        <div class="fw-semibold">User Profile</div>
        <div class="d-flex gap-2">
          <button v-if="!isEditing" class="btn btn-primary btn-sm" @click="enableEditing">EDIT</button>
          <template v-else>
            <button class="btn btn-secondary btn-sm" @click="resetChanges">CANCEL</button>
            <button class="btn btn-success btn-sm" :disabled="isSaving" @click="saveProfileChanges">SAVE</button>
          </template>
        </div>
      </div>
      <div class="card-body">
        <div class="row justify-content-center">
          <div class="col-xl-8 col-lg-10">
            <div class="border-top pt-3 mt-2"></div>
            <div class="d-flex flex-column align-items-center gap-2 mb-3">
              <label v-if="isEditing" class="position-relative rounded-circle bg-light d-flex align-items-center justify-content-center overflow-hidden" style="width:120px; height:120px; cursor:pointer;">
                <img :src="avatarPreviewUrl" alt="avatar" class="w-100 h-100 object-fit-cover" />
                <input type="file" class="d-none" accept="image/*" @change="handleAvatarSelected" />
                <div class="position-absolute bottom-0 start-50 translate-middle-x bg-dark text-white rounded-pill px-2 py-1" style="font-size:12px">Change</div>
              </label>
              <div v-else class="rounded-circle bg-light d-flex align-items-center justify-content-center overflow-hidden" style="width:120px; height:120px;">
                <img :src="avatarPreviewUrl" alt="avatar" class="w-100 h-100 object-fit-cover" />
              </div>
              <div class="text-center">
                <a :href="'mailto:'+profile.email">{{ profile.email }}</a>
                <div class="text-muted small">(Private)</div>
              </div>
            </div>

            <template v-if="isEditing">
              <div class="mb-3">
                <label class="form-label">Name <span class="text-danger small">(required)</span></label>
                <input type="text" class="form-control" v-model="profile.name">
              </div>
              <div class="mb-3">
                <label class="form-label">Job</label>
                <input type="text" class="form-control" v-model="profile.job">
              </div>
              <div class="mb-3">
                <label class="form-label">Company</label>
                <input type="text" class="form-control" v-model="profile.company">
              </div>
            </template>
            <template v-else>
              <dl class="row mb-0">
                <dt class="col-sm-4">Name</dt>
                <dd class="col-sm-8">{{ profile.name || '—' }}</dd>
                <dt class="col-sm-4">Job</dt>
                <dd class="col-sm-8">{{ profile.job || '—' }}</dd>
                <dt class="col-sm-4">Company</dt>
                <dd class="col-sm-8">{{ profile.company || '—' }}</dd>
              </dl>
            </template>
            <div v-if="validationErrors.name" class="text-danger small mt-1">{{ validationErrors.name }}</div>
            <div v-if="validationErrors.email" class="text-danger small mt-1">{{ validationErrors.email }}</div>
          </div>
        </div>
      </div>
    </div>

    <div class="card mb-3 mx-auto" style="max-width: 900px;">
      <div class="card-header fw-semibold text-center">Contact</div>
      <div class="card-body">
        <div class="row justify-content-center">
          <div class="col-xl-8 col-lg-10">
            <template v-if="isEditing">
              <div class="mb-3">
                <label class="form-label">Phone no.</label>
                <div class="d-flex align-items-center gap-2">
                  <input type="text" class="form-control" v-model="profile.phone">
                  <button type="button" class="btn btn-success btn-sm rounded-circle d-flex align-items-center justify-content-center" style="width:32px;height:32px;">+</button>
                </div>
              </div>

              <div class="mb-3">
                <label class="form-label">Mobile no.</label>
                <div class="d-flex align-items-center gap-2">
                  <input type="text" class="form-control" v-model="profile.mobile">
                  <button type="button" class="btn btn-success btn-sm rounded-circle d-flex align-items-center justify-content-center" style="width:32px;height:32px;">+</button>
                </div>
              </div>

              <div class="mb-2">
                <label class="form-label">Email</label>
                <div class="d-flex align-items-center gap-2">
                  <input type="email" class="form-control" v-model="profile.email" placeholder="name@example.com">
                  <button type="button" class="btn btn-success btn-sm rounded-circle d-flex align-items-center justify-content-center" style="width:32px;height:32px;">+</button>
                </div>
              </div>
            </template>
            <template v-else>
              <dl class="row mb-0">
                <dt class="col-sm-4">Phone</dt>
                <dd class="col-sm-8">{{ profile.phone || '—' }}</dd>
                <dt class="col-sm-4">Mobile</dt>
                <dd class="col-sm-8">{{ profile.mobile || '—' }}</dd>
                <dt class="col-sm-4">Email</dt>
                <dd class="col-sm-8">{{ profile.email || '—' }}</dd>
              </dl>
            </template>
          </div>
        </div>
      </div>
    </div>

    <div class="card mb-3 mx-auto" style="max-width: 900px;">
      <div class="card-header fw-semibold text-center">Address</div>
      <div class="card-body">
        <div class="row justify-content-center">
          <div class="col-xl-8 col-lg-10">
            <template v-if="isEditing">
              <div class="mb-2">
                <label class="form-label">Country</label>
                <select class="form-select" v-model="profile.country">
                  <option value="">Select country</option>
                  <option v-for="c in countries" :key="c" :value="c">{{ c }}</option>
                </select>
              </div>
            </template>
            <template v-else>
              <dl class="row mb-0">
                <dt class="col-sm-4">Country</dt>
                <dd class="col-sm-8">{{ profile.country || '—' }}</dd>
              </dl>
            </template>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import axios from 'axios';
import defaultAvatar from '../../assets/images/profile-default.png';

export default {
  name: 'ProfilePage',
  props: {
    fetchUrl: { type: String, required: true },
    saveUrl: { type: String, required: true },
    defaultAvatarUrl: { type: String, default: '' }
  },
  data() {
    return {
      profile: { name: '', email: '', job: '', company: '', phone: '', mobile: '', country: '', avatar_url: '' },
      originalProfile: null,
      isSaving: false,
      isEditing: false,
      validationErrors: {},
      avatarFile: null,
      avatarPreviewUrl: defaultAvatar,
      fallbackAvatar: defaultAvatar,
      countries: ['United States', 'United Kingdom', 'Germany', 'France', 'Russia']
    };
  },
  mounted() {
    this.loadProfile();
  },
  methods: {
    async loadProfile() {
      const { data } = await axios.get(this.fetchUrl);
      this.profile = { ...this.profile, ...data };
      this.originalProfile = JSON.parse(JSON.stringify(this.profile));
      this.avatarPreviewUrl = this.profile.avatar_url || this.defaultAvatarUrl || this.fallbackAvatar || null;
    },
    resetChanges() {
      if (this.originalProfile) this.profile = JSON.parse(JSON.stringify(this.originalProfile));
      this.avatarFile = null;
      this.avatarPreviewUrl = this.profile.avatar_url || this.defaultAvatarUrl || this.fallbackAvatar || null;
      this.isEditing = false;
    },
    async saveProfileChanges() {
      this.isSaving = true; this.validationErrors = {};
      try {
        const form = new FormData();
        for (const [k, v] of Object.entries(this.profile)) form.append(k, v ?? '');
        if (this.avatarFile) form.append('avatar', this.avatarFile);
        await axios.post(this.saveUrl, form, {
          headers: { 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content, 'Content-Type': 'multipart/form-data' }
        });
        
        await this.loadProfile();
        
        this.originalProfile = JSON.parse(JSON.stringify(this.profile));
        this.avatarFile = null;
      } catch (e) {
        if (e.response && e.response.status === 422) {
          this.validationErrors = Object.fromEntries(Object.entries(e.response.data.errors || {}).map(([k, v]) => [k, v[0]]));
        }
      } finally { this.isSaving = false; this.isEditing = false; }
    },
    enableEditing() { this.isEditing = true; },
    handleAvatarSelected(e) {
      const f = e.target.files && e.target.files[0];
      if (!f) return;
      this.avatarFile = f;
      this.avatarPreviewUrl = URL.createObjectURL(f);
    }
  }
};
</script>

<style scoped>
</style>


