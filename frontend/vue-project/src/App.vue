<template>
  <router-view></router-view>
</template>

import axios from 'axios'
import { store } from './stores/stores'

axios.defaults.withCredentials = true

const checkSession = async () => {
  try {
    const res = await axios.get('http://localhost/ProjectLomba/backend/services/check_session.php')
    if(res.data.status === 'success'){
      store.isLoggedIn = true
      store.user = res.data.user
    } else {
      store.isLoggedIn = false
      store.user = null
    }
  } catch (err) {
    console.error('Gagal cek session', err)
  }
}

// jalankan saat app load
checkSession()