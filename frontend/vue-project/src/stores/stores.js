import { reactive } from 'vue'

export const store = reactive({
  isLoggedIn: false,
  user: null, // { id, email, name, role }
})