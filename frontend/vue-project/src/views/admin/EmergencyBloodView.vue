<script setup>
import { ChevronLeftIcon, ChevronRightIcon, FunnelIcon, PencilSquareIcon, TrashIcon } from '@heroicons/vue/24/solid';
import { ref } from 'vue';

const showModal = ref(false);

const openModal = () => {
    showModal.value = true;
}

const closeModal = () => {
    showModal.value = false;
}

</script>

<template>
    <section class="bg-white p-6 min-h-screen">
        <h1 class="text-2xl font-semibold">Darah Darurat</h1>

        <!-- MODAL -->
        <div v-if="showModal" class="fixed inset-0 bg-black/35 flex items-center justify-center z-50 overflow-y-auto">
            <div class="bg-white w-full max-w-lg p-6 rounded-xl shadow-lg ">
                <h2 class="text-xl font-semibold mb-4">Tambah Data Darah Darurat</h2>

                <div class="space-y-4">
                    <div>
                        <label class="block mb-1 font-medium">Nama Pasien</label>
                        <input type="text" class="w-full p-3 bg-gray-100 border border-gray-300 rounded-lg outline-none" placeholder="Masukkan nama pasien">
                    </div>

                    <div>
                        <label class="block mb-1 font-medium">Rumah Sakit</label>
                        <select class="w-full p-3 bg-gray-100 border border-gray-300 rounded-lg outline-none" >
                            <option value="">--Pilih Rumah Sakit--</option>
                        </select>
                    </div>

                    <div>
                        <label class="block mb-1 font-medium">Kabupaten</label>
                        <select class="w-full p-3 bg-gray-100 border border-gray-300 rounded-lg outline-none" >
                            <option value="">--Pilih Kabupaten--</option>
                        </select>
                    </div>

                    <div class="flex items-center gap-5">
                        <div class="w-full">
                            <label class="block mb-1 font-medium">Golongan Darah</label>
                            <select class="w-full p-3 bg-gray-100 border border-gray-300 rounded-lg outline-none" >
                                <option value="">--Pilih Gol Darah--</option>
                            </select>
                        </div>
    
                        <div class="w-full">
                            <label class="block mb-1 font-medium">Rhesus</label>
                            <select class="w-full p-3 bg-gray-100 border border-gray-300 rounded-lg outline-none" >
                                <option value="">--Pilih Rhesus--</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="flex items-center gap-5">
                        <div class="w-full">
                            <label class="block mb-1 font-medium">Jumlah Pendonor</label>
                            <input type="text" class="w-full p-3 bg-gray-100 border border-gray-300 rounded-lg outline-none" placeholder="Jumlah Pendonor">
                        </div>
    
                        <div class="w-full">
                            <label class="block mb-1 font-medium">Jenis Donor</label>
                            <select class="w-full p-3 bg-gray-100 border border-gray-300 rounded-lg outline-none" >
                                <option value="">--Pilih Jenis Donor--</option>
                            </select>
                        </div>
                    </div>

                    <div class="w-full">
                        <label class="block mb-1 font-medium">Status Urgent</label>
                        <select class="w-full p-3 bg-gray-100 border border-gray-300 rounded-lg outline-none" >
                            <option value="">--Pilih Status--</option>
                        </select>
                    </div>

                </div>

                <div class="flex justify-end mt-5 gap-3">
                    <button 
                        class="px-4 py-2 bg-gray-300 rounded-lg cursor-pointer hover:bg-gray-400"
                        @click="closeModal"
                    >
                        Batal
                    </button>

                    <button 
                        class="px-4 py-2 bg-primary text-white rounded-lg cursor-pointer hover:bg-red-700"
                    >
                        Simpan
                    </button>
                </div>
            </div>
        </div>

        <div class="mt-5">
            <div class="flex items-center justify-between">
                <input type="search" class="px-4 py-2 rounded-full bg-secondary outline-none max-w-sm w-full" placeholder="Cari...">
                <div class="flex items-center gap-3">
                    <FunnelIcon class="size-6 text-gray-300 cursor-pointer"/>
                    <button @click="openModal" class="px-6 py-2 bg-primary hover:bg-red-700 rounded text-white cursor-pointer">+ Tambah Data</button>
                </div>
            </div>

            <div class="overflow-x-auto bg-secondary rounded-xl mt-5 p-4">
                <table class="w-full mt-5 min-w-max ">
                    <thead>
                        <tr class="border-b border-neutral-300">
                            <th class="px-4 py-3 text-left ">Aksi</th>
                            <th class="px-4 py-3 text-left ">No</th>
                            <th class="px-4 py-3 text-left ">Nama Pasien</th>
                            <th class="px-4 py-3 text-left ">Rumah Sakit</th>
                            <th class="px-4 py-3 text-left ">Kabupaten</th>
                            <th class="px-4 py-3 text-left ">Gol Darah</th>
                            <th class="px-4 py-3 text-left ">Rhesus</th>
                            <th class="px-4 py-3 text-left ">Jumlah Pendonor</th>
                            <th class="px-4 py-3 text-left ">Jenis Pendonor</th>
                            <th class="px-4 py-3 text-left ">Status Urgent</th>
                            <th class="px-4 py-3 text-left ">Status Permohonan</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="border-b border-gray-200 text-neutral-800 hover:bg-gray-200 transition">
                            <td class="px-4 py-3 text-left">
                                <div class="flex items-center gap-2">
                                    <div @click="openModal" class="w-6 h-6 bg-blue-50 flex items-center justify-center rounded cursor-pointer">
                                        <PencilSquareIcon class="size-5 text-blue-500"/>
                                    </div>
                                    <div class="w-6 h-6 bg-red-50 flex items-center justify-center rounded cursor-pointer">
                                        <TrashIcon class="size-5 text-red-500"/>
                                    </div>
                                </div>
                            </td>
                            <td class="px-4 py-3 text-left text-neutral-600 ">1</td>
                            <td class="px-4 py-3 text-left text-neutral-600 ">Ilham Yuniar</td>
                            <td class="px-4 py-3 text-left text-neutral-600 ">Rumah Sakit ABC</td>
                            <td class="px-4 py-3 text-left text-neutral-600 ">Sleman</td>
                            <td class="px-4 py-3 text-left text-neutral-600 ">A</td>
                            <td class="px-4 py-3 text-left text-neutral-600 ">Positif</td>
                            <td class="px-4 py-3 text-left text-neutral-600 ">2</td>
                            <td class="px-4 py-3 text-left text-neutral-600 ">Plasma</td>
                            <td class="px-4 py-3 text-left text-neutral-600 ">Urgent</td>
                            <td class="px-4 py-3 text-left text-neutral-600 "><p class="bg-green-50 w-fit px-4 rounded-full text-green-500">Selesai</p></td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="flex items-center justify-center gap-2 mt-5">
                <button class="p-2 bg-black rounded text-white cursor-pointer"><ChevronLeftIcon class="size-5"/></button>
                <div class="mx-5 flex items-center gap-2">
                    <div class="cursor-pointer">
                        <p class="px-4 py-2  text-black rounded ">1</p>
                        <div class="h-[2px] bg-black"></div>
                    </div>
                    <div class="cursor-pointer">
                        <p class="px-4 py-2  text-gray-400 rounded ">2</p>
                        <div class="h-[2px] bg-gray-300"></div>
                    </div>
                </div>
                <button class="p-2 bg-black rounded text-white cursor-pointer"><ChevronRightIcon class="size-5"/></button>
            </div>
        </div>
    </section>
</template>