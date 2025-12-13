<script setup>
import { AdjustmentsHorizontalIcon, CheckIcon, XMarkIcon } from '@heroicons/vue/24/solid';
import { ref, onMounted } from 'vue';
import axios from 'axios'

const total_permintaan = ref(0)
const getDarah = async () => {
    try {
        const res = await axios.get('http://localhost/ProjectLomba/backend/dashboard_total_darah.php')
        total_permintaan.value = res.data?.data?.total_permintaan || 0
    } catch(err) {
        console.error(err)
    }
}

const total_terpenuhi = ref(0)
const getTerpenuhi = async () => {
    try {
        const res = await axios.get('http://localhost/ProjectLomba/backend/dashboard_total_terpenuhi.php')
        total_terpenuhi.value = res.data?.data?.total_terpenuhi || 0
    } catch(err) {
        console.error(err)
    }
}

const total_batal = ref(0)
const getBatal = async () => {
    try {
        const res = await axios.get('http://localhost/ProjectLomba/backend/dashboard_total_batal.php')
        total_batal.value = res.data?.data?.total_batal || 0
    } catch(err) {
        console.error(err)
    }
}

onMounted(()=>{
    getDarah()
    getTerpenuhi()
    getBatal()
})
</script>

<template>
    <section class="bg-white p-6 min-h-screen">
        <h1 class="text-2xl font-semibold">Dashboard</h1>

        <div class="grid grid-rows-3 md:grid-cols-3 gap-10 mt-5">
            <div class="flex items-center gap-8 bg-secondary rounded-2xl p-8 shadow-md">
                <div class="flex items-center justify-center rounded w-12 h-12 bg-green-50">
                    <AdjustmentsHorizontalIcon class="size-9 text-green-500"/>
                </div>
                <div class="flex flex-col">
                    <p>Permintaan Darah</p>
                    <h1 class="text-3xl">{{ total_permintaan }}</h1>
                </div>
            </div>
            <div class="flex items-center gap-8 bg-secondary rounded-2xl p-8 shadow-md">
                <div class="flex items-center justify-center rounded w-12 h-12 bg-cyan-50">
                    <CheckIcon class="size-9 text-cyan-500"/>
                </div>
                <div class="flex flex-col">
                    <p>Total Terpenuhi</p>
                    <h1 class="text-3xl">{{ total_terpenuhi }}</h1>
                </div>
            </div>
            <div class="flex items-center gap-8 bg-secondary rounded-2xl p-8 shadow-md">
                <div class="flex items-center justify-center rounded w-12 h-12 bg-red-50">
                    <XMarkIcon class="size-9 text-red-500"/>
                </div>
                <div class="flex flex-col">
                    <p>Total Batal</p>
                    <h1 class="text-3xl">{{ total_batal }}</h1>
                </div>
            </div>
        </div>
    </section>
</template>