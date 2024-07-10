<template>
  <v-container class="fill-height white-background">
    <v-responsive class="align-center fill-height mx-auto" max-width="400">
      <v-img class="mb-4" height="150" src="@/assets/logo.png" />

      <v-card class="pa-4" elevation="2">
        <v-card-title class="text-h5 text-center">Register</v-card-title>

        <v-card-text>
          <v-form @submit.prevent="register">
            <v-text-field
              v-model="name"
              label="Name"
              required
              :rules="[rules.required]"
            />

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
              :rules="[rules.required, rules.minPasswordLength]"
            />

            <v-text-field
              v-model="passwordConfirmation"
              label="Confirm Password"
              type="password"
              required
              :rules="[rules.required, confirmPasswordRule]"
            />

            <v-btn
              class="mt-4 mr-2"
              color="green"
              type="submit"
              block
            >
              Register
            </v-btn>

            
            <router-link to="/login">
              <v-btn class="mt-4" color="blue" block>
                Back to Login
                <template v-slot:append>
                  <v-icon v-if="isLoading">mdi-loading</v-icon>
                </template>
              </v-btn>
            </router-link>
          </v-form>
        </v-card-text>
      </v-card>
    </v-responsive>
  </v-container>
</template>

<script setup>
import { ref } from 'vue'
import { useRouter } from 'vue-router'
import axios from 'axios'

const name = ref('')
const email = ref('')
const password = ref('')
const passwordConfirmation = ref('')
const isLoading = ref(false) 

const router = useRouter()

const rules = {
  required: value => !!value || 'Required.',
  email: value => /.+@.+\..+/.test(value) || 'E-mail must be valid.',
  minPasswordLength: value => value.length >= 8 || 'Password must be at least 8 characters long.',
}

const confirmPasswordRule = value => value === password.value || 'Passwords do not match.'

const register = async () => {
  try {
    isLoading.value = true; 

    const response = await axios.post('http://localhost:8000/api/auth/register', {
      name: name.value,
      email: email.value,
      password: password.value,
      password_confirmation: passwordConfirmation.value
    });

    console.log('Registration successful:', response.data);
    
    setTimeout(() => {
      isLoading.value = false; 
      router.push('/login');
    }, 5000); 

  } catch (error) {
    console.error('Registration failed:', error.response.data);
  }
}
</script>

<style scoped>
.fill-height {
  display: flex;
  justify-content: center;
  align-items: center;
}
</style>
