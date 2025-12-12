<template>
    <section class="bg-secondary">
        
        <main>
            
        </main>
    </section>
</template>

<script setup>
import { ref } from 'vue'
import { store, logout } from '../stores/stores'
import { useRouter } from 'vue-router'
import img1 from '../assets/img/iklan.png'
import img2 from '../assets/img/iklan2.png'
import img3 from '../assets/img/iklan3.png'
import Footer from '@/components/Footer.vue'
import Navbar from '@/components/Navbar.vue'

const openNavbar = ref(false)
const slides = [
  img1,
  img2,
  img3
]

const currentIndex = ref(0)

function next() {
  currentIndex.value = (currentIndex.value + 1) % slides.length
}

function prev() {
  currentIndex.value = (currentIndex.value - 1 + slides.length) % slides.length
}

const router = useRouter()
const logoutUser = () => {
  logout(router)
}
</script>