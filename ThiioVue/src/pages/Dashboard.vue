<template>
    <v-app>
      <v-navigation-drawer app>
        <v-list>
          <v-list-item link @click="showusers">
            <v-list-item-content>
              <IconoList />
            </v-list-item-content>
          </v-list-item>
        </v-list>
      </v-navigation-drawer>
  
      <v-app-bar app>
        <v-spacer></v-spacer>
        <v-list-item link @click="openAccountDialog">
          <v-list-item-content>
            <IconoAccount />
          </v-list-item-content>
        </v-list-item>
        <v-btn @click="logout" color="red">Logout</v-btn>
      </v-app-bar>
  
      <v-main>
        <v-container>
          <Usergrid v-if="Showusers" />
        </v-container>
      </v-main>
  
      <v-dialog v-model="accountDialog" max-width="500">
        <v-card>
          <v-card-title>
            <span class="headline">Account Settings</span>
          </v-card-title>
          <v-card-text>
            <v-form @submit.prevent="updateAccount">
              <v-text-field v-model="username" label="Username" required></v-text-field>
              <v-text-field v-model="email" label="Email" type="email" required></v-text-field>
              <v-text-field v-model="password" label="Password" type="password"></v-text-field>
              <v-text-field v-model="passwordConfirmation" label="Confirm Password" type="password"></v-text-field>
            </v-form>
          </v-card-text>
          <v-card-actions>
            <v-spacer></v-spacer>
            <v-btn color="blue darken-1" text @click="closeAccountDialog">Cancel</v-btn>
            <v-btn color="blue darken-1" text @click="updateAccount">Save</v-btn>
          </v-card-actions>
        </v-card>
      </v-dialog>
    </v-app>
  </template>
  
  <script setup>
  import { ref } from 'vue'
  import axios from 'axios'
  import { useRouter } from 'vue-router'
  import IconoAccount from '@/components/IconoAccount.vue'
  import IconoList from '@/components/IconoList.vue'
  import Usergrid from '../pages/Usergrid.vue';

  
  const router = useRouter()
  
  const accountDialog = ref(false)
  const username = ref('')
  const email = ref('')
  const password = ref('')
  const passwordConfirmation = ref('')
  const Showusers = ref(false) 
  
  const openAccountDialog = async () => {
    accountDialog.value = true
    try {
      const token = localStorage.getItem('access_token');
      const response = await axios.get('http://localhost:8000/api/auth/me', {
        headers: {
          Authorization: `Bearer ${token}`
        }
      })
      const userData = response.data
      username.value = userData.name
      email.value = userData.email
    } catch (error) {
      console.error('Error fetching user data:', error.response.data)
    }
  }
  
  const closeAccountDialog = () => {
    accountDialog.value = false
  }
  
  const updateAccount = async () => {
    try {
      const token = localStorage.getItem('access_token');
      const response = await axios.put('http://localhost:8000/api/auth/update-account', {
        name: username.value,
        email: email.value,
        password: password.value,
        password_confirmation: passwordConfirmation.value,
      }, {
        headers: {
          Authorization: `Bearer ${token}`
        }
      })
      console.log('Account updated:', response.data)
      closeAccountDialog()
    } catch (error) {
      console.error('Error updating account:', error.response.data)
    }
  }
  
  const logout = async () => {
    try {
      const token = localStorage.getItem('access_token');
      await axios.post('http://localhost:8000/api/auth/logout', {}, {
        headers: {
          Authorization: `Bearer ${token}`
        }
      });
      localStorage.removeItem('access_token');
      router.push('/login');
    } catch (error) {
      console.error('Error during logout:', error.response.data);
    }
  }
  
  const showusers = () => {
    Showusers.value = true; 
  }
  </script>
  
  <style scoped>
  
  </style>
  