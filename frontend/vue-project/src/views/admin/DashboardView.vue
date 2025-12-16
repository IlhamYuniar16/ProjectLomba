<script setup>
import { AdjustmentsHorizontalIcon, CheckIcon, XMarkIcon } from '@heroicons/vue/24/solid';
import {ArchiveBoxIcon} from '@heroicons/vue/24/outline';
import { ref, onMounted } from 'vue';
import axios from 'axios'
import { Chart, DoughnutController, ArcElement, Tooltip, Legend } from 'chart.js'
Chart.register(DoughnutController, ArcElement, Tooltip, Legend)

import {
  BarController,
  BarElement,
  CategoryScale,
  LinearScale,

} from 'chart.js'

Chart.register(
  BarController,
  BarElement,
  CategoryScale,
  LinearScale,
  Tooltip,
  Legend
)

// CHART 
const chartCanvas = ref(null)
const chartCanvas1 = ref(null)
const chartCanvas2 = ref(null)

let lokasiChart = null
const renderlokasiChart = () => {
  if (lokasiChart) {
    lokasiChart.destroy()
  }
  lokasiChart = new Chart(chartCanvas2.value, {
    type: 'bar',
    data: {
      labels: ['K.Progo', 'Bantul', 'G.Kidul', 'Sleman', 'Yogyakarta', 'DIYogyakarta'],
      datasets: [
        {
          label: 'Permintaan Darah',
          data: [
            lokasiPasien.value.kulon_progo,
            lokasiPasien.value.bantul,
            lokasiPasien.value.gunung_kidul,
            lokasiPasien.value.sleman,
            lokasiPasien.value.yogyakarta,
            lokasiPasien.value.diyogyakarta
          ],
          backgroundColor: '#3b82f6', 
          borderRadius: 8,
        },
      ],
    },
    options: {
      responsive: true,
      plugins: {
        legend: {
          display: false,
        },
      },
      scales: {
        y: {
          beginAtZero: true,
          grid: {
            color: '#e5e7eb',
          },
        },
        x: {
          grid: {
            display: false,
          },
        },
      },
    },
  })
}

let kelaminChart = null
const renderKelaminChart = () => {
  if (kelaminChart) {
    kelaminChart.destroy()
  }
  kelaminChart = new Chart(chartCanvas.value, {
    type: 'doughnut',
    data: {
      labels: ['Laki-Laki', 'Perempuan'],
      datasets: [
        {
          data: [
            jenisKelamin.value.Lakilaki,
            jenisKelamin.value.Perempuan,
          ],
          backgroundColor: [
            '#3b82f6', 
            '#EC4899',
          ],
          borderWidth: 0,
        },
      ],
    },
    options: {
      responsive: true,
      cutout: '70%', 
      plugins: {
        legend: {
          position: 'bottom',
          labels: {
            usePointStyle: true,
          },
        },
      },
    },
  })
}

let golonganChart = null
const renderGolonganChart = () => {
  if (golonganChart) {
    golonganChart.destroy()
  }

  golonganChart = new Chart(chartCanvas1.value, {
    type: 'doughnut',
    data: {
      labels: ['A', 'B', 'AB', 'O'],
      datasets: [
        {
          data: [
            golonganDarah.value.A,
            golonganDarah.value.B,
            golonganDarah.value.AB,
            golonganDarah.value.O
          ],
          backgroundColor: [
            '#EF4444',
            '#FBBF24',
            '#9333EA',
            '#3B82F6'
          ],
          borderWidth: 0
        }
      ]
    },
    options: {
      responsive: true,
      cutout: '70%',
      plugins: {
        legend: {
          position: 'bottom',
          labels: {
            usePointStyle: true
          }
        }
      }
    }
  })
}


const total_permintaan = ref(0)
const total_terpenuhi = ref(0)
const stok_darah = ref(0)
const total_batal = ref(0)
const lokasiPasien = ref({
  kulon_progo: 0,
  bantul: 0,
  gunung_kidul: 0,
  sleman: 0,
  yogyakarta: 0,
  diyogyakarta: 0
})
const golonganDarah = ref({
  A: 0,
  B: 0,
  AB: 0,
  O: 0
})
const pendonor = ref([])
const permohonan = ref([])
const jenisKelamin = ref({
  Lakilaki: 0,
  Perempuan: 0
})
const getTotal = async () => {
    try {
        const res = await axios.get('http://localhost/ProjectLomba/backend/dashboard_total.php')
        total_permintaan.value = res.data?.data?.total_permintaan || 0
        total_terpenuhi.value = res.data?.data?.total_terpenuhi || 0
        stok_darah.value = res.data?.data?.stok_darah || 0
        total_batal.value = res.data?.data?.total_batal || 0
        lokasiPasien.value = res.data?.data?.lokasi_pasien || {
          kulon_progo: 0,
          bantul: 0,
          gunung_kidul: 0,
          sleman: 0,
          yogyakarta: 0,
          diyogyakarta: 0
        }
        jenisKelamin.value = res.data?.data?.jenis_kelamin || {
          Lakilaki: 0,
          Perempuan: 0
        }
        golonganDarah.value = res.data?.data?.golongan_darah || {
          A: 0,
          B: 0,
          AB: 0,
          O: 0
        }
        pendonor.value = res.data.data.pendonor || []
        permohonan.value = res.data.data.permohonan || []
        renderlokasiChart()
        renderKelaminChart()
        renderGolonganChart()
    } catch(err) {
        console.error(err)
    }
}

onMounted(()=>{
  getTotal()
})
</script>

<template>
    <section class="bg-white p-6 min-h-screen">
        <h1 class="text-2xl font-semibold">Dashboard</h1>
        <main>
            <div class="grid mb-5 grid-cols-1 md:grid-cols-2 lg:grid-cols-4 grid-rows-3 md:grid-rows-1 gap-5 mt-5">
                <div class="flex w-full items-center gap-8 bg-secondary rounded-2xl p-8 shadow-md">
                    <div class="flex items-center justify-center rounded w-10 h-10 bg-green-50">
                        <AdjustmentsHorizontalIcon class="size-9 text-green-500"/>
                    </div>
                    <div class="flex flex-col">
                        <p>Permintaan Darah</p>
                        <h1 class="text-3xl">{{ total_permintaan }}</h1>
                    </div>
                </div>
                <div class="flex items-center gap-8 bg-secondary rounded-2xl p-8 shadow-md">
                    <div class="flex items-center justify-center rounded w-10 h-10 bg-cyan-50">
                        <CheckIcon class="size-9 text-cyan-500"/>
                    </div>
                    <div class="flex flex-col">
                        <p>Total Terpenuhi</p>
                        <h1 class="text-3xl">{{ total_terpenuhi }}</h1>
                    </div>
                </div>
                <div class="flex items-center gap-8 bg-secondary rounded-2xl p-8 shadow-md">
                  <div class="flex items-center justify-center rounded w-10 h-10 bg-blue-50">
                    <ArchiveBoxIcon class="size-9 text-blue-500"/>
                  </div>
                  <div class="flex flex-col">
                    <p>Total Stok Darah</p>
                    <h1 class="text-3xl">{{ stok_darah }}</h1>
                  </div>
                </div>
                <div class="flex items-center gap-8 bg-secondary rounded-2xl p-8 shadow-md">
                  <div class="flex items-center justify-center rounded w-10 h-10 bg-red-50">
                    <XMarkIcon class="size-9 text-red-500"/>
                  </div>
                  <div class="flex flex-col">
                    <p>Total Batal</p>
                      <h1 class="text-3xl">{{ total_batal }}</h1>
                  </div>
              </div>
            </div>

            <main class="grid grid-cols-1 lg:grid-cols-3 gap-5">
                <div class="w-full bg-secondary rounded-xl shadow p-6">
                    <h2 class="text-lg font-semibold text-gray-700 mb-4 text-center">
                      Permintaan Darah
                    </h2>
                
                    <div class="relative h-64 flex items-center justify-center">
                      <canvas ref="chartCanvas2"></canvas>
                    </div>
                </div>
                <div class="w-full flex flex-col items-center bg-secondary rounded-xl shadow p-6">
                    <h2 class="text-lg font-semibold text-gray-700 mb-4 text-center">
                      Jumlah Pendonor
                    </h2>
                
                    <div class="relative h-64">
                      <canvas ref="chartCanvas"></canvas>
                    </div>
                </div>
                <div class="w-full flex flex-col items-center bg-secondary rounded-xl shadow p-6">
                  <h2 class="text-lg font-semibold text-gray-700 mb-4 text-center">
                    Golongan yang didonorkan
                  </h2>
              
                  <div class="relative h-64">
                    <canvas ref="chartCanvas1"></canvas>
                  </div>
              </div>
            </main>

            <main class="grid grid-cols-1 lg:grid-cols-2 gap-0 lg:gap-5">
              <div class="overflow-x-auto bg-secondary rounded-xl mt-5 p-4">
                  <h2 class="text-lg font-semibold text-gray-700 text-center">Pendonor Terbaru</h2>
                    <table class="w-full min-w-max ">
                        <thead>
                            <tr class="border-b border-neutral-300">
                                <!-- <th class="px-4 py-3 text-left ">No</th> -->
                                <!-- <th class="px-4 py-3 text-left ">Status</th> -->
                                <th class="px-4 py-3 text-left ">Tanggal</th>
                                <th class="px-4 py-3 text-left ">Nama Pendonor</th>
                                <th class="px-4 py-3 text-left ">Tanggal Lahir</th>
                                <th class="px-4 py-3 text-left ">Jenis Kelamin</th>
                                <th class="px-4 py-3 text-left ">Tipe Darah</th>
                                <th class="px-4 py-3 text-left ">Rhesus</th>
                                <th class="px-4 py-3 text-left ">Unit PMI</th>
                                <th class="px-4 py-3 text-left ">Jenis Donor</th>
                                <th class="px-4 py-3 text-left ">Catatan Kesehatan</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(item) in pendonor.slice(0, 4)" :key="item.id_pengajuan_donor" class="border-b border-gray-200 text-neutral-800 hover:bg-gray-200 transition">
                                <!-- <td class="px-4 py-3 text-left text-neutral-600">{{ (currentPage - 1) * perPage + index + 1 }}</td> -->
                                <!-- <td class="px-4 py-3 text-center text-neutral-600 flex items-center justify-center ">
                                    <div @click="openEdit(item)" class="w-6 h-6 bg-blue-50 rounded flex items-center justify-center  cursor-pointer">
                                        <PencilSquareIcon class="size-5 text-blue-500"/>
                                    </div> -->
                                    <!-- <select v-model="submitForm" name="" id="" class="w-fit px-4 rounded-full outline-none" :class="{'text-green-500 bg-green-50' : pilihStatus === 'eligible', 'text-yellow-500 bg-yellow-50' : pilihStatus === 'pending', 'text-red-500 bg-red-50' : pilihStatus === 'not_eligible'}">
                                        <option value="pending">pending</option>
                                        <option value="eligible">eligible</option>
                                        <option value="not_eligible">Not eligible</option>
                                    </select> -->
                                <!-- </td> -->
                                <td class="px-4 py-3 text-left text-neutral-600">{{ item.created_at }}</td>
                                <td class="px-4 py-3 text-left text-neutral-600">{{ item.nama_pendonor }}</td>
                                <td class="px-4 py-3 text-left text-neutral-600">{{ item.tanggal_lahir }}</td>
                                <td class="px-4 py-3 text-left text-neutral-600">{{ item.jenis_kelamin }}</td>
                                <td class="px-4 py-3 text-left text-neutral-600">{{ item.tipe_darah }}</td>
                                <td class="px-4 py-3 text-left text-neutral-600">{{ item.rhesus }}</td>
                                <td class="px-4 py-3 text-left text-neutral-600">{{ item.unit_pmi }}</td>
                                <td class="px-4 py-3 text-left text-neutral-600">{{ item.jenis_donor }}</td>
                                
                                <td class="px-4 py-3 text-left text-neutral-600 max-w-md">{{ item.catatan_kesehatan }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="overflow-x-auto bg-secondary rounded-xl mt-5 p-4">
                  <h2 class="text-lg font-semibold text-gray-700 text-center">Permohonan Terbaru</h2>
                <table class="w-full min-w-max ">
                    <thead>
                        <tr class="border-b border-neutral-300">
                            <!-- <th class="px-4 py-3 text-left ">Aksi</th> -->
                            <!-- <th class="px-4 py-3 text-left ">No</th> -->
                            <th class="px-4 py-3 text-left ">Status Permohonan</th>
                            <th class="px-4 py-3 text-left ">Nama Pasien</th>
                            <th class="px-4 py-3 text-left ">Rumah Sakit</th>
                            <th class="px-4 py-3 text-left ">Kabupaten</th>
                            <th class="px-4 py-3 text-left ">Gol Darah</th>
                            <th class="px-4 py-3 text-left ">Rhesus</th>
                            <th class="px-4 py-3 text-left ">Jumlah Pendonor</th>
                            <th class="px-4 py-3 text-left ">Jenis Pendonor</th>
                            <th class="px-4 py-3 text-left ">Status Urgent</th>
                            
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(item, index) in permohonan.slice(0, 4)" :key="item.id" class="border-b border-gray-200 text-neutral-800 hover:bg-gray-200 transition">
                            <!-- <td class="px-4 py-3 text-left">
                                <div class="flex items-center gap-2">
                                    <div @click="openEdit(item)" class="w-6 h-6 bg-blue-50 flex items-center justify-center rounded cursor-pointer">
                                        <PencilSquareIcon class="size-5 text-blue-500"/>
                                    </div>
                                    <div @click="handleDelete(item.id)" class="w-6 h-6 bg-red-50 flex items-center justify-center rounded cursor-pointer">
                                        <TrashIcon class="size-5 text-red-500"/>
                                    </div>
                                </div>
                            </td> -->
                            <!-- <td class="px-4 py-3 text-left text-neutral-600 ">{{ (currentPage - 1) * perPage + index + 1 }}</td> -->
                            <td class="px-4 py-3 text-left text-neutral-600 ">
                                <!-- <select
                                    v-model="item.status_pengajuan"
                                    @change="submitForm(item.id, item.status_pengajuan)"
                                    class="w-fit px-4 rounded-full outline-none"
                                    :class="{
                                        'text-blue-500 bg-blue-50': item.status_pengajuan === 'diterima',
                                        'text-green-500 bg-green-50': item.status_pengajuan === 'selesai',
                                        'text-yellow-500 bg-yellow-50': item.status_pengajuan === 'pending',
                                    }">
                                    <option value="pending">pending</option>
                                    <option value="diterima">diterima</option>
                                    <option value="selesai">selesai</option>
                                </select> -->
                                {{ item.status_pengajuan }}

                                <!-- <p class=" w-fit px-4 rounded-full" :class="{
                                'text-green-500 bg-green-50': item.status_pengajuan === 'diterima' || item.status_pengajuan === 'selesai',
                                'text-yellow-500 bg-yellow-50': item.status_pengajuan === 'pending',
                                 'text-red-500 bg-red-50': item.status_pengajuan === 'batal'}">{{ item.status_pengajuan }}
                                </p> -->
                            </td>
                            <td class="px-4 py-3 text-left text-neutral-600 ">{{ item.nama_pasien }}</td>
                            <td class="px-4 py-3 text-left text-neutral-600 ">{{ item.nama_rumah_sakit }}</td>
                            <td class="px-4 py-3 text-left text-neutral-600 ">{{ item.lokasi_pasien }}</td>
                            <td class="px-4 py-3 text-left text-neutral-600 ">{{ item.golongan_darah }}</td>
                            <td class="px-4 py-3 text-left text-neutral-600 ">{{ item.rhesus }}</td>
                            <td class="px-4 py-3 text-left text-neutral-600 ">{{ item.jumlah_pendonor }}</td>
                            <td class="px-4 py-3 text-left text-neutral-600 ">{{ item.jenis_donor_darah }}</td>
                            <td class="px-4 py-3 text-left text-neutral-600 ">{{ item.status_urgent }}</td>
                            
                        </tr>
                    </tbody>
                </table>
            </div>
            </main>
        </main>
    </section>
</template>