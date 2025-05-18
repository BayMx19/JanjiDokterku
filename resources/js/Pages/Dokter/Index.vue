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
                        <!-- Tombol tambah dokter + pencarian -->
                        <div class="mb-4 flex justify-between items-center">
                            <Link
                                :href="route('dokter.create')"
                                class="rounded bg-blue-600 px-4 py-2 text-white hover:bg-blue-700"
                            >
                                <i class="fas fa-plus mr-2"></i>Tambah Dokter
                            </Link>
                            <div class="flex space-x-4">
                                <input
                                    v-model="search"
                                    type="text"
                                    placeholder="Cari nama atau spesialisasi..."
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
                                            <span v-if="sortKey === 'name'">
                                                {{
                                                    sortOrder === "asc"
                                                        ? "▲"
                                                        : "▼"
                                                }}
                                            </span>
                                        </th>
                                        <th
                                            class="border border-gray-300 px-4 py-2 text-left cursor-pointer"
                                            @click="setSort('NIK')"
                                        >
                                            NIK
                                            <span v-if="sortKey === 'NIK'">
                                                {{
                                                    sortOrder === "asc"
                                                        ? "▲"
                                                        : "▼"
                                                }}
                                            </span>
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
                                            class="border border-gray-300 px-4 py-2 text-left cursor-pointer"
                                            @click="setSort('spesialisasi')"
                                        >
                                            Spesialisasi
                                            <span
                                                v-if="
                                                    sortKey === 'spesialisasi'
                                                "
                                            >
                                                {{
                                                    sortOrder === "asc"
                                                        ? "▲"
                                                        : "▼"
                                                }}
                                            </span>
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
                                        v-for="dokter in filteredSortedDokter"
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
                                    <tr
                                        v-if="filteredSortedDokter.length === 0"
                                    >
                                        <td
                                            colspan="8"
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
import { ref, computed } from "vue";

const props = defineProps({
    dokter: Object,
});

const search = ref("");
const sortKey = ref("name");
const sortOrder = ref("asc");

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

const filteredSortedDokter = computed(() => {
    let data = props.dokter.data;

    if (search.value.trim() !== "") {
        const q = search.value.toLowerCase();
        data = data.filter(
            (d) =>
                (d.user?.name ?? "").toLowerCase().includes(q) ||
                (d.spesialisasi ?? "").toLowerCase().includes(q)
        );
    }

    data = data.slice().sort((a, b) => {
        let aVal = a[sortKey.value] ?? "";
        let bVal = b[sortKey.value] ?? "";

        // khusus untuk name ambil dari relasi user
        if (sortKey.value === "name") {
            aVal = a.user?.name?.toLowerCase() ?? "";
            bVal = b.user?.name?.toLowerCase() ?? "";
        } else {
            aVal = String(aVal).toLowerCase();
            bVal = String(bVal).toLowerCase();
        }

        if (aVal < bVal) return sortOrder.value === "asc" ? -1 : 1;
        if (aVal > bVal) return sortOrder.value === "asc" ? 1 : -1;
        return 0;
    });

    return data;
});
</script>
