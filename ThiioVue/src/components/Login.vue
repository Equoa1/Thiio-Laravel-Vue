<template>
  <v-container class="fill-height">
    <v-responsive class="align-center fill-height mx-auto" max-width="400">
      <v-img class="mb-4" height="150" src="@/assets/logo.png" />

      <v-card class="pa-4" elevation="2">
        <v-card-title class="text-h5">Login</v-card-title>

        <v-card-text>
          <v-form @submit.prevent="login">
            <v-text-field
              v-model="email"
              label="Email"
              type="email"
              required
              :rules="[rules.required, rules.email]"
            />

            <v-text-field
              v-model="password"
              label="Password"
              type="password"
              required
              :rules="[rules.required]"
              :error-messages="passwordError"
            />

            
            <v-overlay :value="isLoading">
              <v-progress-circular indeterminate color="primary"></v-progress-circular>
            </v-overlay>

            <v-btn
              class="mt-4 mr-2"
              color="blue"
              type="submit"
              block
            >
              Login
            </v-btn>

            <v-btn
              class="mt-4"
              color="green"
              @click="goToRegister"
              block
            >
              Register
            </v-btn>
          </v-form>
        </v-card-text>
      </v-card>
    </v-responsive>
  </v-container>
</template>

<script setup>
import { ref, computed } from 'vue'
import { useRouter } from 'vue-router'
import axios from 'axios'

const email = ref('')
const password = ref('')
const router = useRouter()

const rules = {
  required: value => !!value || 'Required.',
  email: value => /.+@.+\..+/.test(value) || 'E-mail must be valid.',
}

const loginError = ref(null)
const isLoading = ref(false) 

const login = async () => {
  isLoading.value = true; 

  try {
    const response = await axios.post('http://localhost:8000/api/auth/login', { email: email.value, password: password.value });
    
    localStorage.setItem('access_token', response.data.access_token); 
    router.push('/dashboard');
  } catch (error) {
    console.error('Login failed:', error.response.data);
    if (error.response.status === 401) {
      loginError.value = 'Invalid email or password.';
    } else {
      loginError.value = 'Login failed. Please try again later.';
    }
  } finally {
    isLoading.value = false; 
  }
}

const goToRegister = () => {
  router.push('/register')
}

const passwordError = computed(() => {
  return loginError.value;
});

</script>

<style scoped>
.fill-height {
  display: flex;
  justify-content: center;
  align-items: center;
}
</style>
