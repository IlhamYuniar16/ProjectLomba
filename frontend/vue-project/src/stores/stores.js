import { reactive } from 'vue'

export const store = reactive({
  isLoggedIn: false,
  user: null
})

// Load user dari localStorage saat app mulai
const savedUser = localStorage.getItem('user')
if (savedUser) {
  store.isLoggedIn = true
  store.user = JSON.parse(savedUser)
}

// Fungsi logout
export const logout = (router) => {
  store.isLoggedIn = false
  store.user = null
  localStorage.removeItem('user')
  router.push('/masuk')
}