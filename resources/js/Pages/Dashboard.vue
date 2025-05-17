<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head, usePage } from "@inertiajs/vue3";

const user = usePage().props.auth.user;
</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                Dashboard
            </h2>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
                    <!-- Kartu Statistik -->
                    <div class="bg-white shadow-md rounded-lg p-4">
                        <p class="text-gray-500 text-sm">Total Pasien</p>
                        <h3 class="text-2xl font-bold text-gray-800">
                            {{ $page.props.totalPasien }}
                        </h3>
                    </div>
                    <div class="bg-white shadow-md rounded-lg p-4">
                        <p class="text-gray-500 text-sm">Total Dokter</p>
                        <h3 class="text-2xl font-bold text-gray-800">
                            {{ $page.props.totalDokter }}
                        </h3>
                    </div>
                    <div class="bg-white shadow-md rounded-lg p-4">
                        <p class="text-gray-500 text-sm">Total Jadwal</p>
                        <h3 class="text-2xl font-bold text-gray-800">
                            {{ $page.props.totalJadwal }}
                        </h3>
                    </div>
                </div>

                <div v-if="['Administrator'].includes(user.role)" class="mb-6">
                    <div class="flex flex-wrap gap-4">
                        <a
                            href="/pasien/create"
                            class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded"
                            >Tambah Pasien</a
                        >
                        <a
                            href="/dokter/create"
                            class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded"
                            >Tambah Dokter</a
                        >
                        <a
                            href="/jadwal/create"
                            class="bg-purple-500 hover:bg-purple-600 text-white px-4 py-2 rounded"
                            >Tambah Jadwal</a
                        >
                    </div>
                </div>

                <!-- Audit Trail Terbaru -->
                <div class="bg-white p-6 shadow-md sm:rounded-lg">
                    <h3 class="mb-2 font-bold text-lg">Audit Trail Terbaru</h3>
                    <table
                        class="table-auto border-collapse border border-gray-300 w-full"
                    >
                        <thead>
                            <tr>
                                <th class="border border-gray-300 px-2 py-1">
                                    Tanggal
                                </th>
                                <th class="border border-gray-300 px-2 py-1">
                                    Aksi
                                </th>
                                <th class="border border-gray-300 px-2 py-1">
                                    Oleh User
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr
                                v-for="audit in $page.props.audits"
                                :key="audit.id"
                            >
                                <td class="border border-gray-300 px-2 py-1">
                                    {{
                                        new Date(
                                            audit.created_at
                                        ).toLocaleString()
                                    }}
                                </td>
                                <td class="border border-gray-300 px-2 py-1">
                                    {{ audit.event }}
                                </td>
                                <td class="border border-gray-300 px-2 py-1">
                                    {{ audit.user?.name ?? "System" }}
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
