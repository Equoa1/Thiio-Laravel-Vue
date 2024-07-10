<template>
  <v-container>
    
    <v-app-bar app>
      
      <v-spacer></v-spacer>
      <v-btn icon color="green" @click="openAddUserDialog">
        <v-icon>mdi-plus</v-icon>
      </v-btn>
    </v-app-bar>

    <v-row>
      <v-col cols="12" md="4" v-for="user in users" :key="user.id">
        <v-card>
          <v-card-title>{{ user.name }}</v-card-title>
          <v-card-text>
            <p>{{ user.email }}</p>
          </v-card-text>
          <v-card-actions>
            <v-btn color="blue" @click="openEditUserDialog(user)">Edit</v-btn>
            <v-btn color="red" @click="confirmDeleteUser(user)">Delete</v-btn>
            <v-btn color="purple" @click="openChangePasswordDialog(user)">Change Password</v-btn>
          </v-card-actions>
        </v-card>
      </v-col>
    </v-row>

    
    <v-dialog v-model="isAddUserDialogOpen" max-width="500">
      <v-card>
        <v-card-title>
          <span class="headline">Add User</span>
        </v-card-title>
        <v-card-text>
          <v-form @submit.prevent="addUser">
            <v-text-field v-model="newUser.name" label="User Name" required></v-text-field>
            <v-text-field v-model="newUser.email" label="Email" required></v-text-field>
            <v-text-field v-model="newUser.password" label="Password" type="password" required></v-text-field>
            <v-text-field v-model="newUser.password_confirmation" label="Confirm Password" type="password" required></v-text-field>
            <v-card-actions>
              <v-btn color="blue darken-1" text @click="closeAddUserDialog">Cancel</v-btn>
              <v-btn type="submit" :loading="isLoading.addUser" color="blue darken-1" text>Save</v-btn>
            </v-card-actions>
          </v-form>
        </v-card-text>
      </v-card>
    </v-dialog>

    
    <v-dialog v-model="isDeleteUserDialogOpen">
      <v-card>
        <v-card-title>Delete User</v-card-title>
        <v-card-text>
          Are you sure you want to delete "{{ deleteUser.name }}"?
        </v-card-text>
        <v-card-actions>
          <v-btn color="blue darken-1" text @click="closeDeleteUserDialog">Cancel</v-btn>
          <v-btn color="red darken-1" text @click="deleteConfirmedUser" :loading="isLoading.deleteUser">Delete</v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>

    
    <v-dialog v-model="isEditUserDialogOpen" max-width="500">
      <v-card>
        <v-card-title>
          <span class="headline">Edit User</span>
        </v-card-title>
        <v-card-text>
          <v-form @submit.prevent="updateUser">
            <v-text-field v-model="editUser.name" label="User Name" required></v-text-field>
            <v-text-field v-model="editUser.email" label="Email" required></v-text-field>
            <v-card-actions>
              <v-btn color="blue darken-1" text @click="closeEditUserDialog">Cancel</v-btn>
              <v-btn type="submit" :loading="isLoading.updateUser" color="blue darken-1" text>Save</v-btn>
            </v-card-actions>
          </v-form>
        </v-card-text>
      </v-card>
    </v-dialog>

    
    <v-dialog v-model="isChangePasswordDialogOpen" max-width="500">
      <v-card>
        <v-card-title>
          <span class="headline">Change Password</span>
        </v-card-title>
        <v-card-text>
          <v-form @submit.prevent="changeUserPassword">
            <v-text-field v-model="changePassword.user_id" type="hidden"></v-text-field>
            <v-text-field v-model="changePassword.new_password" label="New Password" type="password" required></v-text-field>
            <v-text-field v-model="changePassword.new_password_confirmation" label="Confirm New Password" type="password" required></v-text-field>
            <v-card-actions>
              <v-btn color="blue darken-1" text @click="closeChangePasswordDialog">Cancel</v-btn>
              <v-btn type="submit" :loading="isLoading.changePassword" color="blue darken-1" text>Save</v-btn>
            </v-card-actions>
          </v-form>
        </v-card-text>
      </v-card>
    </v-dialog>
  </v-container>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import axios from 'axios'

const users = ref([])
const isAddUserDialogOpen = ref(false)
const isDeleteUserDialogOpen = ref(false)
const isEditUserDialogOpen = ref(false)
const isChangePasswordDialogOpen = ref(false)
const newUser = ref({
  name: '',
  email: '',
  password: '',
  password_confirmation: ''
})
const editUser = ref({
  id: '',
  name: '',
  email: ''
})
const changePassword = ref({
  user_id: '',
  new_password: '',
  new_password_confirmation: ''
})
const deleteUser = ref({ id: '', name: '' })
const isLoading = ref({
  addUser: false,
  deleteUser: false,
  updateUser: false,
  changePassword: false
})

onMounted(async () => {
  await fetchUsers()
})

const fetchUsers = async () => {
  try {
    const token = localStorage.getItem('access_token')
    const response = await axios.get('http://localhost:8000/api/auth/users', {
      headers: {
        Authorization: `Bearer ${token}`
      }
    })
    users.value = response.data
  } catch (error) {
    console.error('Error fetching users:', error.response.data)
  }
}

const openAddUserDialog = () => {
  isAddUserDialogOpen.value = true
}

const closeAddUserDialog = () => {
  isAddUserDialogOpen.value = false
  newUser.value = { name: '', email: '', password: '', password_confirmation: '' }
}

const addUser = async () => {
  try {
    isLoading.value.addUser = true
    const token = localStorage.getItem('access_token')
    const response = await axios.post('http://localhost:8000/api/auth/users', newUser.value, {
      headers: {
        Authorization: `Bearer ${token}`
      }
    })
    console.log('User added:', response.data)
    closeAddUserDialog()
    await fetchUsers()
  } catch (error) {
    console.error('Error adding user:', error.response.data)
  } finally {
    isLoading.value.addUser = false
  }
}

const openEditUserDialog = (user) => {
  editUser.value = { id: user.id, name: user.name, email: user.email }
  isEditUserDialogOpen.value = true
}

const closeEditUserDialog = () => {
  isEditUserDialogOpen.value = false
}

const updateUser = async () => {
  try {
    isLoading.value.updateUser = true
    const token = localStorage.getItem('access_token')
    const response = await axios.put(`http://localhost:8000/api/auth/users/${editUser.value.id}`, {
      name: editUser.value.name,
      email: editUser.value.email
    }, {
      headers: {
        Authorization: `Bearer ${token}`
      }
    })
    console.log('User updated:', response.data)
    closeEditUserDialog()
    await fetchUsers()
  } catch (error) {
    console.error('Error updating user:', error.response.data)
  } finally {
    isLoading.value.updateUser = false
  }
}

const openChangePasswordDialog = (user) => {
  changePassword.value = { user_id: user.id, new_password: '', new_password_confirmation: '' }
  isChangePasswordDialogOpen.value = true
}

const closeChangePasswordDialog = () => {
  isChangePasswordDialogOpen.value = false
}

const changeUserPassword = async () => {
  try {
    isLoading.value.changePassword = true
    const token = localStorage.getItem('access_token')
    const response = await axios.put(`http://localhost:8000/api/auth/users/${changePassword.value.user_id}/change-password`, {
      new_password: changePassword.value.new_password,
      new_password_confirmation: changePassword.value.new_password_confirmation
    }, {
      headers: {
        Authorization: `Bearer ${token}`
      }
    })
    console.log('Password changed:', response.data)
    closeChangePasswordDialog()
    await fetchUsers()
  } catch (error) {
    console.error('Error changing password:', error.response.data)
  } finally {
    isLoading.value.changePassword = false
  }
}

const confirmDeleteUser = (user) => {
  deleteUser.value = { id: user.id, name: user.name }
  isDeleteUserDialogOpen.value = true
}

const closeDeleteUserDialog = () => {
  isDeleteUserDialogOpen.value = false
}

const deleteConfirmedUser = async () => {
  try {
    isLoading.value.deleteUser = true
    const token = localStorage.getItem('access_token')
    const response = await axios.delete(`http://localhost:8000/api/auth/users/${deleteUser.value.id}`, {
      headers: {
        Authorization: `Bearer ${token}`
      }
    })
    console.log('User deleted:', response.data)
    closeDeleteUserDialog()
    await fetchUsers()
  } catch (error) {
    console.error('Error deleting user:', error.response.data)
  } finally {
    isLoading.value.deleteUser = false
  }
}

</script>

<style scoped>

</style>
