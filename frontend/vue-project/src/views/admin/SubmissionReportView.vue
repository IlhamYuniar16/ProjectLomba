<script setup>
import { ChevronLeftIcon, ChevronRightIcon, CloudArrowDownIcon, FunnelIcon } from '@heroicons/vue/24/solid';

</script>

<template>
    <section class="bg-white p-6 min-h-screen">
        <h1 class="text-2xl font-semibold">Laporan Permohonan</h1>

        <div class="mt-5">
            <div class="flex items-center justify-between">
                <input type="search" class="px-4 py-2 rounded-full bg-secondary outline-none max-w-sm w-full" placeholder="Cari...">
                <div class="flex items-center gap-3">
                    <button class="flex items-center gap-3 px-6 py-2 bg-green-500 rounded text-white cursor-pointer"><CloudArrowDownIcon class="size-5"/>Excel</button>
                    <FunnelIcon class="size-6 text-gray-300 cursor-pointer"/>
                </div>
            </div>

            <div class="overflow-x-auto bg-secondary rounded-xl mt-5 p-4">
                <table class="w-full mt-5 min-w-max ">
                    <thead>
                        <tr class="border-b border-neutral-300">
                            <th class="px-4 py-3 text-left">No</th>
                            <th class="px-4 py-3 text-left ">Tanggal</th>
                            <th class="px-4 py-3 text-left ">Nama Pasien</th>
                            <th class="px-4 py-3 text-left ">Tipe Darah</th>
                            <th class="px-4 py-3 text-left ">Rhesus</th>
                            <th class="px-4 py-3 text-left ">Rumah Sakit</th>
                            <th class="px-4 py-3 text-left ">Jumlah Pendonor</th>
                            <th class="px-4 py-3 text-left ">Jenis Donor</th>
                            <th class="px-4 py-3 text-left ">Status</th>
                            <th class="px-4 py-3 text-left ">Status Urgent</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="border-b border-gray-200 text-neutral-800 hover:bg-gray-200 transition">
                            <td class="px-4 py-3 text-left text-neutral-600 ">1</td>
                            <td class="px-4 py-3 text-left text-neutral-600 ">Rizki Chandra</td>
                            <td class="px-4 py-3 text-left text-neutral-600 ">Rizki Chandra</td>
                            <td class="px-4 py-3 text-left text-neutral-600 ">2005-01-01</td>
                            <td class="px-4 py-3 text-left text-neutral-600 ">Laki-laki</td>
                            <td class="px-4 py-3 text-left text-neutral-600 ">A</td>
                            <td class="px-4 py-3 text-left text-neutral-600 ">Positif</td>
                            <td class="px-4 py-3 text-left text-neutral-600 ">Positif</td>
                            <td class="px-4 py-3 text-left text-neutral-600 "><p class="bg-green-50 w-fit px-4 rounded-full text-green-500">Selesai</p></td>
                            <td class="px-4 py-3 text-left text-neutral-600 ">Positif</td>
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