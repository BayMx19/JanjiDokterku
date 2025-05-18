<template>
    <Head title="Master Pasien" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                Master Pasien
            </h2>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <div class="mb-4 flex justify-between items-center">
                            <Link
                                :href="route('pasien.create')"
                                class="rounded bg-blue-600 px-4 py-2 text-white hover:bg-blue-700"
                            >
                                <i class="fas fa-plus mr-2"></i>Tambah Pasien
                            </Link>

                            <div class="flex space-x-4">
                                <input
                                    v-model="search"
                                    type="text"
                                    placeholder="Cari nama atau NIK..."
                                    class="rounded border px-3 py-1"
                                />
                            </div>
                        </div>

                        <div class="overflow-x-auto">
                            <table
                                class="w-full table-auto border-collapse border border-gray-200"
                            >
                                <thead class="bg-gray-100">
                                    <tr>
                                        <th
                                            class="border border-gray-300 px-4 py-2 text-left cursor-pointer"
                                            @click="setSort('name')"
                                        >
                                            Nama
                                            <span v-if="sortKey === 'name'">{{
                                                sortOrder === "asc" ? "▲" : "▼"
                                            }}</span>
                                        </th>
                                        <th
                                            class="border border-gray-300 px-4 py-2 text-left cursor-pointer"
                                            @click="setSort('nik')"
                                        >
                                            NIK
                                            <span v-if="sortKey === 'nik'">{{
                                                sortOrder === "asc" ? "▲" : "▼"
                                            }}</span>
                                        </th>
                                        <th
                                            class="border border-gray-300 px-4 py-2 text-left cursor-pointer"
                                            @click="setSort('alamat')"
                                        >
                                            Alamat
                                            <span v-if="sortKey === 'alamat'">{{
                                                sortOrder === "asc" ? "▲" : "▼"
                                            }}</span>
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
                                        v-for="p in filteredSortedPasien"
                                        :key="p.id"
                                        class="even:bg-gray-50"
                                    >
                                        <td
                                            class="border border-gray-300 px-4 py-2"
                                        >
                                            {{ p.user?.name ?? "-" }}
                                        </td>
                                        <td
                                            class="border border-gray-300 px-4 py-2"
                                        >
                                            {{ p.NIK }}
                                        </td>
                                        <td
                                            class="border border-gray-300 px-4 py-2"
                                        >
                                            {{ p.alamat?.jalan ?? "-" }}
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
                                                            'pasien.edit',
                                                            p.id
                                                        )
                                                    "
                                                    class="text-blue-600 hover:text-blue-800"
                                                    title="Edit"
                                                >
                                                    <i class="fas fa-edit"></i>
                                                </Link>
                                                <button
                                                    @click="destroyPasien(p.id)"
                                                    class="text-red-600 hover:text-red-800"
                                                >
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr
                                        v-if="filteredSortedPasien.length === 0"
                                    >
                                        <td
                                            colspan="4"
                                            class="text-center py-4 text-gray-500"
                                        >
                                            Tidak ada data.
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <div class="mt-4 flex justify-center space-x-4">
                            <Link
                                v-if="props.pasien.prev_page_url"
                                :href="props.pasien.prev_page_url"
                                class="rounded bg-gray-200 px-3 py-1 hover:bg-gray-300"
                            >
                                Sebelumnya
                            </Link>
                            <span class="px-3 py-1">{{
                                props.pasien.current_page
                            }}</span>
                            <Link
                                v-if="props.pasien.next_page_url"
                                :href="props.pasien.next_page_url"
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
import { ref, computed } from "vue";

const props = defineProps({
    pasien: Object,
});

const search = ref("");
const sortKey = ref("name");
const sortOrder = ref("asc");

function destroyPasien(id) {
    if (confirm("Yakin ingin menghapus pasien ini?")) {
        router.delete(route("pasien.destroy", id), {
            preserveScroll: true,
            onSuccess: () => {
                console.log("Pasien berhasil dihapus.");
            },
            onError: () => {
                console.error("Gagal menghapus pasien.");
            },
        });
    }
}

function toggleSortOrder() {
    sortOrder.value = sortOrder.value === "asc" ? "desc" : "asc";
}

function setSort(key) {
    if (sortKey.value === key) {
        toggleSortOrder();
    } else {
        sortKey.value = key;
        sortOrder.value = "asc";
    }
}

const filteredSortedPasien = computed(() => {
    let data = props.pasien.data;

    if (search.value.trim() !== "") {
        const lower = search.value.toLowerCase();
        data = data.filter((p) => p.user?.name?.toLowerCase().includes(lower));
    }

    data = data.slice().sort((a, b) => {
        let aVal, bVal;

        if (sortKey.value === "name") {
            aVal = a.user?.name?.toLowerCase() || "";
            bVal = b.user?.name?.toLowerCase() || "";
        } else {
            aVal = a[sortKey.value]?.toLowerCase() || "";
            bVal = b[sortKey.value]?.toLowerCase() || "";
        }

        if (aVal < bVal) return sortOrder.value === "asc" ? -1 : 1;
        if (aVal > bVal) return sortOrder.value === "asc" ? 1 : -1;
        return 0;
    });

    return data;
});
</script>
