<template>
    <Head title="Data Janji Temu" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                Data Janji Temu
            </h2>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <!-- Tombol di kanan -->
                        <div class="mb-4 flex justify-end">
                            <Link
                                :href="route('appointments.create')"
                                class="rounded bg-blue-600 px-4 py-2 text-white hover:bg-blue-700"
                            >
                                <i class="fas fa-plus mr-2"></i>Tambah Janji
                                Temu
                            </Link>
                        </div>

                        <div class="overflow-x-auto">
                            <table
                                class="w-full table-auto border-collapse border border-gray-200"
                            >
                                <thead class="bg-gray-100">
                                    <tr>
                                        <th
                                            class="border border-gray-300 px-4 py-2 text-left"
                                        >
                                            Nama Pasien
                                        </th>
                                        <th
                                            class="border border-gray-300 px-4 py-2 text-left"
                                        >
                                            Dokter
                                        </th>
                                        <th
                                            class="border border-gray-300 px-4 py-2 text-left"
                                        >
                                            Jadwal
                                        </th>
                                        <th
                                            class="border border-gray-300 px-4 py-2 text-left"
                                        >
                                            Status
                                        </th>
                                        <th
                                            class="border border-gray-300 px-4 py-2 text-left"
                                        >
                                            Aksi
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr
                                        v-for="data in props.appointments"
                                        :key="data.id"
                                        class="even:bg-gray-50"
                                    >
                                        <td
                                            class="border border-gray-300 px-4 py-2"
                                        >
                                            {{ data.pasien.user.name }}
                                        </td>
                                        <td
                                            class="border border-gray-300 px-4 py-2"
                                        >
                                            {{ data.dokter.user.name }}
                                        </td>
                                        <td
                                            class="border border-gray-300 px-4 py-2"
                                        >
                                            {{
                                                formatTanggal(
                                                    data.jadwal.tanggal
                                                )
                                            }}
                                            | {{ data.jadwal.jam_awal }} -
                                            {{ data.jadwal.jam_akhir }}
                                        </td>
                                        <td
                                            class="border border-gray-300 px-4 py-2 capitalize"
                                        >
                                            {{ data.status }}
                                        </td>
                                        <td
                                            class="border border-gray-300 px-4 py-2"
                                        >
                                            <div
                                                class="flex items-center space-x-2"
                                            >
                                                <Link
                                                    :href="
                                                        route(
                                                            'appointments.detail',
                                                            data.id
                                                        )
                                                    "
                                                    class="text-green-600 hover:text-green-800"
                                                    title="Detail"
                                                >
                                                    <i
                                                        class="fas fa-info-circle"
                                                    ></i>
                                                </Link>
                                                <Link
                                                    :href="
                                                        route(
                                                            'appointments.edit',
                                                            data.id
                                                        )
                                                    "
                                                    class="text-blue-600 hover:text-blue-800"
                                                    title="Edit"
                                                >
                                                    <i class="fas fa-edit"></i>
                                                </Link>
                                                <button
                                                    @click="destroy(data.id)"
                                                    class="text-red-600 hover:text-red-800"
                                                    title="Hapus"
                                                >
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <!-- Belum pakai pagination karena datanya belum paginated -->
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head, Link, router } from "@inertiajs/vue3";

const props = defineProps({
    appointments: Array,
});

const appointments = props.appointments;
console.log(appointments);

function destroy(id) {
    if (confirm("Yakin ingin menghapus janji temu ini?")) {
        router.delete(route("appointments.destroy", id), {
            preserveScroll: true,
            onSuccess: () => {
                console.log("Data berhasil dihapus.");
            },
            onError: () => {
                console.error("Gagal menghapus data.");
            },
        });
    }
}

function formatTanggal(tgl) {
    const date = new Date(tgl);
    const day = String(date.getDate()).padStart(2, "0");
    const month = String(date.getMonth() + 1).padStart(2, "0");
    const year = date.getFullYear();
    return `${day}-${month}-${year}`;
}
</script>
