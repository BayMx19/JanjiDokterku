<template>
    <Head title="Master Dokter" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                Master Dokter
            </h2>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <!-- Tombol tambah dokter -->
                        <div class="mb-4 flex justify-end">
                            <Link
                                :href="route('dokter.create')"
                                class="rounded bg-blue-600 px-4 py-2 text-white hover:bg-blue-700"
                            >
                                <i class="fas fa-plus mr-2"></i>Tambah Dokter
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
                                            Nama
                                        </th>
                                        <th
                                            class="border border-gray-300 px-4 py-2 text-left"
                                        >
                                            NIK
                                        </th>
                                        <th
                                            class="border border-gray-300 px-4 py-2 text-left"
                                        >
                                            Jenis Kelamin
                                        </th>
                                        <th
                                            class="border border-gray-300 px-4 py-2 text-left"
                                        >
                                            No HP
                                        </th>
                                        <th
                                            class="border border-gray-300 px-4 py-2 text-left"
                                        >
                                            Alamat
                                        </th>
                                        <th
                                            class="border border-gray-300 px-4 py-2 text-left"
                                        >
                                            Spesialisasi
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
                                        v-for="dokter in props.dokter.data"
                                        :key="dokter.id"
                                        class="even:bg-gray-50"
                                    >
                                        <td
                                            class="border border-gray-300 px-4 py-2"
                                        >
                                            {{ dokter.user?.name ?? "-" }}
                                        </td>
                                        <td
                                            class="border border-gray-300 px-4 py-2"
                                        >
                                            {{ dokter.NIK ?? "-" }}
                                        </td>
                                        <td
                                            class="border border-gray-300 px-4 py-2"
                                        >
                                            {{ dokter.jenis_kelamin ?? "-" }}
                                        </td>
                                        <td
                                            class="border border-gray-300 px-4 py-2"
                                        >
                                            {{ dokter.no_hp ?? "-" }}
                                        </td>
                                        <td
                                            class="border border-gray-300 px-4 py-2"
                                        >
                                            {{ dokter.alamat?.jalan ?? "-" }}
                                        </td>
                                        <td
                                            class="border border-gray-300 px-4 py-2"
                                        >
                                            {{ dokter.spesialisasi ?? "-" }}
                                        </td>
                                        <td
                                            class="border border-gray-300 px-4 py-2"
                                        >
                                            <span
                                                :class="{
                                                    'text-green-600 font-semibold':
                                                        dokter.aktif,
                                                    'text-red-600 font-semibold':
                                                        !dokter.aktif,
                                                }"
                                            >
                                                {{
                                                    dokter.aktif
                                                        ? "Aktif"
                                                        : "Nonaktif"
                                                }}
                                            </span>
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
                                                            'dokter.edit',
                                                            dokter.id
                                                        )
                                                    "
                                                    class="text-blue-600 hover:text-blue-800"
                                                    title="Edit"
                                                >
                                                    <i class="fas fa-edit"></i>
                                                </Link>
                                                <button
                                                    @click="
                                                        destroyDokter(dokter.id)
                                                    "
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

                        <div class="mt-4 flex justify-center space-x-4">
                            <Link
                                v-if="props.dokter.prev_page_url"
                                :href="props.dokter.prev_page_url"
                                class="rounded bg-gray-200 px-3 py-1 hover:bg-gray-300"
                            >
                                Sebelumnya
                            </Link>
                            <span class="px-3 py-1">{{
                                props.dokter.current_page
                            }}</span>
                            <Link
                                v-if="props.dokter.next_page_url"
                                :href="props.dokter.next_page_url"
                                class="rounded bg-gray-200 px-3 py-1 hover:bg-gray-300"
                            >
                                Berikutnya
                            </Link>
                        </div>
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
    dokter: Object,
});

function destroyDokter(id) {
    if (confirm("Yakin ingin menghapus data dokter ini?")) {
        router.delete(route("dokter.destroy", id), {
            preserveScroll: true,
            onSuccess: () => {
                console.log("Dokter berhasil dihapus.");
            },
            onError: () => {
                console.error("Gagal menghapus dokter.");
            },
        });
    }
}
</script>
