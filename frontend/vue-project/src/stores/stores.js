import { reactive } from 'vue'

export const store = reactive({
  isLoggedIn: false,
  user: {},
  permohonan: [],
  donorData: []
})

// Load user dari localStorage saat app mulai
const savedUser = localStorage.getItem('user')
if (savedUser) {
  store.isLoggedIn = true
  store.user = JSON.parse(savedUser)
}


export const logout = (router) => {
  fetch('http://localhost/ProjectLomba/backend/logout.php', { credentials: 'include' })
    .then(() => {
      store.isLoggedIn = false
      store.user = {}
      store.permohonan = []
      store.donorData = []
      localStorage.removeItem('user')
      router.push('/masuk')
    })
}
